<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\repository\DeefyRepository;
use mysql_xdevapi\Exception;

class Authz
{
    private $user2playlist;
    private $repo;
    public function __construct()
    {
        DeefyRepository::setConfig(__DIR__ . '/../../db.config');
        $this->repo = DeefyRepository::getInstance();
        $this->user2playlist = $this->repo->recupereTousUtilisateurs();
    }

    public function checkRole(int $role):bool
    {
        if(!isset($_SESSION['User_id']))
        {
            throw new Exception('Veuillez vous connecter au serveur');
        }
        else
        {
            return (int)$_SESSION['User_role'] == $role;
        }
    }

    public function checkPlaylistOwner(int $playlist_id):bool
    {
        if(!isset($_SESSION['User_id']))
        {
            throw new Exception('Veuillez vous connecter au serveur');
        }
        else
        {
            $res ="flase";
            foreach ($this->user2playlist as $user)
            {
                if(($user['id_user'] == $_SESSION['User_id'])and ($user['id_pl'] == $playlist_id))
                {
                    $res = "true";
                }
            }
        }
        return $res;
    }
}