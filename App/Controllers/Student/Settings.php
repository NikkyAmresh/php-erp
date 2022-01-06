<?php

namespace App\Controllers\Student;

use App\Helpers\Constants;
use App\Helpers\Models\Student as StudentHelper;

class Settings extends StudentController
{
    protected $pageCode = 'settings';

    protected $studentHelper;
    public function __construct(
        StudentHelper $studentHelper
    ) {
        $this->studentHelper = $studentHelper;

        parent::__construct($studentHelper);
    }

    public function indexAction()
    {
        $this->renderTemplate('Student/Dashboard/Settings/index.html');
    }
    public function changePasswordAction()
    {
        $this->renderTemplate('Student/Dashboard/Settings/password.html');
    }
    public function changePasswordRequestHandlerAction()
    {
        if ($_SERVER["REQUEST_METHOD"] == Constants::REQUEST_METHOD_POST) {
            if (!($_REQUEST["newPassword"] == $_REQUEST["confirmPassword"])) {
                $this->setErrorMessage("Password didn't match.Please try again.");
            } else {
                $result = $this->studentHelper->changePassword($this->student->getUserID(), $_REQUEST);
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
        return $this->redirect('/student/settings/changePassword');
    }
}
