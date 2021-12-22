<?php

namespace App;

class Config
{

    public static function __callStatic($func, $params)
    {
        if ($func=='getEnv') {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->safeLoad();
            return $_ENV[$params[0]];
        }
    }

}
