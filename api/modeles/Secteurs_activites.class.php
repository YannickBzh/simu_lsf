<?php
if (!defined('SECTEURS')) {
    define('SECTEURS', 'secteurs_activite');
}
class Secteurs_activites {
	private $activiteId;
	private $nom;
	private $fonct_sel;

	public function setactiviteId($pArg = "0") { $this->activiteId = $pArg;}
	public function setnom($pArg = "0") { $this->nom = $pArg;}
	public function setfonct_sel($pArg = "0") { $this->fonct_sel = $pArg;}

	public function getactiviteId() { return $this->activiteId; }
	public function getnom() { return $this->nom; }
	public function getfonct_sel() { return $this->fonct_sel; }

	public function readObject($array = array()) {
		$qry = "SELECT * FROM " . SECTEURS;
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
			$this->setactiviteId($record['activiteId']);
			$this->setnom($record['nom']);
			$this->setfonct_sel($record['fonct_sel']);

			return true;
		}
	}
	public static function readArray($array = array())
	{
		$qry = "SELECT *  FROM " . SECTEURS;
		$and = " WHERE ";

		foreach($array as $key => $value) {
			if ($array[$key] != "") {
				$qry .= $and.$key." = '".$array[$key]."'" ;
				$and = "AND ";
			}
		}

		$qry .= " ORDER BY activiteId ASC";
		$recordset     = Database::select($qry);
		$class_objects = array();
		if (is_array($recordset) == true) {
			while (list($i, $record) = each($recordset)) {
				$class_object = new Secteurs_activites();

				$class_object->setactiviteId($record['activiteId']);
				$class_object->setnom($record['nom']);
				$class_object->setfonct_sel($record['fonct_sel']);

				$class_objects[$class_object->getactiviteId()] = $class_object;
			}
		}
		return $class_objects;
	}
	public function insert()
	{
		if ($this->getactiviteId() != '') {
			$qry = "UPDATE " . SECTEURS . " SET
            activiteId = '" . $this->getactiviteId() .
			"', nom = '" . addslashes($this->getnom()) .
			"', fonct_sel = '" . addslashes($this->getfonct_sel()) .
            "' WHERE activiteId = " . $this->getactiviteId() ;
            //echo $qry;
			Database::insert($qry);
		} else {
			$qry = "INSERT INTO " . SECTEURS . " ( activiteId, nom, fonct_sel) VALUES (" .
            "'" . $this->getactiviteId() .
            "','" . addslashes($this->getnom()) .
            "','" . addslashes($this->getfonct_sel()) .
            "')" ;
			//echo $qry;
			$this->setactiviteId(Database::insert($qry));
		}
	}
	public function delete($array = array())
	{
		$qry = "DELETE FROM " . SECTEURS;
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