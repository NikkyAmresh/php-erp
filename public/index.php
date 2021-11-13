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
$router->add('{controller}/{action}');
$router->add('login', ['controller' => 'Login', 'action' => 'index']);

$router->add("profile", ['controller' => 'Profile', 'action' => 'xyz']);

$router->dispatch($_SERVER['QUERY_STRING'] ?? '/');
