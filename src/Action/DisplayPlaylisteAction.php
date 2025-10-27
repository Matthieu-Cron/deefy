<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\src\interfaces\render\Renderer;

class DisplayPlaylisteAction extends Action
{

    public function execute(): string
    {
        if(!isset($_SESSION['playlist'])){
            $html = "<p>Pas de playlist en session</p>";
        }
        else
        {
            $pl = unserialize($_SESSION['playlist']);
            $html = "<p>Playlist en session</p><br>".$pl->render();
        }
        return $html;
    }
}