<?php

$notes = htmlspecialchars($_POST['notes']);
$dateStr = htmlspecialchars($_POST['dateStr']);
$prix = htmlspecialchars($_POST['prix']);
$dateFacture = htmlspecialchars($_POST['dateFacture']);
$dateLivraison = htmlspecialchars($_POST['dateLivraison']);
$numFacture = htmlspecialchars($_POST['numFacture']);
$typeFacture = htmlspecialchars($_POST['typeFacture']);
$idClient = htmlspecialchars($_POST['idClient']);

addFacture(getId(htmlspecialchars($_SESSION['mail'])), $idClient, $notes, $dateStr, $prix, $dateFacture, $dateLivraison, $numFacture, $typeFacture);

header("Location: ../index.php?action=factures");

?>