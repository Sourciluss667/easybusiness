<?php
session_start();
ini_set('display_errors', 1);

try{

  if (isset($_SESSION['status'])) {
    if($_SESSION['status'] == 'connected') {
      require('models/backend.php');
      $_SESSION['balance'] = getBalance(getId(htmlspecialchars($_SESSION['mail'])));

      if (isset($_GET['action'])) {
        switch ($_GET['action']) {
          case 'register':
            require('views/register.php');
          break;
          case 'settings':
            require('views/parametres.php');
          break;
          case 'admin':
            require('views/admin.php');
          break;
          case 'calendar':
            require('views/calendrier.php');
          break;
          case 'factures':
            require('views/factures.php');
          break;
          case 'clients':
            require('views/clients.php');
          break;
          default:
            require('views/register.php');
          break;
        }
      }
      else {

        require('views/accueil.php');
      }
    }
    else {
      require('views/register.php');
    }
  }
  else {
    require('views/register.php');
  }

} catch (Exception $e) {
  $message = $e->getMessage();
}
?>