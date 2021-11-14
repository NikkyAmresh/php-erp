<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */

//  phpinfo();
// echo $_SERVER['QUERY_STRING'] ;
// echo $_GET['url'] ;
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
// $router->add('{controller}/{action}');
$router->add('login', ['controller' => 'Auth\Login', 'action' => 'index']);
$router->add('logout', ['controller' => 'Auth\Logout', 'action' => 'index']);

$router->add("profile", ['controller' => 'Profile', 'action' => 'xyz']);

$router->add("admin", ['controller' => 'Admin\Index', 'action' => 'index']);
$router->add("admin/department", ['controller' => 'Admin\Department', 'action' => 'index']);
$router->add("admin/department/{id:\d+}", ['controller' => 'Admin\Department', 'action' => 'edit']);
$router->add("admin/createDepartment", ['controller' => 'Admin\Department', 'action' => 'create']);
$router->add("admin/deleteDepartment/{id:\d+}", ['controller' => 'Admin\Department', 'action' => 'delete']);

$router->dispatch($_SERVER['QUERY_STRING'] ?? '/');
