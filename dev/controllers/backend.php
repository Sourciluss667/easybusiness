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
            case 'modifyRate':
                require('modifyRate.php');
            break;
            case 'displayUser';
                require('displayUser.php');
            break;
            case 'editUser':
                require('editUser.php');
            break;
            case 'editEnterprise':
                require('editEnterprise.php');
            break;
            case 'editRate':
                require('editRate.php');
            break;
            case 'editFacture':
                require('editFacture.php');
            break;
            case 'addFacture':
                require('addFacture.php');
            break;
            case 'addFactureFromCalendar':
                require('addFactureFromCalendar.php');
            break;
            case 'addClient':
                require('addClient.php');
            break;
            case 'deleteAccount':
                require('delAccount.php');
            break;
            case 'deleteClient':
                require('delClient.php');
            break;
            case 'deleteFacture':
                require('delFacture.php');
            break;

            case 'editClient':
                require('editClient.php');
            break;
        }
    } else {
        header('Location: ../index.php?action=home');
    }

} catch(Exception $e) {
    $message = $e->getMessage();
} 
?>
