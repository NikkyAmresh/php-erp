<?php

namespace App\Models;

use Core\Model;

class Branch extends Model
{
    protected static $table = 'branches';
    protected static $tableJOIN = 'SELECT branches.departmentID as departmentID,branches.name as name,branches.code as branchCode,departments.name as department FROM `branches` left join departments on departments.id=branches.departmentID';
}
