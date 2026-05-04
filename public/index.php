<?php
session_start();

// Determine the base URL path mapped to the site directory
$baseUrl = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);

// Parse the clean URL
$urlParam = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$urlParam = filter_var($urlParam, FILTER_SANITIZE_URL);
$urlParts = explode('/', $urlParam);

$page = !empty($urlParts[0]) ? $urlParts[0] : 'home';

$basePath = __DIR__ . '/../view/';
$baseUrl = "/252-WebDesign-jobSearchSystem/public";
$viewFile = '';

require_once __DIR__ . '/../config/database.php';
$database = new Database();
$db = $database->getConnection();

switch($page) {
    case 'home':
        $viewFile = 'home/index.php';
        break;
    case 'jobs':
        require_once __DIR__ . '/../controllers/jobseekerController.php';
        require_once __DIR__ . '/../models/jobSearch.php';

        if (!isset($urlParts[1])) $viewFile = 'jobs/list.php';
        elseif ($urlParts[1] === 'detail') {
            $viewFile = 'jobs/detail.php';
            if (isset($urlParts[2])) {
                $_GET['id'] = $urlParts[2]; // Pass clean ID into GET if needed
            }
        } elseif ($urlParts[1] === 'api') {
            header('Content-Type: application/json');
            $response = JobseekerController::handle_request($db, $urlParts);
            echo json_encode($response);
            exit();
        } else $viewFile = 'errors/404.php';
        break;
    case 'about':
        $viewFile = 'pages/about.php';
        break;
    case 'contact':
        $viewFile = 'pages/contact.php';
        break;
    case 'login':
        if (isset($urlParts[1]) && $urlParts[1] === 'auth') {
            require_once '../controllers/AuthController.php';
            $auth = new AuthController($db,$baseUrl);
            $auth->login();
        } else {
            // Sinon, on affiche juste la page de login
            $viewFile = 'auth/login.php';
        }
        break;
    case 'register':
        $viewFile = 'auth/register.php';
        break;
    case 'reset':
        $viewFile = 'auth/reset.php';
        break;
    // BEFORE LOGOUT FIX: No logout route existed in the front controller.
    case 'logout':
        require_once '../controllers/AuthController.php';
        $auth = new AuthController($db, $baseUrl);
        $auth->logout();
        // logout() calls exit(), so nothing below runs
        break;
    case 'employer':
        if (isset($urlParts[1]) && $urlParts[1] === 'dashboard') {
            $viewFile = 'employer/dashboard.php';
        } elseif (isset($urlParts[1]) && $urlParts[1] === 'job-form') {
            $viewFile = 'employer/job_form.php';
        } else {
            $viewFile = 'employer/dashboard.php';
        }
        break;
    case 'admin':
        // RBAC
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . $baseUrl . "/login");
            exit();
        }
        //
        require_once __DIR__ . '/../controllers/AdminController.php';
        $adminCtrl = new AdminController($db,$baseUrl);
        $action = isset($urlParts[1]) ? $urlParts[1] : 'dashboard';

        ob_start();
        $adminCtrl->handleRequest($action);
        $adminContent = ob_get_clean();

        require_once $basePath . 'layouts/header.php';
        echo $adminContent;
        require_once $basePath . 'layouts/footer.php';
        
        exit(); // Exit here so we don't fall through to the default view handler below
        // if (isset($urlParts[1]) && $urlParts[1] === 'dashboard') {
        //     $viewFile = 'admin/dashboard.php';
        // } elseif (isset($urlParts[1]) && $urlParts[1] === 'references') {
        //     $viewFile = 'admin/references.php';
        // } else {
        //     $viewFile = 'admin/dashboard.php';
        // }
        break;
    default:
        // 404 Not Found
        header("HTTP/1.0 404 Not Found");
        $viewFile = 'errors/404.php';
        break;
}

if (!file_exists($basePath . $viewFile)) {
    header("HTTP/1.0 404 Not Found");
    $viewFile = 'errors/404.php';
}

require_once $basePath . 'layouts/header.php';
require_once $basePath . $viewFile;
require_once $basePath . 'layouts/footer.php';
