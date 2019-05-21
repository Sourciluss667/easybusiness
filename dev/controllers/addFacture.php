<?php

$notes = $_POST['notes'];
$date = $_POST['date'];
$prix = $_POST['prix'];
$idClient = $_POST['idClient'];

addFacture(getId($_SESSION['mail']), $idClient, $notes, $date, $prix);

header("Location : ../index.php?action=calendar");

?>