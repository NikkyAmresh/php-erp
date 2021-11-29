<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Teacher;

class Profile extends TeacherController
{
    public function profileAction()
    {
        $teacher = new Teacher(Session::get(Constants::LOGGED_IN_TEACHER_ID));
        $res = $teacher->getOneWithJoin();
        $this->setTemplateVars(['teacher' => $res]);
        $this->renderTemplate('Teacher/Dashboard/profile.html');
    }
}
