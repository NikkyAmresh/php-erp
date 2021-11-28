<?php

namespace App\Controllers\Admin;

class AdminBaseController extends \Core\Controller

{

    public function before()
    {
        $this->setTemplateVars(
            ['listItems' => [
                ['name' => 'Home', 'url' => '/admin', 'icon' => 'fa fa-home'],
                ['name' => 'Department', 'url' => '/admin/department', 'icon' => 'fa fa-user'],
                ['name' => 'Teachers', 'url' => '/admin/teacher', 'icon' => 'fa fa-clock'],
                ['name' => 'Batches', 'url' => '/admin/batch', 'icon' => 'fa fa-calendar'],
                ['name' => 'Courses', 'url' => '/admin/course', 'icon' => 'fa fa-calendar'],
                ['name' => 'Branch', 'url' => '/admin/branch', 'icon' => 'fa fa-calendar'],
                ['name' => 'Semester', 'url' => '/admin/semester', 'icon' => 'fa fa-calendar'],
                ['name' => 'Class', 'url' => '/admin/classes', 'icon' => 'fa fa-calendar'],
                ['name' => 'Student', 'url' => '/admin/student', 'icon' => 'fa fa-calendar'],
                ['name' => 'Subject', 'url' => '/admin/subject', 'icon' => 'fa fa-calendar'],
                ['name' => 'Periods', 'url' => '/admin/period', 'icon' => 'fa fa-calendar'],
                ['name' => 'Time table', 'url' => '/admin/timeTable', 'icon' => 'fa fa-calendar'],
                ['name' => 'Logout', 'url' => '/logout', 'icon' => 'fa fa-sign-out-alt'],
            ],
            ]);
    }

}
