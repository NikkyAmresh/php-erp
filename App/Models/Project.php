<?php

namespace App\Models;

use Core\Model;

class Project extends Model
{
    protected $table = 'projects';

    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
