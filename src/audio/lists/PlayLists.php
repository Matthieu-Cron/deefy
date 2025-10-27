<?php
namespace iutnc\deefy\audio\lists;
use iutnc\deefy\audio\tracks\AudioTrack;

class PlayLists extends AudioList
{
    function __construct(string $nom, AudioList $liste=null)
    {
        parent::__construct($nom,$liste);
    }
    public function remove(int $index)
    {
        if($index < 0 || $index > count($this->liste)){
            $this->liste->remove($index);
        }
    }

    public function adds(array|AudioTrack $liste): void
    {
        foreach($liste as $track){
            $this->add($track);
        }
    }
}