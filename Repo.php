<?php
echo "<a href=/deefy/index.php>Retour</a>";
require_once  __DIR__ . '/src/vendor/autoload.php';

\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/db.config');

$repo = \iutnc\deefy\repository\DeefyRepository::getInstance();

$playlists = $repo->recupererToutesPlaylists();
foreach ($playlists as $pl) {
    print "playlist  : " . $pl->nom . ":". $pl->id . "\n";
}


//$pl = new \iutnc\deefy\audio\lists\PlayList('test');
//$pl = $repo->saveEmptyPlaylist($pl);
//print "playlist  : " . $pl->nom . ":". $pl->id . "\n";

//$track = new \iutnc\deefy\audio\tracks\PodcastTrack('test', 'test.mp3', 'auteur', '2021-01-01', 10, 'genre');
//$track = $repo->savePodcastTrack($track);
//print "track 2 : " . $track->titre . ":". get_class($track). "\n";
//$repo->addTrackToPlaylist($pl->id, $track->id);

