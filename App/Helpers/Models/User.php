<?php

namespace App\Helpers\Models;

use App\Models\User as UserModel;
use Core\Model as UserAreaModel;

class User extends ModelHelper
{
    public function __construct(UserModel $userModel, UserAreaModel $userAreaModel)
    {
        $this->userModel = $userModel;
        $this->userAreaModel = $userAreaModel;
        parent::__construct($userAreaModel);
    }

    public function createUser($user)
    {
        $userModel = $this->userModel->bind();
        $userModel->setName($user['name']);
        $userModel->setMobile($user['mobile']);
        $userModel->setEmail($user['email']);
        $userModel->setPassword(md5($user['password']));
        return $userModel->save();
    }

    public function updateUser($user)
    {
        $userModel = $this->userModel->bind($user['id']);
        $userModel->setName($user['name']);
        $userModel->setMobile($user['mobile']);
        $userModel->setEmail($user['email'])->save();
    }

    public function changePassword($userID, $password)
    {
        $userModel = $this->userModel->bind(null, ['users.id' => $userID, 'users.password' => md5($password['oldPassword'])]);
        if (!$userModel->get()) {
            return -1;
        } else {
            $userModel->setPassword(md5($password['newPassword']));
            return $userModel->save();
        }

    }

    public function deleteUser($userID)
    {
        $userModel = $this->userModel->bind($userID);
        return $userModel->delete();
    }

    public function delete($id)
    {
        $user = $this->userAreaModel->bind($id);
        $userId = $user->get()['userID'];
        $user->delete($id);
        return $this->deleteUser($userId);
    }

    public function getUser($userID)
    {
        return $this->userAreaModel->bind($userID);
    }
}
