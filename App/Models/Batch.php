<?php

namespace App\Models;

use Core\Model;

class Batch extends Model
{
    protected $table = 'batches';

    public function __construct(\MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
