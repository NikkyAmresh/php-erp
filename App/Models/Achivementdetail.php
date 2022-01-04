<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class AchivementDetail extends Model
{
    protected $table = 'achivementdetails';
    public function __construct(MysqliDb $dbModel)
    {
        parent::__construct($dbModel);
    }
}
