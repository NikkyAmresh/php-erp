<?php

namespace App\Controllers\Auth;

use App\Helpers\Constants;
use \App\Helpers\Session;

class Logout extends \Core\Controller
{

    public function indexAction()
    {
        Session::reset();
        
        $this->redirect('/', array('type' => Constants::SUCCESS, 'message' => 'Logout Success!'));
    }
}
