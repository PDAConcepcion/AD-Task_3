<?php
require_once __DIR__ . '/bootstrap.php';
require_once HANDLERS_PATH . '/postgreAuth.handler.php';

if ($auth->isLoggedIn()) {
    header('Location: /dashboard.php');
    exit;
}

$pageTitle = 'Login - TaskFlow';
$showContainer = false;

ob_start();
?>

<div style="
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
">
    <div style="
        width: 100%;
        max-width: 420px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.2);
    ">
        <div style="text-align: center; margin-bottom: 30px;">
            <h2 style="margin: 0 0 10px 0; color: #333; font-size: 1.8rem;">🔐 Welcome Back</h2>
            <p style="margin: 0; color: #666; font-size: 1rem;">Sign in to your TaskFlow account</p>
        </div>
        
        <?php if (isset($loginError)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($loginError) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['message']) && $_GET['message'] === 'logged_out'): ?>
            <div class="alert alert-success">
                You have been successfully logged out.
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="action" value="login">
            
            <div style="margin-bottom: 20px;">
                <label for="username" style="display: block; margin-bottom: 6px; font-weight: 500; color: #333;">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                       placeholder="Enter your username">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; margin-bottom: 6px; font-weight: 500; color: #333;">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required
                       placeholder="Enter your password">
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;">
                Sign In
            </button>
        </form>
        
        <div style="margin-top: 30px; padding: 20px; background: rgba(102, 126, 234, 0.1); border-radius: 8px; text-align: center;">
            <h4 style="margin: 0 0 15px 0; color: #333; font-size: 1rem;">🧪 Demo Accounts</h4>
            <div style="margin: 8px 0; font-size: 0.9rem; color: #555; font-family: monospace; background: rgba(255, 255, 255, 0.7); padding: 8px; border-radius: 4px;">
                <strong>Admin:</strong> admin.user / AdminPass456#
            </div>
            <div style="margin: 8px 0; font-size: 0.9rem; color: #555; font-family: monospace; background: rgba(255, 255, 255, 0.7); padding: 8px; border-radius: 4px;">
                <strong>Manager:</strong> mike.wilson / MikePass789$
            </div>
            <div style="margin: 8px 0; font-size: 0.9rem; color: #555; font-family: monospace; background: rgba(255, 255, 255, 0.7); padding: 8px; border-radius: 4px;">
                <strong>Developer:</strong> john.smith / SecurePass123!
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include LAYOUTS_PATH . '/main.layout.php';
?>