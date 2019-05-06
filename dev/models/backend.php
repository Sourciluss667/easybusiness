<?php

function dbConnect() {
  try
  {
    $db = new PDO('mysql:host=localhost;dbname=easybusiness;charset=utf8','phpmyadmin','secret');
  }
  catch(Exception $e)
  {
    die('Erreur :' .$e->getMessage());
  }
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function CreateMember($lastname, $firstname, $password, $email)
{
    $db = dbConnect();    
    $req = $bdd->prepare('INSERT INTO membres(lastname, firstname, password, email, dateInscription) VALUES(:lastname, :firstname, :password, :email, CURDATE())');
    $req->execute(array(
        'lastname' => $lastname,
        'firstname'=> $firstname,
        'password' => $password,
        'email' => $email));
    $req->closeCursor();
}

function isRegister($pseudo,$password){
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM profil WHERE pseudo = :pseudo AND password = :password');
    $req->execute(array(
      'pseudo' => $pseudo,
      'password' => $password
    ));
    return $req;
    }

?>