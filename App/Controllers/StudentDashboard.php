<?php

namespace App\Controllers;

use \Core\View;

class StudentDashboard extends \Core\Controller

{
    public function indexAction()
    {
        View::renderTemplate('Student/Dashboard/Homepage/index.html');

    }

}
