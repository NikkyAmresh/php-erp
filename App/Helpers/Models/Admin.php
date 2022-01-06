<?php

namespace App\Helpers\Models;

use App\Models\Admin as AdminModel;
use App\Models\User as UserModel;

class Admin extends User
{

    public function __construct(AdminModel $adminModel, UserModel $userModel)
    {
        $this->adminModel = $adminModel;
        $this->userModel = $userModel;
        parent::__construct($userModel, $adminModel);
    }

    public function create($admin)
    {
        if ($userId = $this->createUser($admin)) {
            $adminModel = $this->adminModel->bind();
            $adminModel->setUserID($userId);
            if ($id = $adminModel->save()) {
                return $id;
            } else {
                return null;
                $this->deleteUser($userId);
            }
        }
        return null;
    }
}
