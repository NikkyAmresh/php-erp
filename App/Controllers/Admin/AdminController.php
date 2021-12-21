<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;
use App\Models\Admin as AdminModel;

class AdminController extends AdminBaseController
{
    protected $adminModel;
    public function __construct(AdminModel $adminModel)
    {
        $this->adminModel = $adminModel;
    }
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_ADMIN_ID);
    }
    public function before()
    {
        parent::before();
        $adminID = $this->isLoggedIn();
        if ($adminID) {
            $this->loggedAdminID = $adminID;
            $this->admin = $this->adminModel->bind($this->loggedAdminID);
            $this->setTemplateVars(['islogin' => 1, 'name' => $this->admin->getName()]);
            return true;
        }
        $this->setErrorMessage("You must need to login!");
        $this->redirect("/admin");
        return false;
    }

}
