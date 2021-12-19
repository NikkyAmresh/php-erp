<?php

namespace App\Models;

use Core\Model;

class Period extends Model
{
    protected $table = 'periods';

    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
