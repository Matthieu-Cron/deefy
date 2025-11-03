<?php

namespace iutnc\deefy\Action;

use iutnc\deefy\audio\lists\PlayLists;
use iutnc\deefy\renders\AudioListRenderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPlaylistAction extends Action
{

    public function execute(): string
    {
        if ($this->http_method === 'GET') {
            if(!isset($_SESSION['User_id']))
            {
                return "<h2>Veuillez vous connecter</h2>";
            }
            $html = "<form method='post' action='?action=add-playlist'>
                <label>
                    Nom de la playlist :
                    <input type='text' name='Nom' placeholder='Nom de la playlist' required>
                </label>
                <button type='submit'>Créer</button>
            </form>";

        }
        else
        {
            if(isset($_SESSION['User_id']))
            {
                if (!isset($_POST['Nom']) || trim($_POST['Nom']) === '') {
                    return "<p>Erreur : Le nom de la playlist est obligatoire.</p>";
                }
                $nom = filter_var($_POST['Nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $playlist = new PlayLists($nom);
                DeefyRepository::setConfig(__DIR__ . "/../../db.config");
                $repo = DeefyRepository::getInstance();
                $playlist = $repo->sauvegarderPlaylistVide($playlist);
                $_SESSION['PlaylistSession'] = serialize($playlist);
                echo "Test d'id : ".$playlist->id;
                $repo->droitsSurPlaylistVideEnSession();

                $renderer = new AudioListRenderer($playlist);
                $html = $renderer->render();
            }
            else{
                $html="<p>Erreur : Veuillez vous connecter</p>";
            }
        }
        return $html;
    }
}