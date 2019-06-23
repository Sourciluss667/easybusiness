<?php

$status = htmlspecialchars($_POST['status']);

if (isset($_POST['ACRE'])) {
    $acre = htmlspecialchars($_POST['ACRE']);
}
else {
    $acre = 0;
}

if (isset($_POST['ARCE'])) {
    $arce = htmlspecialchars($_POST['ARCE']);
}
else {
    $arce = 0;
}

if (isset($_POST['RCP'])) {
    $rcp = htmlspecialchars($_POST['RCP']);
}
else {
    $rcp = 0;
}

$declarationTime = htmlspecialchars($_POST['declarationTime']);

$typeNumFacture = htmlspecialchars($_POST['typeNumFacture']);

$id = getId($_SESSION['mail']);

editEnterprise($id, $status, $acre, $arce, $rcp, $declarationTime, $typeNumFacture);

header('Location: ../index.php?action=settings&msg=Success');

?>