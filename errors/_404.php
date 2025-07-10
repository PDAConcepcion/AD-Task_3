<?php
require_once __DIR__ . '/bootstrap.php';

$pageTitle = 'Page Not Found - TaskFlow';

ob_start();
?>

<div style="display: flex; align-items: center; justify-content: center; min-height: 60vh; text-align: center;">
    <div style="max-width: 500px; padding: 40px;">
        <div style="font-size: 4rem; margin-bottom: 20px;">🔍</div>
        <h1 style="font-size: 2.5rem; color: #667eea; margin: 0 0 20px 0;">Page Not Found</h1>
        <p style="font-size: 1.1rem; color: #666; margin: 0 0 30px 0; line-height: 1.6;">
            The page you're looking for doesn't exist or has been moved.
        </p>
        
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="/" class="btn btn-primary">
                🏠 Go Home
            </a>
            <a href="/dashboard.php" class="btn btn-secondary">
                📊 Dashboard
            </a>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include LAYOUTS_PATH . '/main.layout.php';
?>