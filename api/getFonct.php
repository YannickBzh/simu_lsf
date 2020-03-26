<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

$fonctBdd = array();

$extractFonct = new Fonctionnalites();

if(isset($_GET["idFonct"]) && !empty($_GET["idFonct"])) {
    $extractFonct->setfonctId($_GET["idFonct"]);
    $extractFonct->readObject();
    $total= new stdClass();
    $total->nom = $extractFonct->getnom();
    $total->description_courte = $extractFonct->getdescription_courte();
    $total->prix_achat = $extractFonct->getprix_achat();
    $total->prix_location_24 = $extractFonct->getprix_location_24();
    $total->prix_location_36 = $extractFonct->getprix_location_36();
    $total->prix_location_48 = $extractFonct->getprix_location_48();
    $fonctBdd[] = $total;
}
else {
    $totalFoct = $extractFonct->readArray();

    foreach ($totalFoct as $key) {

        $total= new stdClass();
        $total->id = $key->getfonctId();
        $total->nom = $key->getnom();
        $total->categorie = intval($key->getcategorie());
        $total->description_courte = $key->getdescription_courte();
        $total->description_longue = $key->getdescription_longue();
        $total->icone = $key->geturl_icone();
        $total->prix_achat = $key->getprix_achat();
        $total->prix_location_24 = $key->getprix_location_24();
        $total->prix_location_36 = $key->getprix_location_36();
        $total->prix_location_48 = $key->getprix_location_48();
        $total->selection = false;

        $fonctBdd[] = $total;

    }
}

echo json_encode($fonctBdd);