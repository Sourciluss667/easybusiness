<?php

$nom = htmlspecialchars($_POST["nom"]);
$status = htmlspecialchars($_POST["status"]);


$adresse = "nooo";
if (isset($_POST["adresse"]) && $_POST["adresse"] != "") {
    $adresse = htmlspecialchars($_POST["adresse"]);
}

$idUser = getId(htmlspecialchars($_SESSION["mail"]));

$idClient = htmlspecialchars($_POST["idclient"]);

editClientSecure($nom, $status, $adresse, $idClient, $idUser);

header('Location: ../index.php?action=clients');

?>