<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Models\Admin as AdminHelper;
use App\Helpers\Session;

class AdminController extends AdminBaseController
{
    protected $adminHelper;
    public function __construct(AdminHelper $adminHelper)
    {
        $this->adminHelper = $adminHelper;
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
            $this->admin = $this->adminHelper->getUser($this->loggedAdminID);
            $this->setTemplateVars(['islogin' => 1, 'name' => $this->admin->getName()]);
            return true;
        }
        $this->setErrorMessage("You must need to login!");
        $this->redirect("/admin");
        return false;
    }

}
