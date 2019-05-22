<?php

deleteClient(htmlspecialchars($_POST['idClient']));

header('Location: ../index.php?action=clients');
?>