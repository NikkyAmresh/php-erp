<?php

namespace App\Routes;

use Core\Router;

class Index
{
    protected $router;

    public function init()
    {
        $this->router = new Router();
        $this->setRoutes();
        $this->router->dispatch($_SERVER['QUERY_STRING'] ?? '/');
    }

    public function createManagementRoutes($type)
    {
        $_type = ucfirst($type);
        $controller = "Admin\\$_type";
        $this->router->add("admin/$type", ['controller' => $controller, 'action' => 'index']);
        $this->router->add("admin/$type/{id:\d+}", ['controller' => $controller, 'action' => 'edit']);
        $this->router->add("admin/create$_type", ['controller' => $controller, 'action' => 'create']);
        $this->router->add("admin/update$_type", ['controller' => $controller, 'action' => 'update']);
        $this->router->add("admin/delete$_type/{id:\d+}", ['controller' => $controller, 'action' => 'delete']);
    }

    public function setRoutes()
    {
        $this->router->add('', ['controller' => 'Home', 'action' => 'index']);
        // $this->router->add('{controller}/{action}');
        $this->router->add('login', ['controller' => 'Auth\Login', 'action' => 'index']);
        $this->router->add('logout', ['controller' => 'Auth\Logout', 'action' => 'index']);
        $this->router->add("admin", ['controller' => 'Admin\Index', 'action' => 'index']);

        $this->createManagementRoutes('department');
        $this->createManagementRoutes('teacher');
        $this->createManagementRoutes('batch');
        $this->createManagementRoutes('course');
        $this->createManagementRoutes('branch');
        $this->createManagementRoutes('semester');
        $this->createManagementRoutes('classes');
        $this->createManagementRoutes('student');

    }

}
