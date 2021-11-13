<?php

namespace App\Controllers;

use \App\Models\User;
use \Core\View;

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
        $user = $usr->get(2);
        $users = $usr->getAll();
        View::renderTemplate('Home/login.html', ['user' => $user, 'allU' => $users]);
    }
}
