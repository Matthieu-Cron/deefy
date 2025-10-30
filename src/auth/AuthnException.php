<?php

namespace iutnc\deefy\auth;

use Throwable;

class AuthnException extends \Exception
{
    public function __construct(){
        parent::__construct("Erreur lors de l'authentification");
    }
}