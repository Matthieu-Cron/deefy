<?php

namespace iutnc\deefy\dispatch;

use iutnc\deefy\Action\Action;
use iutnc\deefy\Action\AddPlaylistAction;
use iutnc\deefy\Action\AddTrackAction;
use iutnc\deefy\Action\AddUserAction;
use iutnc\deefy\Action\DefaultAction;
use iutnc\deefy\Action\DisplayPlayListeAction;
use iutnc\deefy\Action\MesPlaylisteAction;
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
        if(isset($_SESSION['IdPlaylistSession']))
        {
            $idpl=$_SESSION['IdPlaylistSession'];
        }
        else{
            $idpl=0;
        }
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
.navbar h1{
color: white;
text-align: center;
}
</style>
<body>
        <ul class='navbar'>
        <h1>Application deffy</h1>
            <li><a href='.?action=Mes-playlist'>Mes playlists</a></li>
            <li><a href='.?action=add-track'>Ajouter une piste</a></li>
            <li><a href='.?action=add-playlist'>Créer une playlist vide</a></li>
            <li><a href='.?action=playlist&id=".$idpl."'>Afficher la playlist en courante</a></li>
            <li><a href='.?action=add-user'>S’inscrire</a></li>
            <li><a href='.?action=SigninAction'>S’authentifier</a></li>
        </ul>
    
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
            case 'Mes-playlist':
                $act = new MesPlaylisteAction();
                break;
            default:
                $act = new DefaultAction();
                break;
        }
        //$act->execute();
        $this->renderPage($act->execute());
    }
}