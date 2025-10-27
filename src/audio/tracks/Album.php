<?php
namespace iutnc\deefy\audio\tracks;
class Album extends AudioList
{
    private string $artist;
    private string $album;
    private string $date;

    function __construct(string $nom, AudioList $liste=null,string $artist,string $album,string $date)
    {
        $this->nom = $nom;
        if($liste != null){
            $this->liste = $liste->liste;
        }
        $this->artist = $artist;
        $this->album = $album;
        $this->date = $date;
    }

    public function __get(string $at):mixed {
        if (property_exists ($this, $at)) return $this->$at;
        throw new Exception ("$at: invalid property");
    }
}