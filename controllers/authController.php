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
            #######################################
            #### DEMO (DELETE WHEN DB FINISH) #####
            #######################################

            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            $email = strtolower(trim($email));

            switch($email) { 
                case "admin@jobportal.com":
                    $_SESSION['user_id'] = 1;
                    $_SESSION['role'] = "admin";
                    $_SESSION['full_name'] = "John Admin";
                    header("Location: ".$this->baseUrl."/admin/dashboard");
                    exit();
                    break;
                case 'employer@company.com':
                    $_SESSION['user_id'] = 2;
                    $_SESSION['role'] = "employer";
                    $_SESSION['full_name'] = "John employer";
                    header("Location: employer/dashboard");
                    break;
                default:
                    $_SESSION['user_id'] = 3;
                    $_SESSION['role'] = "job_seeker";
                    $_SESSION['full_name'] = "John Seeker";
                    header("Location: home");
                    break;
                }

            #######################################
            #### DEMO (DELETE WHEN DB FINISH) #####
            #######################################

            // $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            // $password = $_POST['password'];

            // $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
            // $stmt->execute(['email' => $email]);
            // $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // // password_verify (PHP built-in) verify hash and salt of a password 
            // // (hash and salt are stocked in the password_hash as well as the true password)

            // if ($user && password_verify($password, $user['password_hash'])) { 
            //     $_SESSION['user_id'] = $user['id'];
            //     $_SESSION['role'] = $user['role']; // admin, employer, or job_seeker
            //     $_SESSION['full_name'] = $user['full_name'];

            //     switch($user['role']) {
            //         case 'admin':
            //             header("Location: /admin/dashboard");
            //             break;
            //         case 'employer':
            //             header("Location: /employer/dashboard");
            //             break;
            //         default:
            //             header("Location: /home");
            //             break;
            //     }
            //     exit;
            // } else {
            //     $_SESSION['login_error'] = "Invalid email or password.";
            //     header("Location: /login");
            //     exit;
            // }
        }
    }
}
?>