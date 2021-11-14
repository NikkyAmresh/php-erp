<?php

namespace App\Helpers;

class Session
{
    public static function get(string $varName)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_SESSION[$varName])) {
            return $_SESSION[$varName];
        }
        return null;
    }

    public static function reset()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        return null;
    }

    public static function delete(string $varName)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION[$varName]);
        return null;
    }

    public static function set(string $varName, string $value)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION[$varName] = $value;
        return $_SESSION[$varName];
    }
}
