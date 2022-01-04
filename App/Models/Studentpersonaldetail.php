<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class StudentPersonalDetail extends Model
{
    protected $table = 'studentpersonaldetails';

    public function __construct(MysqliDb $dbModel)
    {
        parent::__construct($dbModel);
    }
}
