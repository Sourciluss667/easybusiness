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
    
    // Recup rate admin
    $req = $db->prepare('SELECT * FROM rate WHERE id = 1');
    $req->execute();
    $rateAdmin = $req->fetchAll();

    // rate
    //id 	seuil 	formationPro 	RSI 	TVA
    $req = $db->prepare('INSERT INTO rate(seuil, seuilTVA, formationPro, RSI, TVA) VALUES(:seuil, :seuilTVA, :formationPro, :RSI, :TVA)'); // Mettre les taux admin
    $req->execute(array(
      "seuil" => $rateAdmin[0]["seuil"],
      "seuilTVA" => $rateAdmin[0]["seuilTVA"],
      "formationPro" => $rateAdmin[0]["formationPro"],
      "RSI" => $rateAdmin[0]["RSI"],
      "TVA" => $rateAdmin[0]["TVA"]
    ));
    $req->closeCursor();


    // enterpriseInfo
    $req = $db->prepare('INSERT INTO enterpriseInfo(status, ACRE, ARCE, RCP, declarationTime, typeNumFacture, rate_id, account_id) VALUES("Achat/revente de marchandises", 0, 0, 0, "Trimestrielle", "0000", :rateId, :id)');
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

  function editRate($idUser, $seuil, $seuilTVA, $formationPro, $RSI, $TVA) { // Taux user
    $db = dbConnect();
    if ($TVA === -1) {
      $query = $db->prepare('UPDATE rate SET seuil = :seuil, seuilTVA = :seuilTVA, formationPro = :formationPro, RSI = :RSI WHERE id LIKE (SELECT rate_id FROM enterpriseInfo WHERE account_id = :idUser)');
    $query->execute(array(
      'seuil'=> $seuil,
      "seuilTVA" => $seuilTVA,
      'formationPro'=> $formationPro,
      'RSI' => $RSI,
      'idUser' => $idUser
    ));
    }
    else {
      $query = $db->prepare('UPDATE rate SET seuil = :seuil, seuilTVA = :seuilTVA, formationPro = :formationPro, RSI = :RSI, TVA = :TVA WHERE id LIKE (SELECT rate_id FROM enterpriseInfo WHERE account_id = :idUser)');
    $query->execute(array(
      'seuil'=> $seuil,
      "seuilTVA" => $seuilTVA,
      'formationPro'=> $formationPro,
      'RSI' => $RSI,
      'TVA' => $TVA,
      'idUser' => $idUser
    ));
    }
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

  function editEnterprise($idUser, $status, $acre, $arce, $rcp, $declarationTime, $typeNumFacture) { // 	status 	ACRE 	ARCE 	RCP 	declarationTime
    $db = dbConnect();
    $query = $db->prepare('UPDATE enterpriseInfo SET status = :status, ACRE = :acre, ARCE = :arce, RCP = :rcp, declarationTime = :declarationTime, typeNumFacture = :typeNumFacture WHERE account_id = :idUser');
    $query->execute(array(
      'status'      => $status,
      'acre'       => $acre,
      'arce' => $arce,
      'rcp' => $rcp,
      'declarationTime' => $declarationTime,
      'idUser'         => $idUser,
      'typeNumFacture' => $typeNumFacture
    ));

    

    if ($acre) {
      // ACRE
      switch ($status) {
        // Seuil SeuilTVA RSI FormationPro
        case 'Achat/revente de marchandises':
          // 139 738 € HT , 82 800 € de CA HT , 3.2% , 0.1
          editRate($idUser, 139738, 82800, 0.1, 3.2, 0);
        break;
        case 'Vente de denrées à consommer sur place':
          // 139 738 € HT , 82 800 € de CA HT , 3.2% , 0.1
          editRate($idUser, 139738, 82800, 0.1, 3.2, 0);
        break;
        case 'Prestations d\'hébergement (BIC)':
          // 170 000 € HT , 33 200 € de CA HT, 3.2%, 0.2
          editRate($idUser, 170000, 33200, 0.2, 3.2, 0);
        break;
        case 'Prestation de service commerciale ou artisanale (BIC / BNC)':
          // 81 048 € HT , 33 200 € de CA HT, 5.5%, 0.2
          editRate($idUser, 81048, 33200, 0.2, 5.5, 0);
        break;
        case 'Profession libérale':
          // 61 400 € HT , 33 200 € de CA HT, 5.5% , 0.2
          editRate($idUser, 61400, 33200, 0.2, 5.5, 0);
        break;
        case 'Activité de location de tourisme':
          // 170 000 € HT , 33 200 € de CA HT, 1.9% , 0.2
          editRate($idUser, 170000, 33200, 0.2, 1.9, 0);
        break;
        
      }
    }
    else {
      // Sans ACRE
      switch ($status) {
        // Seuil SeuilTVA RSI FormationPro
        case 'Achat/revente de marchandises':
          // 170 000 € HT , 82 800 € de CA HT , 12.8% , 0.1
          editRate($idUser, 170000, 82800, 0.1, 12.8, -1);
        break;
        case 'Vente de denrées à consommer sur place':
          // 170 000 € HT , 82 800 € de CA HT , 12.8% , 0.1
          editRate($idUser, 170000, 82800, 0.1, 12.8, -1);  
        break;
        case 'Prestations d\'hébergement (BIC)':
          // 170 000 € HT , 33 200 € de CA HT, 12.8%, 0.2
          editRate($idUser, 170000, 33200, 0.2, 12.8, -1);
        break;
        case 'Prestation de service commerciale ou artisanale (BIC / BNC)':
          // 70 000 € HT , 33 200 € de CA HT, 22%, 0.2
          editRate($idUser, 70000, 33200, 0.2, 22, -1);
        break;
        case 'Profession libérale':
          // 70 000 € HT , 33 200 € de CA HT, 22% , 0.2
          editRate($idUser, 70000, 33200, 0.2, 22, -1);
        break;
        case 'Activité de location de tourisme':
          // 170 000 € HT , 33 200 € de CA HT, 22% , 0.2
          editRate($idUser, 170000, 33200, 0.2, 22, -1);
        break;
        
      }
    }
  }

  function addFactureFromCalendar($idUser, $idClient, $notes, $date, $totalPrix) {
    try {

      // account
      $db = dbConnect();    
      $req = $db->prepare('INSERT INTO facture(totalPrix, dateStr, notes, account_id, client_id) VALUES(:totalPrix, :dateStr, :notes, :idUser, :idClient)');
      $req->execute(array(
          'totalPrix' => $totalPrix,
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

  function addFacture($idUser, $idClient, $notes, $dateStr, $dateMax, $totalPrix, $dateFacture, $dateLivraison, $numFacture, $typeFacture, $TVA, $RCP, $produit, $quantity, $prixUnit, $totalUnit) {
    try {

      // account
      $db = dbConnect();    
      $req = $db->prepare('INSERT INTO facture(totalPrix, dateStr, dateMax, notes, dateFacture, dateLivraison, numFacture, typeFacture, TVA, del, account_id, client_id, RCP, produit, quantity, prixUnit, totalUnit) VALUES(:totalPrix, :dateStr, :dateMax, :notes, :dateFacture, :dateLivraison, :numFacture, :typeFacture, :TVA, 0, :idUser, :idClient, :RCP, :produit, :quantity, :prixUnit, :totalUnit)');
      $req->execute(array(
          'totalPrix' => $totalPrix,
          'dateStr'=> $dateStr,
          'dateMax' => $dateMax,
          'notes' => $notes,
          'dateFacture' => $dateFacture,
          'dateLivraison' => $dateLivraison,
          'numFacture' => $numFacture,
          'typeFacture' => $typeFacture,
          'TVA' => $TVA,
          'idUser' => $idUser,
          'idClient' => $idClient,
          'RCP' => $RCP,
          'produit' => $produit,
          'quantity' => $quantity,
          'prixUnit' => $prixUnit,
          'totalUnit' => $totalUnit
        ));
      $req->closeCursor();
      
      }
      catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
      }
  }

  function editFacture($idUser, $idClient, $idFacture, $notes, $dateStr, $totalPrix, $dateFacture, $dateLivraison, $numFacture, $typeFacture) {
    try {
      $db = dbConnect();    
      $req = $db->prepare('UPDATE facture SET client_id = :idClient, notes = :notes, dateStr = :dateStr, totalPrix = :totalPrix, dateFacture = :dateFacture, dateLivraison = :dateLivraison, numFacture = :numFacture, typeFacture = :typeFacture WHERE id = :id AND account_id = :idUser');
      $req->execute(array(
          'totalPrix' => $totalPrix,
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

  function addClient($idUser, $nom, $status, $adresse) {
    try {
    $db = dbConnect();
    $req = $db->prepare("INSERT INTO client(nom, status, adresse, account_id) VALUES(:nom, :status, :adresse, :idUser)");
    $req->execute(array(
      "nom" => $nom,
      "status" => $status,
      "idUser" => $idUser,
      "adresse" => $adresse
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
      // $req = $db->prepare("DELETE FROM facture WHERE id=:idFacture");
      $req = $db->prepare("UPDATE facture SET del = 1 WHERE id = :idFacture");
      $req->execute(array(
        "idFacture" => $idFacture
      ));
    }
    catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
    }
  }

  function editClientSecure($nom, $status, $adresse, $idClient, $idUser) {
    $db = dbConnect();
    
    if ($adresse != "nooo") {
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

    $query = $db->prepare('SELECT totalPrix, typeFacture, dateStr FROM facture WHERE account_id LIKE :id AND del LIKE 0');
    $query->execute(array(
      'id' => $id
    ));

    $result = $query->fetchAll();

    $balance = 0;

    for ($i = 0; $i < count($result, COUNT_NORMAL); $i++) {

      if ($result[$i]["dateStr"] <= date('Y-m-d')) {
        if ($result[$i]["typeFacture"] == "Achat") {
          $balance -= $result[$i]["totalPrix"];
        }
        elseif ($result[$i]["typeFacture"] == "Vente") {
          $balance += $result[$i]["totalPrix"];
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

    $query = $db->prepare('SELECT totalPrix, typeFacture FROM facture WHERE account_id LIKE :id AND del LIKE 0');
    $query->execute(array(
      'id' => $id
    ));

    $result = $query->fetchAll();

    $balance = 0;

    for ($i = 0; $i < count($result, COUNT_NORMAL); $i++) {
        if ($result[$i]["typeFacture"] == "Achat") {
          $balance -= $result[$i]["totalPrix"];
        }
        elseif ($result[$i]["typeFacture"] == "Vente") {
          $balance += $result[$i]["totalPrix"];
        }
        else {
          echo 'wtf'; // Ne sera jamais vu :)
        }
    }

    return $balance;
  }

  function getDateLastFacture($id) {
    $db = dbConnect();

    $query = $db->prepare('SELECT dateStr FROM facture WHERE account_id LIKE :id AND del LIKE 0');
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

  function getTypeNumFacture($id) {
    $db = dbConnect();
    $req = $db->prepare('SELECT typeNumFacture FROM enterpriseInfo WHERE account_id = :id');
    $req->execute(array(
      "id" => $id
    ));

    return $req->fetchAll();
  }

  function getAllIn($id) {
    $db = dbConnect();

    $query = $db->prepare('SELECT totalPrix, typeFacture FROM facture WHERE account_id LIKE :id AND del LIKE 0');
    $query->execute(array(
      'id' => $id
    ));

    $result = $query->fetchAll();

    $balance = 0;

    for ($i = 0; $i < count($result, COUNT_NORMAL); $i++) {
        if ($result[$i]["typeFacture"] == "Vente") {
          $balance += $result[$i]["totalPrix"];
        }
    }

    return $balance;
  }

  function getAllOut($id) {
    $db = dbConnect();

    $query = $db->prepare('SELECT totalPrix, typeFacture FROM facture WHERE account_id LIKE :id AND del LIKE 0');
    $query->execute(array(
      'id' => $id
    ));

    $result = $query->fetchAll();

    $balance = 0;

    for ($i = 0; $i < count($result, COUNT_NORMAL); $i++) {
        if ($result[$i]["typeFacture"] == "Achat") {
          $balance += $result[$i]["totalPrix"];
        }
        echo $i;

    }
    echo $balance;
    return $balance;
  }
  

?>