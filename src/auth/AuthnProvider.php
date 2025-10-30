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
        echo "<p>test de : ".$username." avec le mot de passe: ".$password."<br>";
        $password = password_hash($password, PASSWORD_DEFAULT);
        echo "test de : ".$username." avec le mot de passe: ".$password."</p><br>";
        $res = false;
        foreach ($this->users as $user) {
            if($user->getEmail() === $username && $user->getPassword() === $password) {
                $res = true;
            }
        }
        if($res) {
            echo "<p>Conection réusie</p>";
        }
        else {
            echo "<p>Conection impossible</p>";
        }
    }
}