<?php

$seuil = htmlspecialchars($_POST['seuil']);
$TVA = htmlspecialchars($_POST['TVA']);
$formationPro = htmlspecialchars($_POST['formationPro']);
$RSI = htmlspecialchars($_POST['RSI']);


$_SESSION['seuil'] = $seuil;
$_SESSION['TVA'] = $TVA;
$_SESSION['formationPro'] = $formationPro;
$_SESSION['RSI'] = $RSI;

modifyRate($seuil, $formationPro, $RSI, $TVA);
header("Location : ../index.php?action=admin");
?>
