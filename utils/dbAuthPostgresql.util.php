<?php
declare(strict_types=1);

class AuthUtil {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Authenticate user with username and password
     */
    public function login(string $username, string $password): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT id, username, first_name, last_name, role, password 
                FROM users 
                WHERE username = :username
            ");
            
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
                return ['success' => false, 'message' => 'User not found'];
            }
            
            if (!password_verify($password, $user['password'])) {
                return ['success' => false, 'message' => 'Invalid password'];
            }
            
            // Remove password from session data
            unset($user['password']);
            
            $_SESSION['user'] = $user;
            $_SESSION['is_logged_in'] = true;
            
            return ['success' => true, 'user' => $user];
            
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
    
    /**
     * Log out user
     */
    public function logout(): void {
        $_SESSION = [];
        session_destroy();
    }
    
    /**
     * Check if user is logged in
     */
    public function isLoggedIn(): bool {
        return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
    }
    
    /**
     * Get current user data
     */
    public function getCurrentUser(): ?array {
        return $_SESSION['user'] ?? null;
    }
    
    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool {
        $user = $this->getCurrentUser();
        return $user && $user['role'] === $role;
    }
    
    /**
     * Require login - redirect if not logged in
     */
    public function requireLogin(string $redirectTo = '/login.php'): void {
        if (!$this->isLoggedIn()) {
            header("Location: $redirectTo");
            exit;
        }
    }
    
    /**
     * Require specific role - redirect if not authorized
     */
    public function requireRole(string $role, string $redirectTo = '/unauthorized.php'): void {
        $this->requireLogin();
        if (!$this->hasRole($role)) {
            header("Location: $redirectTo");
            exit;
        }
    }
}