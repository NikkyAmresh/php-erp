<?php

namespace App\Helpers;
use App\Models\Admin as AdminModel;
use App\Models\User as UserModel;

class Admin extends User{

    public function __construct(AdminModel $adminModel,UserModel $userModel) {
        $this->adminModel = $adminModel;
        $this->userModel = $userModel;
        parent::__construct($userModel);
    }

    public function get($id)
    {
        return $this->adminModel->bind($id)->get();
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

    public function delete($id)
    {
        $admin = $this->adminModel->bind($id);
        $userId = $admin->get()['userID'];
        $admin->delete($id);
        return $this->deleteUser($userId);
    }
}