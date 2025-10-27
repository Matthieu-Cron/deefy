<?php

namespace iutnc\deefy\action;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\renders\AudioListRenderer;

class AddTrackAction extends Action
{
    public function execute(): string
    {
        if (!isset($_SESSION['PlayList'])) {
            return "<h2>Pas de playlist en session</h2>";
        }

        if ($this->http_method === 'GET') {
            $pl = unserialize($_SESSION['PlayList']);

            $html = "<form method='post' action='?action=add-track' enctype='multipart/form-data'>
                <label>Nom de l'artiste :</label>
                <input type='text' name='Artiste' placeholder=\"Nom de l'artiste\" required><br>

                <label>Titre de Track :</label>
                <input type='text' name='Titre' placeholder='Titre du Track' required><br>

                <label>Genre du Track :</label>
                <input type='text' name='Genre' placeholder='Genre du Track' required><br>

                <label>Durée du Track (en secondes) :</label>
                <input type='number' name='Duree' placeholder='Durée' required><br>

                <label>Fichier audio (MP3) :</label>
                <input type='file' name='userfile' accept='.mp3,audio/mpeg' required><br><br>

                <button type='submit'>Créer</button>
            </form>";

            $html .= "<h2>Playlist en session :</h2>";
            $renderer = new AudioListRenderer($pl);
            $html .= $renderer->render();

            return $html;
        } else {
            
            if (!isset($_POST['Artiste']) || trim($_POST['Artiste']) === '') {
                return "<p>Erreur : Le nom de l'Artiste est obligatoire.</p>";
            }
            if (!isset($_POST['Titre']) || trim($_POST['Titre']) === '') {
                return "<p>Erreur : Le Titre est obligatoire.</p>";
            }
            if (!isset($_POST['Genre']) || trim($_POST['Genre']) === '') {
                return "<p>Erreur : Le Genre est obligatoire.</p>";
            }
            if (!isset($_POST['Duree']) || trim($_POST['Duree']) === '' || !is_numeric($_POST['Duree']) || $_POST['Duree'] <= 0) {
                return "<p>Erreur : La durée doit être un nombre positif.</p>";
            }

            
            if (!isset($_FILES['userfile']) || $_FILES['userfile']['error'] !== UPLOAD_ERR_OK) {
                return "<p>Erreur : Aucun fichier audio téléchargé ou erreur d'upload.</p>";
            }

            $fileName = $_FILES['userfile']['name'];
            $fileTmpName = $_FILES['userfile']['tmp_name'];
            $fileType = $_FILES['userfile']['type'];

           
            if (substr($fileName, -4) !== '.mp3' || $fileType !== 'audio/mpeg') {
                return "<p>Erreur : Le fichier doit être un MP3.</p>";
            }

           
            $randomName = uniqid('audio_', true) . '.mp3';
            $destination = __DIR__ . '/../../audio/' . $randomName;

            if (!move_uploaded_file($fileTmpName, $destination)) {
                return "<p>Erreur : Impossible de sauvegarder le fichier.</p>";
            }

        
            $artiste = htmlspecialchars(trim($_POST['Artiste']));
            $titre = htmlspecialchars(trim($_POST['Titre']));
            $genre  = htmlspecialchars(trim($_POST['Genre']));
            $duree  = (int) $_POST['Duree'];

            $track = new AudioTrack($artiste, $titre, $genre, $duree, 'audio/' . $randomName);

         
            $pl = unserialize($_SESSION['PlayList']);
            $pl->add($track);
            $_SESSION['PlayList'] = serialize($pl);

            
            $renderer = new AudioListRenderer($pl);
            $html = "<h2>Nouvelle Playlist en session :</h2>";
            $html .= $renderer->render();

            return $html; //
        }
    }
}
