<?php
namespace iutnc\deefy\renders;
use iutnc\deefy\interfaces\Renderer;
class AudioListRenderer implements Renderer
{
    private \iutnc\deefy\audio\lists\AudioList $list;

    public function __construct(\iutnc\deefy\audio\lists\AudioList $list)
    {
        $this->list = $list;
    }
    public function Render(int $selector=self::COMPACT):string
    {
        $retour=$this->list->nom;
        foreach ($this->list as $audio) {
            $retour .= "<br>".$audio.$this->Render(self::COMPACT);
        }
        $retour.="<br> Nombre de pistes : ".$this->list->getNumberOfTracks();
        $retour.="<br> Temps totals en secondes : ".$this->list->getTotalTime();
        return $retour;
    }
}