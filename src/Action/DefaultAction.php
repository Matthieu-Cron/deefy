<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;

class DefaultAction extends Action
{

    public function execute(): string
    {
        return "<p>Bienvenue sur la page de deffy</p>";
    }

}