<?php

namespace Core;

use App\Helpers\Constants;
use App\Helpers\Session;

/**
 * Base controller
 *
 * PHP version 7.0
 */
abstract class Controller
{

    protected $pageCode = 'index';
    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    protected $template_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                $this->setTemplateVars(['type' => $this->pageCode]);
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }

    public function redirect($path, $messageObject = null)
    {
        if ($messageObject) {
            Session::set(Constants::MESSAGE_TYPE[$messageObject['type']], $messageObject['message']);
        }
        header('location: ' . $path);
    }

    public function setTemplateVars($vars)
    {
        $this->template_params = array_merge($this->template_params, $vars);
    }

    public function renderTemplate($template)
    {
        View::renderTemplate($template, $this->template_params);
    }

    public function setSuccessMessage($message)
    {
        return Session::set(Constants::MESSAGE_TYPE[Constants::SUCCESS], $message);
    }
    public function setErrorMessage($message)
    {
        return Session::set(Constants::MESSAGE_TYPE[Constants::ERROR], $message);
    }
    public function setWarningMessage($message)
    {
        return Session::set(Constants::MESSAGE_TYPE[Constants::WARNING], $message);
    }
    public function getInfoMessage($message)
    {
        return Session::set(Constants::MESSAGE_TYPE[Constants::INFO], $message);
    }
}
