<?php

deleteUser(getId(htmlspecialchars($_SESSION['mail'])));

$_SESSION['status'] = '';
$_SESSION['statut'] = '';
$_SESSION['mail'] = '';
$_SESSION['name'] = '';
$_SESSION['nameEnterprise'] = '';
$_SESSION['error'] = '';

header('Location: ../index.php');

?>