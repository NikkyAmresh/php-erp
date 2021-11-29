<?php

namespace App\Models;

class Admin extends \Core\Model

{
    protected static $table = 'admin';

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
