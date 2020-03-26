<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

if(isset($_GET["idConfig"]) && !empty($_GET["idConfig"])) {

    $infosConfiguration = array();

    $extractConfiguration = new Configuration();
    $extractConfiguration->setconfigId($_GET["idConfig"]);
    $extractConfiguration->readObject();

    $total= new stdClass();
    $total->configId = $extractConfiguration->getconfigId();
    $total->formuleId = $extractConfiguration->getformuleId();
    $total->date_creation = $extractConfiguration->getdate_creation();
    $total->type = $extractConfiguration->gettypeChoix();
    $total->nb_mensualites = $extractConfiguration->getnb_mensualites();
    $total->hebergement = $extractConfiguration->gethebergement();
    $total->maintenance = $extractConfiguration->getmaintenance();
    $total->prix_total = $extractConfiguration->getprix_total();

    $infosConfiguration[] = $total;
    echo json_encode($infosConfiguration);
}
else {
    return;
}