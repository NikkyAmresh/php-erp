<?php

// echo "test";
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
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
require dirname(__DIR__) . '/vendor/autoload.php';
// /**
//  * Error and Exception handling
//  */
error_reporting(1);
ini_set("mysql.trace_mode", "0");
ini_set('display_errors', 1);

set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
// /**
//  * Routing
//  */
$routes = new \App\Routes\Index();
$routes->init();