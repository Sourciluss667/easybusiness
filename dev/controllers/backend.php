<?php
require('model/backend.php');
ini_set('display_errors', 1);
error_reporting(e_all);

function registerMember() {
    if(isset($_POST['inscription']))
    {
        $_POST['lastName'] = htmlspecialchars($_POST['lastName']);
        $_POST['firstName'] = htmlspecialchars($_POST['firstName']);
        $_POST['password'] = htmlspecialchars($_POST['password']);
        $_POST['verifPassword'] = htmlspecialchars($_POST['verifPassword']);
        $_POST['mail'] = htmlspecialchars($_POST['mail']);
        
        
        // Regex pour vérifier l'email
        if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['mail']))
        {
            $email_valide = true;
        }
        
            if(!isset($_POST['lastName']) OR empty($_POST['lastName']))
            {
                echo 'Veuillez saisir un nouveau nom';
            }
            
            else if(!isset($_POST['firstName']) OR empty($_POST['firstName']))
            {
                echo 'Veuillez saisir un nouveau prenom';
            }
            
            // Verification du mot de passe
            elseif(!isset($_POST['password']) OR !isset($_POST['verifPassword']) OR empty($_POST['password']) OR $_POST['password'] != $_POST['verifPassword'])
            {
                echo 'Les deux mots de passes ne sont pas identiques, veuillez les saisir à nouveau';
            }
            
            elseif(empty($_POST['mail']) OR !isset($email_valide))
            {
                echo 'L\'adresse e-mail n\'est pas valide !';
            }
            else
            {
                $password_hash = sha1($_POST['password']);
                
                createMember($_POST['pseudo'], $password_hash, $_POST['email']);
                
                echo 'Vous avez été inscrit.';
            }		
    }

    
    else
    {
        include_once('views/register.php');
    }
}

?>