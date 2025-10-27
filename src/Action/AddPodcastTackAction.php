<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\audio\lists\PlayLists;
use iutnc\deefy\renders\AudioListRenderer;

class AddPodcastTackAction extends Action
{
    public function execute(): string
    {
        // S'assurer que la session est démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['PlayList'])) {
            return "<p>Aucune playlist n'existe. Veuillez d'abord en créer une.</p>";
        }

        if ($this->http_method === 'GET') {
            $files = glob(__DIR__ . "/../sons/*.mp3");

            if (empty($files)) {
                return "<p>Aucun fichier audio trouvé dans le dossier <code>sons/</code>.</p>";
            }

            sort($files); // Tri alphabétique des fichiers

            $html = "<h3>Ajouter un podcast à la playlist</h3>";
            $html .= "<form method='post' action='?action=add-podcast-track'>";
            $html .= "<label for='fichier'>Choisissez un podcast :</label>";
            $html .= "<select name='fichier' id='fichier' required>";

            foreach ($files as $file) {
                $filename = basename($file);
                $html .= "<option value='" . htmlspecialchars($filename) . "'>" . htmlspecialchars($filename) . "</option>";
            }

            $html .= "</select>";
            $html .= "<button type='submit'>Ajouter</button>";
            $html .= "</form>";

            return $html;
        } else {
            if (empty($_POST['fichier'])) {
                return "<p>Erreur : aucun fichier sélectionné.</p>";
            }

            $filename = basename($_POST['fichier']);
            $fullPath = "sons/" . $filename;

            if (!file_exists($fullPath)) {
                return "<p>Erreur : le fichier sélectionné n'existe pas.</p>";
            }
            
            $titre = pathinfo($filename, PATHINFO_FILENAME);
            //Test de valeur du fichier musique
            $artiste = "Inconnu";
            $date = date('Y-m-d');
            $duree = rand(100, 400); 

            $podcast = new PodcastTrack($titre, $artiste, $fullPath, $date, $duree);

            $playlist = unserialize($_SESSION['PlayList']);
            $playlist->add($podcast); 
            $_SESSION['PlayList'] = serialize($playlist);

           
            $renderer = new AudioListRenderer($playlist);
            $html = "<p>Le podcast <strong>" . htmlspecialchars($titre) . "</strong> a été ajouté à la playlist.</p>";
            $html .= $renderer->render();

            return $html;
        }
    }
}
