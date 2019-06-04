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

<div v-if="!factureForm">

<div class="ui text titleFactures">Liste des factures</div>

<div class="ui middle aligned divided selection list listClient">
    
    <?php
        require('models/backend.php');
        $factures = getFacturesFromId(getId(htmlspecialchars($_SESSION['mail'])));

        for ($i = 0; $i < count($factures, COUNT_NORMAL); $i++) {
            // 1 Client
            $client = getClientFromId($factures[$i]["client_id"]); 
        ?>
        <div class="item" id="clients-<?php echo $factures[$i]["id"];?>">
            <?php if ($factures[$i]["typeFacture"] == "Vente") {
                ?> <img class="ui avatar image" src="public/img/facture_vente_avatar.png"> <!-- SELON SI VENTE OU ACHAT --> <?php
            }
            elseif ($factures[$i]["typeFacture"] == "Achat") {
                ?> <img class="ui avatar image" src="public/img/facture_achat_avatar.png"> <!-- SELON SI VENTE OU ACHAT --> <?php
            }
            ?>
            
            <div class="content">
                <div class="header"><?php echo $factures[$i]["notes"];?></div>
                <span class="nomclientlist"><?php echo $client[0]["nom"]; ?></span>
                <span class="numerofacturelist right floated content">No.<?php echo $factures[$i]["numFacture"]; ?></span>
            </div>
            <div class="right floated content">
                <i class="trash alternate icon deleteIconClient" onclick="deleteFacture('<?php echo $factures[$i]['id']; ?>')"></i>
            </div>
        </div>
    <?php } ?>
</div>


</div>

<!-- Creer factures id 	prix 	dateStr 	notes 	dateFacture 	dateLivraison 	numFacture 	account_id 	client_id -->

<button class="ui button" v-on:click="factureForm = true" v-if="!factureForm">Ajouter une facture</button>

<a href="javascript:void(0);" v-if="factureForm" v-on:click="factureForm = false">Retour</a>

<form action="controllers/backend.php" method="post" v-if="factureForm">

Nom client : <select name="idClient" id="idClient" required> <!-- combobox a utiliser pour pouvoir faire une recherche dans le champs -->
        <?php
        $clients = getClients(getId(htmlspecialchars($_SESSION['mail'])));

        for ($i = 0; $i < count($clients, COUNT_NORMAL); $i++) {
            echo  '<option value="'.$clients[$i]["id"].'">'.$clients[$i]["nom"].'</option>';
        }
        ?>
        </select>
<br><br>
Prix (en EUR): <input type="number" name="prix">
<br><br>
Notes : <input type="text" name="notes" id="notes">
<br><br>
Date règlement : <input type="date" name="dateStr" id="dateStr">
<br><br>
Date emission de la facture : <input type="date" name="dateFacture" id="dateFacture">
<br><br>
Date de livraison du service/produit : <input type="date" name="dateLivraison" id="dateLivraison">
<br><br>
Type de facture : 
<select name="typeFacture" id="typeFacture" required>
    <option value="Achat">Achat</option>
    <option value="Vente">Vente</option>
</select>
<br><br>
Numéro de facture : <input type="text" name="numFacture" id="numFacture">
<br><br>
<input type="hidden" name="typeForm" value="addFacture">

<input type="submit" value="Ajouter la facture !">

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
        factureForm: false
    }
})
</script>
</body>
</html>