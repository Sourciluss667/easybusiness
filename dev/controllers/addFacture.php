<?php

$notes = htmlspecialchars($_POST['notes']);
$dateStr = htmlspecialchars($_POST['dateStr']);
$dateMax = htmlspecialchars($_POST['dateMax']);
$prix = htmlspecialchars($_POST['prix']);
$dateFacture = htmlspecialchars($_POST['dateFacture']);
$dateLivraison = htmlspecialchars($_POST['dateLivraison']);
$numFacture = htmlspecialchars($_POST['numFacture']);
$typeFacture = htmlspecialchars($_POST['typeFacture']);
$TVA = htmlspecialchars($_POST['TVA']);
$idClient = htmlspecialchars($_POST['idClient']);

addFacture(getId(htmlspecialchars($_SESSION['mail'])), $idClient, $notes, $dateStr, $dateMax, $prix, $dateFacture, $dateLivraison, $numFacture, $typeFacture, $TVA);

header("Location: ../index.php?action=factures");

?>