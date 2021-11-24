<?php

namespace App\Controllers\Auth;

use App\Helpers\Constants;
use \App\Helpers\Session;

class Logout extends \Core\Controller

{

    public function indexAction()
    {
        if (Session::get(Constants::LOGGED_IN_STUDENT_USER_ID)) {
            Session::reset();

            $this->redirect('/student', ['type' => Constants::SUCCESS, 'message' => 'Logout Success!']);
        } elseif (Session::get(Constants::LOGGED_IN_TEACHER_USER_ID)) {
            Session::reset();

            $this->redirect('/teacher', ['type' => Constants::SUCCESS, 'message' => 'Logout Success!']);
        } elseif (Session::get(Constants::LOGGED_IN_ADMIN_ID)) {
            Session::reset();

            $this->redirect('/admin', ['type' => Constants::SUCCESS, 'message' => 'Logout Success!']);
        }
    }
}
