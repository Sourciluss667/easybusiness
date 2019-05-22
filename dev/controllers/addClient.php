<?php

$nom = $_POST["nomClient"];
$status = $_POST["statutClient"];

$idUser = getId(htmlspecialchars($_SESSION["mail"]));

print_r($idUser);

?>