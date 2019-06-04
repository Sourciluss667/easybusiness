<?php

deleteFacture(htmlspecialchars($_POST['idFacture']));

header('Location: ../index.php?action=factures');
?>