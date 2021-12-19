<?php

namespace App\Models;

use Core\Model;
class Achivementdetail extends Model
{
    protected $table = 'achivementdetails';
    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
