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
    $clientActuel = getClientFromIdSecure($facture[0]["client_id"], $facture[0]["account_id"]);
?>

<!-- Edit / Details -->
<div class="facture-div">

<form action="controllers/backend.php" method="post">

Type de facture : 
        <?php 
        if ($facture[0]["typeFacture"] == "Achat") {
            ?>
                <input type="text" name="typeFacture" value="Achat" readonly="readonly">
            <?php
        } else {
            ?>
                <input type="text" name="typeFacture" value="Vente" readonly="readonly">
            <?php
        }
        ?>
&nbsp;&nbsp;&nbsp;
Notes/Titre : <input type="text" name="notes" id="notes" value="<?php echo $facture[0]["notes"]; ?>" readonly="readonly">

<br><br>
<!-- Identification de l'autoentrepreneur -->
<div class="first-cadre">
    <h3>Identification de l'auto-entrepreneur</h3>
    <br>
    <input type="text" name="nameEnterprise" value="<?php echo $_SESSION['nameEnterprise']; ?>" placeholder="Nom d'entreprise" readonly="readonly">
    <br><br>
    <input type="text" name="name" value="<?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?>" placeholder="Nom" readonly="readonly">
    <br><br>
    <input type="text" name="adresse" placeholder="Adresse" readonly="readonly">
    <br><br>
    <input type="text" name="SIREN" placeholder="Numéro de SIREN" readonly="readonly">
</div>

<!-- Identification client -->
<div class="second-cadre">
    <h3>Client</h3>
    <br>
    <input type="text" name="client" value="<?php echo $clientActuel[0]["nom"]; ?>" readonly="readonly">
    <br><br>
    <input type="text" name="addrClient" value="<?php echo $clientActuel[0]["adresse"]; ?>" placeholder="Adresse" readonly="readonly">
    <br><br>
    <input type="text" name="formeJuridique" value="<?php echo $clientActuel[0]["formeJuridique"]; ?>" placeholder="Forme Juridique" readonly="readonly">
</div>
<br><br>
<div class="cadre-3">
Date emission de la facture : <input type="date" name="dateFacture" id="dateFacture" value="<?php echo $facture[0]["dateFacture"]; ?>" readonly="readonly">
</div>
<br><br><br>
<table class="cadre-4">
    <tr>
        <th>Désignation des produits ou prestations</th>
        <th>Quantité</th>
        <th>Prix unitaire HT</th>
        <th>Total HT</th>
    </tr>
    <tr>
        <td><input type="text" name="produit" id="produit" value="<?php echo $facture[0]["produit"]; ?>" style="width: 100%;" readonly="readonly"></td>
        <td><input type="number" name="quantity" id="quantity" style="width: 100%;" value="<?php echo $facture[0]["quantity"]; ?>" readonly="readonly"></td>
        <td><input type="number" step=".01" name="prixUnit" id="prixUnit" style="width: 100%;" value="<?php echo $facture[0]["prixUnit"]; ?>" readonly="readonly"></td>
        <td><input type="number" step=".01" name="totalUnit" id="totalUnit" value="<?php echo $facture[0]["totalUnit"]; ?>" style="width: 100%;" readonly="readonly"></td>
    </tr>
</table>

<br><br>
<div class="cadre-5">
Total HT : <input type="number" step=".01" name="totalPrix" value="<?php echo $facture[0]["totalPrix"]; ?>" readonly="readonly">
<br><br>
<?php
if ($facture[0]["TVA"] != 0) {
?>
TVA : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" step=".01" name="TVA" id="TVA" value="<?php
$rate = getRate(getId(htmlspecialchars($_SESSION['mail'])));
echo $rate[0]['TVA'];
?>" readonly="readonly">
<br>
<?php } else { ?>
TVA non applicable, art. 293B du CGI
<?php } ?>
</div>

<br><br>
<br><br>

Date de règlement max : <input type="text" name="dateMax" id="dateMax" value="<?php echo $facture[0]["dateMax"]; ?>" readonly="readonly">


<br><br>
Date de règlement : <input type="date" name="dateStr" id="dateStr" value="<?php echo $facture[0]["dateStr"]; ?>" readonly="readonly">
<br><br>
Date de livraison du service/produit : <input type="date" name="dateLivraison" id="dateLivraison" value="<?php echo $facture[0]["dateLivraison"]; ?>" readonly="readonly">
<br><br>

<?php

if (isset($facture[0]['RCP']) && $facture[0]['RCP'] == true) {
    echo 'Assurance RC Pro';
}
//Assurance décennale
//Assurance RC Pro
//Mention CGA
?>
<br><br>
<br><br>
Numéro de facture : <input type="text" name="numFacture" id="numFacture" value="<?php echo $facture[0]["numFacture"]; ?>">

<!--
<input type="hidden" name="idFacture" value="<?php echo $facture[0]["id"]; ?>">
<input type="hidden" name="typeForm" value="editFacture">

<input type="submit" value="Modifier la facture !">
-->

</form>

</div>

<!-- Fin details -->

<?php
}
}
else { // Liste factures et ajout
?>

<!-- Liste factures -->

<div v-if="!factureForm">

<div class="ui text titleFactures">Liste des factures</div><br>

<div class="ui text">Trié par : <a href="index.php?action=factures&tri=notes">Alphabetiquement</a> | <a href="index.php?action=factures&tri=totalPrix">Prix</a> | <a href="index.php?action=factures&tri=dateStr">Date de facturation</a> | <a href="index.php?action=factures&tri=numFacture">No Facture</a> | <a href="index.php?action=factures&tri=client_id">Clients</a> | <a href="index.php?action=factures&tri=typeFacture">Achat</a> | <a href="index.php?action=factures&tri=typeFacture DESC">Vente</a></div>

<div class="ui middle aligned divided selection list listClient">
    
    <?php

        $tri = "id";

        if (isset($_GET["tri"])) {
            if ($_GET["tri"] == "notes" || $_GET["tri"] == "totalPrix" || $_GET["tri"] == "dateStr" || $_GET["tri"] == "numFacture" || $_GET["tri"] == "client_id" || $_GET["tri"] == "typeFacture" || $_GET["tri"] == "typeFacture DESC") {
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
                <div class="header"><?php if ($factures[$i]["del"] == 1) { echo '<span style="color: red;">SUPR</span>&nbsp;&nbsp;'; } ?><?php echo $factures[$i]["notes"]; ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $factures[$i]["totalPrix"]; ?> EUR</div>
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

<?php 

if ($factures == Array()) {
    echo 'Vous n\'avez aucune factures !';
}

?>

</div>

<!-- Creer factures id 	prix 	dateStr 	notes 	dateFacture 	dateLivraison 	numFacture 	account_id 	client_id -->
<br>
<button class="ui button" v-on:click="factureForm = true" v-if="!factureForm">Ajouter une facture</button>

<a href="javascript:void(0);" v-if="factureForm" v-on:click="factureForm = false">Retour</a>

<div class="facture-div">

<form action="controllers/backend.php" method="post" v-if="factureForm">

Type de facture : 
<select name="typeFacture" id="typeFacture" v-if="!variableconcon">
    <option value="Achat">Achat</option>
    <option value="Vente">Vente</option>
</select>
<select name="typeFacture" id="typeFacture" v-if="variableconcon">
    <option value="Vente">Vente</option>
    <option value="Achat">Achat</option>
</select>
&nbsp;&nbsp;&nbsp;
Notes/Titre : <input type="text" name="notes" id="notes" required>

<br><br>
<!-- Identification de l'autoentrepreneur -->
<div class="first-cadre">
    <h3>Identification de l'auto-entrepreneur</h3>
    <br>
    <input type="text" name="nameEnterprise" value="<?php echo $_SESSION['nameEnterprise']; ?>" placeholder="Nom d'entreprise" readonly="readonly">
    <br><br>
    <input type="text" name="name" value="<?php echo $_SESSION['firstname'].' '.$_SESSION['lastname']; ?>" placeholder="Nom" readonly="readonly">
    <br><br>
    <input type="text" name="adresse" placeholder="Adresse" readonly="readonly">
    <br><br>
    <input type="text" name="SIREN" placeholder="Numéro de SIREN" readonly="readonly">
</div>

<!-- Identification client -->
<div class="second-cadre">
    <h3>Client</h3>
    <br>
    <select name="idClient" id="idClient" v-on:change="typeClient($event)" required> <!-- combobox a utiliser pour pouvoir faire une recherche dans le champs -->
        <?php
        $clients = getClients(getId(htmlspecialchars($_SESSION['mail'])));

        for ($i = 0; $i < count($clients, COUNT_NORMAL); $i++) {
            echo  '<option id="'.$i.'" value="'.$clients[$i]["id"].'" label="'.$clients[$i]["status"].'">'.$clients[$i]["nom"].'</option>';
        }
        ?>
    </select>
    <br><br>
    <input type="text" name="addrClient" placeholder="Adresse" readonly="readonly">
    <br><br>
    <input type="text" name="formeJuridique" placeholder="Forme Juridique" readonly="readonly">
</div>
<br><br>
<div class="cadre-3">
Date emission de la facture : <input type="date" name="dateFacture" id="dateFacture" value="" required>
</div>
<br><br><br>
<table class="cadre-4">
    <tr>
        <th>Désignation des produits ou prestations</th>
        <th>Quantité</th>
        <th>Prix unitaire HT</th>
        <th>Total HT</th>
    </tr>
    <tr>
        <td><input type="text" name="produit" id="produit" style="width: 100%;"required></td>
        <td><input type="number" name="quantity" id="quantity" style="width: 100%;" v-on:change="quantity($event)" required></td>
        <td><input type="number" step=".01" name="prixUnit" id="prixUnit" style="width: 100%;" v-on:change="prixUnit($event)" required></td>
        <td><input type="number" step=".01" name="totalUnit" id="totalUnit" v-bind:value="prixTot" style="width: 100%;" required></td>
    </tr>
</table>

<br><br>
<div class="cadre-5">
Total HT : <input type="number" step=".01" name="totalPrix" v-bind:value="prixTot" required>
<br><br>
TVA : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" step=".01" name="TVA" id="TVA" required value="<?php
$rate = getRate(getId(htmlspecialchars($_SESSION['mail'])));
echo $rate[0]['TVA'];
?>">
<br>
Si 0, TVA non applicable, art. 293B du CGI
</div>

<br><br>
<br><br>

Date de règlement max : <select name="dateMax" id="dateMax" required>
    <option value="Immédiat">Immédiat</option>
    <option value="Fin de mois">Fin de mois</option>
    <option value="30 Jours + Fin de mois">30 Jours + Fin de mois</option>
    <option value="60 Jours + Fin de mois">60 Jours + Fin de mois</option>
    <option value="90 Jours + Fin de mois">90 Jours + Fin de mois</option>
    <option value="Particulier">Particulier</option>
</select>

<br><br>
Date de règlement : <input type="date" name="dateStr" id="dateStr" <?php if(isset($_GET['date'])) { echo 'value="'.$_GET['date'].'"'; } ?> required>
<br><br>
Date de livraison du service/produit : <input type="date" name="dateLivraison" id="dateLivraison" required>
<br><br>

<?php
$enterpriseInfo = selectEnterpriseInfo(getId(htmlspecialchars($_SESSION['mail'])));

if ($enterpriseInfo['RCP']) {
    echo '<input type="checkbox" value="true" name="RCP" id="RCP" checked>&nbsp;&nbsp;Assurance RC Pro';
}
//Assurance décennale
//Assurance RC Pro
//Mention CGA
?>
<br><br>
<br><br>
Numéro de facture : <input type="text" required name="numFacture" id="numFacture" value="<?php 
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

<input type="hidden" name="typeForm" value="addFacture">
&nbsp;&nbsp;
<input type="submit" value="Ajouter la facture !">

</form>

</div>


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
    data: function () {
        return {
            factureForm: <?php if(isset($_GET['from']) && $_GET['from'] == 'calendar') { echo 'true'; } else { echo 'false'; } ?>,
            variableconcon: true,
            prixTot: 0,
            qty: 0,
            prix: 0
        }
    },
    methods: {
        typeClient (val) {
            let typedutype = val.target.options[val.target.selectedIndex].label
            if (typedutype === 'Acheteur') {
                this.variableconcon = true
            }
            else if (typedutype === 'Vendeur') {
                this.variableconcon = false
            }
            else {
                this.variableconcon = true
            }
        },
        quantity (val) {
            console.log(val)
            this.qty = val.target.value;
            this.prixTot = this.prix*this.qty;
        },
        prixUnit (val) {
            this.prix = val.target.value;
            this.prixTot = this.prix*this.qty;
        }
    }
})
</script>
</body>
</html>