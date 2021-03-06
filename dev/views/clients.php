<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>EasyBusiness - Prestataires</title>
    <link rel="stylesheet" href="public/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
</head>
<body>

<?php require('template/top.php'); ?>
<?php require('template/navbar.php'); ?>

<!-- TOUT ICI -->
<div class="containerCenter" id="app">

<?php

if (isset($_GET["detailClient"])) {
    // Afficher detail du client avec l'id
    $client = getClientFromIdSecure(htmlspecialchars($_GET["detailClient"]), getId(htmlspecialchars($_SESSION['mail'])));
    // Info client et modif possible
    ?>

    <!-- Btn retour -->
    <a href="index.php?action=clients">Retour</a>

    <!-- Details clients form -->
    <form action="controllers/backend.php" method="post">
        <br>
        Nom : <input type="text" name="nom" id="adresse" value="<?php echo $client[0]["nom"]; ?>">
        <br><br>
        <?php
        if ($client[0]["status"] == "Acheteur") {
            ?>
                <select name="status" id="status" required>
                    <option value="Acheteur"><span style="color: green;">Client</span></option>
                    <option value="Vendeur">Fournisseur</option>
                </select>
            <?php
        }
        elseif ($client[0]["status"] == "Vendeur") {
            ?>
                <select name="status" id="status" required>
                    <option value="Vendeur"><span style="color: green;">Fournisseur</span></option>
                    <option value="Acheteur">Client</option>
                </select>
            <?php
        }

        if ($client[0]["adresse"] != "") {
            ?>
            <br><br>
            Adresse : <input type="text" name="adresse" id="adresse" value="<?php echo $client[0]["adresse"]; ?>">
            <?php
        }
        ?>
        <br><br>

        <input type="hidden" name="idclient" value="<?php echo $_GET["detailClient"]; ?>">

        <input type="hidden" name="typeForm" value="editClient">

        <input type="submit" value="Edit">
    </form>
    <br><br>
    <ul class="listFactureDetailClient">
        <li>ID | Notes | Prix | Date Reglement | Date Facture | Date Livraison | No Facture</li>
    <?php
    // Liste des factures
    $factures = getFacturesFromClientIdSecure(htmlspecialchars($_GET["detailClient"]), getId(htmlspecialchars($_SESSION['mail'])));

    for ($i = 0; $i < count($factures, COUNT_NORMAL); $i++) {
        ?>
        <li>
            <?php if ($factures[$i]["typeFacture"] == "Achat") { echo '<span style="color: red">'; } else { echo '<span style="color: green">'; } echo $factures[$i]["id"]; ?>&nbsp;|&nbsp;<?php echo $factures[$i]["notes"]; ?>&nbsp;|&nbsp;<?php echo $factures[$i]["totalPrix"]; ?>&nbsp;|&nbsp;<?php echo $factures[$i]["dateStr"]; ?>&nbsp;|&nbsp;<?php echo $factures[$i]["dateFacture"]; ?>&nbsp;|&nbsp;<?php echo $factures[$i]["dateLivraison"]; ?>&nbsp;|&nbsp;<?php echo $factures[$i]["numFacture"]; ?></span>
        </li>
        <?php
    }
    ?>
    </ul>

<?php
    } else {
?>

<div id="allWithoutForm" v-if="!clientForm">
<!-- Liste -->
<div class="ui text titleClients">Liste des prestataires</div>

<div class="ui middle aligned divided selection list listClient">
    
    <?php
        $clients = getClients(htmlspecialchars(getId($_SESSION['mail'])));

        for ($i = 0; $i < count($clients, COUNT_NORMAL); $i++) {
            // 1 Client
        ?>
        <div class="item" id="clients-<?php echo $clients[$i]["id"];?>" onclick="detailClient('<?php echo $clients[$i]['id']; ?>')">
            <img class="ui avatar image" src="public/img/client_avatar.png">
            <div class="content">
                <div class="header"><?php echo $clients[$i]["nom"];?></div>
                <?php 
                if ($clients[$i]["status"] == "Acheteur") {
                    echo 'Client';
                }
                else {
                    echo 'Fournisseur';
                }
                ?>
            </div>
            <div class="right floated content">
                <i class="trash alternate icon deleteIconClient" onclick="deleteClient('<?php echo $clients[$i]['id']; ?>')"></i>
            </div>
        </div>
    <?php } ?>
</div>

<?php 

if ($clients == Array()) {
    echo 'Vous n\'avez aucun clients !';
}

?>

<!-- -->

</div>

<!-- Ajouter un client -->
<br>
<button class="ui button" v-on:click="clientForm = true" v-if="!clientForm">Ajouter un prestataire</button>

<a href="javascript:void(0);" v-if="clientForm" v-on:click="clientForm = false">Retour</a>

<form action="controllers/backend.php" method="post" v-if="clientForm">

Nom client : <input type="text" name="nomClient" id="nomClient" required>
<br><br>
Statut : <select name="statutClient" id="statutClient">
    <option value="Acheteur">Client</option>
    <option value="Vendeur">Fournisseur</option>
</select>
<br><br>
Adresse : <input type="text" name="adresse" id="adresse" required>
<br><br>

<input type="hidden" name="typeForm" value="addClient">

<input type="submit" value="Ajouter le client !">

</form>

<?php } // fin else ?>

</div>

<!-- FIN TOUT ICI -->

<?php require('template/bottom.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="public/js/vue.js"></script>
<script>

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

const deleteClient = id => {
    // FAIRE UNE REQUETE POST SUR LE BACKEND POUR SUPR LE COMPTE
    if (confirm("Cela entrainera la suppression de toutes les factures liées, êtes-vous sûr ?")) {
        post('controllers/backend.php', {typeForm: 'deleteClient', idClient: id});
    }
}

const detailClient = id => {
    // Faire requete sur la meme page avec un argument get en +
    document.location.href = `index.php?action=clients&detailClient=${id}`;
}

const app = new Vue({
    el: '#app',
    data: {
        clientForm: false
    }
})
</script>
</body>
</html>