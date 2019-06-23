<?php

$notes = htmlspecialchars($_POST['notes']);
$dateStr = htmlspecialchars($_POST['dateStr']);
$prix = htmlspecialchars($_POST['prix']);
$dateFacture = htmlspecialchars($_POST['dateFacture']);
$dateLivraison = htmlspecialchars($_POST['dateLivraison']);
$numFacture = htmlspecialchars($_POST['numFacture']);
$typeFacture = htmlspecialchars($_POST['typeFacture']);
$idClient = htmlspecialchars($_POST['idClient']);
$idFacture = htmlspecialchars($_POST['idFacture']);

$idUser = getId(htmlspecialchars($_SESSION['mail']));


//editFacture($idUser, $idClient, $idFacture, $notes, $dateStr, $prix, $dateFacture, $dateLivraison, $numFacture, $typeFacture);

header("Location: ../index.php?action=factures");
?>