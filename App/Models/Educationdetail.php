<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class EducationDetail extends Model
{
    protected $table = 'educationdetails';

    public function __construct(MysqliDb $dbModel)
    {
        parent::__construct($dbModel);
    }
}
