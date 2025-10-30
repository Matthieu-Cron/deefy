<?php

namespace iutnc\deefy\auth;

use iutnc\deefy\repository\DeefyRepository;

class AuthnProvider
{
    private const longmini = 10; //constante corespondant au nombre minimum de caratère nécessaire au mot de passe.
    private array $users;
    private $repository;

    function __construct()
    {
        DeefyRepository::setConfig(__DIR__ . '/../../db.config');
        $this->repository = DeefyRepository::getInstance();
        $this->users = $this->repository->recupereTousUtilisateurs();
    }

    public function signin(string $username, string $password): void
    {
        $res = false;
        foreach ($this->users as $user) {
            if($user->getEmail() === $username) {
                if(password_verify($password, $user->getPassword())) {
                    $res = true;
                }
            }
        }
        if(!$res) {
            throw new AuthnException();
        }
    }

    public function register(string $mail,string $password):bool
    {
        $res = true;
        if(strlen($password)<self::longmini) {
            $res = false;
        }
        if($res){
            foreach ($this->users as $user) {
                if($user->getEmail() === $mail) {
                    $res = false;
                }
            }
        }
        if($res) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $this->repository->inscriptionUtilisateur($mail, $password);
            $this->users = $this->repository->recupereTousUtilisateurs();
        }
        return $res;
    }
}