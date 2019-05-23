<?php

$seuil = htmlspecialchars($_POST['seuil']);
$TVA = htmlspecialchars($_POST['tva']);
$formationPro = htmlspecialchars($_POST['formationPro']);
$RSI = htmlspecialchars($_POST['rsi']);
$idUser = getId(htmlspecialchars($_SESSION['mail']));

editRate($idUser, $seuil, $formationPro, $RSI, $TVA);
header("Location: ../index.php?action=settings");
?>
