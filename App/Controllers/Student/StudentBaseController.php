<?php

namespace App\Controllers\Student;

class StudentBaseController extends \Core\Controller
{

    public function before()
    {
        $this->setTemplateVars(
            ['listItems' => [
                ['name' => 'Home', 'url' => '/student', 'icon' => 'fa fa-home', 'code' => 'home'],
                ['name' => 'Profile', 'url' => '/student/profile', 'icon' => 'fa fa-user', 'code' => 'profile'],
                ['name' => 'Attendance', 'url' => '#', 'icon' => 'fa fa-clock', 'code' => 'attendance'],
                ['name' => 'Timetable', 'url' => '/student/timetable/', 'icon' => 'fa fa-calendar', 'code' => 'timetable'],
                ['name' => 'Logout', 'url' => '/logout', 'icon' => 'fa fa-sign-out-alt'],
            ],
            ]);
    }

}