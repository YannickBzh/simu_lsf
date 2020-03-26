<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

$formBdd = array();

if(isset($_GET["code"]) && !empty($_GET["code"])) {
    $extractinfoCode = new Code_promo();
    $extractinfoCode->setcode($_GET["code"]);
    $extractinfoCode->readObject();
    $listeInfos = new stdClass();
    $listeInfos->date_debut = $extractinfoCode->getdate_debut();
    $listeInfos->date_fin = $extractinfoCode->getdate_fin();
    $listeInfos->montant = $extractinfoCode->getmontant();
    $listeInfos->pourcentage = $extractinfoCode->getpourcentage();

    $formBdd[] = $listeInfos;
}
else {
    $extractCodesPromo = new Code_promo();
    $totalCodesPromo= $extractCodesPromo->readArray();

    foreach ($totalCodesPromo as $key) {

        $total= new stdClass();
        $total->id = $key->getformuleId();
        $total->code = $key->getnom();
        $total->date_debut = $key->getdescription();
        $total->date_fin = $key->getprix_achat();
        $total->montant = $key->getprix_location_24();
        $total->pourcentage = $key->getprix_location_36();

        $formBdd[] = $total;

    }
}

echo json_encode($formBdd);