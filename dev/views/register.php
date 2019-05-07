<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>EasyBusiness</title>
<link rel="stylesheet" href="public/css/register.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
</head>
<body>

<div id="app"> <!-- For VUEJS -->

<div id="background"></div>

<img src="public/img/logo-pi.png" alt="Logo" class="logo">


<!-- Connexion -->
<div class="ui placeholder segment" id="connexion" v-if="switchForm">
  <div class="ui two column very relaxed stackable grid">
    <div class="column">
      <form class="ui form" action="controllers/backend.php" method="post">
        <div class="field">
          <label>E-Mail</label>
          <div class="ui left icon input">
            <input type="email" name="email" placeholder="E-Mail" required>
            <i class="at icon"></i>
          </div>
        </div>
        <div class="field">
          <label>Mot de passe</label>
          <div class="ui left icon input">
            <input type="password" name="password" placeholder="Mot de passe" required>
            <i class="lock icon"></i>
          </div>
        </div>
        <div class="ui blue submit button">Login</div>
        </form>
    </div>
    <div class="middle aligned column">
      <div class="ui big button" v-on:click="switchForm = !switchForm">
        <i class="signup icon"></i>
        Inscription !
      </div>
    </div>
  </div>
  <div class="ui vertical divider">
    Ou
  </div>
</div>

<!-- Inscription -->
<div class="ui placeholder segment" id="inscription" v-if="!switchForm">
  <div class="ui two column very relaxed stackable grid">
    <div class="column">
      <form class="ui form" action="controllers/backend.php" method="post">

      <div class="field">
          <label>Nom</label>
          <div class="ui left icon input">
            <input type="text" name="lastname" placeholder="Nom" required>
            <i class="user icon"></i>
          </div>
        </div>

        <div class="field">
          <label>Prénom</label>
          <div class="ui left icon input">
            <input type="text" name="firstname" placeholder="Prénom" required>
            <i class="user icon"></i>
          </div>
        </div>

        <div class="field">
          <label>Nom d'entreprise</label>
          <div class="ui left icon input">
            <input type="text" name="nameEnterprise" placeholder="Nom d'entreprise" required>
            <i class="user icon"></i>
          </div>
        </div>

        <div class="field">
          <label>E-Mail</label>
          <div class="ui left icon input">
            <input type="email" name="email" placeholder="E-Mail" required>
            <i class="at icon"></i>
          </div>
        </div>

        <div class="field">
          <label>Mot de passe</label>
          <div class="ui left icon input">
            <input type="password" name="password" placeholder="Mot de passe" required>
            <i class="lock icon"></i>
          </div>
        </div>

        <div class="field">
          <label>Encore</label>
          <div class="ui left icon input">
            <input type="password" name="verifPassword" placeholder="Mot de passe" required>
            <i class="lock icon"></i>
          </div>
        </div>

        <div class="ui blue submit button">Login</div>
        </form>
    </div>
    <div class="middle aligned column">
      <div class="ui big button" v-on:click="switchForm = !switchForm">
        <i class="sign-in icon"></i>
        Connexion !
      </div>
    </div>
  </div>
  <div class="ui vertical divider">
    Ou
  </div>
</div>





</div>

<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
<script src="public/js/vue.js"></script>
<script>

//$('#connexion').transition('fly down');
//$('#inscription').transition('fly down');


const app = new Vue({
    el: '#app',
    data: {
        switchForm: true
    }
})
</script>
</body>
</html>