<?php

namespace iutnc\deefy\repository;

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

   
   
   public function recupererToutesPlaylists(): array
{
    $sql = "SELECT * FROM playlist";
    $stmt = $this->pdo->query($sql);
    $playlists = $stmt->fetchAll();

    return $playlists ?: [];
}


    
    public function sauvegarderPlaylistVide(string $nom, string $description = ''): int
{
    $sql = "INSERT INTO playlist (nom, description) VALUES (:nom, :description)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'nom' => $nom,
        'description' => $description
    ]);

    
    return (int) $this->pdo->lastInsertId();
}


      public function sauvegarderTrack(string $titre, string $artiste, string $album, int $duree): int
{
    $sql = "INSERT INTO track (titre, artiste, album, duree)
            VALUES (:titre, :artiste, :album, :duree)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'titre' => $titre,
        'artiste' => $artiste,
        'album' => $album,
        'duree' => $duree
    ]);

    return (int) $this->pdo->lastInsertId();
}


    public function ajouterTrackAPlaylist(int $playlistID, int $trackId): void 
    {
       $checkPlaylist = $this->pdo->prepare("Select id from playlist where id = :id");
       $checkPlaylist->execute(['id' => $playlistID]);

       $checkTrack = $this->pdo->prepare("Select id from track where id = :id");
       $checkTrack->execute(['id' => $trackId]);


       $sql = "insert into playlist2track (playlist_id, track_id) values (: pid, :tid)";
       $stmt = $this->pdo->prepare($sql);
       $stmt->execute(['pid' => $playlistId , 'tid' => $trackId]);

    

    }
}
