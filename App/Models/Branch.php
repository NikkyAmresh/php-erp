<?php

namespace App\Models;

use Core\Model;

class Branch extends Model
{
    protected $table = 'branches';
    protected $tableJOIN = 'SELECT branches.*,departments.name as department FROM `branches` left join departments on departments.id=branches.departmentID';
    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
