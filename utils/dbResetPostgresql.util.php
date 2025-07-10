<?php
declare(strict_types=1);

// 1) Composer autoload
require_once 'vendor/autoload.php';

// 2) Composer bootstrap
require_once 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/dbEnvSetter.util.php';

echo "🔄 Starting PostgreSQL Database Reset...\n";

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
    echo "🐳 Try: docker compose exec adtask3 php utils/dbResetPostgresql.util.php\n";
    exit(1);
}

try {
    // ——— Connect to PostgreSQL ———
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    echo "✅ Connected to PostgreSQL successfully!\n";

    // Array of all model files to process
        $modelFiles = [
        'users.model.sql',
        'projects.model.sql', 
        'tasks.model.sql',
        'projects_users.model.sql'  // FIXED: actual filename with underscore
    ];

    // Apply each model schema
    foreach ($modelFiles as $modelFile) {
        echo "Applying schema from database/{$modelFile}…\n";
        
        // Use absolute path from BASE_PATH
        $filePath = BASE_PATH . '/sql/' . $modelFile;
        $sql = file_get_contents($filePath);
        
        if ($sql === false) {
            throw new RuntimeException("Could not read database/{$modelFile}");
        } else {
            echo "✅ Creation Success from the database/{$modelFile}\n";
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

    echo "🎉 PostgreSQL reset complete!\n";

} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}