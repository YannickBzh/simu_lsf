<?php
if (!defined('CONFIGURATION')) {
    define('CONFIGURATION', 'configuration');
}
class Configuration {
	private $configId;
    private $formuleId;
    private $date_creation;
    private $typeChoix;
    private $nb_mensualites;
    private $hebergement;
    private $maintenance;
    private $prix_total;

	public function setconfigId($pArg = "0") { $this->configId = $pArg;}
    public function setformuleId($pArg = "0") { $this->formuleId = $pArg;}
    public function setdate_creation($pArg = "0") { $this->date_creation = $pArg;}
    public function settypeChoix($pArg = "0") { $this->typeChoix = $pArg;}
    public function setnb_mensualites($pArg = "0") { $this->nb_mensualites = $pArg;}
    public function sethebergement($pArg = "0") { $this->hebergement = $pArg;}
    public function setmaintenance($pArg = "0") { $this->maintenance = $pArg;}
    public function setprix_total($pArg = "0") { $this->prix_total = $pArg;}

	public function getconfigId() { return $this->configId; }
    public function getformuleId() { return $this->formuleId; }
    public function getdate_creation() { return $this->date_creation; }
    public function gettypeChoix() { return $this->typeChoix; }
    public function getnb_mensualites() { return $this->nb_mensualites; }
    public function gethebergement() { return $this->hebergement; }
    public function getmaintenance() { return $this->maintenance; }
    public function getprix_total() { return $this->prix_total; }

	public function readObject($array = array()) {
		$qry = "SELECT * FROM " . CONFIGURATION;
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
			$this->setconfigId($record['configId']);
            $this->setformuleId($record['formuleId']);
            $this->setdate_creation($record['date_creation']);
            $this->settypeChoix($record['type']);
            $this->setnb_mensualites($record['nb_mensualites']);
            $this->sethebergement($record['hebergement']);
            $this->setmaintenance($record['maintenance']);
            $this->setprix_total($record['prix_total']);

			return true;
		}
	}
	public static function readArray($array = array())
	{
		$qry = "SELECT *  FROM " . CONFIGURATION;
		$and = " WHERE ";

		foreach($array as $key => $value) {
			if ($array[$key] != "") {
				$qry .= $and.$key." = '".$array[$key]."'" ;
				$and = "AND ";
			}
		}

		$qry .= " ORDER BY configId ASC";
		$recordset     = Database::select($qry);
		$class_objects = array();
		if (is_array($recordset) == true) {
			while (list($i, $record) = each($recordset)) {
				$class_object = new Configuration();

				$class_object->setconfigId($record['fconficonfigIdgId']);
                $class_object->setformuleId($record['formuleId']);
                $class_object->setdate_creation($record['date_creation']);
                $class_object->settypeChoix($record['type']);
                $class_object->setnb_mensualites($record['nb_mensualites']);
                $class_object->sethebergement($record['hebergement']);
                $class_object->setmaintenance($record['maintenance']);
                $class_object->setprix_total($record['prix_total']);

				$class_objects[$class_object->getconfigId()] = $class_object;
			}
		}
		return $class_objects;
	}
	public function insert()
	{
		if ($this->getconfigId() != '') {
			$qry = "UPDATE " . CONFIGURATION . " SET
            configId = '" . $this->getconfigId() .
            "', formuleId = '" . addslashes($this->getformuleId()) .
            "', date_creation = '" . addslashes($this->getdate_creation()) .
            "', type = '" . addslashes($this->gettypeChoix()) .
            "', nb_mensualites = '" . addslashes($this->getnb_mensualites()) .
            "', hebergement = '" . addslashes($this->gethebergement()) .
            "', maintenance = '" . addslashes($this->getmaintenance()) .
            "', prix_total = '" . addslashes($this->getprix_total()) .
            "' WHERE configId = " . $this->getconfigId() ;
            //echo $qry;
			Database::insert($qry);
		} else {
			$qry = "INSERT INTO " . CONFIGURATION . " ( configId, formuleId, date_creation, type, nb_mensualites, hebergement, maintenance, prix_total) VALUES (" .
            "'" . $this->getconfigId() .
            "','" . addslashes($this->getformuleId()) .
            "','" . addslashes($this->getdate_creation()) .
            "','" . addslashes($this->gettypeChoix()) .
            "','" . addslashes($this->getnb_mensualites()) .
            "','" . addslashes($this->gethebergement()) .
            "','" . addslashes($this->getmaintenance()) .
            "','" . addslashes($this->getprix_total()) .
            "')" ;
			//echo $qry;
			$this->setconfigId(Database::insert($qry));
		}
	}
	public function delete($array = array())
	{
		$qry = "DELETE FROM " . CONFIGURATION;
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