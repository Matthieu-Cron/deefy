<?php

namespace iutnc\deefy\Action;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\renders\AudioListRenderer;

class AddTackAction extends Action
{

    public function execute(): string
    {
        if(!isset($_SESSION['PlayList'])){
            $html = "<h2>Pas de playlist en session</h2>";
        }
        else
        {
            if($this->http_method === 'GET'){
                $html = "<form method='post' action='?action=add-track'>
                    <label>Nom de l'artiste :</label>
                    <input type='text' name='Artiste' placeholder=\"Nom de l'artiste\" required>
                    <br>
                    <label>Titre de Track :</label>
                    <input type='text' name='Titre' placeholder='Titre du Track' required>
                    <br>
                    <label>Genre du Track</label>
                    <input type='text' name='Genre' placeholder='Genre du Track' required>
                    <br>
                    <label>Durée du Track</label>
                    <input type='number' name='Duree' placeholder='Duree du Track en secondes' required>
                    <br>
                    <button type='submit'>Créer</button>
                </form>";
                $pl = unserialize($_SESSION['PlayList']);
                $html .= "<h2>Playlist en session : </h2>";
                $renderer = new AudioListRenderer($pl);
                $html .=$renderer->render();
            }
            else{
                if (!isset($_POST['Artiste']) || trim($_POST['Artiste']) === '') {
                    return "<p>Erreur : Le nom de l'Artiste est obligatoire.</p>";
                }
                if (!isset($_POST['Titre']) || trim($_POST['Titre']) === '') {
                    return "<p>Erreur : Le Titre est obligatoire.</p>";
                }
                if (!isset($_POST['Genre']) || trim($_POST['Genre']) === '') {
                    return "<p>Erreur : Le Genre est obligatoire.</p>";
                }
                if (!isset($_POST['Duree']) || trim($_POST['Duree']) === '') {
                    return "<p>Erreur : Le Duree est obligatoire.</p>";
                }

                $artiste = filter_var($_POST['Artiste'], FILTER_SANITIZE_STRING);
                $titre = filter_var($_POST['Titre'], FILTER_SANITIZE_STRING);
                $genre = filter_var($_POST['Genre'], FILTER_SANITIZE_STRING);
                $duree = filter_var($_POST['Duree'], FILTER_SANITIZE_NUMBER_INT);
                $track = new AudioTrack($artiste, $titre, $genre, $duree,"src/sons/01-Im_with_you_BB-King-Lucille.mp3");
                $pl = unserialize($_SESSION['PlayList']);
                $pl->add($track);
                $renderer = new AudioListRenderer($pl);
                $html = "<h2>Nouvelle Playlist en session : </h2>";
                $html .=$renderer->render();
                $_SESSION['PlayList'] = serialize($pl);
            }

        }
        return $html;
    }
}