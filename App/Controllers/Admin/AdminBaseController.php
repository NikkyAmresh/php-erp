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
                ['name' => 'Department', 'url' => '/admin/department', 'icon' => 'fas fa-building', 'code' => 'department'],
                ['name' => 'Teachers', 'url' => '/admin/teacher', 'icon' => 'fas fa-chalkboard-teacher', 'code' => 'teacher'],
                ['name' => 'Batches', 'url' => '/admin/batch', 'icon' => 'fas fa-layer-group', 'code' => 'batch'],
                ['name' => 'Courses', 'url' => '/admin/course', 'icon' => 'fas fa-book', 'code' => 'course'],
                ['name' => 'Branches', 'url' => '/admin/branch', 'icon' => 'fas fa-code-branch', 'code' => 'branch'],
                ['name' => 'Semesters', 'url' => '/admin/semester', 'icon' => 'fas fa-book-open', 'code' => 'semester'],
                ['name' => 'Classes', 'url' => '/admin/classes', 'icon' => 'fas fa-users-class', 'code' => 'classes'],
                ['name' => 'Students', 'url' => '/admin/student', 'icon' => 'fas fa-user-graduate', 'code' => 'student'],
                ['name' => 'Subjects', 'url' => '/admin/subject', 'icon' => 'fas fa-books', 'code' => 'subject'],
                ['name' => 'Periods', 'url' => '/admin/period', 'icon' => 'fas fa-clock', 'code' => 'period'],
                ['name' => 'Time table', 'url' => '/admin/timeTable', 'icon' => 'fa fa-calendar', 'code' => 'timetable'],
                ['name' => 'Logout', 'url' => '/logout', 'icon' => 'fa fa-sign-out-alt'],
            ],
            ]);
    }

}
