<?php
// Ensure auth is available
if (!isset($auth)) {
    require_once __DIR__ . '/../bootstrap.php';
    require_once HANDLERS_PATH . '/postgreAuth.handler.php';
}

$currentUser = $auth->getCurrentUser();
$isLoggedIn = $auth->isLoggedIn();
?>

<nav class="navbar">
    <div class="container">
        <a href="/" class="navbar-brand">
            🎯 TaskFlow
        </a>
        
        <div class="navbar-nav">
            <?php if ($isLoggedIn): ?>
                <a href="/dashboard.php">📊 Dashboard</a>
                <a href="/projects.php">📁 Projects</a>
                <a href="/tasks.php">✅ Tasks</a>
                
                <?php if ($auth->hasRole('admin')): ?>
                    <a href="/users.php">👥 Users</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <div class="user-info">
            <?php if ($isLoggedIn): ?>
                <div class="user-avatar">
                    <?= strtoupper(substr($currentUser['first_name'], 0, 1)) ?>
                </div>
                <span>
                    <?= htmlspecialchars($currentUser['first_name']) ?>
                    (<?= htmlspecialchars($currentUser['role']) ?>)
                </span>
                <a href="?action=logout" class="btn btn-danger">🚪 Logout</a>
            <?php else: ?>
                <a href="/login.php" class="btn">🔐 Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
