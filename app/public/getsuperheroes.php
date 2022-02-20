<?php 
require_once('../app/config/parametros.php');
require_once('../vendor/autoload.php');

use App\Core\Router;
use App\Controllers\AjaxController;

$router = new Router();

$router->add(
    array(
        'name' => 'home',
        'path' => '/\/actividades\/Ud6\/SH\/public\/getsuperheroes.php/',
        'action' => [AjaxController::class, 'AjaxAction']
    ),
);

$request = str_replace(DIRBASEURL, '', $_SERVER['REQUEST_URI']);
$route = $router->matchs($request);

if ($route) {
    $controllerName = $route['action'][0];
    $actionName = $route['action'][1];
    $controller = new $controllerName;
    $controller->$actionName($request);
} else {
    echo "No route";
}
