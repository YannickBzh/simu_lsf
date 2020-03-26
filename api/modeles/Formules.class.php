<?php
if (!defined('FORMULES')) {
    define('FORMULES', 'formules');
}
class Formules {
	private $formuleId;
    private $nom;
    private $description;
    private $prix_achat;
    private $prix_location_24;
    private $prix_location_36;
    private $prix_location_48;

	public function setformuleId($pArg = "0") { $this->formuleId = $pArg;}
    public function setnom($pArg = "0") { $this->nom = $pArg;}
    public function setdescription($pArg = "0") { $this->description = $pArg;}
    public function setprix_achat($pArg = "0") { $this->prix_achat = $pArg;}
    public function setprix_location_24($pArg = "0") { $this->prix_location_24 = $pArg;}
    public function setprix_location_36($pArg = "0") { $this->prix_location_36 = $pArg;}
    public function setprix_location_48($pArg = "0") { $this->prix_location_48 = $pArg;}

	public function getformuleId() { return $this->formuleId; }
    public function getnom() { return $this->nom; }
    public function getdescription() { return $this->description; }
    public function getprix_achat() { return $this->prix_achat; }
    public function getprix_location_24() { return $this->prix_location_24; }
    public function getprix_location_36() { return $this->prix_location_36; }
    public function getprix_location_48() { return $this->prix_location_48; }

	public function readObject($array = array()) {
		$qry = "SELECT * FROM " . FORMULES;
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
			$this->setformuleId($record['formuleId']);
            $this->setnom($record['nom']);
            $this->setdescription($record['description']);
            $this->setprix_achat($record['prix_achat']);
            $this->setprix_location_24($record['prix_location_24']);
            $this->setprix_location_36($record['prix_location_36']);
            $this->setprix_location_48($record['prix_location_48']);

			return true;
		}
	}
	public static function readArray($array = array())
	{
		$qry = "SELECT *  FROM " . FORMULES;
		$and = " WHERE ";

		foreach($array as $key => $value) {
			if ($array[$key] != "") {
				$qry .= $and.$key." = '".$array[$key]."'" ;
				$and = "AND ";
			}
		}

		$qry .= " ORDER BY formuleId ASC";
		$recordset     = Database::select($qry);
		$class_objects = array();
		if (is_array($recordset) == true) {
			while (list($i, $record) = each($recordset)) {
				$class_object = new Formules();

				$class_object->setformuleId($record['formuleId']);
                $class_object->setnom($record['nom']);
                $class_object->setdescription($record['description']);
                $class_object->setprix_achat($record['prix_achat']);
                $class_object->setprix_location_24($record['prix_location_24']);
                $class_object->setprix_location_36($record['prix_location_36']);
                $class_object->setprix_location_48($record['prix_location_48']);

				$class_objects[$class_object->getformuleId()] = $class_object;
			}
		}
		return $class_objects;
	}
	public function insert()
	{
		if ($this->getformuleId() != '') {
			$qry = "UPDATE " . FORMULES . " SET
            formuleId = '" . $this->getformuleId() .
            "', nom = '" . addslashes($this->getnom()) .
            "', description = '" . addslashes($this->getdescription()) .
            "', prix_achat = '" . addslashes($this->getprix_achat()) .
            "', prix_location_24 = '" . addslashes($this->getprix_location_24()) .
            "', prix_location_36 = '" . addslashes($this->getprix_location_36()) .
            "', prix_location_48 = '" . addslashes($this->getprix_location_48()) .
            "' WHERE formuleId = " . $this->getformuleId() ;
            //echo $qry;
			Database::insert($qry);
		} else {
			$qry = "INSERT INTO " . FORMULES . " ( formuleId, nom, description, prix_achat, prix_location_24, prix_location_36, prix_location_48) VALUES (" .
            "'" . $this->getformuleId() .
            "','" . addslashes($this->getnom()) .
            "','" . addslashes($this->getdescription()) .
            "','" . addslashes($this->getprix_achat()) .
            "','" . addslashes($this->getprix_location_24()) .
            "','" . addslashes($this->getprix_location_36()) .
            "','" . addslashes($this->getprix_location_48()) .
            "')" ;
			//echo $qry;
			$this->setformuleId(Database::insert($qry));
		}
	}
	public function delete($array = array())
	{
		$qry = "DELETE FROM " . FORMULES;
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