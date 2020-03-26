<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->formuleId)) { //Evite les entrées vides (raffraichissement de page par ex)
    exit();
}

if(isset($_GET['configId']) && !empty($_GET['prix_total']) && !empty($_GET['configId'])) {
    $modConfiguration = new Configuration();
    $modConfiguration->setconfigId($_GET['configId']);
    $modConfiguration->readObject();
    $modConfiguration->setprix_total($_GET['prix_total']);
    $modConfiguration->insert();
    if($modConfiguration->getconfigId() == $_GET['configId']) {
        echo json_encode(true);
    }
    else {
        echo json_encode(false);
    }
}
else {
    $addConfiguration = new Configuration();

    $addConfiguration->setformuleId($data->formuleId);
    $addConfiguration->setdate_creation(date("Y-m-d H:i:s"));
    $addConfiguration->settypeChoix($data->type);
    if($data->type == 1) {
        $addConfiguration->setnb_mensualites($data->nb_mensualites); // seulement si location
    }
    $data->hebergement == true ? $addConfiguration->sethebergement(1) : $addConfiguration->sethebergement(0);
    $data->maintenance == true ? $addConfiguration->setmaintenance(1) : $addConfiguration->setmaintenance(0);
    $addConfiguration->setprix_total($data->prixTotal);

    $addConfiguration->insert();
    $idCree = $addConfiguration->getconfigId();

    if($addConfiguration->getconfigId() != "") {
        echo json_encode($idCree);
    }
    else {
        echo json_encode(false);
    }
}

