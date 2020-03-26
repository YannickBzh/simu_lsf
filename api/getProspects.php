<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

if(isset($_GET["idProspect"]) && !empty($_GET["idProspect"])) {

    $infosProspect = array();

    $extractProspect = new Prospects();
    $extractProspect->setprospectId($_GET["idProspect"]);
    $extractProspect->readObject();

    $total= new stdClass();
    $total->configId = $extractProspect->getconfigId();
    $total->prenom = $extractProspect->getprenom();
    $total->nom = $extractProspect->getnom();
    $total->email = $extractProspect->getemail();
    $total->telephone = $extractProspect->gettelephone();
    $total->societe = $extractProspect->getsociete();
    $total->siret = $extractProspect->getsiret();
    $total->cp = $extractProspect->getcp();
    $total->adresse = $extractProspect->getadresse();
    $total->ville = $extractProspect->getville();

    $infosProspect[] = $total;
    echo json_encode($infosProspect);
}
else {
    /*$catBdd = array();
    $total = new stdClass();
    $total->value = null;
    $total->text = "Votre secteur d'activité";
    $total->selected = true;
    $catBdd[] = $total;

    $extractCat = new Secteurs_activites();
    $totalCat = $extractCat->readArray();

    foreach ($totalCat as $key) {

        $total= new stdClass();
        $total->value = $key->getactiviteId();
        $total->text = $key->getnom();
        $total->selected = false;
        $total->activites = $key->getfonct_sel();

        $catBdd[] = $total;
    }
    echo json_encode($catBdd);*/
}