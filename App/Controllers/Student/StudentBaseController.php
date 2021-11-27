<?php

namespace App\Controllers\Student;

class StudentBaseController extends \Core\Controller
{

    public function before()
    {
        $this->setTemplateVars([
            ['listItems', [
                ['name' => 'Home', 'url' => '/student', 'icon' => 'fa fa-home'],
                ['name' => 'Profile', 'url' => '#', 'icon' => 'fa fa-user'],
                ['name' => 'Attendance', 'url' => '#', 'icon' => 'fa fa-clock'],
                ['name' => 'Timetable', 'url' => '/student/timetable/', 'icon' => 'fa fa-calendar'],
                ['name' => 'Logout', 'url' => '/logout', 'icon' => 'fa fa-sign-out-alt'],
            ],
            ]]);
    }

}
