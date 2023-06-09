<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Models\Admin as AdminHelper;

class Settings extends AdminController
{
    protected $pageCode = 'settings';

    protected $adminHelper;
    public function __construct(
        AdminHelper $adminHelper
    ) {
        $this->adminHelper = $adminHelper;
        parent::__construct($adminHelper);
    }

    public function indexAction()
    {
        $this->renderTemplate('Admin/Dashboard/Settings/index.html');
    }
    public function changePasswordAction()
    {
        $this->renderTemplate('Admin/Dashboard/Settings/password.html');
    }
    public function changePasswordRequestHandlerAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if (!($_REQUEST["newPassword"] == $_REQUEST["confirmPassword"])) {
                $this->setErrorMessage("Password didn't match.Please try again.");
            } else {
                $result = $this->adminHelper->changePassword($this->admin->getUserID(), $_REQUEST);
                if ($result === -1) {
                    $this->setErrorMessage("Incorrect old password");
                } else if ($result) {
                    $this->setSuccessMessage("Password changed succesfully.");
                } else {
                    $this->setErrorMessage("Unable to change password. Please try again.");
                }

            }
        } else {
            $this->setErrorMessage("Invalid Request!");
        }
        return $this->redirect('/admin/settings/changePassword');
    }
}
