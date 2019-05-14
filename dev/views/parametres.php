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

<?php require('template/top.php'); ?>
<?php require('template/navbar.php'); ?>

<!-- TOUT ICI -->

<div class="containerCenter">
<div class="containerParamUser">

<div class="titleFormParamUser">Paramètres utilisateur :</div>

<form action="controllers/backend.php" method="post" class="ui form formParamUser">
  <div class="fields">
    <div class="field">
      <label>Prénom</label>
      <input type="text" name="firstname" placeholder="PRENOM" value="<?php echo $_SESSION['firstname']; ?>" required>
    </div>
    <div class="field">
      <label>Nom</label>
      <input type="text" name="lastname" placeholder="NOM" value="<?php echo $_SESSION['lastname']; ?>" required>
    </div>
    <div class="field">
      <label>Nom d'entreprise</label>
      <input type="text" name="nameEnterprise" placeholder="NOM D'ENTREPRISE" value="<?php echo $_SESSION['nameEnterprise']; ?>" required>
    </div>
  </div>
  <div class="fields">
    <div class="field">
      <label>E-Mail</label>
      <input type="email" name="email" placeholder="E-MAIL" value="<?php echo $_SESSION['mail']; ?>" required>
    </div>
  </div>
  <div class="fields">
  <div class="field">
      <label>Ancien mot de passe</label>
      <input type="password" name="oldPassword" placeholder="MOT DE PASSE">
    </div>
    <div class="field">
      <label>Nouveau mot de passe</label>
      <input type="password" name="password" placeholder="MOT DE PASSE">
    </div>
    <div class="field">
      <label>Retapé le mot de passe</label>
      <input type="password" name="verifPassword" placeholder="MOT DE PASSE">
    </div>

    <input type="hidden" name="typeForm" value="editUser">

    <div class="field">
        <button class="ui right labeled icon yellow button submitEditParamUser" type="submit">Edit&nbsp;&nbsp;&nbsp;<i class="edit icon"></i></button>
    </div>
  </div>
</form>

<?php 

if (isset($_GET['msg']) && $_GET['msg'] == "Success") {
  echo 'Edit successfully';

/*
*
*
*
**
*
* Popup "Successfully edited informations"
*
*
**
*
*
*
*
*
*/

}

?>

</div>

</div>

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