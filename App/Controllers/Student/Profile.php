<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;
use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Student;

class Profile extends StudentController
{
    public function profileAction()
    {
        $student = new Student(Session::get(Constants::LOGGED_IN_STUDENT_ID));
        $res = $student->getOneWithJoin();
        $this->setTemplateVars(['student' => $res]);
        $this->renderTemplate('Student/Dashboard/Homepage/profile.html');
    }
}
