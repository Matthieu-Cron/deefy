<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;
use iutnc\deefy\audio\lists\Playlists;
use iutnc\deefy\renders\AudioListRenderer;

class AddPlaylistAction extends Action
{

    public function execute(): string
    {

        if ($this->http_method === 'GET') {
            $html = "<form method=\"post\" action=\"?action=add-playlist\">
                    <label>
                        Nom de la playlist :
                        <input type=\"text\" name=\"nom\" placeholder=\"Nom de la playlist\" required>
                    </label>
                    <button type=\"submit\">Créer</button>
                </form>";
        }
        else
        {
            if (!isset($_POST['nom']) || trim($_POST['nom']) === '') {
                return "<p>Erreur : le nom de la playlist est obligatoire.</p>";
            }
            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $playlist = new PlayLists($nom);
            $_SESSION['playlist'] = serialize($playlist);

            $renderer = new AudioListRenderer($playlist);
            $html = $renderer->render();
            //$html = "<b>Bonjour</b>";
        }
        return $html;
    }
}