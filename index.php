<?php

require __DIR__ ."/src/vendor/autoload.php";

session_start();

$Dispatcher = new \iutnc\deefy\dispatch\Dispatcher();
$Dispatcher->run();

/*
$track1 = new \iutnc\deefy\audio\tracks\AlbumTrack("Lucille","I'm with you","rock",151,"src/sons/01-Im_with_you_BB-King-Lucille.mp3","BB-King Lucille",2003,1);
$pod1 = new \iutnc\deefy\audio\tracks\PodcastTrack("21/07/2003","inter","10 sep","actu",143,"src/sons/02-I_Need_Your_Love-BB_King-Lucille.mp3");
echo $track1;
echo "<br><br>";
echo $pod1;
echo "<br><br>";
$test = new iutnc\deefy\renders\AlbumTrackerRenderer($track1);
echo $test->Render(2);
$test2 = new iutnc\deefy\renders\PodcastRenderer($pod1);
echo $test2->Render(2);
echo "\n\n";*/