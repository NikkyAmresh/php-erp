<?php

namespace App\Models;

class Hod extends \Core\Model
{
    protected static $table = 'hods';
    protected static $tableJOIN = 'SELECT hods.*,users.name,users.email,users.phone FROM `hods` join users on users.id = hods.userID';
}
