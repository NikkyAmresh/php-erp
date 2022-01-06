<?php

namespace App\Controllers\Admin;

use App\Helpers\Models\Admin as AdminHelper;

class Profile extends AdminController
{
    protected $pageCode = 'profile';

    public function __construct(
        AdminHelper $adminHelper
    ) {
        parent::__construct($adminHelper);
    }

    public function indexAction()
    {
        $this->setTemplateVars(['admin' => $this->admin->getResult()]);
        $this->renderTemplate('Admin/Dashboard/profile.html');
    }

}
