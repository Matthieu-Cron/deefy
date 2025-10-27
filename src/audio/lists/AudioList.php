<?php
namespace iutnc\deefy\audio\lists;
class AudioList
{
    protected string $nom;
    protected array $liste;

    function __construct(string $nom, AudioList $liste=null)
    {
        $this->nom = $nom;
        if($liste != null){
            $this->liste = $liste->liste;
        }
        else
        {
            $this->liste = [];
        }
    }

    public function __get(string $at):mixed {
        if (property_exists ($this, $at)) return $this->$at;
        throw new Exception ("$at: invalid property");
    }

    public function getTotalTime():int
    {
        $n=0;
        if($this->liste != null)
        {
            foreach($this->liste as $track)
            {
                $n=$n+$track->duree;
            }
        }
        return $n;
    }

    public function getNumberOfTracks():int
    {
        return count($this->liste);
    }
}