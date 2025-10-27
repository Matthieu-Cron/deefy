<?php

namespace iutnc\deefy\renders;

use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\interfaces\Renderer;

class AudioTrackRenderer implements Renderer
{
    private $track;
    function __construct(AudioTrack $track)
    {
        $this->track = $track;
    }
    function render(int $selector=self::COMPACT): string
    {
        $retour="";
        switch ($selector) {
            case self::COMPACT: $retour='<legend>'.$this->track->titre.' - by '.$this->track->artiste.'</legend><audio controls src="'.$this->track->filename.'"></audio>';break;
            case self::LONG: $retour='<legend>'.$this->track->titre.' - by '.$this->track->artiste.' '.$this->track->duree.'s </legend><audio controls src="'.$this->track->filename.'"></audio>';break;
        }
        return $retour;
    }
}