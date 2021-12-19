<?php

namespace App\Models;

use Core\Model;

class Studentpersonaldetail extends Model
{
    protected $table = 'studentpersonaldetails';

    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
