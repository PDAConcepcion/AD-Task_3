<?php
require_once BASE_PATH . '/bootstrap.php';  // This should go UP one directory
require_once HANDLERS_PATH . '/postgreAuth.handler.php';

if ($auth->isLoggedIn()) {
    header('Location: /pages/dashboard.php');
    exit;
}

// Enable login processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $loginError = 'Please enter both username and password.';
    } else {
        $loginResult = $auth->login($username, $password);
        
        if ($loginResult['success']) {
            header('Location: /pages/dashboard.php');
            exit;
        } else {
            $loginError = $loginResult['message'] ?? 'Invalid username or password.';
        }
    }
}

$pageTitle = 'Login - TaskFlow';
$showContainer = false;

ob_start();
?>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h2 class="login-title">🔐 Welcome Back</h2>
            <p class="login-subtitle">Sign in to your TaskFlow account</p>
        </div>
        
        <?php if (isset($loginError)): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($loginError) ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/pages/login.php">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label for="username" class="form-label">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required 
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                       placeholder="Enter your username">
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required
                       placeholder="Enter your password">
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg">
                Sign In
            </button>
        </form>
        
        <div class="demo-section">
            <h4 class="demo-title">🧪 Demo Accounts</h4>
            <div class="demo-account">
                <strong>Admin:</strong> admin.user / AdminPass456#
            </div>
            <div class="demo-account">
                <strong>Manager:</strong> mike.wilson / MikePass789$
            </div>
            <div class="demo-account">
                <strong>Developer:</strong> john.smith / SecurePass123!
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include LAYOUTS_PATH . '/main.layout.php';
?>