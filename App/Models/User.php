<?php

namespace App\Models;

class User extends \Core\Model
{
    protected $table = 'users';

    public function auth($email, $pass)
    {
        $result = $this->db->where('email', $email)->where('password', md5($pass))->getOne($this->table);
        if ($result && isset($result['id'])) {
            // $this->get($result['id']);
            $this->user = $result;
            $this->setData($result);
            return true;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        return $this->user;
    }
}
