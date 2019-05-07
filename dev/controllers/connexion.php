<?php
ini_set('display_errors', 1);
$email = $_POST['email'];
$password = $_POST['password'];
$isRegister = isRegister($email,$password)->fetch(PDO::FETCH_ASSOC);

if($isRegister){
    if ($isRegister['email'] == $email) {
        if ($isRegister['password'] == $password) {
            $_SESSION['status'] = 'connected';
            $_SESSION['statut'] = $isRegister['statut'];
            $_SESSION['email'] = $email;
            $_SESSION['error'] = "";
        }
    }else {
        $_SESSION['error'] = "Erreur : email ou mot de passe inconnu !";
    }
}else{
    $_SESSION['error'] = "Erreur : Email ou mot de passe inconnu !";
}
header('Location: index.php');




?>