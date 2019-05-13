<?php
session_start();
require('../models/backend.php');
ini_set('display_errors', 1);

try{
    if (isset($_POST['typeForm'])) {
        switch($_POST['typeForm']) {
            case 'inscription' :
            require('inscription.php');
            break;
            case 'connexion' :
            require('connexion.php');
            break;
            case 'deconnexion';
            require('deconnexion.php');
            break;
            case 'administration'
            require('administration.php');
            break;
        }
    } else {
        header('Location: ../index.php?action=home');
    }

} catch(Exception $e) {
    $message = $e->getMessage();
} 
?>
