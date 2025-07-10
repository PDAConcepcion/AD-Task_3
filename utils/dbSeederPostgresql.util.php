<?php
declare(strict_types=1);

// 1) Composer autoload
require_once 'vendor/autoload.php';

// 2) Composer bootstrap
require_once 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/dbEnvSetter.util.php';

echo "🌱 Starting PostgreSQL Database Seeding...\n";

// Load dummy data after setting requirements
$users = require_once DUMMIES_PATH . '/users.staticData.php';
$projects = require_once DUMMIES_PATH . '/projects.staticData.php';
$tasks = require_once DUMMIES_PATH . '/tasks.staticData.php';

// Get database configuration
$host = $databases['pgHost'];
$port = $databases['pgPort'];
$username = $databases['pgUser'];
$password = $databases['pgPassword'];
$dbname = $databases['pgDB'];

// Check if PDO PostgreSQL driver is available
if (!extension_loaded('pdo_pgsql')) {
    echo "❌ PDO PostgreSQL driver not found!\n";
    echo "💡 Please run this script inside the Docker container or install php-pgsql extension.\n";
    echo "🐳 Try: docker compose exec adtask3 php utils/dbSeederPostgresql.util.php\n";
    exit(1);
}

try {
    // ——— Connect to PostgreSQL ———
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    echo "✅ Connected to PostgreSQL successfully!\n";

    // Array of all model files to process (FIXED: using actual filenames from /sql/)
    $modelFiles = [
        'users.model.sql',
        'projects.model.sql', 
        'tasks.model.sql',
        'projects_users.model.sql'
    ];

    // Apply each model schema
    foreach ($modelFiles as $modelFile) {
        echo "Applying schema from sql/{$modelFile}…\n";
        
        // Use absolute path from BASE_PATH to /sql/ directory
        $filePath = BASE_PATH . '/sql/' . $modelFile;
        $sql = file_get_contents($filePath);
        
        if ($sql === false) {
            throw new RuntimeException("Could not read {$filePath}");
        } else {
            echo "✅ Creation Success from the sql/{$modelFile}\n";
        }
        
        // Execute the SQL to create the table
        $pdo->exec($sql);
    }

    // Clean the tables (truncate them)
    echo "🧹 Truncating tables…\n";
    $tables = ['project_users', 'tasks', 'projects', 'users']; // Order matters due to foreign keys
    
    foreach ($tables as $table) {
        try {
            $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
            echo "✅ Truncated table: {$table}\n";
        } catch (Exception $e) {
            echo "ℹ️  Table {$table} might not exist yet: " . $e->getMessage() . "\n";
        }
    }

    // ——— SEEDING LOGIC ———
    
    // Seed Users
    echo "🌱 Seeding users…\n";
    $stmt = $pdo->prepare("
        INSERT INTO users (username, role, first_name, last_name, password)
        VALUES (:username, :role, :fn, :ln, :pw)
    ");

    foreach ($users as $u) {
        $stmt->execute([
            ':username' => $u['username'],
            ':role' => $u['role'],
            ':fn' => $u['first_name'],
            ':ln' => $u['last_name'],
            ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
        ]);
    }
    echo "✅ Seeded " . count($users) . " users\n";

    // Seed Projects
    echo "🌱 Seeding projects…\n";
    $stmt = $pdo->prepare("
        INSERT INTO projects (name, description, start_date, end_date, status)
        VALUES (:name, :description, :start_date, :end_date, :status)
    ");

    foreach ($projects as $p) {
        $stmt->execute([
            ':name' => $p['name'],
            ':description' => $p['description'],
            ':start_date' => $p['start_date'],
            ':end_date' => $p['end_date'],
            ':status' => $p['status'],
        ]);
    }
    echo "✅ Seeded " . count($projects) . " projects\n";

    // Get user and project IDs for tasks
    $userIds = $pdo->query("SELECT id FROM users")->fetchAll(PDO::FETCH_COLUMN);
    $projectIds = $pdo->query("SELECT id FROM projects")->fetchAll(PDO::FETCH_COLUMN);

    // Seed Tasks
    echo "🌱 Seeding tasks…\n";
    $stmt = $pdo->prepare("
        INSERT INTO tasks (title, description, status, priority, project_id, assigned_user_id, due_date)
        VALUES (:title, :description, :status, :priority, :project_id, :assigned_user_id, :due_date)
    ");

    foreach ($tasks as $index => $t) {
        $stmt->execute([
            ':title' => $t['title'],
            ':description' => $t['description'],
            ':status' => $t['status'],
            ':priority' => $t['priority'],
            ':project_id' => $projectIds[$index % count($projectIds)], // Cycle through projects
            ':assigned_user_id' => $userIds[$index % count($userIds)], // Cycle through users
            ':due_date' => $t['due_date'],
        ]);
    }
    echo "✅ Seeded " . count($tasks) . " tasks\n";

    // Seed Project-User assignments
    echo "🌱 Seeding project-user assignments…\n";
    $stmt = $pdo->prepare("
        INSERT INTO project_users (project_id, user_id, role)
        VALUES (:project_id, :user_id, :role)
    ");

    // Assign some users to projects
    $assignments = [
        ['project_idx' => 0, 'user_idx' => 0, 'role' => 'lead'],
        ['project_idx' => 0, 'user_idx' => 1, 'role' => 'member'],
        ['project_idx' => 1, 'user_idx' => 1, 'role' => 'lead'],
        ['project_idx' => 1, 'user_idx' => 2, 'role' => 'member'],
        ['project_idx' => 2, 'user_idx' => 3, 'role' => 'lead'],
    ];

    foreach ($assignments as $assignment) {
        $stmt->execute([
            ':project_id' => $projectIds[$assignment['project_idx']],
            ':user_id' => $userIds[$assignment['user_idx']],
            ':role' => $assignment['role'],
        ]);
    }
    echo "✅ Seeded " . count($assignments) . " project-user assignments\n";

    echo "🎉 PostgreSQL seeding complete!\n";

} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}