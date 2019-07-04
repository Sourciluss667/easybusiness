<?php

$nom = htmlspecialchars($_POST["nomClient"]);
$status = htmlspecialchars($_POST["statutClient"]);
$adresse = htmlspecialchars($_POST["adresse"]);

$idUser = getId(htmlspecialchars($_SESSION["mail"]));

addClient($idUser, $nom, $status, $adresse);

header('Location: ../index.php?action=clients');

?>