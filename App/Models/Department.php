<?php

namespace App\Models;

use Core\Model;

class Department extends Model{
    protected static $table = 'departments'; 
    protected static $tableJOIN = 'SELECT departments.*,users.name as hod FROM `departments` left join teachers on teachers.id=departments.hodID left join users on users.id=teachers.userID';
}