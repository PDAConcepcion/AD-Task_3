<?php
declare(strict_types=1);

// 1) Composer autoload
require_once 'vendor/autoload.php';

// 2) Composer bootstrap
require_once 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/dbEnvSetter.util.php';

echo "🔄 Starting PostgreSQL Database Migration...\n";

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
    echo "🐳 Try: docker compose exec adtask3 php utils/dbMigratePostgresql.util.php\n";
    exit(1);
}

try {
    // ——— Connect to PostgreSQL ———
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    echo "✅ Connected to PostgreSQL successfully!\n";

    // ——— DROP OLD TABLES ———
    echo "🗑️ Dropping old tables…\n";
    foreach ([
        'project_users',  // Drop dependent tables first
        'tasks',
        'projects',
        'users',
    ] as $table) {
        // Use IF EXISTS so it won't error if the table is already gone
        $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
        echo "✅ Dropped table: {$table}\n";
    }

    // ——— RECREATE TABLES ———
    echo "🏗️ Creating new table structures...\n";

    // Array of all model files to process
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

    echo "🎉 PostgreSQL migration complete!\n";
    echo "📋 Summary:\n";
    echo "   - Dropped all existing tables\n";
    echo "   - Recreated tables with updated schemas\n";
    echo "   - Ready for fresh data or seeding\n";

} catch (PDOException $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}