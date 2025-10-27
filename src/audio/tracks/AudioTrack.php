<?php
namespace iutnc\deefy\audio\tracks;
use Exception;

Class AudioTrack{
    protected string $titre;
    protected string $artiste;
    protected string $genre;
    protected int $duree=0;
    protected string $filename;

    /**
     * @param string $artiste
     * @param string $titre
     * @param string $genre
     * @param int $duree
     * @param string $filename
     */
    public function __construct(string $artiste, string $titre, string $genre, int $duree, string $filename)
    {
        $this->artiste = $artiste;
        $this->titre = $titre;
        $this->genre = $genre;
        $this->duree = $duree;
        $this->filename = $filename;
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