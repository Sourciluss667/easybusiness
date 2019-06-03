<?php

$notes = $_POST['notes'];
$dateStr = $_POST['dateStr'];
$prix = $_POST['prix'];
$dateFacture = $_POST['dateFacture'];
$dateLivraison = $_POST['dateLivraison'];
$numFacture = $_POST['numFacture'];
$idClient = $_POST['idClient'];

addFacture(getId(htmlspecialchars($_SESSION['mail'])), $idClient, $notes, $dateStr, $prix, $dateFacture, $dateLivraison, $numFacture);

header("Location: ../index.php?action=factures");

?>