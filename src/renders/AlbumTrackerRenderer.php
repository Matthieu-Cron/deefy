<?php
namespace iutnc\deefy\renders;
use iutnc\deefy\interfaces\Renderer;
use iutnc\deefy\audio\tracks\AlbumTrack;
class AlbumTrackerRenderer implements Renderer {
    private  AlbumTrack $track;
    public function __construct(AlbumTrack $track)
    {
        $this->track = $track;
    }

    public function Render(int $selector=self::COMPACT):string
    {
        $retour="";
        switch ($selector) {
            case self::COMPACT: $retour='<legend>'.$this->track->numero.' - '.$this->track->titre.' - by '.$this->track->artiste.' (from '.$this->track->album.')</legend><audio controls src="'.$this->track->filename.'"></audio>';break;
            case self::LONG: $retour='<legend>'.$this->track->numero.' - '.$this->track->titre.' - by '.$this->track->artiste.' (from '.$this->track->album.', '.$this->track->année.' ) '.$this->track->duree.'s </legend><audio controls src="'.$this->track->filename.'"></audio>';break;
        }
        return $retour;
    }
}