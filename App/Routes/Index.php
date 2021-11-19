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
        $this->createManagementRoutes('subject');
        $this->createManagementRoutes('period');
        $this->createManagementRoutes('timeTable');

        $this->router->add("admin/getTimeTable/{id:\d+}", ['controller' => 'Admin\TimeTable', 'action' => 'get']);
        $this->router->add("admin/showTimeTable", ['controller' => 'Admin\TimeTable', 'action' => 'show']);
        $this->router->add("admin/setTimeTable", ['controller' => 'Admin\TimeTable', 'action' => 'updateByClass']);
        
        $this->router->add("student", ['controller' => 'Student\Index', 'action' => 'index']);
        $this->router->add("student/getTimeTable", ['controller' => 'Student\TimeTable', 'action' => 'get']);
        $this->router->add("student/timeTable", ['controller' => 'Student\TimeTable', 'action' => 'show']);
        
        $this->router->add("teacher", ['controller' => 'teacher\Index', 'action' => 'index']);
        $this->router->add("teacher/getTimeTable", ['controller' => 'teacher\TimeTable', 'action' => 'get']);
        $this->router->add("teacher/timeTable", ['controller' => 'teacher\TimeTable', 'action' => 'show']);
        $this->router->add("teacher/attendance/{id:\d+}", ['controller' => 'teacher\Attendance', 'action' => 'mark']);

    }

}
