<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class ExperienceDetail extends Model
{
    protected $table = 'experiencedetails';

    public function __construct(MysqliDb $dbModel)
    {
        parent::__construct($dbModel);
    }
}
