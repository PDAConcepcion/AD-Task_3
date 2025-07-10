<?php
require_once __DIR__ . '/bootstrap.php';
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

<h1>👋 Welcome, <?= htmlspecialchars($user['first_name']) ?>!</h1>

<div class="grid grid-2">
    <div class="card">
        <h2 style="margin: 0 0 20px 0; color: #333;">👤 Your Profile</h2>
        <div style="text-align: center;">
            <div class="user-avatar" style="width: 60px; height: 60px; font-size: 1.5rem; margin: 0 auto 15px auto;">
                <?= strtoupper(substr($user['first_name'], 0, 1)) ?>
            </div>
            <div style="text-align: left;">
                <p style="margin: 8px 0;"><strong>Name:</strong> <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></p>
                <p style="margin: 8px 0;"><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                <p style="margin: 8px 0;"><strong>Role:</strong> 
                    <span class="badge badge-<?= $user['role'] === 'admin' ? 'danger' : ($user['role'] === 'manager' ? 'warning' : 'primary') ?>">
                        <?= htmlspecialchars(ucfirst($user['role'])) ?>
                    </span>
                </p>
            </div>
        </div>
    </div>
    
    <div class="card">
        <h2 style="margin: 0 0 20px 0; color: #333;">🚀 Quick Actions</h2>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <a href="/projects.php" class="btn btn-primary" style="text-align: left;">
                📁 View Projects
            </a>
            <a href="/tasks.php" class="btn btn-secondary" style="text-align: left;">
                ✅ View Tasks
            </a>
            <?php if ($auth->hasRole('admin')): ?>
                <a href="/users.php" class="btn btn-warning" style="text-align: left;">
                    👥 Manage Users
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="card">
    <h2 style="margin: 0 0 20px 0; color: #333;">📊 System Overview</h2>
    <div class="grid grid-3">
        <div style="text-align: center; padding: 20px;">
            <div style="font-size: 2rem; margin-bottom: 10px;">💾</div>
            <h4 style="margin: 0 0 10px 0; color: #333;">Database</h4>
            <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 14px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #28a745;"></span>
                Connected
            </div>
        </div>
        <div style="text-align: center; padding: 20px;">
            <div style="font-size: 2rem; margin-bottom: 10px;">🔐</div>
            <h4 style="margin: 0 0 10px 0; color: #333;">Authentication</h4>
            <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 14px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #28a745;"></span>
                Active
            </div>
        </div>
        <div style="text-align: center; padding: 20px;">
            <div style="font-size: 2rem; margin-bottom: 10px;">⚡</div>
            <h4 style="margin: 0 0 10px 0; color: #333;">Server</h4>
            <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 14px;">
                <span style="width: 8px; height: 8px; border-radius: 50%; background: #28a745;"></span>
                Running
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include LAYOUTS_PATH . '/main.layout.php';
?>