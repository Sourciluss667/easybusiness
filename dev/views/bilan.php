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
<h1>Under construction /!\</h1>
<!--
<?php
$depense = getAllOut(htmlspecialchars($_SESSION['mail']));
getAllOut(htmlspecialchars($_SESSION['mail']));
$ventes = getAllIn(htmlspecialchars($_SESSION['mail']));

?>

<h2>Dépenses totales HT :&nbsp;
<?php if ($depense > 0) 
{ 
    echo '<span style="color: red">'; 
} else {
    echo '<span style="color: green">'; 
}
echo $depense.'</span>'; ?></h2>
<h2>Ventes totales HT   : 
<?php if ($ventes < 0) 
{ 
    echo '<span style="color: red">'; 
} else {
    echo '<span style="color: green">'; 
} 
echo $ventes.'</span>'; ?></h2>
-->

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