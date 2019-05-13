<div class="ui left fixed vertical menu">
  <div class="item">
    <img class="ui image" src="public/img/logo-pi.png">
  </div>
  <a class="item">Dashboard</a>
  <a class="item">Calendrier</a>
  <a class="item">Factures</a>
  <a class="item">Bilan</a>

  <!-- Paramètres -->
  <a class="item" href="index.php">Paramètres</a>
  
  <!-- Deconnexion -->
  <form name="deconnexionForm" action="controllers/backend.php" method="post">
    <input type="hidden" name="typeForm" value="deconnexion">
    <a class="item" href="javascript:document.deconnexionForm.submit()">Déconnexion</a>
  </form>
</div>