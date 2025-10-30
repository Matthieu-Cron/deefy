<?php

namespace iutnc\deefy\auth;

class AuthnProvider
{
    private array $users;

    function __construct()
    {
        $repo = \iutnc\deefy\repository\DeefyRepository::getInstance();
        $this->users = $repo->recupereTousUtilisateurs();
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
}