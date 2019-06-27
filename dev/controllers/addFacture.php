<?php

// Base
$typeFacture = htmlspecialchars($_POST['typeFacture']);
$notes = htmlspecialchars($_POST['notes']);

// Id auto-entrepreneur
/*if ($_POST['nameEnterprise'] == $_SESSION['nameEnterprise']) {
    $nameEnterprise = "0";
} else {
    $nameEnterprise = htmlspecialchars($_POST['nameEnterprise']);
}

if ($_POST['name'] == $_SESSION['firstname'].' '.$_SESSION['lastname']) {
    $name = "0";
} else {
    $name = htmlspecialchars($_POST['name']);
}


$adresseUser = htmlspecialchars($_POST['adresse']);
$SIREN = htmlspecialchars($_POST['SIREN']);
*/

// Client
$idClient = htmlspecialchars($_POST['idClient']);
//$addrClient = htmlspecialchars($_POST['addrClient']);
//$formeJuridique = htmlspecialchars($_POST['formeJuridiqueClient']);

// Date emission
$dateFacture = htmlspecialchars($_POST['dateFacture']);

// Produit
$produit = htmlspecialchars($_POST['produit']);
$quantity = htmlspecialchars($_POST['quantity']);
$prixUnit = htmlspecialchars($_POST['prixUnit']);
$totalUnit = htmlspecialchars($_POST['totalUnit']);
$totalPrix = htmlspecialchars($_POST['totalPrix']);
$TVA = htmlspecialchars($_POST['TVA']);

// Date / Reste
$dateMax = htmlspecialchars($_POST['dateMax']);
$dateStr = htmlspecialchars($_POST['dateStr']);
$dateLivraison = htmlspecialchars($_POST['dateLivraison']);
$RCP = htmlspecialchars($_POST['RCP']);

$numFacture = htmlspecialchars($_POST['numFacture']);

$userId = getId(htmlspecialchars($_SESSION['mail']));


addFacture($userId, $idClient, $notes, $dateStr, $dateMax, $totalPrix, $dateFacture, $dateLivraison, $numFacture, $typeFacture, $TVA, $RCP, $produit, $quantity, $prixUnit, $totalUnit);

header("Location: ../index.php?action=factures");

?>