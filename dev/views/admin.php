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
<?php 
require('models/backend.php');
$rateInfo = getRate(1);
print_r($rateInfo);

$list = getInfoUser();

?>
<!-- TOUT ICI -->
<form class="ui form" action="controllers/backend.php" method ="POST">
  <div class="fields">
    <div class="two wide field">
      <label>Seuil </label>
      <input type="text" name="seuil" placeholder=<?php echo $rateInfo[0]['seuil']; /*if (isset($_SESSION["seuil"])) { echo $_SESSION["seuil"]; }*/ ?>>
    </div>
    <div class="two wide field">
      <label>TVA</label>
      <input type="text" name="TVA" placeholder=<?php  echo $rateInfo[0]['TVA']; ?>>
    </div>
    <div class="two wide field">
      <label>Formation Professionelle</label>
      <input type="text" name="formationPro" placeholder=<?php  echo $rateInfo[0]['formationPro']; ?>>
    </div>
  </div>
  <div class="fields">
    <div class="two wide field">
      <label>RSI</label>
      <input type="text" name="RSI" placeholder=<?php echo $rateInfo[0]['RSI'];?>>
    </div>
  </div>
  </div>
</div>
    <input type="hidden" name="typeForm" value="modifyRate">
    <button class="ui  button" type="submit" >Modifier les taux !</button>
</form>

<br>
<br>
<br>
<br>
<form action = "controllers/backend.php" method = "POST">
<input type="hidden" name="typeForm" value="displayUser">
</form>
<h1> Liste des utilisateurs</h1>
<thead>
<tr><th>ID</th>&nbsp;&nbsp;<th>Nom</th>&nbsp;&nbsp;&nbsp;&nbsp;<th>Prenom</th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Mail</th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<th>Nom Entreprise</th>&nbsp;&nbsp;<th>Date d'inscription</th></tr>
</thead>

<br>

<?php
/*foreach ($list as $v1) {
  foreach ($v1 as $v2) {
      echo $v2."<br>";
  }
}*/

foreach ($list as $v1) {
echo "<br><br>".$v1["id"]." &nbsp;&nbsp;".$v1["lastname"]."&nbsp;&nbsp; ".$v1["firstname"]." &nbsp;&nbsp;".$v1["mail"]." &nbsp;&nbsp;".$v1["nameEnterprise"]."&nbsp;&nbsp; ".$v1["dateInscription"];

}
?>





<!-- FIN TOUT ICI -->

<?php require('template/bottom.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="public/js/vue.js"></script>
<script>
const app = new Vue({
    el: '#app',
    data: {
      
    }
})
</script>
</body>
</html>