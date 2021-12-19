<?php

namespace Core\Exceptions;

class NotEntityException extends \Exception
{

    public function __construct()
    {

        $this->message = 'No Such Entity';
        $this->code = 204;
    }

}