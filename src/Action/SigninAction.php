<?php

namespace iutnc\deefy\Action;

use iutnc\deefy\auth\AuthnException;
use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\repository\DeefyRepository;

class SigninAction extends Action
{
    private AuthnProvider $provider;
    public function execute(): string
    {
        $html= "";
        if(!($this->http_method === 'POST')){
            if(isset($_SESSION["Username"]))
            {
                $html = "<h2>Connection Réussie Grâce à la session</h2><br><p>L'utilisateur : ".$_SESSION["Username"]."est connecté</p>";
            }
            else{
                $html = "
            <form action='.?action=signinAction' method='POST'>
            <label>Utilisateur</label>
            <input type='text' name='Username'>
            <label>Mot de passe</label>
            <input type='password' name='Password'>
            <button type='submit'>Connexion</button>
            </form>";
            }
        }
        else
        {
            $username = filter_var($_POST["Username"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $password = filter_var($_POST["Password"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            DeefyRepository::setConfig(__DIR__.'/../../db.config');
            $this->provider = new AuthnProvider();
            try {
                $this->provider->signin($username, $password);
            }
            catch (AuthnException $e){
                $html = "<p>".$e->getMessage()."</p>";
            }
            $_SESSION["Username"] = $username;
            $html = "<h2>Connection Réussie</h2><br><p>L'utilisateur : ".$username."est connecté</p>";
        }
        return $html;
    }
}