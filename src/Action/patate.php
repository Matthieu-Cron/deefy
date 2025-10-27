<?php

class AddPlaylistActionV12 extends Action {

    public function execute(): string {

        if ($this->http_method === 'GET') {

            $html = <<<END
                <form method="post" action="?action=add-playlist">
                    <label>
                        Nom de la playlist :
                        <input type="text" name="nom" placeholder="Nom de la playlist" required>
                    </label>
                    <button type="submit">Créer</button>
                </form>
            END;

            return $html;
        }


        else {


            if (!isset($_POST['nom']) || trim($_POST['nom']) === '') {
                return "<p>Erreur : le nom de la playlist est obligatoire.</p>";
            }


            $nom = filter_var($_POST['nom'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            $playlist = new PlayList($nom);
            $_SESSION['playlist'] = $playlist;

            $renderer = new AudioListRenderer($playlist);
            $htmlPlaylist = $renderer->render();


            $lien = '<a href="?action=add-track">Ajouter une piste</a>';

            return $htmlPlaylist . $lien;
        }
    }
}