<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\action\Action;
use iutnc\deefy\action\AddPlaylistAction;
use iutnc\deefy\action\AddTrackAction;
use iutnc\deefy\action\AddUserAction;
use iutnc\deefy\action\DefaultAction;
use iutnc\deefy\action\DisplayPlayListeAction;
use iutnc\deefy\Action\signinAction;

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
<style>
body {
  margin: 0;
  padding: 0;
}
h2,h3, p {
  margin: 10px;
}

.navbar {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: black;
}
.navbar li {
  float: left;
}
.navbar li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}
.navbar li a:hover {
  background-color: lightgray;
}
</style>
<body>
        <ul class='navbar'>
            <li><a href='.?action=playlist&id=1'>AFFICHER LA PLAYLIST EN SESSION</a></li>
            <li><a href='.?action=add-playlist'>CREER 1 PLAYLIST EN SESSION</a></li>
            <li><a href='.?action=add-track'>AJOUTER 1 TRACK DANS LA PLAYLIST</a></li>
            <li><a href='.?action=add-user'>Ajouter un utlisateur</a></li>
            <li><a href='.?action=SigninAction'>Connexion</a></li>
            <li><a href='.'>ACTION PAR DÉFAULT</a></li>
            <li><a href='/deefy/Repo.php'>RepoTest</a></li>
        </ul>
    <h1>Application deffy</h1>
    ".$html."
</body>";
        echo $res;
    }
    public function run():void
    {
        switch ($this->action) {
            case 'playlist':
                $act = new DisplayPlayListeAction();
                break;
            case 'add-playlist':
                $act = new AddPlaylistAction();
                break;
            case 'add-track':
                $act = new AddTrackAction();
                break;
            case 'add-user':
                $act = new AddUserAction();
                break;
            case 'SigninAction':
                $act = new SigninAction();
                break;
            default:
                $act = new DefaultAction();
                break;
        }
        //$act->execute();
        $this->renderPage($act->execute());
    }
}