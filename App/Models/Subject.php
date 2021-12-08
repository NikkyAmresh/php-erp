<?php

namespace App\Models;

use Core\Model;

class Subject extends Model
{
    protected static $table = 'subjects';
    protected static $tableJOIN = 'SELECT subjects.*,dept.name as subjectDepartment from subjects join departments as dept on subjects.departmentID=dept.id';
}
