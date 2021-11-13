<?php

namespace App\Controllers;

use \App\Models\Department;
use \Core\Controller;
use \Core\View;

class Profile extends Controller
{

    public function xyzAction()
    {
        $d = new Department();
        $list = $d->get(2);
        print_r($list);
        View::renderTemplate('Profile.html', ['abcVar' => 'nikky']);
    }
}
