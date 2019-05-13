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
<
<form class="ui form" action="controller/backend.php" method ="GET">
  <div class="fields">
    <div class="two wide field">
      <label>seuil </label>
      <input type="text" name="seuil" placeholder="First Name">
    </div>
    <div class="two wide field">
      <label>Middle</label>
      <input type="text" placeholder="Middle Name">
    </div>
    <div class="two wide field">
      <label>Last name</label>
      <input type="text" placeholder="Last Name">
    </div>
  </div>
  <div class="fields">
    <div class="two wide field">
      <input type="text" placeholder="2 Wide">
    </div>
    <div class="two wide field">
      <input type="text" placeholder="12 Wide">
    </div>
    <div class=" two field">
      <input type="text" placeholder="2 Wide">
    </div>
  </div>
  </div>
</div>
    <input type="hidden" name="typeForm" value="modifyRate">
    <button class="ui  button" type="submit" name="modifyRate">Modifier les taux !</button>
</form>
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