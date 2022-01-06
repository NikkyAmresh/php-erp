<?php

namespace App\Controllers\Teacher;

use App\Helpers\Constants;
use App\Helpers\Models\Teacher as TeacherHelper;
use App\Helpers\Session;

class TeacherController extends TeacherBaseController
{
    protected $teacherHelper;
    public function __construct(TeacherHelper $teacherHelper)
    {
        $this->teacherHelper = $teacherHelper;
    }

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
            $this->teacher = $this->teacherHelper->getUser($this->loggedTeacherID);
            $this->setTemplateVars(['islogin' => 1, 'name' => $this->teacher->getName()]);
            return true;
        }
        $this->redirect("/teacher", ["message" => "You must need to login!", 'type' => Constants::ERROR]);
        return false;
    }

}
