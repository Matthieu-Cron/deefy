<?php
namespace iutnc\deefy\audio\tracks;
use Exception;
use iutnc\deefy\audio\lists\AudioList;

class Album extends AudioList
{
    private string $artist;
    private string $album;
    private string $date;

    function __construct(string $nom,string $artist,string $album,string $date,int $id=0,AudioTrack $liste=null)
    {
        parent::__construct($nom,$id,$liste);
        $this->artist = $artist;
        $this->album = $album;
        $this->date = $date;
    }

    /**
     * @throws Exception
     */
    public function __get(string $at):mixed {
        if (property_exists ($this, $at)) return $this->$at;
        throw new Exception ("$at: invalid property");
    }
}