<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;
use App\Models\Student;

class Profile extends StudentController
{
    public function indexAction()
    {
        $res = $this->student->getOneWithJoin();
        $this->setTemplateVars(['student' => $res]);
        $this->renderTemplate('Student/Dashboard/Homepage/profile.html');
    }
}
