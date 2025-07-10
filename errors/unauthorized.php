<?php
require_once __DIR__ . '/bootstrap.php';
require_once HANDLERS_PATH . '/postgreAuth.handler.php';

$pageTitle = 'Access Denied - TaskFlow';

ob_start();
?>

<div style="display: flex; align-items: center; justify-content: center; min-height: 60vh; text-align: center;">
    <div style="max-width: 500px; padding: 40px;">
        <div style="font-size: 4rem; margin-bottom: 20px;">🚫</div>
        <h1 style="font-size: 2.5rem; color: #dc3545; margin: 0 0 20px 0;">Access Denied</h1>
        <p style="font-size: 1.1rem; color: #666; margin: 0 0 30px 0; line-height: 1.6;">
            You don't have permission to access this resource.
        </p>
        
        <div style="display: flex; gap: 15px; justify-content: center; margin-bottom: 20px; flex-wrap: wrap;">
            <a href="/dashboard.php" class="btn btn-primary">
                📊 Go to Dashboard
            </a>
            <a href="/login.php" class="btn btn-secondary">
                🔐 Login Again
            </a>
        </div>
        
        <div style="color: #999; font-size: 0.9rem;">
            If you believe this is an error, please contact your administrator.
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include LAYOUTS_PATH . '/main.layout.php';
?>