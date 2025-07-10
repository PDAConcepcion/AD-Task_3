<?php
declare(strict_types=1);

require_once UTILS_PATH . '/dbEnvSetter.util.php';
require_once UTILS_PATH . '/dbAuthPostgresql.util.php';

// Database connection
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
    
    $auth = new AuthUtil($pdo);
    
    // Handle login form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $loginError = "Please fill in all fields";
        } else {
            $result = $auth->login($username, $password);
            
            if ($result['success']) {
                header('Location: /dashboard.php');
                exit;
            } else {
                $loginError = $result['message'];
            }
        }
    }

    // Handle logout
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        $auth->logout();
        header('Location: /login.php?message=logged_out');
        exit;
    }
    
} catch (Exception $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}