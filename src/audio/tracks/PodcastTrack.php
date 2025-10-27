<?php
namespace iutnc\deefy\audio\tracks;
use Exception;

class PodcastTrack extends \iutnc\deefy\audio\tracks\AudioTrack
{
    private String $date;

    /**
     * @param String $date
     */
    public function __construct(string $date,string $artiste, string $titre, string $genre, int $duree, string $filename)
    {
        parent::__construct($artiste,$titre,$genre,$duree,$filename);
        $this->date = $date;
    }

    public function __get(string $at):mixed {
        if (property_exists ($this, $at)) return $this->$at;
        throw new Exception ("$at: invalid property");
    }

}