<?php
//define path of application
define('APPLICATION_PATH', getcwd().'/../app/');

//config
require_once APPLICATION_PATH . 'Core/config.php';

//composer psr-4 autoload
require_once APPLICATION_PATH . 'vendor/autoload.php';

//Initialize Illuminate Database Connection
$DataBase = \App\Core\Connection::getInstance();
//Check connection
try {
    $DataBase::connection()->getPdo();
} catch (\Exception $e) {
    die("Could not connect to the database. Please check your configuration.");
}

//request routes
$routes = explode('/', $_SERVER['REQUEST_URI']);

//default controller and action
$controllerName = "Main";
$actionName = 'index'; // defaultAction
$parametres = [];

foreach ($routes as $routeKey => $routeVal) {
    if ($routeVal) {
        switch ($routeKey) {
            case '0':
                break;
            case '1':
                $controllerName = $routeVal;
                break;
            case '2':
                $actionName = $routeVal;
                break;
            default:
                $parametres[] = $routeVal;
        }
    }
}

try {
    $classname = "App\Controllers\\" . ucfirst($controllerName);
    if (class_exists($classname)) {
        $controller = new $classname();
    } else {
        throw new Exception("Класс отсутсвует");
    }
    if (method_exists($controller, $actionName)) {
        $controller->$actionName($parametres);
    } else {
        throw new Exception("Метод класса отсутсвует");
    }
} catch (Exception $e) {
    require APPLICATION_PATH . "errors/showError404.php";
}
