<?php

namespace App\Models;

use Core\Model;

class ExperienceDetail extends Model
{
    protected $table = 'experiencedetails';

    public function __construct(\MysqliDb$dbModel)
    {
        parent::__construct($dbModel);
    }
}
