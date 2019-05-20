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

<div class="containerCenter" id="app">

<div class="ui text titleForm">Paramètres utilisateur :</div>

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

    </div>

    <input type="hidden" name="typeForm" value="editUser">

    <div class="fields">
      <div class="field">
        <button class="ui right labeled icon yellow button" type="submit">Edit&nbsp;&nbsp;&nbsp;<i class="edit icon"></i></button>
      </div>
    </div>
</form>

<!-- Autre params (entreprise info) -->

<?php
require('models/backend.php');

$enterpriseInfo = selectEnterpriseInfo(getId($_SESSION['mail'])); // A SECURISER

?>

<div class="ui text titleForm">Paramètres entreprise :</div>

<form action="controllers/backend.php" method="post" class="ui form formParamUser">
  <div class="fields">
    <div class="field">
      
      <select class="ui dropdown" name="status">
        <option value="<?php echo $enterpriseInfo['status']; ?>"><?php echo $enterpriseInfo['status']; ?></option>
        <option value="Achat/revente de marchandises">Achat/revente de marchandises</option>
        <option value="Vente de denrées à consommer sur place">Vente de denrées à consommer sur place</option>
        <option value="Prestations d'hébergement (BIC)">Prestations d'hébergement (BIC)</option>
        <option value="Prestation de service commerciale ou artisanale (BIC / BNC)">Prestation de service commerciale ou artisanale (BIC / BNC)</option>
        <option value="Profession libérale">Profession libérale</option>
        <option value="Activité de location de tourisme">Activité de location de tourisme</option>
      </select>

    </div>
  </div>

  <div class="fields">
    <div class="field">
      <div class="ui checkbox">
        <input type="checkbox" name="ACRE" <?php if ($enterpriseInfo['ACRE']) { ?>checked="checked" <?php } ?> value="1">
        <label><a href="https://www.auto-entrepreneur.fr/aide/aide-financiere/accre.html" target="_blank" rel="noopener noreferrer" title="Aide à la Création d'une Auto-entreprise">ACRE</a></label>
      </div>
    </div>

    <div class="field">
      <div class="ui checkbox">
        <input type="checkbox" name="ARCE" <?php if ($enterpriseInfo['ARCE']) { ?>checked="checked" <?php } ?> value="1">
        <label><a href="https://www.auto-entrepreneur.fr/aide/aide-financiere/arce.html" target="_blank" rel="noopener noreferrer" title="Aide à la Reprise ou à la Création d'Entreprise ">ARCE</a></label>
      </div>
    </div>

    <div class="field">
      <div class="ui checkbox">
        <input type="checkbox" name="RCP" <?php if ($enterpriseInfo['RCP']) { ?>checked="checked" <?php } ?> value="1">
        <label><a href="https://www.auto-entrepreneur.fr/assurance/assurance-responsabilite-civile-professionnelle/index.html" target="_blank" rel="noopener noreferrer" title="Responsabilité Civile Professionnelle">RCP</a></label>
      </div>
    </div>

  </div>

  <div class="inline fields">
    <label>A quelle fréquence voulez-vous déclarer ?</label>

    <?php
      if ($enterpriseInfo['declarationTime'] == "Mensuelle") {
    ?>

    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="declarationTime" checked="checked" value="Mensuelle">
        <label>Mensuelle</label>
      </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="declarationTime" value="Trimestrielle">
        <label>Trimestrielle</label>
      </div>
    </div>
    
    <?php
      }
      else {
    ?>

    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="declarationTime" value="Mensuelle">
        <label>Mensuelle</label>
      </div>
    </div>
    <div class="field">
      <div class="ui radio checkbox">
        <input type="radio" name="declarationTime" checked="checked" value="Trimestrielle">
        <label>Trimestrielle</label>
      </div>
    </div>
    
    <?php } ?>

  </div>

    <input type="hidden" name="typeForm" value="editEnterprise">

    <div class="fields">
      <div class="field">
        <button class="ui right labeled icon yellow button" type="submit">Edit&nbsp;&nbsp;&nbsp;<i class="edit icon"></i></button>
      </div>
    </div>
  </div>
</form>


<!-- Param Rates -->











<?php if (isset($_GET['msg']) && $_GET['msg'] == "Success") { ?>

<!-- Fermeture du pop up non faites ! -->

<div class="ui success message popupsuccess" v-if="showPopup = true">
  <i class="close icon" v-on:click="showPopup = false"></i>
  <div class="header">
    Edit successfully !
  </div>
  <p>You can edit settings everytime <?php echo $_SESSION["firstname"].' '.$_SESSION["lastname"]; ?> !</p>
</div>

<?php } ?>


<!-- Supression compte -->

<form action="controllers/backend.php" method="post">
  <input type="hidden" name="typeForm" value="deleteAccount">
  <div class="suprAccount"><button class="ui right labeled icon red button" type="submit">Supprimer le compte<i class="delete icon"></i></button></div>
</form>


</div>

<!-- FIN TOUT ICI -->

<?php require('template/bottom.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="public/js/vue.js"></script>
<script>
const app = new Vue({
    el: '#app',
    data: {
      showPopup: true
    }
})
</script>
</body>
</html>