<?php

namespace App\Controllers\Admin;

class AdminBaseController extends \Core\Controller
{

    public function before()
    {
        $this->setTemplateVars(
            ['listItems' => [
                ['name' => 'Home', 'url' => '/admin', 'icon' => 'fa fa-home', 'code' => 'home'],
                ['name' => 'Profile', 'url' => '/admin/profile', 'icon' => 'fa fa-user', 'code' => 'profile'],
                ['name' => 'Department', 'url' => '/admin/department', 'icon' => 'fa fa-user', 'code' => 'department'],
                ['name' => 'Teachers', 'url' => '/admin/teacher', 'icon' => 'fa fa-clock', 'code' => 'teacher'],
                ['name' => 'Batches', 'url' => '/admin/batch', 'icon' => 'fa fa-calendar', 'code' => 'batch'],
                ['name' => 'Courses', 'url' => '/admin/course', 'icon' => 'fa fa-calendar', 'code' => 'course'],
                ['name' => 'Branches', 'url' => '/admin/branch', 'icon' => 'fa fa-calendar', 'code' => 'branch'],
                ['name' => 'Semesters', 'url' => '/admin/semester', 'icon' => 'fa fa-calendar', 'code' => 'semester'],
                ['name' => 'Classes', 'url' => '/admin/classes', 'icon' => 'fa fa-calendar', 'code' => 'classes'],
                ['name' => 'Students', 'url' => '/admin/student', 'icon' => 'fa fa-calendar', 'code' => 'student'],
                ['name' => 'Subjects', 'url' => '/admin/subject', 'icon' => 'fa fa-calendar', 'code' => 'subject'],
                ['name' => 'Periods', 'url' => '/admin/period', 'icon' => 'fa fa-calendar', 'code' => 'period'],
                ['name' => 'Time table', 'url' => '/admin/timeTable', 'icon' => 'fa fa-calendar', 'code' => 'timetable'],
                ['name' => 'Logout', 'url' => '/logout', 'icon' => 'fa fa-sign-out-alt'],
            ],
            ]);
    }

}