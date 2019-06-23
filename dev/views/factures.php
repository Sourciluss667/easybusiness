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

<?php 
if (isset($_GET["detail"]) && $_GET["detail"] != "") {
// Detail facture

?>
<a href="index.php?action=factures">Retour</a>
<?php
// Get facture by id
$facture = getFactureById(htmlspecialchars($_GET["detail"]), getId(htmlspecialchars($_SESSION["mail"])));
if (!$facture) {
    echo "<br>Erreur d'id";
}
else {

?>



<form action="controllers/backend.php" method="post">

Nom client : <select name="idClient" id="idClient" required> <!-- combobox a utiliser pour pouvoir faire une recherche dans le champs -->
        <?php
        $clients = getClients(getId(htmlspecialchars($_SESSION['mail'])));
        $clientActuel = getClientFromIdSecure($facture[0]["client_id"], $facture[0]["account_id"]);

        echo  '<option value="'.$clientActuel[0]["id"].'">'.$clientActuel[0]["nom"].'</option>';

        for ($i = 0; $i < count($clients, COUNT_NORMAL); $i++) {
            if ($clients[$i]["id"] != $clientActuel[0]["id"]) {
                echo  '<option value="'.$clients[$i]["id"].'">'.$clients[$i]["nom"].'</option>';
            }
        }
        ?>
        </select>
<br><br>
Prix (en EUR): <input type="number" name="prix" value="<?php echo $facture[0]["prix"]; ?>">
<br><br>
Notes/Titre : <input type="text" name="notes" id="notes" value="<?php echo $facture[0]["notes"]; ?>">
<br><br>
Date règlement : <input type="date" name="dateStr" id="dateStr" value="<?php echo $facture[0]["dateStr"]; ?>">
<br><br>
Date emission de la facture : <input type="date" name="dateFacture" id="dateFacture" value="<?php echo $facture[0]["dateFacture"]; ?>">
<br><br>
Date de livraison du service/produit : <input type="date" name="dateLivraison" id="dateLivraison" value="<?php echo $facture[0]["dateLivraison"]; ?>">
<br><br>
Type de facture : 
<select name="typeFacture" id="typeFacture" required>
        <?php 
        if ($facture[0]["typeFacture"] == "Achat") {
            ?>
                <option value="Achat">Achat</option>
                <option value="Vente">Vente</option>
            <?php
        } else {
            ?>
                <option value="Vente">Vente</option>
                <option value="Achat">Achat</option>
            <?php
        }
        ?>
</select>
<br><br>
Numéro de facture : <input type="text" name="numFacture" id="numFacture" value="<?php echo $facture[0]["numFacture"]; ?>">
<br><br>
<input type="hidden" name="idFacture" value="<?php echo $facture[0]["id"]; ?>">
<input type="hidden" name="typeForm" value="editFacture">

<input type="submit" value="Modifier la facture !">

</form>




<?php
}
}
else { // Liste factures et ajout
?>

<!-- Liste factures -->

<div v-if="!factureForm">

<div class="ui text titleFactures">Liste des factures</div><br>

<div class="ui text">Trié par : <a href="index.php?action=factures&tri=notes">Alphabetiquement</a> | <a href="index.php?action=factures&tri=prix">Prix</a> | <a href="index.php?action=factures&tri=dateStr">Date de facturation</a> | <a href="index.php?action=factures&tri=numFacture">No Facture</a> | <a href="index.php?action=factures&tri=client_id">Clients</a> | <a href="index.php?action=factures&tri=typeFacture">Achat</a> | <a href="index.php?action=factures&tri=typeFacture DESC">Vente</a></div>

<div class="ui middle aligned divided selection list listClient">
    
    <?php

        $tri = "id";

        if (isset($_GET["tri"])) {
            if ($_GET["tri"] == "notes" || $_GET["tri"] == "prix" || $_GET["tri"] == "dateStr" || $_GET["tri"] == "numFacture" || $_GET["tri"] == "client_id" || $_GET["tri"] == "typeFacture" || $_GET["tri"] == "typeFacture DESC") {
                $tri = htmlspecialchars($_GET["tri"]);
            }
        }

        $factures = getFacturesFromId(getId(htmlspecialchars($_SESSION['mail'])), $tri);

        for ($i = 0; $i < count($factures, COUNT_NORMAL); $i++) {
            // 1 Client
            $client = getClientFromId($factures[$i]["client_id"]); 
        ?>
        <div class="item" id="clients-<?php echo $factures[$i]["id"]; ?>" onclick="detailFacture(<?php echo $factures[$i]['id']; ?>)">
            <?php if ($factures[$i]["typeFacture"] == "Vente") {
                ?> <img class="ui avatar image" src="public/img/facture_achat_avatar.png"> <!-- SELON SI VENTE OU ACHAT --> <?php
            }
            elseif ($factures[$i]["typeFacture"] == "Achat") {
                ?> <img class="ui avatar image" src="public/img/facture_vente_avatar.png"> <!-- SELON SI VENTE OU ACHAT --> <?php
            }
            ?>
            
            <div class="content">
                <div class="header"><?php if ($factures[$i]["del"] == 1) { echo '<span style="color: red;">SUPR</span>&nbsp;&nbsp;'; } ?><?php echo $factures[$i]["notes"]; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $factures[$i]["prix"]; ?> EUR</div>
                <span class="nomclientlist"><?php echo $client[0]["nom"]; ?></span>
                <span class="numerofacturelist right floated content">No.<?php echo $factures[$i]["numFacture"]; ?></span>
            </div>
            <?php if ($factures[$i]["del"] != 1) { ?>
            <div class="right floated content">
                <i class="trash alternate icon deleteIconClient" onclick="deleteFacture('<?php echo $factures[$i]['id']; ?>')"></i>
            </div>
            <?php } ?>
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
Notes/Titre : <input type="text" name="notes" id="notes">
<br><br>
Date max du règlement : <select name="dateMax" id="dateMax">
    <option value="Immédiat">Immédiat</option>
    <option value="Fin de mois">Fin de mois</option>
    <option value="30 Jours + Fin de mois">30 Jours + Fin de mois</option>
    <option value="60 Jours + Fin de mois">60 Jours + Fin de mois</option>
    <option value="90 Jours + Fin de mois">90 Jours + Fin de mois</option>
    <option value="Particulier">Particulier</option>
</select>
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
TVA : <input type="number" name="TVA" id="TVA" value="<?php
$rate = getRate(getId(htmlspecialchars($_SESSION['mail'])));
echo $rate[0]['TVA'];
?>">
<br><br>
Numéro de facture : <input type="text" name="numFacture" id="numFacture" value="<?php 
if (!$factures) {
    $temp = getTypeNumFacture(getId(htmlspecialchars($_SESSION['mail'])));
    echo ++$temp[0]["typeNumFacture"];
}
else {
    $index = count($factures, COUNT_NORMAL);
    $str = $factures[--$index]["numFacture"];
    echo ++$str;
}

?>" placeholder="<?php $temp = getTypeNumFacture(getId(htmlspecialchars($_SESSION['mail']))); echo $temp[0]["typeNumFacture"]; ?>">
<br><br>
<input type="hidden" name="typeForm" value="addFacture">

<input type="submit" value="Ajouter la facture !">

</form>




<?php } ?>

</div>

<!-- FIN TOUT ICI -->

<?php require('template/bottom.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="public/js/vue.js"></script>
<script>

let deleteFact = 0;

function post(path, params, method='post') {

// The rest of this code assumes you are not using a library.
// It can be made less wordy if you use one.
const form = document.createElement('form');
form.method = method;
form.action = path;

for (const key in params) {
  if (params.hasOwnProperty(key)) {
    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = key;
    hiddenField.value = params[key];

    form.appendChild(hiddenField);
  }
}

document.body.appendChild(form);
form.submit();
}

const deleteFacture = id => {
    if (confirm("Cela entrainera la suppression de la facture, êtes-vous sûr ?")) {
        deleteFact = 1;
        post('controllers/backend.php', {typeForm: 'deleteFacture', idFacture: id});
    }
}

const detailFacture = id => {
    if (deleteFact != 1) {
        window.location = `index.php?action=factures&detail=${id}`;
    } else {
        deleteFact = 0;
    }
}



const app = new Vue({
    el: '#app',
    data: {
        factureForm: false
    }
})
</script>
</body>
</html>