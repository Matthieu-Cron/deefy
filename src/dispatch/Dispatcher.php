<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\Action;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddPodcastTackAction;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlaylisteAction;

class Dispatcher
{
    protected ?string $action;
    public function __construct()
    {
        $this->action = isset($_GET['action']) ? $_GET['action'] : null;
    }

    private function renderPage(string $html):void
    {
        $res="<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <title>Deffy</title>
</head>
<body>
    <h1>Application deffy</h1>
            ".$html."
        <nav>
        <h2>Barre d'action</h2>
        <ul>
            <li><a href='.?action=playlist'>AFFICHER LA PLAYLIST EN SESSION</a></li>
            <li><a href='.?action=add-playlist'>CREER 1 PLAYLIST EN SESSION</a></li>
            <li><a href='.?action=add-track'>AJOUTER 1 TRACK DANS LA PLAYLIST</a></li>
            <li><a href='.'>ACTION PAR DÉFAULT</a></li>
        </ul>
    </nav>
</body>";
        echo $res;
    }
    public function run():void
    {
        switch ($this->action) {
            case 'playlist':
                $act = new DisplayPlaylisteAction();
                break;
            case 'add-playlist':
                $act = new AddPlaylistAction();
                break;
            case 'add-track':
                $act = new AddPodcastTackAction();
                break;
            default:
                $act = new DefaultAction();
                break;
        }
        //$act->execute();
        $this->renderPage($act->execute());
    }
}