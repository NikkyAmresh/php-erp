<?php

namespace App\Controllers\Admin;

use App\Models\Admin;

class Profile extends AdminController
{
    public function profileAction()
    {
        $this->setTemplateVars(['admin' => $this->admin->get()]);
        $this->renderTemplate('Admin/Dashboard/profile.html');
    }

}
