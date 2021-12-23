<?php

namespace App\Helpers;

use App\Models\User as UserModel;


class User{
    public function __construct(UserModel $userModel) {
        $this->userModel = $userModel;
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

    public function changePassword($userID, $oldPassword, $newPassword){
        $userModel = $this->userModel->bind(null,['users.id'=>$userID, 'users.password'=>md5($oldPassword)]);
        if(!$userModel->get()){
            return -1;
        }
        $userModel->setPassword(md5($newPassword));
        return $userModel->save();
    }

    public function deleteUser($userID)
    {
        $userModel = $this->userModel->bind($userID);
        return $userModel->delete();
    }
}