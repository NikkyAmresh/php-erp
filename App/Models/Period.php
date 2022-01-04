<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class Period extends Model
{
    protected $table = 'periods';

    public function __construct(MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
