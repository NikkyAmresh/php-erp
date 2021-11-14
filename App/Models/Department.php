<?php

namespace App\Models;

use Core\Model;

class Department extends Model{
    protected static $table = 'departments'; 
    protected static $tableJOIN = 'SELECT departments.*,users.name as hod FROM `departments` left join hods on hods.id=departments.hodID join users on users.id=hods.userID';
}