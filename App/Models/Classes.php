<?php

namespace App\Models;

use Core\Model;

class Classes extends Model
{
    protected static $table = 'classes';
    protected static $tableJOIN = 'SELECT classes.*,departments.name as department,branches.name as brancheName,branches.code as branch,semesters.name as semester, users.name as teacher FROM `classes` left join departments on departments.id=classes.departmentID left join branches on branches.id=classes.branchID left join semesters on semesters.id=classes.semesterID join teachers on classes.teacherID=teachers.id join users on users.id=teachers.userID';
}
