<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>EasyBusiness</title>
<link rel="stylesheet" href="../public/css/register.css">
</head>
<body>

<div id="app"> <!-- For VUEJS -->

    <img src="../public/img/logo-pi.png" alt="Logo EASYBUSINESS" id="logo">

    <!-- Formulaire Inscription -->
    <transition name="move">
    <div class="center" id="form-inscription" v-if="switchForm">
        <form action="../controllers/backend.php" method="post" class="center">

            <input type="text" name="lastname" id="lastname" placeholder="Nom"><br><br>

            <input type="text" name="firstname" id="firstname" placeholder="Prénom"><br><br>

            <input type="text" name="nameEnterprise" id="nameEnterprise" placeholder="Nom de l'entreprise"><br><br>

            <input type="email" name="email" id="email" placeholder="E-Mail" required><br><br>

            
            <input type="password" name="password" id="password" placeholder="Password"><br><br>
            <input type="password" name="verifPassword" id="verifPassword" placeholder="Retype Password"><br><br><br>

            <input type="hidden" name="typeForm" value="inscription">
            <input type="submit" value="Je m'inscris">

            <a href="#" v-on:click="switchForm = !switchForm">Switch</a>
        </form>
    </div>
    </transition>
    <!-- Formulaire Connexion -->
    <transition name="move">
    <div class="center" id="form-connexion" v-if="!switchForm">
        <form action="../controllers/backend.php" method="post" class="center">
            <input type="email" name="email" id="email" placeholder="E-Mail"><br><br>
            <input type="password" name="password" id="password" placeholder="Password"><br><br><br>

            <input type="hidden" name="typeForm" value="connexion">
            <input type="submit" value="Connexion">
            
            <a href="#" v-on:click="switchForm = !switchForm">Switch</a>
        </form>
    </div>
    </transition>
</div>

<script src="../public/js/vue.js"></script>
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