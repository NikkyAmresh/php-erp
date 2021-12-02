<?php

namespace App\Controllers\Teacher;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Teacher;

class TeacherController extends TeacherBaseController
{
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_TEACHER_ID);
    }
    public function before()
    {

        parent::before();
        $teacherID = $this->isLoggedIn();
        if ($this->isLoggedIn()) {
            $this->loggedTeacherID = $teacherID;
            $this->teacher = new Teacher($this->loggedTeacherID);
            $this->setTemplateVars(['islogin' => 1, 'name' => $this->teacher->getName()]);
            return true;
        }
        $this->redirect("/teacher", ["message" => "You must need to login!", 'type' => Constants::ERROR]);
        return false;
    }

}
