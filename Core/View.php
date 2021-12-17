<?php

namespace Core;

use App\Helpers\Constants;
use App\Helpers\Session;
/**
 * View
 *
 * PHP version 7.0
 */
class View
{

    /**
     * Render a view file
     *
     * @param string $view  The view file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = dirname(__DIR__) . "/App/Views/$view"; // relative to Core directory

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }
    }

    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig\Environment($loader);
        }
        $messages = [
            Constants::MESSAGE_TYPE[Constants::SUCCESS] => self::getSuccessMessage(),
            Constants::MESSAGE_TYPE[Constants::ERROR] => self::getErrorMessage(),
            Constants::MESSAGE_TYPE[Constants::WARNING] => self::getWarningMessage(),
            Constants::MESSAGE_TYPE[Constants::INFO] => self::getInfoMessage()];
        $finalArgs = array_merge($args, $messages);
        $twig->addFilter(new \Twig\TwigFilter('ucf', 'ucfirst'));
        $twig->addFilter(new \Twig\TwigFilter('sortData', ['App\Helpers\Utils','sortData'] ));
        $twig->addFilter(new \Twig\TwigFilter('formatDate', ['App\Helpers\Utils','formatDate']));
        echo $twig->render($template, $finalArgs);
        self::resetMessages();
    }

    public static function resetMessages()
    {
        Session::delete(Constants::MESSAGE_TYPE[Constants::SUCCESS]);
        Session::delete(Constants::MESSAGE_TYPE[Constants::ERROR]);
        Session::delete(Constants::MESSAGE_TYPE[Constants::WARNING]);
        Session::delete(Constants::MESSAGE_TYPE[Constants::INFO]);
    }
    public static function getSuccessMessage()
    {
        return Session::get(Constants::MESSAGE_TYPE[Constants::SUCCESS]);
    }
    public static function getErrorMessage()
    {
        return Session::get(Constants::MESSAGE_TYPE[Constants::ERROR]);
    }
    public static function getWarningMessage()
    {
        return Session::get(Constants::MESSAGE_TYPE[Constants::WARNING]);
    }
    public static function getInfoMessage()
    {
        return Session::get(Constants::MESSAGE_TYPE[Constants::INFO]);
    }
}