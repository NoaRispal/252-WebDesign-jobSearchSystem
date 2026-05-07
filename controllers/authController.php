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

            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                $_SESSION['flash'] = "Invalid email or password. Please try again.";
                $_SESSION['flash_type'] = "danger";
                header("Location: ".$this->baseUrl."/login");
                exit;
            }

            $req = "SELECT role_name 
            FROM roles 
            WHERE role_id = :id;";
            $stmtRole = $this->db->prepare($req);
            $stmtRole->execute(['id' => $user['role_id']]);
            $role = $stmtRole->fetch(PDO::FETCH_ASSOC);
            $roleName = strtolower($role['role_name']);

            // password_verify (PHP built-in) verify hash and salt of a password 
            // (hash and salt are stocked in the password_hash as well as the true password)

            if ($user && password_verify($password, $user['password_hash'])) { 
                $_SESSION['user_id'] = $user['user_id'];
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
                $_SESSION['flash_type'] = "danger";
                header("Location: ".$this->baseUrl."/login");
                exit;
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = htmlspecialchars(trim($_POST['first_name']));
            $lastName  = htmlspecialchars(trim($_POST['last_name']));
            $email     = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password  = $_POST['password'];
            $roleName    = $_POST['role'];
    
            if (strlen($password)<8) {
                $_SESSION['flash'] = "Password length must be greater than 8";
                $_SESSION['flash_type'] = "danger";
                header("Location: " . $this->baseUrl . "/register");
                exit;
            }

            // Email already exists ? 
            $stmtCheck = $this->db->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmtCheck->execute(['email' => $email]);
            
            if ($stmtCheck->fetch()) {
                $_SESSION['flash'] = "This email is already registered.";
                $_SESSION['flash_type'] = "danger";
                header("Location: " . $this->baseUrl . "/register");
                exit;
            }
    
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $req = "SELECT role_id
            FROM roles 
            WHERE role_name = :r_name;";
            $stmtRole = $this->db->prepare($req);
            $stmtRole->execute(['r_name' => strtolower($roleName)]);
            $role = $stmtRole->fetch(PDO::FETCH_ASSOC);
            $roleId = strtolower($role['role_id']);
    
            try {
                $sql = "INSERT INTO users (role_id, email, password_hash) 
                        VALUES (:role_id, :email, :hash_pwd)";
                
                $stmt = $this->db->prepare($sql);
                $success = $stmt->execute([
                    ':email' => $email,
                    ':hash_pwd'  => $passwordHash,
                    ':role_id'  => $roleId
                ]);
                $user_id = $this->db->lastInsertId();

                if (strtolower($roleName)==='employer' && $user_id){
                    $sql = "INSERT INTO employers (user_id, company_name, company_description, website) 
                            VALUES (:user_id, :name, :description, :website)";

                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        ':user_id'     => $user_id, 
                        ':name'        => "Big Company",
                        ':description' => "A very big company",
                        ':website'     => "https://bigcompany.com"
                    ]);
                }
    
                if ($success) {
                    $_SESSION['flash'] = "Account created! You can now log in.";
                    $_SESSION['flash_type'] = "success";
                    header("Location: " . $this->baseUrl . "/login");
                    exit;
                }
            } catch (PDOException $e) {
                error_log("Erreur Register : " . $e->getMessage());
                $_SESSION['flash'] = "An error occurred during registration.".$e->getMessage();
                $_SESSION['flash_type'] = "danger";
                header("Location: " . $this->baseUrl . "/register");
                exit;
            }
        }
    }

    public function reset() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];


            if (strlen($newPassword)<8) {
                $_SESSION['flash'] = "Password length must be greater than 8";
                $_SESSION['flash_type'] = "danger";
                header("Location: " . $this->baseUrl . "/reset");
            }
    
            if ($newPassword !== $confirmPassword) {
                $_SESSION['flash'] = "The passwords do not match.";
                $_SESSION['flash_type'] = "danger";
                header("Location: " . $this->baseUrl."/reset");
                exit;
            }
    
            // User exists ?
            $stmt = $this->db->prepare("SELECT user_id FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
    
            if ($user) {
                $newHash = password_hash($newPassword, PASSWORD_DEFAULT);
    
                $update = $this->db->prepare("UPDATE users SET password_hash = :hash WHERE email = :email");
                $success = $update->execute([
                    'hash'  => $newHash,
                    'email' => $email
                ]);
    
                if ($success) {
                    $_SESSION['flash'] = "Your password has been updated !";
                    $_SESSION['flash_type'] = "success";
                    header("Location: " . $this->baseUrl . "/login");
                    exit;
                }
            } else {
                $_SESSION['flash'] = "No account linked to this email.";
                $_SESSION['flash_type'] = "danger";
                header("Location: " . $this->baseUrl . "/reset");
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