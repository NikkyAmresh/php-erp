<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $usr = new User();
        print_r($usr->get(2));
        print_r($usr->getAll());
        View::renderTemplate('Home/login.html');
    }
}
