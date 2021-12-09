<?php

namespace App\Controllers\Admin;

class Profile extends AdminController
{
    protected $pageType = 'profile';
    public function indexAction()
    {
        $this->setTemplateVars(['admin' => $this->admin->get()]);
        $this->renderTemplate('Admin/Dashboard/profile.html');
    }

}