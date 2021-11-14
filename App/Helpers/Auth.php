<?php

namespace App\Helpers;

class Auth
{

    public function __construct(string $email = null,string $pass=null) {
        $this->email = $email;
        $this->pass = $pass;
    }

   public function validateLogin(){
        
   }
}
