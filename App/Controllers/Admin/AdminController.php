<?php

namespace App\Controllers\Admin;

use App\Helpers\Constants;
use App\Helpers\Session;

class AdminController extends \Core\Controller
{
    public function isLoggedIn()
    {
        return Session::get(Constants::LOGGED_IN_ADMIN_ID);
    }
    public function before()
    {
        if ($this->isLoggedIn()) {
            return true;
        }
        $this->redirect("/admin", array("message" => "You must need to login!", 'type' => Constants::ERROR));
        return false;
    }

}
