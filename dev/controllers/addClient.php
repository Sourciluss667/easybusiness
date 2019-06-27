<?php

$nom = htmlspecialchars($_POST["nomClient"]);
$status = htmlspecialchars($_POST["statutClient"]);
$adresse = htmlspecialchars($_POST["adresse"]);
$formeJuridique = htmlspecialchars($_POST["formeJuridique"]);

$idUser = getId(htmlspecialchars($_SESSION["mail"]));

addClient($idUser, $nom, $status, $adresse, $formeJuridique);

header('Location: ../index.php?action=clients');

?>