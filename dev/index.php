<?php
session_start();
ini_set('display_errors', 1);

try{
  if(isset($_GET['action'])){
    switch($_GET['action']){
      case 'register' :
      require('views/register.php');
      break;
    }
  } else {
    if(isset($_SESSION['status'])) {
      if($_SESSION['status'] == "connected") {
        require('views/accueil.php');
      }
    }
    else {
      require('views/register.php');
    }
  }
}catch(Exception $e){
  $message = $e->getMessage();
}
?>