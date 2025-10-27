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
        $retour="<h3>Nom : ".$this->list->nom."</h3>";
        foreach ($this->list as $audio) {
            $retour .= "<br>".$audio.$this->Render(self::COMPACT);
        }
        $retour.="<h3>Nombre de pistes : ".$this->list->getNumberOfTracks()."</h3>";
        $retour.="<h3>Temps totals en secondes : ".$this->list->getTotalTime()."</h3>";
        return $retour;
    }
}