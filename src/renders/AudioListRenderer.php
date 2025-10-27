<?php
namespace iutnc\deefy\renders;
use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\interfaces\Renderer;
class AudioListRenderer implements Renderer
{
    private AudioList $list;

    public function __construct(AudioList $list)
    {
        $this->list = $list;
    }
    public function Render(int $selector=self::COMPACT):string
    {
        $retour="<h3>Nom : ".$this->list->nom."</h3><ul>";

        foreach ($this->list->getListe() as $track)
        {
            if($track instanceof AudioTrack)
            {
                $renderer=new AudioTrackRenderer($track);
                $retour.="<li>".$renderer->Render($selector)."</li>";
            }
        }

        $retour.="</ul><h3>Nombre de pistes : ".$this->list->getNumberOfTracks()."</h3>";
        $retour.="<h3>Temps totals en secondes : ".$this->list->getTotalTime()."</h3>";
        return $retour;
    }
}