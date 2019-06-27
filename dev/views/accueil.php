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
<br>
<h1>Comment fonctionne le site ?</h1>

<!-- Video -->

<iframe width="560" height="315" src="https://www.youtube.com/embed/5oPAjdEbvhg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<ol style="font-size: 21px; width: 60%;">
    <li>Paramétré le compte</li>
    <li>Ajouter des intermédiaires (clients)</li>
    <li>Ajouter les factures</li>
    <li>Garder un suivi avec le calendrier</li>
    <li>Avoir un bilan complet</li>
</ol>

</div>

<!-- FIN TOUT ICI -->

<?php require('template/bottom.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="public/js/vue.js"></script>
<script>
const app = new Vue({
    el: '#app',
    data: {}
})
</script>
</body>
</html>