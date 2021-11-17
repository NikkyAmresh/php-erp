<?php

namespace App;
class Config
{

    public static function getDbHost()
    {
        return $_ENV['DB_HOST'];
    }
    public static function getDbName()
    {
        return $_ENV['DB_NAME'];
    }
    public static function getDbUser()
    {
        return $_ENV['DB_USER'];
    }
    public static function getDbPassword()
    {
        return $_ENV['DB_PASSWORD'];
    }
    public static function getShowErrors()
    {
        return $_ENV['SHOW_ERRORS'];
    }

}
