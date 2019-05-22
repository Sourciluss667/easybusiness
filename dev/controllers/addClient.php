<?php

$nom = $_POST["nomClient"];
$status = $_POST["statutClient"];

$idUser = getId(htmlspecialchars($_SESSION["mail"]));

addClient($idUser, $nom, $status);

header('Location: ../index.php?action=clients');

?>