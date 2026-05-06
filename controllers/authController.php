<?php 
include_once '../config/database.php';

class AuthController {
    private $db;
    private $baseUrl;

    public function __construct($db,$baseUrl) {
        $this->db = $db;
        $this->baseUrl = $baseUrl;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $stmt = $this->db->prepare("SELECT * FROM Users WHERE Email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $_SESSION['flash'] = "Invalid email or password. Please try again.";
                header("Location: ".$this->baseUrl."/login");
                exit;
            }

            $req = "SELECT Role_Name 
            FROM ROLES 
            WHERE Role_ID = :id;";
            $stmtRole = $this->db->prepare($req);
            $stmtRole->execute(['id' => $user['Role_ID']]);
            $role = $stmtRole->fetch(PDO::FETCH_ASSOC);
            $roleName = strtolower($role['Role_Name']);

            // password_verify (PHP built-in) verify hash and salt of a password 
            // (hash and salt are stocked in the password_hash as well as the true password)

            if ($user && password_verify($password, $user['Password_Hash'])) { 
                $_SESSION['user_id'] = $user['User_ID'];
                $_SESSION['role'] = $roleName; // admin, employer, or job_seeker
                // $_SESSION['full_name'] = $user['full_name'];

                switch($roleName) {
                    case 'admin':
                        header("Location: ".$this->baseUrl."/admin/dashboard");
                        break;
                    case 'employer':
                        header("Location: ".$this->baseUrl."/employer/dashboard");
                        break;
                    default:
                        header("Location: ".$this->baseUrl."/home");
                        break;
                }
                exit;
            } else {
                // $_SESSION['flash'] = password_hash("admin123",PASSWORD_DEFAULT);
                $_SESSION['flash'] = "Invalid email or password. Please try again.";
                header("Location: ".$this->baseUrl."/login");
                exit;
            }
        }
    }

    /**
     * Logout — destroy session and redirect to login page.
     * BEFORE LOGOUT FIX: No logout method existed; sidebar links just navigated to /login without clearing session.
     */
    public function logout() {
        // Clear all session variables
        $_SESSION = array();

        // Destroy the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy the session
        session_destroy();

        // Redirect to login page
        header("Location: " . $this->baseUrl . "/login");
        exit();
    }
}
?>