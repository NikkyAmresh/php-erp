<?php

namespace App\Models;

use Core\Model;

class Course extends Model
{
    protected $table = 'courses';
    
    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
