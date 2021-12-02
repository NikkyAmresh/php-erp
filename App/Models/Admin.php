<?php

namespace App\Models;

class Admin extends \Core\Model

{
    protected static $table = 'admin';
    protected static $tableJOIN = 'select admin.*,users.name as name,users.email as email,users.mobile as mobile from admin join users on users.id=admin.userID';

    public function adminAuth($email, $pass)
    {
        $usr = new User();
        $validate = $usr->auth($email, $pass);
        if ($validate) {
            $adminUser = $this->db->where('userID', $usr->getUser()['id'])->getOne(static::$table);
            if ($adminUser) {
                $this->adminUser = $usr->getUser();
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

}
