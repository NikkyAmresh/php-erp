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
$router->add("admin/updateDepartment", ['controller' => 'Admin\Department', 'action' => 'update']);
$router->add("admin/deleteDepartment/{id:\d+}", ['controller' => 'Admin\Department', 'action' => 'delete']);

$router->add("admin/teacher", ['controller' => 'Admin\Teacher', 'action' => 'index']);
$router->add("admin/teacher/{id:\d+}", ['controller' => 'Admin\Teacher', 'action' => 'edit']);
$router->add("admin/createTeacher", ['controller' => 'Admin\Teacher', 'action' => 'create']);
$router->add("admin/updateTeacher", ['controller' => 'Admin\Teacher', 'action' => 'update']);
$router->add("admin/deleteTeacher/{id:\d+}", ['controller' => 'Admin\Teacher', 'action' => 'delete']);

$router->add("admin/batches", ['controller' => 'Admin\Batch', 'action' => 'index']);
$router->add("admin/batches/{id:\d+}", ['controller' => 'Admin\Batch', 'action' => 'edit']);
$router->add("admin/deleteBatch/{id:\d+}", ['controller' => 'Admin\Batch', 'action' => 'delete']);
$router->add("admin/updateBatch", ['controller' => 'Admin\Batch', 'action' => 'update']);
$router->add("admin/createBatch", ['controller' => 'Admin\Batch', 'action' => 'create']);

$router->add("admin/course", ['controller' => 'Admin\Course', 'action' => 'index']);
$router->add("admin/createCourse", ['controller' => 'Admin\Course', 'action' => 'create']);
$router->add("admin/course/{id:\d+}", ['controller' => 'Admin\Course', 'action' => 'edit']);
$router->add("admin/deleteCourse/{id:\d+}", ['controller' => 'Admin\Course', 'action' => 'delete']);
$router->add("admin/updateCourse", ['controller' => 'Admin\Course', 'action' => 'update']);

$router->add("admin/branch", ['controller' => 'Admin\Branch', 'action' => 'index']);
$router->add("admin/createBranch", ['controller' => 'Admin\Branch', 'action' => 'create']);
$router->add("admin/branch/{id:\d+}", ['controller' => 'Admin\Branch', 'action' => 'edit']);
$router->add("admin/deleteBranch/{id:\d+}", ['controller' => 'Admin\Branch', 'action' => 'delete']);
$router->add("admin/updateBranch", ['controller' => 'Admin\Branch', 'action' => 'update']);

$router->dispatch($_SERVER['QUERY_STRING'] ?? '/');
