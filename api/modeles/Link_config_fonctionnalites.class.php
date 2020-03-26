<?php
if (!defined('LINK_CONFIG_FONCTIONNALITES')) {
    define('LINK_CONFIG_FONCTIONNALITES', 'link_config_fonctionnalites');
}
class Link_config_fonctionnalites {
	private $lcfId;
	private $configId;
	private $fonctId;

	public function setlcfId($pArg = "0") { $this->lcfId = $pArg;}
	public function setconfigId($pArg = "0") { $this->configId = $pArg;}
	public function setfonctId($pArg = "0") { $this->fonctId = $pArg;}

	public function getlcfId() { return $this->lcfId; }
	public function getconfigId() { return $this->configId; }
	public function getfonctId() { return $this->fonctId; }

	public function readObject($array = array()) {
		$qry = "SELECT * FROM " . LINK_CONFIG_FONCTIONNALITES;
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
			$this->setlcfId($record['lcfId']);
			$this->setconfigId($record['configId']);
			$this->setfonctId($record['fonctId']);

			return true;
		}
	}
	public static function readArray($array = array())
	{
		$qry = "SELECT *  FROM " . LINK_CONFIG_FONCTIONNALITES;
		$and = " WHERE ";

		foreach($array as $key => $value) {
			if ($array[$key] != "") {
				$qry .= $and.$key." = '".$array[$key]."'" ;
				$and = "AND ";
			}
		}

		$qry .= " ORDER BY lcfId ASC";
		$recordset     = Database::select($qry);
		$class_objects = array();
		if (is_array($recordset) == true) {
			while (list($i, $record) = each($recordset)) {
				$class_object = new Link_config_fonctionnalites();

				$class_object->setlcfId($record['lcfId']);
				$class_object->setconfigId($record['configId']);
				$class_object->setfonctId($record['fonctId']);

				$class_objects[$class_object->getlcfId()] = $class_object;
			}
		}
		return $class_objects;
	}
	public function insert()
	{
		if ($this->getlcfId() != '') {
			$qry = "UPDATE " . LINK_CONFIG_FONCTIONNALITES . " SET
            lcfId = '" . $this->getlcfId() .
			"', configId = '" . addslashes($this->getconfigId()) .
			"', fonctId = '" . addslashes($this->getfonctId()) .
            "' WHERE lcfId = " . $this->getlcfId() ;
            //echo $qry;
			Database::insert($qry);
		} else {
			$qry = "INSERT INTO " . LINK_CONFIG_FONCTIONNALITES . " ( lcfId, configId, fonctId) VALUES (" .
            "'" . $this->getlcfId() .
            "','" . addslashes($this->getconfigId()) .
            "','" . addslashes($this->getfonctId()) .
            "')" ;
			//echo $qry;
			$this->setlcfId(Database::insert($qry));
		}
	}
	public function delete($array = array())
	{
		$qry = "DELETE FROM " . LINK_CONFIG_FONCTIONNALITES;
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
