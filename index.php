<?php
$page = $_GET['page'] ?? 'auth';
$action = $_GET['action'] ?? 'loginForm';

switch ($page) {
    case 'auth':
        require_once("controllers/AuthController.php");
        $controller = new AuthController();
        break;
    case 'loueur':
        require_once("controllers/LoueurController.php");
        $controller = new LoueurController();
        break;
    case 'admin':
        require_once("controllers/AdminController.php");
        $controller = new AdminController();
        break;
    default:
        die("Page non trouvée.");
}

if (method_exists($controller, $action)) {
    $controller->$action();
} else {
    die("Action non trouvée.");
}
