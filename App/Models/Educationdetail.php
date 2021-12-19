<?php

namespace App\Models;

use Core\Model;

class Educationdetail extends Model
{
    protected $table = 'educationdetails';

    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
