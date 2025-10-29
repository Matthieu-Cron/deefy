<?php

require_once  __DIR__ . '/src/vendor/autoload.php';

\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/db.config');

$repo = \iutnc\deefy\repository\DeefyRepository::getInstance();

$playlists = $repo->recupererToutesPlaylists();
foreach ($playlists as $pl) {
    print "playlist  : " . $pl->nom . ":". $pl->id . "   \n";
}


$pl = new \iutnc\deefy\audio\lists\PlayLists('test');
$pl = $repo->sauvegarderPlaylistVide($pl);
print "playlist  : " . $pl->nom . ":". $pl->id . "\n";

$track = new \iutnc\deefy\audio\tracks\PodcastTrack('test', 'test.mp3', 'auteur', '2021-01-01', 10, 'genre');
$track = $repo->sauvegarderTrack($track);
print "track 2 : " . $track->titre . ":". get_class($track). "\n";
$repo->ajouterTrackAPlaylist($pl->id, $track->id);

