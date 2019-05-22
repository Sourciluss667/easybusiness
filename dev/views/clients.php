<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EasyBusiness - Clients</title>
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
</head>
<body>

<?php require('template/top.php'); ?>
<?php require('template/navbar.php'); ?>

<!-- TOUT ICI -->

<div class="containerCenter" id="app">

<div id="allWithoutForm" v-if="!clientForm">
<!-- Liste -->
<div class="ui text titleClients">Liste des clients</div>

    <div class="ui middle aligned selection list">
  <div class="item">
    <img class="ui avatar image" src="/images/avatar/small/helen.jpg">
    <div class="content">
      <div class="header">Helen</div>
    </div>
  </div>
  <div class="item">
    <img class="ui avatar image" src="/images/avatar/small/christian.jpg">
    <div class="content">
      <div class="header">Christian</div>
    </div>
  </div>
  <div class="item">
    <img class="ui avatar image" src="/images/avatar/small/daniel.jpg">
    <div class="content">
      <div class="header">Daniel</div>
    </div>
  </div>
</div>

<!-- -->

</div>

<!-- Ajouter un client -->

<button class="ui button" v-on:click="clientForm = true">Ajouter un client</button>

<a href="javascript:void(0);" v-if="clientForm" v-on:click="clientForm = false">Retour</a>

<form action="controllers/backend.php" method="post" v-if="clientForm">

<input type="text" name="nomClient" id="nomClient">

<input type="text" name="statutClient" id="statutClient">

<input type="hidden" name="typeForm" value="addClient">

<input type="submit" value="Ajouter le client !">

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
        clientForm: false
    }
})
</script>
</body>
</html>