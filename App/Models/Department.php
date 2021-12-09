<?php

namespace App\Models;

use Core\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $tableJOIN = 'SELECT departments.*,users.name as hod FROM `departments` left join teachers on teachers.id=departments.hodID left join users on users.id=teachers.userID';

    public function getTeachers()
    {
        $st = new Teacher(null, ['field' => 'departmentID', 'value' => $this->id]);
        return $st->getWithJoin();
    }

}
