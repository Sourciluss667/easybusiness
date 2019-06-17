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
    $req = $db->prepare('INSERT INTO rate(seuil, formationPro, RSI, TVA) VALUES(1, 1, 1, 1)'); // Mettre les taux admin
    $req->execute();
    $req->closeCursor();


    // enterpriseInfo
    $db = dbConnect();
    $req = $db->prepare('INSERT INTO enterpriseInfo(status, ACRE, ARCE, RCP, declarationTime, rate_id, account_id) VALUES("Achat/revente de marchandises", 0, 0, 0, "Trimestrielle", :rateId, :id)');
    $req->execute(array(
      "id" => getId($email),
      "rateId" => getId($email)
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
  try {
  $db = dbConnect();

  // Delete facture
  $query = $db->prepare('DELETE FROM facture WHERE account_id = :id');
  $query->execute(array(
    'id'=>$id
  ));

  // Delete client
  $query = $db->prepare('DELETE FROM client WHERE account_id = :id');
  $query->execute(array(
    'id'=>$id
  ));

  // Get rateId
  $query = $db->prepare('SELECT rate_id FROM enterpriseInfo WHERE account_id = :id');
  $query->execute(array(
    'id'=>$id
  ));

  $rateId = $query->fetchAll();

  // Delete enterpriseInfo
  $query = $db->prepare('DELETE FROM enterpriseInfo WHERE account_id = :id');
  $query->execute(array(
    'id'=>$id
  ));

  // Delete rate
  $query = $db->prepare('DELETE FROM facture WHERE account_id = :id');
  $query->execute(array(
    'id'=>$rateId[0][0]
  ));

  // Delete account
  $query = $db->prepare('DELETE FROM account WHERE id = :id');
  $query->execute(array(
    'id'=>$id
  ));
  }
  catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
  }
}

  function modifyRate($seuil, $formationPro,$RSI,$TVA) { // Taux admin
    $db = dbConnect();
    $query =$db->prepare('UPDATE rate SET seuil = :seuil , formationPro = :formationPro , RSI = :RSI, TVA = :TVA WHERE id=1');
    $query->execute(array(
      'seuil'=> $seuil,
      'formationPro'=> $formationPro,
      'RSI' => $RSI,
      'TVA' => $TVA
    ));
  }

  function editRate($idUser, $seuil, $formationPro, $RSI, $TVA) { // Taux user
    $db = dbConnect();
    $query = $db->prepare('UPDATE rate SET seuil = :seuil, formationPro = :formationPro, RSI = :RSI, TVA = :TVA WHERE id LIKE (SELECT rate_id FROM enterpriseInfo WHERE account_id = :idUser)');
    $query->execute(array(
      'seuil'=> $seuil,
      'formationPro'=> $formationPro,
      'RSI' => $RSI,
      'TVA' => $TVA,
      'idUser' => $idUser
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
function getRate ($id) {
    $db = dbConnect();
    $query = $db->prepare("SELECT * FROM rate WHERE id LIKE (SELECT rate_id FROM enterpriseInfo WHERE account_id = :idUser)");
    $query->execute(array('idUser' => $id));
    $result = $query->fetchAll();
    return $result;
}
  function getId($mail) {
    $db = dbConnect();
    $query = $db->prepare("SELECT id FROM account WHERE mail = :mail");
    $query->execute(array('mail' => $mail));
    $result = $query->fetchAll();
    $result = $result[0]['id'];
    return $result;
  }
function getInfoUser() {
  $db = dbConnect();
  $query = $db->prepare("SELECT * FROM account");
  $query->execute();
  $result = $query->fetchAll();
  return $result;
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
    $query = $db->prepare('UPDATE enterpriseInfo SET status = :status, ACRE = :acre, ARCE = :arce, RCP = :rcp, declarationTime = :declarationTime WHERE account_id = :idUser');
    $query->execute(array(
      'status'      => $status,
      'acre'       => $acre,
      'arce' => $arce,
      'rcp' => $rcp,
      'declarationTime' => $declarationTime,
      'idUser'         => $idUser
    ));
  }

  function addFactureFromCalendar($idUser, $idClient, $notes, $date, $prix) {
    try {

      // account
      $db = dbConnect();    
      $req = $db->prepare('INSERT INTO facture(prix, dateStr, notes, account_id, client_id) VALUES(:prix, :dateStr, :notes, :idUser, :idClient)');
      $req->execute(array(
          'prix' => $prix,
          'dateStr'=> $date,
          'notes' => $notes,
          'idUser' => $idUser,
          'idClient' => $idClient));
      $req->closeCursor();
      
      }
      catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
      }
  }

  function addFacture($idUser, $idClient, $notes, $dateStr, $prix, $dateFacture, $dateLivraison, $numFacture, $typeFacture) {
    try {

      // account
      $db = dbConnect();    
      $req = $db->prepare('INSERT INTO facture(prix, dateStr, notes, dateFacture, dateLivraison, numFacture, typeFacture, account_id, client_id) VALUES(:prix, :dateStr, :notes, :dateFacture, :dateLivraison, :numFacture, :typeFacture, :idUser, :idClient)');
      $req->execute(array(
          'prix' => $prix,
          'dateStr'=> $dateStr,
          'notes' => $notes,
          'dateFacture' => $dateFacture,
          'dateLivraison' => $dateLivraison,
          'numFacture' => $numFacture,
          'typeFacture' => $typeFacture,
          'idUser' => $idUser,
          'idClient' => $idClient
        ));
      $req->closeCursor();
      
      }
      catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
      }
  }

  function editFacture($idUser, $idClient, $idFacture, $notes, $dateStr, $prix, $dateFacture, $dateLivraison, $numFacture, $typeFacture) {
    try {
      $db = dbConnect();    
      $req = $db->prepare('UPDATE facture SET client_id = :idClient, notes = :notes, dateStr = :dateStr, prix = :prix, dateFacture = :dateFacture, dateLivraison = :dateLivraison, numFacture = :numFacture, typeFacture = :typeFacture WHERE id = :id AND account_id = :idUser');
      $req->execute(array(
          'prix' => $prix,
          'dateStr'=> $dateStr,
          'notes' => $notes,
          'dateFacture' => $dateFacture,
          'dateLivraison' => $dateLivraison,
          'numFacture' => $numFacture,
          'typeFacture' => $typeFacture,
          'idUser' => $idUser,
          'idClient' => $idClient,
          'id' => $idFacture
        ));
      
      }
      catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
      }
  }

  function getFacturesFromId($id, $tri="id") {
    try {
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM facture WHERE account_id LIKE :id ORDER BY $tri");
    
    $req->execute(array(
      "id" => $id
    ));
    $result = $req->fetchAll();
    return $result;
    } catch (Exception $e) {
      die('Erreur: ' . $e->getMessage());
    }
  }

  function getFactureById($id, $userId) {
    try {
      $db = dbConnect();
      $req = $db->prepare("SELECT * FROM facture WHERE id LIKE :id AND account_id LIKE :userId");
      
      $req->execute(array(
        "id" => $id,
        "userId" => $userId
      ));
      $result = $req->fetchAll();
      return $result;
      } catch (Exception $e) {
        die('Erreur: ' . $e->getMessage());
      }
  }

  function getFacturesFromClientIdSecure($id, $idUser) {
    try {
    $db = dbConnect();
    $req = $db->prepare("SELECT * FROM facture WHERE client_id LIKE :id AND account_id LIKE :idUser");
    $req->execute(array(
      "id" => $id,
      "idUser" => $idUser
    ));
    $result = $req->fetchAll();
    return $result;
    } catch (Exception $e) {
      die('Erreur: ' . $e->getMessage());
    }
  }

  function addClient($idUser, $nom, $status) {
    try {
    $db = dbConnect();
    $req = $db->prepare("INSERT INTO client(nom, status, account_id) VALUES(:nom, :status, :idUser)");
    $req->execute(array(
      "nom" => $nom,
      "status" => $status,
      "idUser" => $idUser
    ));
    $req->closeCursor();
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  function getClients($idUser) {
    try {
      $db = dbConnect();
      $req = $db->prepare("SELECT * FROM client WHERE account_id=:idUser");
      $req->execute(array(
        "idUser" => $idUser
      ));
      $result = $req->fetchAll();

      return $result;
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  function getClientFromId($id) {
    try {
      $db = dbConnect();
      $req = $db->prepare("SELECT * FROM client WHERE id=:id");
      $req->execute(array(
        "id" => $id
      ));
      $result = $req->fetchAll();

      return $result;
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  function getClientFromIdSecure($id, $idUser) {
    try {
      $db = dbConnect();
      $req = $db->prepare("SELECT * FROM client WHERE id=:id AND account_id=:idUser");
      $req->execute(array(
        "id" => $id,
        "idUser" => $idUser
      ));
      $result = $req->fetchAll();

      return $result;
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  function deleteClient($idClient) {
    try {
      $db = dbConnect();
      $req = $db->prepare("DELETE FROM client WHERE id=:idClient");
      $req->execute(array(
        "idClient" => $idClient
      ));
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  function deleteFacture($idFacture) {
    try {
      $db = dbConnect();
      $req = $db->prepare("DELETE FROM facture WHERE id=:idFacture");
      $req->execute(array(
        "idFacture" => $idFacture
      ));
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  function editClientSecure($nom, $status, $adresse, $formeJuridique, $idClient, $idUser) {
    $db = dbConnect();

    if ($formeJuridique != "nooo" && $adresse != "nooo") {
      $query = $db->prepare('UPDATE client SET nom = :nom, status = :status, adresse = :adresse, formeJuridique = :formeJuridique WHERE id = :idClient AND account_id = :idUser');
      $query->execute(array(
        'nom'      => $nom,
        'status'       => $status,
        'adresse' => $adresse,
        'formeJuridique' => $formeJuridique,
        'idClient' => $idClient,
        'idUser'         => $idUser
      ));
    }
    elseif ($formeJuridique != "nooo") {
      $query = $db->prepare('UPDATE client SET nom = :nom, status = :status, formeJuridique = :formeJuridique WHERE id = :idClient AND account_id = :idUser');
      $query->execute(array(
        'nom'      => $nom,
        'status'       => $status,
        'formeJuridique' => $formeJuridique,
        'idClient' => $idClient,
        'idUser'         => $idUser
      ));
    }
    elseif ($adresse != "nooo") {
      $query = $db->prepare('UPDATE client SET nom = :nom, status = :status, adresse = :adresse WHERE id = :idClient AND account_id = :idUser');
      $query->execute(array(
        'nom'      => $nom,
        'status'       => $status,
        'adresse' => $adresse,
        'idClient' => $idClient,
        'idUser'         => $idUser
      ));
    }
    else {
      $query = $db->prepare('UPDATE client SET nom = :nom, status = :status WHERE id = :idClient AND account_id = :idUser');
      $query->execute(array(
        'nom'      => $nom,
        'status'       => $status,
        'idClient' => $idClient,
        'idUser'         => $idUser
      ));
    }
      
  }

  function getBalance($id) {
    $db = dbConnect();

    $query = $db->prepare('SELECT prix, typeFacture, dateStr FROM facture WHERE account_id LIKE :id');
    $query->execute(array(
      'id' => $id
    ));

    $result = $query->fetchAll();

    $balance = 0;

    for ($i = 0; $i < count($result, COUNT_NORMAL); $i++) {

      if ($result[$i]["dateStr"] <= date('Y-m-d')) {
        if ($result[$i]["typeFacture"] == "Achat") {
          $balance -= $result[$i]["prix"];
        }
        elseif ($result[$i]["typeFacture"] == "Vente") {
          $balance += $result[$i]["prix"];
        }
        else {
          echo 'wtf'; // Ne sera jamais vu :)
        }
      }
    }

    return $balance;
  }

  function getFuturBalance($id) {
    $db = dbConnect();

    $query = $db->prepare('SELECT prix, typeFacture FROM facture WHERE account_id LIKE :id');
    $query->execute(array(
      'id' => $id
    ));

    $result = $query->fetchAll();

    $balance = 0;

    for ($i = 0; $i < count($result, COUNT_NORMAL); $i++) {
        if ($result[$i]["typeFacture"] == "Achat") {
          $balance -= $result[$i]["prix"];
        }
        elseif ($result[$i]["typeFacture"] == "Vente") {
          $balance += $result[$i]["prix"];
        }
        else {
          echo 'wtf'; // Ne sera jamais vu :)
        }
    }

    return $balance;
  }

  function getDateLastFacture($id) {
    $db = dbConnect();

    $query = $db->prepare('SELECT dateStr FROM facture WHERE account_id LIKE :id');
    $query->execute(array(
      'id' => $id
    ));

    $result = $query->fetchAll();

    $dateLast = date('Y-m-d');

    for ($i = 0; $i < count($result, COUNT_NORMAL); $i++) {
      if ($result[$i]["dateStr"] > $dateLast) {
        $dateLast = $result[$i]["dateStr"];
      }
    }

    return $dateLast;
  }
  

?>