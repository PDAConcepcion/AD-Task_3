<?php
declare(strict_types=1);

require_once UTILS_PATH . '/dbEnvSetter.util.php';

echo "<div class='card'>";
echo "<h3>🔍 System Status Check</h3>";

// PostgreSQL Check
try {
    $host = $databases['pgHost'];
    $port = $databases['pgPort'];
    $username = $databases['pgUser'];
    $password = $databases['pgPassword'];
    $dbname = $databases['pgDB'];
    
    $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    
    echo "<p style='color: green;'>✅ PostgreSQL Connected successfully!</p>";
    echo "<p>📍 Host: {$host}:{$port} | Database: {$dbname}</p>";
    
    // Check tables
    $tables = ['users', 'projects', 'tasks', 'project_users'];
    echo "<div style='margin: 15px 0;'>";
    echo "<h4>📋 Table Status:</h4>";
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM {$table}");
            $count = $stmt->fetchColumn();
            echo "<span class='badge badge-success' style='margin-right: 10px;'>{$table}: {$count} records</span>";
        } catch (Exception $e) {
            echo "<span class='badge badge-warning' style='margin-right: 10px;'>{$table}: Missing</span>";
        }
    }
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>❌ PostgreSQL connection failed: " . $e->getMessage() . "</p>";
}

// Session Check
echo "<div style='margin: 15px 0;'>";
echo "<h4>🔐 Session Status:</h4>";
if (session_status() === PHP_SESSION_ACTIVE) {
    echo "<span class='badge badge-success'>Session: Active</span>";
    if (isset($_SESSION['user'])) {
        echo "<span class='badge badge-info' style='margin-left: 10px;'>User: " . htmlspecialchars($_SESSION['user']['username']) . "</span>";
    } else {
        echo "<span class='badge badge-secondary' style='margin-left: 10px;'>User: Not logged in</span>";
    }
} else {
    echo "<span class='badge badge-danger'>Session: Inactive</span>";
}
echo "</div>";

echo "</div>";