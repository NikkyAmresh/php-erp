<?php

namespace App\Controllers\Teacher;

class TeacherBaseController extends \Core\Controller
{

    public function before()
    {
        $this->setTemplateVars(
            ['listItems' => [
                ['name' => 'Home', 'url' => '/teacher', 'icon' => 'fa fa-home', 'code' => 'home'],
                ['name' => 'Profile', 'url' => '/teacher/profile', 'icon' => 'fa fa-user', 'code' => 'profile'],
                ['name' => 'Attendance', 'url' => '#', 'icon' => 'fa fa-clock', 'code' => 'attendance'],
                ['name' => 'Timetable', 'url' => '/teacher/timetable/', 'icon' => 'fa fa-calendar', 'code' => 'timetable'],
                ['name' => 'Logout', 'url' => '/logout', 'icon' => 'fa fa-sign-out-alt'],
            ],
            ]);
    }

}