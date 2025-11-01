<?php

namespace iutnc\deefy\Action;

use Exception;
use iutnc\deefy\auth\Authz;
use iutnc\deefy\renders\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;
use Throwable;

class DisplayPlayListeAction extends Action
{

    public function execute(): string
    {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $html = "<h2>Affichage de la playlist N°".$id.":</h2>";
            DeefyRepository::setConfig(__DIR__."/../../db.config");
            $repo=DeefyRepository::getInstance();
            $authz = new AuthZ();
            if($authz->checkPlaylistOwner($id))
            {
                try
                {
                    $pl = $repo->findPlaylistById($id);
                    $renderer = new AudioListRenderer($pl);
                    $html .= $renderer->render();
                }
                catch(Throwable $e)
                {
                    $html = "<h2>".$e->getMessage()."</h2>";
                }
            }
            else{
                $html.="<p>Vous n'avez pas l'accès à cette playlist</p>";
            }
        }
        else
        {
            $html ="<h2>La playlist n'est pas spécifié en paramètre.</h2>";
        }
        return $html;
    }
}