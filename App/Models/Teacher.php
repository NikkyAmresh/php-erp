<?php

namespace App\Models;

use Core\Model;

class Teacher extends Model
{
    protected static $table = 'teachers';
    protected static $tableJOIN = 'SELECT teachers.*,departments.name as department, users.name as name FROM `teachers` join departments on departments.id=teachers.departmentID left JOIN users on users.id = teachers.userID';
}
