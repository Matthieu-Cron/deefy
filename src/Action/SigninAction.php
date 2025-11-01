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
            if(isset($_SESSION["User_id"]))
            {
                $html = "<h2>Connection Réussie Grâce à la session</h2><br><p>L'utilisateur : ".$_SESSION['User_id']."<br>".$_SESSION['User_emali']."<br>".$_SESSION['User_role']."<br>Est connecté</p>";
            }
            else{
                $html = "
            <form action='.?action=SigninAction' method='POST'>
            <label>Utilisateur</label>
            <input type='text' name='Username'><br>
            <label>Mot de passe</label>
            <input type='password' name='Password'><br>
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
            $html = "<h2>Connection Réussie</h2><br><p><br><p>L'utilisateur : ".$_SESSION['User_id']."<br>".$_SESSION['User_emali']."<br>".$_SESSION['User_role']."<br>Est connecté</p>";
        }
        return $html;
    }
}