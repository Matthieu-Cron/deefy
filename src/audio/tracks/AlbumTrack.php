<?php
namespace iutnc\deefy\audio\tracks;
class AlbumTrack extends \iutnc\deefy\audio\tracks\AudioTrack {
    private string $album;
    private string $année;
    private int $numero;

    /**
     * @param string $album
     * @param string $année
     * @param int $numero
     */
    public function __construct(string $artiste, string $titre, string $genre, int $duree, string $filename,string $album, string $année, int $numero)
    {
        $this->album = $album;
        $this->année = $année;
        $this->numero = $numero;
        $this->artiste = $artiste;
        $this->titre = $titre;
        $this->genre = $genre;
        $this->filename = $filename;
        $this->duree = $duree;
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