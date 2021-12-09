<?php

namespace App\Controllers\Teacher;

use App\Controllers\Teacher\TeacherController;
use App\Models\Teacher;

class Profile extends TeacherController
{
    protected $pageType = 'profile';

    public function indexAction()
    {
        $res = $this->teacher->getOneWithJoin();
        $this->setTemplateVars(['teacher' => $res]);
        $this->renderTemplate('Teacher/Dashboard/profile.html');
    }
}