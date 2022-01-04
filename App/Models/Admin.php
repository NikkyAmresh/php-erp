<?php

namespace App\Models;

use Core\MysqliDb;

class Admin extends \Core\Model

{
    protected $table = 'admin';
    protected $tableJOIN = 'select admin.*,users.name as name,users.email as email,users.mobile as mobile from admin join users on users.id=admin.userID';

    protected $user;
    public function __construct(User $userModel, MysqliDb $dbModel)
    {
        $this->userModel = $userModel;
        parent::__construct($dbModel);
    }
    public function adminAuth($email, $pass)
    {
        $usr = $this->userModel->bind();
        $validate = $usr->auth($email, $pass);
        if ($validate) {
            $adminUser = $this->db->where('userID', $usr->getUser()['id'])->getOne($this->table);
            if ($adminUser) {
                $this->user = $usr->getUser();
                $this->adminUser = $adminUser;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getAdminUser()
    {
        return $this->adminUser;
    }

    public function getUser()
    {
        return $this->user;
    }


}
