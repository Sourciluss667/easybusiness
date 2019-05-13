<?php
ini_set('display_errors', 1);

function dbConnect() {
  try
  {
    $db = new PDO('mysql:host=localhost;dbname=easybusiness;charset=utf8','root','');
  }
  catch(Exception $e)
  {
    die('Erreur :' .$e->getMessage());
  }
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function createMember($lastname, $firstname, $password, $email, $nameEnterprise) {
    try {
    $db = dbConnect();    
    $req = $db->prepare('INSERT INTO account(lastname, firstname, mail, password, nameEnterprise, dateInscription) VALUES(:lastname, :firstname, :mail, :password, :nameEnterprise, CURDATE())');
    $req->execute(array(
        'lastname' => $lastname,
        'firstname'=> $firstname,
        'mail' => $email,
        'password' => $password,
        'nameEnterprise' => $nameEnterprise));
    $req->closeCursor();
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
}

function selectInfoUser($email){
  $db = dbConnect();
  $req = $db->prepare("SELECT * FROM profil WHERE mail LIKE :mail");
  $req->execute(array(
    ":mail" => $email,
  ));
  $result = $req->fetch(PDO::FETCH_ASSOC);
  return $result;
}

function isExist() {
    $db = dbconnect();
    $req = $bdd->prepare('SELECT COUNT(*) AS nb_email FROM account WHERE mail = ?');
    $req->execute(array($email));
    $req->fetch();
    return $req;
}
function isRegister($email,$password) {
  try {
    $db = dbConnect();
    $req = $db->prepare('SELECT * FROM account WHERE mail = :mail AND password = :password');
    $req->execute(array(
      'mail' => $email,
      'password' => $password
    ));
    return $req;
  }
  catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
  }
}

?>