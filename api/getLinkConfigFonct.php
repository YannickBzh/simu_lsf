<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

if(isset($_GET["idConfig"]) && !empty($_GET["idConfig"])) {

    $idsFonct = array();

    $extractLCF = new Link_config_fonctionnalites();
    $arrayFonctionnalites = array('configId'=>$_GET["idConfig"]);
    $sommeFonctionnalites = $extractLCF->readArray($arrayFonctionnalites);
    
    foreach($sommeFonctionnalites as $fonctionnalite) {
        $total = new stdClass();
        $total->fonctId = $fonctionnalite->getfonctId();
        $idsFonct[] = $total;
    }

    echo json_encode($idsFonct);
}
else {
    return;
}