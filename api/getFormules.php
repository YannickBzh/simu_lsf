<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

$formBdd = array();

if(isset($_GET["idForm"]) && !empty($_GET["idForm"])) {
    $extractinfoForm = new Formules();
    $extractinfoForm->setformuleId($_GET["idForm"]);
    $extractinfoForm->readObject();
    $listeInfos = new stdClass();
    $listeInfos->nom = $extractinfoForm->getnom();
    $listeInfos->description = $extractinfoForm->getdescription();
    $listeInfos->prix_achat = $extractinfoForm->getprix_achat();
    $listeInfos->prix_location_24 = $extractinfoForm->getprix_location_24();
    $listeInfos->prix_location_36 = $extractinfoForm->getprix_location_36();
    $listeInfos->prix_location_48 = $extractinfoForm->getprix_location_48();

    $formBdd[] = $listeInfos;
}
else {
    $extractForm = new Formules();
    $totalForm = $extractForm->readArray();

    foreach ($totalForm as $key) {

        $total= new stdClass();
        $total->id = $key->getformuleId();
        $total->nom = $key->getnom();
        $total->description = $key->getdescription();
        $total->prix_achat = $key->getprix_achat();
        $total->prix_location_24 = $key->getprix_location_24();
        $total->prix_location_36 = $key->getprix_location_36();
        $total->prix_location_48 = $key->getprix_location_48();
        $total->modal = "modal".$key->getformuleId();
        $total->component = "Modal".$key->getformuleId();

        $formBdd[] = $total;

    }
}

echo json_encode($formBdd);