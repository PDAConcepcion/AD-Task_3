<?php
require_once BASE_PATH . '/bootstrap.php';
require_once HANDLERS_PATH . '/postgreAuth.handler.php';

// Require login
$auth->requireLogin();

$pageTitle = 'Dashboard - TaskFlow';
$user = $auth->getCurrentUser();

$breadcrumbs = [
    ['title' => 'Dashboard']
];

ob_start();
?>

<h1 class="welcome-title">👋 Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>

<div class="grid grid-2">
    <div class="card">
        <h2 class="quick-actions">👤 Your Profile</h2>
        <div class="profile-card">
            <div class="user-avatar profile-avatar">
                <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
            </div>
            <div class="profile-info">
                <p class="profile-field"><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
                <p class="profile-field"><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                <p class="profile-field"><strong>Role:</strong> 
                    <span class="badge badge-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'manager' ? 'warning' : 'primary') ?>">
                        <?= htmlspecialchars(ucfirst($user['role'])) ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
    
    <div class="card">
        <h2 class="quick-actions">🚀 Quick Actions</h2>
        <div class="actions-list">
            <a href="/projects.php" class="btn btn-primary action-btn">
                📁 View Projects
            </a>
            <a href="/tasks.php" class="btn btn-secondary action-btn">
                ✅ View Tasks
            </a>
            <?php if ($auth->hasRole('admin')): ?>
                <a href="/users.php" class="btn btn-warning action-btn">
                    👥 Manage Users
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card">
    <h2 class="system-overview">📊 System Overview</h2>
    <div class="grid grid-3">
        <div class="status-item">
            <div class="status-icon">💾</div>
            <h4 class="status-title">Database</h4>
            <div class="status-indicator">
                <span class="status-dot"></span>
                Connected
            </div>
        </div>
        <div class="status-item">
            <div class="status-icon">🔐</div>
            <h4 class="status-title">Authentication</h4>
            <div class="status-indicator">
                <span class="status-dot"></span>
                Active
            </div>
        </div>
        <div class="status-item">
            <div class="status-icon">⚡</div>
            <h4 class="status-title">Server</h4>
            <div class="status-indicator">
                <span class="status-dot"></span>
                Running
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include LAYOUTS_PATH . '/main.layout.php';
?>