<?php

namespace iutnc\deefy\action;

use iutnc\deefy\renders\AudioListRenderer;

class DisplayPlayListeAction extends Action
{

    public function execute(): string
    {
        if(!isset($_SESSION['PlayList'])){
            $html = "<h2>Pas de playlist en session</h2>";
        }
        else
        {
            $pl = unserialize($_SESSION['PlayList']);
            $html = "<h2>Playlist en session : </h2>";
            $renderer = new AudioListRenderer($pl);
            $html .=$renderer->render();
        }
        return $html;
    }
}