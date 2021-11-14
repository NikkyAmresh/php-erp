<?php

namespace App\Controllers;

use \App\Helpers\Constants;
use \App\Helpers\Session;
use \Core\View;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $userID = Session::get(Constants::LOGGED_IN_USER_ID);
        $userName = Session::get(Constants::LOGGED_IN_USER_NAME);
        View::renderTemplate('Home/index.html', ['userID' => $userID, 'userName' => $userName]);
    }
}
