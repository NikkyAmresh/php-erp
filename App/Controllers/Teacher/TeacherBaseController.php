<?php

namespace App\Controllers\Teacher;

class TeacherBaseController extends \Core\Controller

{

    public function before()
    {
        $this->setTemplateVars(
            ['listItems' => [
                ['name' => 'Home', 'url' => '/teacher', 'icon' => 'fa fa-home'],
                ['name' => 'Profile', 'url' => '#', 'icon' => 'fa fa-user'],
                ['name' => 'Attendance', 'url' => '#', 'icon' => 'fa fa-clock'],
                ['name' => 'Timetable', 'url' => '/teacher/timetable/', 'icon' => 'fa fa-calendar'],
                ['name' => 'Logout', 'url' => '/logout', 'icon' => 'fa fa-sign-out-alt'],
            ],
            ]);
    }

}
