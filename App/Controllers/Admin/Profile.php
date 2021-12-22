<?php

namespace App\Controllers\Admin;

use App\Models\Admin as AdminModel;

class Profile extends AdminController
{
    protected $pageCode = 'profile';

    public function __construct(
        AdminModel $adminModel
    ) {
        parent::__construct($adminModel);
    }

    public function indexAction()
    {
        $this->setTemplateVars(['admin' => $this->admin->getCollection()]);
        $this->renderTemplate('Admin/Dashboard/profile.html');
    }

}
