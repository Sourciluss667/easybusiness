<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EasyBusiness</title>
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
</head>
<body>

<!-- TOUT ICI -->
<form class="ui form" action="controllers/backend.php" method ="POST">
  <div class="fields">
    <div class="two wide field">
      <label>Seuil </label>
      <input type="text" name="seuil" placeholder=<?php echo $_SESSION["seuil"];?>>
    </div>
    <div class="two wide field">
      <label>TVA</label>
      <input type="text" name="TVA" placeholder=<?php echo $_SESSION["TVA"];?>>
    </div>
    <div class="two wide field">
      <label>Formation Professionelle</label>
      <input type="text" name="formationPro" placeholder=<?php echo $_SESSION["formationPro"];?>>
    </div>
  </div>
  <div class="fields">
    <div class="two wide field">
      <label>RSI</label>
      <input type="text" name="RSI" placeholder=<?php echo $_SESSION["RSI"];?>>
    </div>
  </div>
  </div>
</div>
    <input type="hidden" name="typeForm" value="modifyRate">
    <button class="ui  button" type="submit" >Modifier les taux !</button>
</form>

<p>
<P>
<p>
<p>
<form action = "controllers/backend.php" method = "POST">
<input type="hidden" name="typeForm" value="displayUser">
</form>
<h1> Liste des utilisateurs</h1>
<table>
<tr><th>ID</th><th>Nom</th><th>Prenom</th><th>Mail</th>Nom Entreprise</th><th>Date d'inscription</th></tr>

</table class =>




<!-- FIN TOUT ICI -->

<?php require('template/bottom.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="public/js/vue.js"></script>
<script>
const app = new Vue({
    el: '#app',
    data: {
        switchForm: true
    }
})
</script>
</body>
</html>