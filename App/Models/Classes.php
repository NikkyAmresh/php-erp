<?php

namespace App\Models;

use Core\Model;

class Classes extends Model
{
    protected static $table = 'classes';
    protected static $tableJOIN = 'SELECT classes.*,departments.name as department,branches.name as brancheName,branches.code as branch,years.name as year, users.name as teacher FROM `classes` left join departments on departments.id=classes.departmentID left join branches on branches.id=classes.branchID left join years on years.id=classes.yearID join teachers on classes.teacherID=teachers.id join users on users.id=teachers.userID';
}
