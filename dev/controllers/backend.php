<?php
session_start();
require('models/backend.php');
ini_set('display_errors', 1);



function home () {
$title = "Easy Business";
require('views/accueil.php');
}

function connection($array) {
    $email = $_GET['email'];
    $password = $_GET['password'];
    $infos = selectInfoUser($pseudo);
    if (isset($infos)){
      if ($infos['password'] == $pw){
        $_SESSION['status'] = 'connected';
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['error'] = '';
      }
    }else {
      $_SESSION['error'] = "Erreur : Compte inconnu.";
    }
}

function registerMember() {
    if(isset($_POST['inscription']))
    {
        $_POST['lastname'] = htmlspecialchars($_POST['lastname']);
        $_POST['firstname'] = htmlspecialchars($_POST['firstname']);
        $_POST['nameEnterprise'] = htmlspecialchars($_POST['nameEnterprise']);
        $_POST['password'] = htmlspecialchars($_POST['password']);
        $_POST['verifPassword'] = htmlspecialchars($_POST['verifPassword']);
        $_POST['email'] = htmlspecialchars($_POST['email']);
        
        
        if(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $_POST['email']))
        {
            $email_valide = true;
        }
        
            if(!isset($_POST['lastname']) OR empty($_POST['lastname']))
            {
                echo 'Veuillez saisir un nouveau nom';
            }
            
            else if(!isset($_POST['firstname']) OR empty($_POST['firstname']))
            {
                echo 'Veuillez saisir un nouveau prenom';
            }
            
            else if(!isset($_POST['nameEnterprise']) OR empty($_POST['nameEnterprise']))
            {
                echo 'Veuillez saisir un nouveau prenom';
            }
            
            // Verification du mot de passe
            elseif(!isset($_POST['password']) OR !isset($_POST['verifPassword']) OR empty($_POST['password']) OR $_POST['password'] != $_POST['verifPassword'])
            {
                echo 'Les deux mots de passes ne sont pas identiques, veuillez les saisir à nouveau';
            }
            
            elseif(empty($_POST['email']) OR !isset($email_valide))
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
