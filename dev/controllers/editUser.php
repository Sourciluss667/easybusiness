<?php

// firstname, lastname, nameEnterprise, password, verifPassword

$lastname = htmlspecialchars($_POST['lastname']);
$firstname = htmlspecialchars($_POST['firstname']);
$nameEnterprise = htmlspecialchars($_POST['nameEnterprise']);
$password = htmlspecialchars($_POST['password']);
$verifPassword = htmlspecialchars($_POST['verifPassword']);
$id = getId($_SESSION['mail']);

if ($password == $verifPassword && $password != '') {
    $isRegister = isRegister($_SESSION['mail'],htmlspecialchars($_POST['oldPassword']))->fetch(PDO::FETCH_ASSOC);
    if ($isRegister['mail'] == $_SESSION['mail']) {
        editUserWPass($id, $firstname, $lastname, $nameEnterprise, $password);
    }
}
else {
    editUser($id, $firstname, $lastname, $nameEnterprise);
}

$_SESSION['firstname'] = $firstname;
$_SESSION['lastname'] = $lastname;
$_SESSION['nameEnterprise'] = $nameEnterprise;

header('Location: ../index.php?action=settings&msg=Success');

?>