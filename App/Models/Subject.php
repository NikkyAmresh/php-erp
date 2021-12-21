<?php

namespace App\Models;

use Core\Model;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $tableJOIN = 'SELECT subjects.*,dept.name as department from subjects join departments as dept on subjects.departmentID=dept.id';

    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
