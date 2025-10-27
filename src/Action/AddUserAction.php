<?php

namespace iutnc\deefy\action;

use iutnc\deefy\action\Action;

class AddUserAction extends Action
{

    public function execute(): string
    {
        if($this->http_method === 'GET'){
            $html = "<form method='post' action='?action=add-user'>
                <label>Nom : </label>
                <input type='text' name='Nom' placeholder=\"Nom de l'utilisateur\">
                <label>Email :<label>
                <input type='email' name='Email' placeholder=\"Email de l'utilisateur\">
                <label>Âge : </label>
                <input type='number' name='Age' placeholder=\"Âge de l'utilisateur\">
                <button type='submit'>Connection</button>";
        }
        else
        {
            if(!isset($_POST['Nom']) || trim($_POST['Nom']) == ''){
                return "<p>Erreur : Le nom est obligatoire</p>";
            }
            if(!isset($_POST['Email']) || trim($_POST['Email']) == ''){
                return "<p>Erreur : L'email est obligatoire</p>";
            }
            if(!isset($_POST['Age']) || trim($_POST['Age']) == ''){
                return "<p>Erreur : L'age est obligatoire</p>";
            }
            $nom = filter_var($_POST['Nom'],FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($_POST['Email'],FILTER_SANITIZE_EMAIL);
            $age = filter_var($_POST['Age'],FILTER_SANITIZE_NUMBER_INT);
            $html = "Nom : ".$nom."<br>Email : ".$email."<br>Age : ".$age;
        }
        return $html;
    }
}