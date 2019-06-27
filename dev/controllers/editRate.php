<?php

$seuil = htmlspecialchars($_POST['seuil']);
$seuilTVA = htmlspecialchars($_POST['seuilTVA']);
$TVA = htmlspecialchars($_POST['tva']);
$formationPro = htmlspecialchars($_POST['formationPro']);
$RSI = htmlspecialchars($_POST['rsi']);
$idUser = getId(htmlspecialchars($_SESSION['mail']));

if ($seuil >= 0 && $TVA >= 0 && $formationPro >= 0 && $RSI >= 0) {
    editRate($idUser, $seuil, $seuilTVA, $formationPro, $RSI, $TVA);
    header("Location: ../index.php?action=settings&msg=Success");
}
else {
    echo 'ERREUR : Un taux ne peut pas etre negatif';
    echo '<br><br><a href="../index.php?action=settings">Retour</a>';
}

?>
