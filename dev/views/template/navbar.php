<div class="ui left fixed vertical menu">
  <div class="item">
    <a href="index.php"><img class="ui image" src="public/img/logo-pi.png"></a>
  </div>
  <a class="item" href="index.php">Dashboard</a>

  <!-- Calendrier -->
  <a class="item" href="index.php?action=calendar">Calendrier</a>

  <!-- -->
  <a class="item" href="index.php?action=factures">Factures</a>
  <a class="item">Bilan</a>

  <!-- Clients -->
  <a class="item" href="index.php?action=clients">Clients</a>

  <!-- Paramètres -->
  <a class="item" href="index.php?action=settings">Paramètres</a>
  
  <!-- Deconnexion -->
  <form name="deconnexionForm" action="controllers/backend.php" method="post">
    <input type="hidden" name="typeForm" value="deconnexion">
    <a class="item" href="javascript:document.deconnexionForm.submit()">Déconnexion</a>
  </form>

<!-- Balance -->
<div class="balance item">
  <?php 
    if ($_SESSION["balance"] < 0) {
      echo '<span style="color: red">';
    }
    else {
      echo '<span style="color: green">';
    }
    echo $_SESSION["balance"]; 

    echo ' EUR</span>';
  ?>
</div>

</div>