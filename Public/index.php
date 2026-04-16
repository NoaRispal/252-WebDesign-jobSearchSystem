<?php
session_start();

// Determine the base URL path mapped to the site directory
$baseUrl = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);

// Parse the clean URL
$urlParam = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
$urlParam = filter_var($urlParam, FILTER_SANITIZE_URL);
$urlParts = explode('/', $urlParam);

$page = !empty($urlParts[0]) ? $urlParts[0] : 'home';

$basePath = __DIR__ . '/../View/';
$viewFile = '';

switch($page) {
    case 'home':
        $viewFile = 'home/index.php';
        break;
    case 'jobs':
        if (isset($urlParts[1]) && $urlParts[1] === 'detail') {
            $viewFile = 'jobs/detail.php';
            if (isset($urlParts[2])) {
                $_GET['id'] = $urlParts[2]; // Pass clean ID into GET if needed
            }
        } else {
            $viewFile = 'jobs/list.php';
        }
        break;
    case 'about':
        $viewFile = 'pages/about.php';
        break;
    case 'contact':
        $viewFile = 'pages/contact.php';
        break;
    case 'login':
        $viewFile = 'auth/login.php';
        break;
    case 'register':
        $viewFile = 'auth/register.php';
        break;
    case 'reset':
        $viewFile = 'auth/reset.php';
        break;
    case 'employer':
        if (isset($urlParts[1]) && $urlParts[1] === 'dashboard') {
            $viewFile = 'employer/dashboard.php';
        } elseif (isset($urlParts[1]) && $urlParts[1] === 'job-form') {
            $viewFile = 'employer/job-form.php';
        } else {
            $viewFile = 'employer/dashboard.php';
        }
        break;
    case 'admin':
        if (isset($urlParts[1]) && $urlParts[1] === 'dashboard') {
            $viewFile = 'admin/dashboard.php';
        } elseif (isset($urlParts[1]) && $urlParts[1] === 'references') {
            $viewFile = 'admin/references.php';
        } else {
            $viewFile = 'admin/dashboard.php';
        }
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
