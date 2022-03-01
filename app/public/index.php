<?php
ob_start();
/**
 * Index.php
 * Hacer pantalla de edición => poder editar habilidades también => mi implementación está bien?
 * Hacer funcionalidad de peticiones => poder agregar peticiones desde el panel de ciudadano y consultarlas y marcarlas como realizadas desde el panel de superheroe y sh experto 
 * Hacer funcionalidad de login => el registro como superheroe experto? qué pasa si te ascienden? eso no lo entiendo bien
 * Hacer funcionalidad de la imagen => lo hacemos como lo hicimos hace un trimestre
 * Usarlo como servicio. Crear una clase en services
 */
require_once('../app/config/parametros.php');
require_once('../vendor/autoload.php');

use App\Core\Router;
use App\Controllers\IndexController;
use App\Controllers\SHController;
use App\Controllers\AjaxController;
use App\Controllers\AuthController;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
define ('IMG_DIRECTORY', realpath(dirname(__FILE__) ). "/imgs/");

if (!isset($_SESSION['perfil'])) {
    $_SESSION['perfil'] = 'invitado';
}
$router = new Router();
$router->add(
    array(
        'name' => 'home',
        'path' => '//',
        'action' => [IndexController::class, 'IndexAction']
    ),
);

$router->add(
    array(
        'name' => 'add',
        'path' => '/^\/superheroes\/add$/',
        'action' => [SHController::class, 'AddAction']
    ),
);

$router->add(
    array(
        'name' => 'del',
        'path' => '/^\/superheroes\/delete\/[0-9]{1,3}$/',
        'action' => [SHController::class, 'DelAction']
    )
);

$router->add(
    array(
        'name' => 'edit',
        'path' => '/^\/superheroes\/edit\/[0-9]{1,3}$/',
        'action' => [SHController::class, 'EditAction']
    )
);

$router->add(
    array(
        'name' => 'addSkill',
        'path' => '/^\/superheroes\/addSkills\/[0-9]{1,3}$/',
        'action' => [SHController::class, 'AddSkillAction']
    )
);

$router->add(
    array(
        'name' => 'modifySkill',
        'path' => '/^\/superheroes\/modifySkill\/[0-9]{1,3}$/',
        'action' => [SHController::class, 'modifySkillAction']
    )
);

$router->add(
    array(
        'name' => 'addRequest',
        'path' => '/^\/superheroes\/addRequest\/[0-9]{1,3}$/',
        'action' => [SHController::class, 'AddRequestAction']
    )
);

$router->add(
    array(
        'name' => 'listRequests',
        'path' => '/^\/superheroes\/listRequests$/',
        'action' => [SHController::class, 'ListRequestsAction']
    )
);

$router->add(
    array(
        'name' => 'listSkills',
        'path' => '/^\/superheroes\/listSkills$/',
        'action' => [SHController::class, 'ListSkillsAction']
    )
);

$router->add(
    array(
        'name' => 'completeRequest',
        'path' => '/^\/superheroes\/requestDone\/[0-9]{1,3}$/',
        'action' => [SHController::class, 'CompleteRequestAction']
    )
);

$router->add(
    array(
        'name' => 'login',
        'path' => '/^\/superheroes\/login$/',
        'action' => [AuthController::class, 'LoginAction']
    ),
);

$router->add(
    array(
        'name' => 'register',
        'path' => '/^\/superheroes\/register$/',
        'action' => [AuthController::class, 'RegisterAction']
    ),
);

$router->add(
    array(
        'name' => 'logout',
        'path' => '/^\/superheroes\/logout$/',
        'action' => [AuthController::class, 'LogoutAction']
    ),
);

$router->add(
    array(
        'name' => 'info',
        'path' => '/^\/superheroes\/info$/',
        'action' => [AuthController::class, 'InfoAction']
    ),
);


$router->add(
    array(
        'name' => 'list_superheroes',
        'path' => '/^\/ajax\?nombre=(.*)$/',
        'action' => [AjaxController::class, 'AjaxAction']
    ),
);

$router->add(
    array(
        'name' => 'list_requests',
        'path' => '/^\/ajax\?peticion=(.*)$/',
        'action' => [AjaxController::class, 'AjaxRequestAction']
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
// ob_end_flush();