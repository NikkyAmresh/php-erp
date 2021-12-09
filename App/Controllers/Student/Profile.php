<?php

namespace App\Controllers\Student;

use App\Controllers\Student\StudentController;

class Profile extends StudentController
{
    protected $pageType = 'profile';

    public function indexAction()
    {
        $res = $this->student->getOneWithJoin();
        $this->setTemplateVars(['student' => $res]);
        $this->renderTemplate('Student/Dashboard/Homepage/profile.html');
    }
}