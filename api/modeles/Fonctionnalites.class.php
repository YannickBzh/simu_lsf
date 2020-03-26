<?php
if (!defined('FONCTIONNALITES')) {
    define('FONCTIONNALITES', 'fonctionnalites');
}
class Fonctionnalites{
	private $fonctId;
    private $nom;
    private $categorie;
    private $description_longue;
    private $description_courte;
    private $url_icone;
    private $prix_achat;
    private $prix_location_24;
    private $prix_location_36;
    private $prix_location_48;

	public function setfonctId($pArg = "0") { $this->fonctId = $pArg;}
    public function setnom($pArg = "0") { $this->nom = $pArg;}
    public function setcategorie($pArg = "0") { $this->categorie = $pArg;}
    public function setdescription_longue($pArg = "0") { $this->description_longue = $pArg;}
    public function setdescription_courte($pArg = "0") { $this->description_courte = $pArg;}
    public function seturl_icone($pArg = "0") { $this->url_icone = $pArg;}
    public function setprix_achat($pArg = "0") { $this->prix_achat = $pArg;}
    public function setprix_location_24($pArg = "0") { $this->prix_location_24 = $pArg;}
    public function setprix_location_36($pArg = "0") { $this->prix_location_36 = $pArg;}
    public function setprix_location_48($pArg = "0") { $this->prix_location_48 = $pArg;}

	public function getfonctId() { return $this->fonctId; }
    public function getnom() { return $this->nom; }
    public function getcategorie() { return $this->categorie; }
    public function getdescription_longue() { return $this->description_longue; }
    public function getdescription_courte() { return $this->description_courte; }
    public function geturl_icone() { return $this->url_icone; }
    public function getprix_achat() { return $this->prix_achat; }
    public function getprix_location_24() { return $this->prix_location_24; }
    public function getprix_location_36() { return $this->prix_location_36; }
    public function getprix_location_48() { return $this->prix_location_48; }

	public function readObject($array = array()) {
		$qry = "SELECT * FROM " . FONCTIONNALITES;
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
			$this->setfonctId($record['fonctId']);
            $this->setnom($record['nom']);
            $this->setcategorie($record['categorie']);
            $this->setdescription_longue($record['description_longue']);
            $this->setdescription_courte($record['description_courte']);
            $this->seturl_icone($record['url_icone']);
            $this->setprix_achat($record['prix_achat']);
            $this->setprix_location_24($record['prix_location_24']);
            $this->setprix_location_36($record['prix_location_36']);
            $this->setprix_location_48($record['prix_location_48']);

			return true;
		}
	}
	public static function readArray($array = array())
	{
		$qry = "SELECT *  FROM " . FONCTIONNALITES;
		$and = " WHERE ";

		foreach($array as $key => $value) {
			if ($array[$key] != "") {
				$qry .= $and.$key." = '".$array[$key]."'" ;
				$and = "AND ";
			}
		}

		$qry .= " ORDER BY fonctId ASC";
		$recordset     = Database::select($qry);
		$class_objects = array();
		if (is_array($recordset) == true) {
			while (list($i, $record) = each($recordset)) {
				$class_object = new Fonctionnalites();

				$class_object->setfonctId($record['fonctId']);
                $class_object->setnom($record['nom']);
                $class_object->setcategorie($record['categorie']);
                $class_object->setdescription_longue($record['description_longue']);
                $class_object->setdescription_courte($record['description_courte']);
                $class_object->seturl_icone($record['url_icone']);
                $class_object->setprix_achat($record['prix_achat']);
                $class_object->setprix_location_24($record['prix_location_24']);
                $class_object->setprix_location_36($record['prix_location_36']);
                $class_object->setprix_location_48($record['prix_location_48']);

				$class_objects[$class_object->getfonctId()] = $class_object;
			}
		}
		return $class_objects;
	}
	public function insert()
	{
		if ($this->getfonctId() != '') {
			$qry = "UPDATE " . FONCTIONNALITES . " SET
            fonctId = '" . $this->getfonctId() .
            "', nom = '" . addslashes($this->getnom()) .
            "', categorie = '" . addslashes($this->getcategorie()) .
            "', description_longue = '" . addslashes($this->getdescription_longue()) .
            "', description_courte = '" . addslashes($this->getdescription_courte()) .
            "', url_icone = '" . addslashes($this->geturl_icone()) .
            "', prix_achat = '" . addslashes($this->getprix_achat()) .
            "', prix_location_24 = '" . addslashes($this->getprix_location_24()) .
            "', prix_location_36 = '" . addslashes($this->getprix_location_36()) .
            "', prix_location_48 = '" . addslashes($this->getprix_location_48()) .
            "' WHERE fonctId = " . $this->getfonctId() ;
            //echo $qry;
			Database::insert($qry);
		} else {
			$qry = "INSERT INTO " . FONCTIONNALITES . " ( fonctId, nom, categorie, description_longue, description_courte, url_icone, prix_achat, prix_location_24, prix_location_36, prix_location_48) VALUES (" .
            "'" . $this->getfonctId() .
            "','" . addslashes($this->getnom()) .
            "','" . addslashes($this->getcategorie()) .
            "','" . addslashes($this->getdescription_longue()) .
            "','" . addslashes($this->getdescription_courte()) .
            "','" . addslashes($this->geturl_icone()) .
            "','" . addslashes($this->getprix_achat()) .
            "','" . addslashes($this->getprix_location_24()) .
            "','" . addslashes($this->getprix_location_36()) .
            "','" . addslashes($this->getprix_location_48()) .
            "')" ;
			//echo $qry;
			$this->setfonctId(Database::insert($qry));
		}
	}
	public function delete($array = array())
	{
		$qry = "DELETE FROM " . FONCTIONNALITES;
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