<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class Certification extends Model
{
    protected $table = 'certifications';

    public function __construct(MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
