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

<!-- Liste factures -->

<div class="ui text titleFactures">Liste des factures</div>

<div class="ui middle aligned divided selection list listClient">
    
    <?php
        require('models/backend.php');
        $factures = getFacturesFromId(getId(htmlspecialchars($_SESSION['mail'])));

        for ($i = 0; $i < count($factures, COUNT_NORMAL); $i++) {
            // 1 Client
        ?>
        <div class="item" id="clients-<?php echo $factures[$i]["id"];?>">
            <img class="ui avatar image" src="public/img/facture_avatar.png">
            <div class="content">
                <div class="header"><?php echo $factures[$i]["notes"];?></div>
                <?php echo $factures[$i]["notes"]; ?>
            </div>
            <div class="right floated content">
                <i class="trash alternate icon deleteIconClient" onclick="deleteFacture('<?php echo $factures[$i]['id']; ?>')"></i>
            </div>
        </div>
    <?php } ?>
</div>

<!-- Creer factures -->

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