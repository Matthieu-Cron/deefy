<?php

namespace iutnc\deefy\repository;

use iutnc\deefy\audio\lists\PlayLists;
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\auth\User;
use PDO;
use PDOException;
use Exception;

class DeefyRepository
{
    private static ?DeefyRepository $instance = null;
    private static array $config = [];

    private PDO $pdo;

    
    private function __construct()
    {
        if (empty(self::$config)) {
            throw new Exception("Configuration non définie. Utilisez DeefyRepository::setConfig().");
        }

        $driver = self::$config['driver'] ?? 'mysql';
        $host = self::$config['host'] ?? 'localhost';
        $dbname = self::$config['dbname'] ?? '';
        $charset = self::$config['charset'] ?? 'utf8mb4';
        $user = self::$config['username'] ?? '';
        $pass = self::$config['password'] ?? '';

        $dsn = "$driver:host=$host;dbname=$dbname;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    /**
     * Charge la configuration depuis un fichier INI
     */
    public static function setConfig(string $file): void
    {
        if (!file_exists($file)) {
            throw new Exception("Fichier de configuration introuvable : $file");
        }

        $config = parse_ini_file($file);
        if ($config === false) {
            throw new Exception("Erreur lors de la lecture du fichier INI : $file");
        }

        self::$config = $config;
    }

    /**
     * Retourne l’instance unique du Repository (singleton)
     */
    public static function getInstance(): DeefyRepository
    {
        if (self::$instance === null) {
            self::$instance = new DeefyRepository();
        }

        return self::$instance;
    }

    /**
     * Retourne la connexion PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }

   public function recupereTousUtilisateurs():array
   {
       $sql = "SELECT id,email,passwd FROM User;";
       $stmt = $this->pdo->query($sql);
       $rows = $stmt->fetchAll();
       $utilisateurs = [];
       foreach ($rows as $row) {
           $utilisateurs[] = new User($row['id'], $row['email'], $row['passwd']);
       }
       return $utilisateurs;
   }

   public function findPlaylistById(int $id): Playlists
   {
       $sql = "SELECT nom from Playlist WHERE id = :id";
       $stmt = $this->pdo->prepare($sql);
       $stmt->execute(['id' => $id]);
       $row = $stmt->fetch();
       if($row == null){
           throw new Exception("La playlist n'existe pas");
       }
       $nom = $row['nom'];
       $stmt->closeCursor();
       $playlist = new PlayLists($nom,$id);
       $sql = "SELECT id_track FROM playlist2track WHERE id_pl = :id";
       $stmt = $this->pdo->prepare($sql);
       $stmt->execute(['id' => $id]);
       $tracks = $stmt->fetchAll();
       $stmt->closeCursor();
       $sql = "SELECT * FROM track WHERE id = :id";
       $stmt = $this->pdo->prepare($sql);
       foreach ($tracks as $track) {
           $stmt->execute(['id' => $track['id_track']]);
           $row = $stmt->fetch();

           if ($row['type'] == 'P') {
               $track = new PodcastTrack($row['date_posdcast'],(string)$row['artiste_album'],$row['titre'],$row['genre'],$row['duree'],$row['filename'],$row['id']);
           } elseif ($row['titre_album'] != null or $row['annee_album'] != null or $row['numero_album'] != null) {
               $track = new AlbumTrack($row['artiste_album'],$row['titre'],$row['genre'],$row['duree'],$row['filename'],$row['titre_album'],$row['annee_album'],$row['numero_album'],$row['id']);
           } else {
               $track = new AudioTrack($row['artiste_album'],$row['titre'],$row['genre'],$row['duree'],$row['filename'],$row['id']);
           }
           $stmt->closeCursor();
           $playlist->add($track);
       }
       return $playlist;

   }
   public function inscriptionUtilisateur(string $email, string $password):void
   {
       $sql = "INSERT INTO User (email,passwd) VALUES ('$email','$password');";
       $stmt = $this->pdo->prepare($sql);
       $stmt->execute();
   }
   
  public function recupererToutesPlaylists(): array {
    $sql = "SELECT * FROM playlist";
    $stmt = $this->pdo->query($sql);
    $rows = $stmt->fetchAll();

    $playlists = [];
    foreach ($rows as $row) {
        $pl = new \iutnc\deefy\audio\lists\PlayLists($row['nom'],$row['id']);
        $playlists[] = $pl;
    }
    return $playlists;
}



    
public function sauvegarderPlaylistVide(\iutnc\deefy\audio\lists\PlayLists $pl): \iutnc\deefy\audio\lists\PlayLists
{
    $sql = "INSERT INTO playlist (nom) VALUES (:nom)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'nom' => $pl->nom
    ]);

    // met à jour l'ID dans l'objet
    $pl->setId((int) $this->pdo->lastInsertId());

    return $pl;
}





public function sauvegarderTrack(\iutnc\deefy\audio\tracks\AudioTrack $track): \iutnc\deefy\audio\tracks\AudioTrack
{
    if ($track instanceof \iutnc\deefy\audio\tracks\PodcastTrack) {
        // pour les podcasts : on utilise des valeurs par défaut si la propriété n'existe pas
        $auteur = property_exists($track, 'auteur') ? $track->auteur : '';
        $date   = property_exists($track, 'date') ? $track->date : '';

        $sql = "INSERT INTO track (titre, genre, duree, filename, type, auteur_podcast, date_posdcast)
                VALUES (:titre, :genre, :duree, :filename, 'P', :auteur, :date)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'titre'  => $track->titre,
            'genre'  => $track->genre,
            'duree'  => $track->duree,
            'filename' => $track->filename,
            'auteur' => $auteur,
            'date'   => $date
        ]);
    } else {
        // pour les tracks audio normales
        $sql = "INSERT INTO track (titre, genre, duree, filename, type, artiste_album, titre_album, annee_album, numero_album)
                VALUES (:titre, :genre, :duree, :filename, 'A', :artiste, :album, :annee, :num)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'titre'    => $track->titre,
            'genre'    => $track->genre,
            'duree'    => $track->duree,
            'filename' => $track->filename,
            'artiste'  => $track->artiste,
            'album'    => property_exists($track, 'titre_album') ? $track->titre_album : '',
            'annee'    => property_exists($track, 'annee_album') ? $track->annee_album : 0,
            'num'      => property_exists($track, 'numero_album') ? $track->numero_album : 0
        ]);
    }

    $track->setId((int) $this->pdo->lastInsertId());
    return $track;
}




 public function ajouterTrackAPlaylist(int $playlistID, int $trackID): void 
{
   
    $stmt = $this->pdo->prepare("SELECT id FROM playlist WHERE id = :id");
    $stmt->execute(['id' => $playlistID]);
    if (!$stmt->fetch()) {
        throw new Exception("Playlist $playlistID introuvable.");
    }

  
    $stmt = $this->pdo->prepare("SELECT id FROM track WHERE id = :id");
    $stmt->execute(['id' => $trackID]);
    if (!$stmt->fetch()) {
        throw new Exception("Track $trackID introuvable.");
    }

    $stmt = $this->pdo->prepare(
        "SELECT * FROM playlist2track WHERE id_pl = :pid AND id_track = :tid"
    );
    $stmt->execute([
        'pid' => $playlistID,
        'tid' => $trackID
    ]);
    if ($stmt->fetch()) {
        
        return;
    }
    $stmt = $this->pdo->prepare(
        "SELECT MAX(no_piste_dans_liste) AS maxNo FROM playlist2track WHERE id_pl = :pid"
    );
    $stmt->execute(['pid' => $playlistID]);
    $row = $stmt->fetch();
    $nextNo = $row['maxNo'] ? $row['maxNo'] + 1 : 1;

    $sql = "INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) VALUES (:pid, :tid, :no)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'pid' => $playlistID,
        'tid' => $trackID,
        'no'  => $nextNo
    ]);
}



}
