<?php
namespace iutnc\deefy\audio\lists;
class Playlists extends AudioList
{
    function __construct(string $nom, AudioList $liste=null)
    {
        $this->nom = $nom;
        if($liste != null){
            $this->liste = $liste->liste;
        }
    }

    public function add(\iutnc\deefy\audio\tracks\AudioTrack $track)
    {
        if(!in_array($track,$this->liste)){
            $this->liste->add($track);
        }
    }

    public function remove(int $index)
    {
        if($index < 0 || $index > count($this->liste)){
            $this->liste->remove($index);
        }
    }

    public function adds(array $liste)
    {
        foreach($liste as $track){
            $this->add($track);
        }
    }
}