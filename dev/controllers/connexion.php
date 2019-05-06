<?php

function connection($array) {
    $email = $_GET['email'];
    $password = $_GET['password'];
    $infos = selectInfoUser($pseudo);
    if (isset($infos)){
        if ($infos['password'] == $password){
            $_SESSION['status'] = 'connected';
            $_SESSION['email'] = $email;
            $_SESSION['error'] = '';
        }
    }else {
        $_SESSION['error'] = "Erreur : Compte inconnu.";
    }
}

?>