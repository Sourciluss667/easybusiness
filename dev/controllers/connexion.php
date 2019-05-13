<?php

$isRegister = isRegister(htmlspecialchars($_POST['email']),htmlspecialchars($_POST['password']))->fetch(PDO::FETCH_ASSOC);

if ($isRegister['mail'] == $_POST['email']) {
    $_SESSION['status'] = 'connected';
    $_SESSION['statut'] = $isRegister['statut'];
    $_SESSION['mail'] = $isRegister['mail'];
    $_SESSION['firstname'] = $isRegister['firstname'];
    $_SESSION['lastname'] = $isRegister['lastname'];
    $_SESSION['nameEnterprise'] = $isRegister['nameEnterprise'];

    $_SESSION['error'] = "";

    header('Location: ../index.php');
} else {
    $_SESSION['error'] = "Erreur : email ou mot de passe inconnu !";
    header('Location: ../index.php');
}

?>