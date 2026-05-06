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
        require_once __DIR__ . '/../controllers/homeController.php';
        $homeCtrl = new HomeController($db,$baseUrl);
        ob_start();
        $homeCtrl->index();
        $homeCtrl = ob_get_clean();
        require_once $basePath . 'layouts/header.php';
        echo $homeCtrl;
        require_once $basePath . 'layouts/footer.php';
        exit();
        break;
    case 'jobs':
        require_once __DIR__ . '/../controllers/jobseekerController.php';
        require_once __DIR__ . '/../models/jobSearch.php';

        if (!isset($urlParts[1])) $viewFile = 'jobs/list.php';
        elseif ($urlParts[1] === 'detail') {
            $response = JobseekerController::getJobDetail($db);
            require_once $basePath.'layouts/header.php';
            require_once $basePath.'jobs/detail.php';
            require_once $basePath.'layouts/footer.php';
            exit();
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
            require_once __DIR__ . '/../controllers/authController.php';
            $auth = new AuthController($db,$baseUrl);
            $auth->login();
        } else {
            $viewFile = 'auth/login.php';
        }
        break;
    case 'register':
        if (isset($urlParts[1]) && $urlParts[1] === 'auth') {
            require_once __DIR__ . '/../controllers/authController.php';
            $auth = new AuthController($db,$baseUrl);
            $auth->register();
        } else {
            $viewFile = 'auth/register.php';
        }
        break;
    case 'reset':
        if (isset($urlParts[1]) && $urlParts[1] === 'auth') {
            require_once __DIR__ . '/../controllers/authController.php';
            $auth = new AuthController($db,$baseUrl);
            $auth->reset();
        } else {
            $viewFile = 'auth/reset.php';
        }
        break;
    // BEFORE LOGOUT FIX: No logout route existed in the front controller.
    case 'logout':
        require_once '../controllers/authController.php';
        $auth = new AuthController($db, $baseUrl);
        $auth->logout();
        // logout() calls exit(), so nothing below runs
        break;
    case 'employer':
        require_once __DIR__ . '/../controllers/employerController.php';
        $emplCtrl = new EmployerController($db,$baseUrl);
        $action = isset($urlParts[1]) ? $urlParts[1] : 'dashboard';
        ob_start();
        $emplCtrl->handleRequest($action);
        $emplCtrl = ob_get_clean();
        require_once $basePath . 'layouts/header.php';
        echo $emplCtrl;
        require_once $basePath . 'layouts/footer.php';
        exit();
        break;
    case 'admin':
        // RBAC
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: " . $baseUrl . "/login");
            exit();
        }
        //
        require_once __DIR__ . '/../controllers/adminController.php';
        $adminCtrl = new AdminController($db,$baseUrl);
        $action = isset($urlParts[1]) ? $urlParts[1] : 'dashboard';

        ob_start();
        $adminCtrl->handleRequest($action);
        $adminContent = ob_get_clean();

        require_once $basePath . 'layouts/header.php';
        echo $adminContent;
        require_once $basePath . 'layouts/footer.php';
        
        exit();
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
