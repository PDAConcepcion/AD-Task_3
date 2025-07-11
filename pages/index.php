<?php
require_once BASE_PATH . '/bootstrap.php';
require_once HANDLERS_PATH . '/postgreAuth.handler.php';

// Check if user is logged in and redirect accordingly
if ($auth->isLoggedIn()) {
    header('Location: /pages/dashboard.php');
    exit;
}

$pageTitle = 'TaskFlow - Task Management System';

ob_start();
?>

<div class="hero-section">
    <h1 class="hero-title">🎯 Welcome to TaskFlow</h1>
    <p class="hero-subtitle">Modern Task Management for Productive Teams</p>

    
    <div class="hero-buttons">
        <a href="/pages/login.php" class="btn btn-primary btn-lg">
            🔐 Get Started
        </a>
        <a href="#features" class="btn btn-secondary btn-lg">
            📖 Learn More
        </a>
    </div>
</div>

<div id="features" class="features-section">
    <h2 class="features-title">✨ Features</h2>
    <div class="grid grid-3">
        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3 class="feature-title">Project Management</h3>
            <p class="feature-description">Organize and track your projects with powerful management tools.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">✅</div>
            <h3 class="feature-title">Task Tracking</h3>
            <p class="feature-description">Keep track of tasks, deadlines, and progress in real-time.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">👥</div>
            <h3 class="feature-title">Team Collaboration</h3>
            <p class="feature-description">Work together seamlessly with role-based access control.</p>
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