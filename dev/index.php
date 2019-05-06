<?php
ini_set('display_errors', 1);

try{
  if(isset($_GET['action'])){
    switch($_GET['action']){
      case 'register' :
      require('views/register.php');
      break;
    }
  } else {
    require('views/accueil.php');
  }
}catch(Exception $e){
  $message = $e->getMessage();
} 
?>