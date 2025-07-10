<?php
require_once BASE_PATH . '/bootstrap.php';
require_once HANDLERS_PATH . '/postgreAuth.handler.php';

// Check if user is logged in and redirect accordingly
if ($auth->isLoggedIn()) {
    header('Location: /dashboard.php');
    exit;
}

$pageTitle = 'TaskFlow - Task Management System';

ob_start();
?>

<div style="text-align: center; padding: 80px 0; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-radius: 16px; margin-bottom: 40px;">
    <h1 style="font-size: 3.5rem; margin: 0 0 20px 0; color: #333; font-weight: bold;">🎯 Welcome to TaskFlow</h1>
    <p style="font-size: 1.3rem; margin: 0 0 40px 0; color: #666;">Modern Task Management for Productive Teams</p>
    
    <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
        <a href="/login.php" class="btn btn-primary btn-lg">
            🔐 Get Started
        </a>
        <a href="#features" class="btn btn-secondary btn-lg">
            📖 Learn More
        </a>
    </div>
</div>

<div id="features" style="margin: 60px 0;">
    <h2 style="text-align: center; font-size: 2.5rem; margin: 0 0 50px 0; color: #333;">✨ Features</h2>
    <div class="grid grid-3">
        <div style="text-align: center; padding: 30px 20px; background: rgba(255, 255, 255, 0.8); border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
            <div style="font-size: 3rem; margin-bottom: 20px;">📊</div>
            <h3 style="margin: 0 0 15px 0; color: #333; font-size: 1.3rem;">Project Management</h3>
            <p style="margin: 0; color: #666; line-height: 1.6;">Organize and track your projects with powerful management tools.</p>
        </div>
        <div style="text-align: center; padding: 30px 20px; background: rgba(255, 255, 255, 0.8); border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
            <div style="font-size: 3rem; margin-bottom: 20px;">✅</div>
            <h3 style="margin: 0 0 15px 0; color: #333; font-size: 1.3rem;">Task Tracking</h3>
            <p style="margin: 0; color: #666; line-height: 1.6;">Keep track of tasks, deadlines, and progress in real-time.</p>
        </div>
        <div style="text-align: center; padding: 30px 20px; background: rgba(255, 255, 255, 0.8); border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
            <div style="font-size: 3rem; margin-bottom: 20px;">👥</div>
            <h3 style="margin: 0 0 15px 0; color: #333; font-size: 1.3rem;">Team Collaboration</h3>
            <p style="margin: 0; color: #666; line-height: 1.6;">Work together seamlessly with role-based access control.</p>
        </div>
    </div>
</div>

<!-- System Status Section -->
<div style="margin-top: 40px;">
    <?php 
    // Include the checker to show system status
    require_once HANDLERS_PATH . '/postgreChecker.handler.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include LAYOUTS_PATH . '/main.layout.php';
?>