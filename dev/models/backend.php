<?php

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

    // account
    $db = dbConnect();    
    $req = $db->prepare('INSERT INTO account(lastname, firstname, mail, password, nameEnterprise, dateInscription) VALUES(:lastname, :firstname, :mail, :password, :nameEnterprise, CURDATE())');
    $req->execute(array(
        'lastname' => $lastname,
        'firstname'=> $firstname,
        'mail' => $email,
        'password' => $password,
        'nameEnterprise' => $nameEnterprise));
    $req->closeCursor();
    
    // rate
    //id 	seuil 	formationPro 	RSI 	TVA 
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO rate(seuil, formationPro, RSI, TVA) VALUES(1, 1, 1, 1)');
    $req->execute();
    $req->closeCursor();


    // enterpriseInfo
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO enterpriseInfo(status, ACRE, ARCE, RCP, declarationTime, rate_id, account_id) VALUES("Achat/revente de marchandises", 0, 0, 0, "trimestrielle", 1, :id)');
    $req->execute(array(
      "id" => getId($email)
    ));
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
/*
function isExist() {
    $db = dbconnect();
    $req = $db->prepare('SELECT COUNT(*) AS nb_email FROM account WHERE mail = ?');
    $req->execute(array($email));
    $req->fetch();
    return $req;
}
*/
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

function selectRate() {
  $db = dbConnect();
  $req = $db->prepare("SELECT * FROM rate");
  return $req;
}

function deleteUser($id){
  $db = dbConnect();
  $query = $db->prepare('DELETE FROM account WHERE id = :id');
  $query->execute(array(
    'id'=>$id
  ));
}

  function modifyRate($idUser, $seuil, $formationPro,$RSI,$TVA) {
    $db =dbConnect();
    $query =$db->prepare('UPDATE rate SET seuil = :seuil , formationPro = :formationPro , RSI = :RSI, TVA = :TVA WHERE id =:idUser');
    $query->execute(array(
      'seuil'=> $seuil,
      'idUser'=> $idUser,
      'formationPro'=> $formationPro,
      'RSI' => $RSI,
      'TVA' => $TVA
    ));
  }

  function editUserWPass($idUser, $firstname, $lastname, $nameEnterprise, $password) {
    $db = dbConnect();
    $query = $db->prepare('UPDATE account SET firstname = :firstname, lastname = :lastname, nameEnterprise = :nameEnterprise, password = :password WHERE id = :idUser');
    $query->execute(array(
      'firstname'      => $firstname,
      'lastname'       => $lastname,
      'nameEnterprise' => $nameEnterprise,
      'password'       => $password,
      'idUser'         => $idUser
    ));
  }

  function editUser($idUser, $firstname, $lastname, $nameEnterprise) {
    $db = dbConnect();
    $query = $db->prepare('UPDATE account SET firstname = :firstname, lastname = :lastname, nameEnterprise = :nameEnterprise WHERE id = :idUser');
    $query->execute(array(
      'firstname'      => $firstname,
      'lastname'       => $lastname,
      'nameEnterprise' => $nameEnterprise,
      'idUser'         => $idUser
    ));
  }

  function getId($mail) {
    $db = dbConnect();
    $query = $db->prepare('SELECT id FROM account WHERE mail = :mail');
    $req= $query->execute(array('mail' => $mail));

    return $req;
  }

  function selectEnterpriseInfo($id){
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM enterpriseInfo WHERE account_id LIKE :id");
    $req->execute(array(
      ":id" => $id,
    ));
    $result = $req->fetch(PDO::FETCH_ASSOC);
    return $result;
  }

  function editEnterprise($idUser, $status, $acre, $arce, $rcp, $declarationTime) { // 	status 	ACRE 	ARCE 	RCP 	declarationTime
    $db = dbConnect();
    $query = $db->prepare('UPDATE enterpriseInfo SET status = :status, ACRE = :acre, ARCE = :arce, RCP = :rcp, declarationTime = :declarationTime WHERE accout_id = :idUser');
    $query->execute(array(
      'status'      => $status,
      'acre'       => $acre,
      'arce' => $arce,
      'rcp' => $rcp,
      'declarationTime' => $declarationTime,
      'idUser'         => $idUser
    ));
  }

?>