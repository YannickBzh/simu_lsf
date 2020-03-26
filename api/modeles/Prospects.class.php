<?php
if (!defined('PROSPECTS')) {
    define('PROSPECTS', 'prospects');
}
class Prospects{
	private $prospectId;
    private $configId;
    private $prenom;
    private $nom;
    private $email;
    private $telephone;
    private $societe;
    private $secteur_activite;
    private $nb_services;
    private $siret;
    private $cp;
    private $adresse;
    private $ville;
    private $config_validee;

	public function setprospectId($pArg = "0") { $this->prospectId = $pArg;}
    public function setconfigId($pArg = "0") { $this->configId = $pArg;}
    public function setprenom($pArg = "0") { $this->prenom = $pArg;}
    public function setnom($pArg = "0") { $this->nom = $pArg;}
    public function setemail($pArg = "0") { $this->email = $pArg;}
    public function settelephone($pArg = "0") { $this->telephone = $pArg;}
    public function setsociete($pArg = "0") { $this->societe = $pArg;}
    public function setsecteur_activite($pArg = "0") { $this->secteur_activite = $pArg;}
    public function setnb_services($pArg = "0") { $this->nb_services = $pArg;}
    public function setsiret($pArg = "0") { $this->siret = $pArg;}
    public function setcp($pArg = "0") { $this->cp = $pArg;}
    public function setadresse($pArg = "0") { $this->adresse = $pArg;}
    public function setville($pArg = "0") { $this->ville = $pArg;}
    public function setconfig_validee($pArg = "0") { $this->config_validee = $pArg;}

	public function getprospectId() { return $this->prospectId; }
    public function getconfigId() { return $this->configId; }
    public function getprenom() { return $this->prenom; }
    public function getnom() { return $this->nom; }
    public function getemail() { return $this->email; }
    public function gettelephone() { return $this->telephone; }
    public function getsociete() { return $this->societe; }
    public function getsecteur_activite() { return $this->secteur_activite; }
    public function getnb_services() { return $this->nb_services; }
    public function getsiret() { return $this->siret; }
    public function getcp() { return $this->cp; }
    public function getadresse() { return $this->adresse; }
    public function getville() { return $this->ville; }
    public function getconfig_validee() { return $this->config_validee; }

	public function readObject($array = array()) {
		$qry = "SELECT * FROM " . PROSPECTS;
		$and = " WHERE ";

		$i = 0;

		foreach($this as $key => $value) {
			${"temp".$i} = "get".$key;
			if ($this->${"temp".$i}() != "") {
				$qry .= $and.$key." = '".$this->${"temp".$i}()."' ";
				$and = "AND ";
			}
			$i++;
		}
		$record = Database::select($qry);
		if (count($record[0]) == 0) {
			return array();
		} else {
			$record = $record[0];
			$this->setprospectId($record['prospectId']);
            $this->setconfigId($record['configId']);
            $this->setprenom($record['prenom']);
            $this->setnom($record['nom']);
            $this->setemail($record['email']);
            $this->settelephone($record['telephone']);
            $this->setsociete($record['societe']);
            $this->setsecteur_activite($record['secteur_activite']);
            $this->setnb_services($record['nb_services']);
            $this->setsiret($record['siret']);
            $this->setcp($record['cp']);
            $this->setadresse($record['adresse']);
            $this->setville($record['ville']);
            $this->setconfig_validee($record['config_validee']);

			return true;
		}
	}
	public static function readArray($array = array())
	{
		$qry = "SELECT *  FROM " . PROSPECTS;
		$and = " WHERE ";

		foreach($array as $key => $value) {
			if ($array[$key] != "") {
				$qry .= $and.$key." = '".$array[$key]."'" ;
				$and = "AND ";
			}
		}

		$qry .= " ORDER BY prospectId ASC";
		$recordset     = Database::select($qry);
		$class_objects = array();
		if (is_array($recordset) == true) {
			while (list($i, $record) = each($recordset)) {
				$class_object = new Prospects();

				$class_object->setprospectId($record['prospectId']);
                $class_object->setconfigId($record['configId']);
                $class_object->setprenom($record['prenom']);
                $class_object->setnom($record['nom']);
                $class_object->setemail($record['email']);
                $class_object->settelephone($record['telephone']);
                $class_object->setsociete($record['societe']);
                $class_object->setsecteur_activite($record['secteur_activite']);
                $class_object->setnb_services($record['nb_services']);
                $class_object->setsiret($record['siret']);
                $class_object->setcp($record['cp']);
                $class_object->setadresse($record['adresse']);
                $class_object->setville($record['ville']);
                $class_object->setconfig_validee($record['config_validee']);

				$class_objects[$class_object->getprospectId()] = $class_object;
			}
		}
		return $class_objects;
	}
	public function insert()
	{
		if ($this->getprospectId() != '') {
			$qry = "UPDATE " . PROSPECTS . " SET
            prospectId = '" . $this->getprospectId() .
            "', configId = '" . addslashes($this->getconfigId()) .
            "', prenom = '" . addslashes($this->getprenom()) .
            "', nom = '" . addslashes($this->getnom()) .
            "', email = '" . addslashes($this->getemail()) .
            "', telephone = '" . addslashes($this->gettelephone()) .
            "', societe = '" . addslashes($this->getsociete()) .
            "', secteur_activite = '" . addslashes($this->getsecteur_activite()) .
            "', nb_services = '" . addslashes($this->getnb_services()) .
            "', siret = '" . addslashes($this->getsiret()) .
            "', cp = '" . addslashes($this->getcp()) .
            "', adresse = '" . addslashes($this->getadresse()) .
            "', ville = '" . addslashes($this->getville()) .
            "', config_validee = '" . addslashes($this->getconfig_validee()) .
            "' WHERE prospectId = " . $this->getprospectId() ;
            //echo $qry;
			Database::insert($qry);
		} else {
			$qry = "INSERT INTO " . PROSPECTS . " ( prospectId, configId, prenom, nom, email, telephone, societe, secteur_activite, nb_services, siret, cp, adresse, ville, config_validee) VALUES (" .
            "'" . $this->getprospectId() .
            "','" . addslashes($this->getconfigId()) .
            "','" . addslashes($this->getprenom()) .
            "','" . addslashes($this->getnom()) .
            "','" . addslashes($this->getemail()) .
            "','" . addslashes($this->gettelephone()) .
            "','" . addslashes($this->getsociete()) .
            "','" . addslashes($this->getsecteur_activite()) .
            "','" . addslashes($this->getnb_services()) .
            "','" . addslashes($this->getsiret()) .
            "','" . addslashes($this->getcp()) .
            "','" . addslashes($this->getadresse()) .
            "','" . addslashes($this->getville()) .
            "','" . addslashes($this->getconfig_validee()) .
            "')" ;
			//echo $qry;
			$this->setprospectId(Database::insert($qry));
		}
	}
	public function delete($array = array())
	{
		$qry = "DELETE FROM " . PROSPECTS;
		$and = " WHERE ";

		$i = 0;

		foreach($this as $key => $value) {
			${"temp".$i} = "get".$key;
			if ($this->${"temp".$i}() != "") {
				$qry .= $and.$key." = '".$this->${"temp".$i}()."' ";
				$and = "AND ";
			}
			$i++;
		}
		Database::delete($qry);
	}
}