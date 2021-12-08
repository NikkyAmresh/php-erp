<?php

namespace App\Models;

use Core\Model;

class Teacher extends Model
{
    protected static $table = 'teachers';
    protected static $tableJOIN = 'SELECT teachers.*,departments.name as teacherDepartment, users.name as name,users.email as email,users.mobile as mobile FROM `teachers` join departments on departments.id=teachers.departmentID left JOIN users on users.id = teachers.userID';

    public function teacherAuth($email, $pass)
    {
        $usr = new User();
        $validate = $usr->auth($email, $pass);
        if ($validate) {
            $teacher = $this->db->where('userID', $usr->getUser()['id'])->getOne(static::$table);
            if ($teacher) {
                $this->user = $usr->getUser();
                $this->teacher = $teacher;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getTeacherUser()
    {
        return $this->teacher;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getTimeTable()
    {
        $timeTable = new TimeTable(null, ['field' => 'teacherID', 'value' => $this->getId()]);
        return $timeTable->getWithJoin();
    }
}
