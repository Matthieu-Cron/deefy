<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\audio\lists\PlayLists;
use iutnc\deefy\renders\AudioListRenderer;

class AddPlaylistAction extends Action
{

    public function execute(): string
    {
        if ($this->http_method === 'GET') {
            if(!isset($_SESSION['PlayList'])){
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
                $html ="<h2>Playlist déjà présente en session :</h2>";
                $playlist = unserialize($_SESSION['PlayList']);
                $renderer = new AudioListRenderer($playlist);
                $html .= $renderer->render();
            }

        }
        else
        {
            if (!isset($_POST['Nom']) || trim($_POST['Nom']) === '') {
                return "<p>Erreur : Le nom de la playlist est obligatoire.</p>";
            }
            $nom = filter_var($_POST['Nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $playlist = new PlayLists($nom);
            $_SESSION['PlayList'] = serialize($playlist);

            $renderer = new AudioListRenderer($playlist);
            $html = $renderer->render();
        }
        return $html;
    }
}