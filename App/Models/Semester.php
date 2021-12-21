<?php

namespace App\Models;

use Core\Model;

class Semester extends Model
{
    protected $table = 'semesters';

    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
