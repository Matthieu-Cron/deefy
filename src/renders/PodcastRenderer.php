<?php
namespace iutnc\deefy\renders;
use iutnc\deefy\interfaces\Renderer;

class PodcastRenderer implements Renderer {
    private \iutnc\deefy\audio\tracks\PodcastTrack $track;
    public function __construct(\iutnc\deefy\audio\tracks\PodcastTrack $track)
    {
        $this->track = $track;
    }

    public function Render(int $selector=self::COMPACT):string
    {
        $retour="";
        switch ($selector) {
            case self::COMPACT: $retour='<legend>'.$this->track->titre.' - by '.$this->track->artiste.'</legend><audio controls src="'.$this->track->filename.'"></audio>';break;
            case self::LONG: $retour='<legend>'.$this->track->titre.' - by '.$this->track->artiste.' (at the '.$this->track->date.' ) '.$this->track->duree.'s </legend><audio controls src="'.$this->track->filename.'"></audio>';break;
        }
        return $retour;
    }
}