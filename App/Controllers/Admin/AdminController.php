<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Admin;

class AdminController extends AdminBaseController
{
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_ADMIN_ID);
    }
    public function before()
    {
        parent::before();
        $studentID = $this->isLoggedIn();
        if ($studentID) {
            $this->loggedStudentID = $studentID;
            $this->admin = new Admin($this->loggedStudentID);
            $this->setTemplateVars(['islogin' => 1, 'name' => $this->admin->getName()]);
            return true;
        }
        $this->setErrorMessage("You must need to login!");
        $this->redirect("/admin");
        return false;
    }

}
