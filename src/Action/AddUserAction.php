<?php

namespace iutnc\deefy\Action;

use iutnc\deefy\action\Action;
use iutnc\deefy\auth\AuthnProvider;

class AddUserAction extends Action
{

    public function execute(): string
    {
        if($this->http_method === 'GET'){
            $html = "<form method='post' action='?action=add-user'>
                <label>Mail : </label>
                <input type='email' name='Mail' placeholder=\"Nom de l'utilisateur\"><br>
                <label>Mot de passe :<label>
                <input type='password' name='MotDePasse' placeholder=\"Email de l'utilisateur\"><br>
                <label>Confirmation du mot de passe : </label>
                <input type='password' name='Confirmation' placeholder=\"Âge de l'utilisateur\">
                <button type='submit'>Connection</button>";
        }
        else
        {
            if(!isset($_POST['Mail']) || trim($_POST['Mail']) == ''){
                return "<p>Erreur : L'email est obligatoire</p>";
            }
            if(!isset($_POST['MotDePasse']) || trim($_POST['MotDePasse']) == ''){
                return "<p>Erreur : Le mot de passe est obligatoire</p>";
            }
            if(!isset($_POST['Confirmation']) || trim($_POST['Confirmation']) == ''){
                return "<p>Erreur : Le mot de passe obligatoire</p>";
            }
            $email = filter_var($_POST['Mail'],FILTER_SANITIZE_EMAIL);
            $MotDePasse = filter_var($_POST['MotDePasse'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $Confirmation = filter_var($_POST['Confirmation'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if(!($MotDePasse === $Confirmation)){
                return "<p>Les deux mots de passe doivent être identique</p>";
            }
            $AuthnProvider = new AuthnProvider();
            if($AuthnProvider->register($email, $MotDePasse))
            {
                $html = "<h2>Inscription réussie.</h2>";
            }
            else
            {
                $html = "<p>Erreur lors de l'inscription</p>";
            }
        }
        return $html;
    }
}