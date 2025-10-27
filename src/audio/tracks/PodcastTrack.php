<?php
namespace iutnc\deefy\audio\tracks;
class PodcastTrack extends \iutnc\deefy\audio\tracks\AudioTrack
{
    private String $date;

    /**
     * @param String $date
     */
    public function __construct(string $date,string $artiste, string $titre, string $genre, int $duree, string $filename)
    {
        $this->date = $date;
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

}