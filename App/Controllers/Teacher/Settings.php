<?php

namespace App\Controllers\Teacher;

use App\Helpers\Constants;
use App\Helpers\Models\Teacher as TeacherHelper;

class Settings extends TeacherController
{
    protected $pageCode = 'settings';

    protected $teacherHelper;
    public function __construct(
        TeacherHelper $teacherHelper
    ) {
        $this->teacherHelper = $teacherHelper;

        parent::__construct($teacherHelper);
    }

    public function indexAction()
    {
        $this->renderTemplate('Teacher/Dashboard/Settings/index.html');
    }
    public function changePasswordAction()
    {
        $this->renderTemplate('Teacher/Dashboard/Settings/password.html');
    }
    public function changePasswordRequestHandlerAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if (!($_REQUEST["newPassword"] == $_REQUEST["confirmPassword"])) {
                $this->setErrorMessage("Password didn't match.Please try again.");
            } else {
                $result = $this->teacherHelper->changePassword($this->teacher->getUserID(), $_REQUEST);
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
        return $this->redirect('/teacher/settings/changePassword');
    }
}
