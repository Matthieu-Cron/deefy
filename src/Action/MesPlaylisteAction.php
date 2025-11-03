<?php

namespace iutnc\deefy\Action;

use iutnc\deefy\auth\Authz;
use iutnc\deefy\repository\DeefyRepository;

class MesPlaylisteAction extends Action
{

    public function execute(): string
    {
        DeefyRepository::setConfig(__DIR__ . "/../../db.config");
        $repo = DeefyRepository::getInstance();
        if($this->http_method === 'GET')
        {

            $playlists = $repo->recupererToutesPlaylists();
            $authz = new Authz();
            $html = "<h2>Affichage de mes playlists :</h2>";
            foreach ($playlists as $playlist) {
                if ($authz->checkPlaylistOwner($playlist->id)) {
                    $html .= "<form method='post' action='.?action=Mes-playlist'><input type='hidden' name='id' value='".$playlist->id."'><button type='submit'>".$playlist->nom."</button> </form>";
                }
            }
        }
        else{
            $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
            $pl = $repo->findPlaylistById((int)$id);
            $_SESSION['PlaylistSession'] = serialize($pl);
            $html = "<h2>Mise en Session de la playlist : ".$pl->nom."</h2>";
        }

        return $html;
    }
}