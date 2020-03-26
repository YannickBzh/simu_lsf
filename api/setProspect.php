<?php
/* Pour tests en local  */
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Origin: http://localhost:8080");
//header("Access-Control-Allow-Origin: https://simulateur.2020.le-site-francais.fr");
header('content-type: application/json; charset=utf-8');

include('modeles/index.php');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->prenom) && empty($data->prospectId)) { //Evite les entrées vides (raffraichissement de page par ex)
    exit();
}

$addProspect = new Prospects();
if(!empty($data->prospectId)) {
    $addProspect->setprospectId($data->prospectId);
    $addProspect->readObject();
    $addProspect->setconfigId($data->configId);
    $addProspect->setconfig_validee(1);
}
else {
    $addProspect->setprenom($data->prenom);
    $addProspect->setnom($data->nom);
    $addProspect->setemail($data->email);
    $addProspect->settelephone($data->telephone);
    $addProspect->setsociete($data->societe);
    $addProspect->setsecteur_activite(intval($data->secteur_activite));
    if(!empty($data->siret)) {
        $addProspect->setsiret($data->siret);
    }
    if(!empty($data->cp)) {
        $addProspect->setcp($data->cp);
    }
    if(!empty($data->adresse)) {
        $addProspect->setadresse($data->adresse);
    }
    if(!empty($data->ville)) {
        $addProspect->setville($data->ville);
    }
    if(!empty($data->config_validee)) {
        $addProspect->setconfig_validee(0);
    }
}

$addProspect->insert();
$idCree = $addProspect->getprospectId();

if($addProspect->getprospectId() != "") {
    echo json_encode($idCree);
}
else {
    echo json_encode(false);
}

