<?php
namespace iutnc\deefy\audio\tracks;
use Exception;

class AlbumTrack extends \iutnc\deefy\audio\tracks\AudioTrack {
    private string $album;
    private string $annee;
    private int $numero;

    /**
     * @param string $album
     * @param string $annee
     * @param int $numero
     */
    public function __construct(string $artiste, string $titre, string $genre, int $duree, string $filename,string $album, string $annee, int $numero,int $id=0)
    {
        parent::__construct($artiste,$titre,$genre,$duree,$filename,$id);
        $this->album = $album;
        $this->annee = $annee;
        $this->numero = $numero;
    }

    public function __get(string $at):mixed {
        if (property_exists ($this, $at)) return $this->$at;
        throw new Exception ("$at: invalid property");
    }

    public function __toString():string
    {
        return json_encode(get_object_vars($this),JSON_PRETTY_PRINT);
    }
}