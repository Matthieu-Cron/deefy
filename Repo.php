<?php

use iutnc\deefy\auth\AuthnException;

echo "<a href=/deefy/index.php>Retour</a><br>";
require_once  __DIR__ . '/src/vendor/autoload.php';

\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/db.config');

$test = new \iutnc\deefy\auth\AuthnProvider();
try{
    if($test->register("user5@mail.com","1234567890")){
        echo "<h2>register complete</h2>";
    }
    else
    {
        echo "<h2>failed to register</h2>";
    }

}
catch(AuthnException $e){
    echo $e->getMessage();
}
/*
$repo = \iutnc\deefy\repository\DeefyRepository::getInstance();

$playlists = $repo->recupererToutesPlaylists();
foreach ($playlists as $pl) {
    print "playlist  : " . $pl->nom . ":". $pl->id . "   <br>";
}


$pl = new \iutnc\deefy\audio\lists\PlayLists('test');
$pl = $repo->sauvegarderPlaylistVide($pl);
print "playlist  : " . $pl->nom . ":". $pl->id . "<br>";


$track = new \iutnc\deefy\audio\tracks\PodcastTrack('2021-01-01', 'auteur', 'test', 'genre', 10, 'test.mp3');
$track = $repo->sauvegarderTrack($track);
print "track 2 : " . $track->titre . ":". get_class($track). "<br>";
$repo->ajouterTrackAPlaylist($pl->id, $track->id);
$track2 = new \iutnc\deefy\audio\tracks\PodcastTrack('2021-01-01', 'auteur', 'test', 'genre', 10, 'test2.mp3');
$track2 = $repo->sauvegarderTrack($track);
$repo->ajouterTrackAPlaylist($pl->id, $track2->id);*/

