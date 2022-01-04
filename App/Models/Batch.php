<?php

namespace App\Models;

use Core\Model;
use Core\MysqliDb;

class Batch extends Model
{
    protected $table = 'batches';

    public function __construct(MysqliDb $dbModel) {
        parent::__construct($dbModel);
    }
}
