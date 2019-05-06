<?php
ini_set('display_errors', 1);
require('controllers/backend.php');
try{
  if(isset($_GET['action'])){
    switch($_GET['action']){
      case 'home' :
        home();
      break;
      case 'B' :
        echo 'B';
      break;
      case 'C' :
        echo 'C';
      break;
    }
  }else{
    home();
  }
}catch(Exception $e){
  $message = $e->getMessage();
} 
?>