<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->configId)) { //Evite les entrées vides (raffraichissement de page par ex)
    exit();
}

$addLcf = new Link_config_fonctionnalites();

$addLcf->setconfigId($data->configId);
$addLcf->setfonctId($data->fonctId);

$addLcf->insert();
$idCree = $addLcf->getconfigId();

if($addLcf->getlcfId() != "") {
    echo json_encode($idCree);
}
else {
    echo json_encode(false);
}

