<?php
if (!defined('CODE_PROMO')) {
    define('CODE_PROMO', 'code_promo');
}
class Code_promo {
	private $codePromoId;
    private $code;
    private $date_debut;
    private $date_fin;
    private $montant;
    private $pourcentage;

	public function setcodePromoId($pArg = "0") { $this->codePromoId = $pArg;}
    public function setcode($pArg = "0") { $this->code = $pArg;}
    public function setdate_debut($pArg = "0") { $this->date_debut = $pArg;}
    public function setdate_fin($pArg = "0") { $this->date_fin = $pArg;}
    public function setmontant($pArg = "0") { $this->montant = $pArg;}
    public function setpourcentage($pArg = "0") { $this->pourcentage = $pArg;}

	public function getcodePromoId() { return $this->codePromoId; }
    public function getcode() { return $this->code; }
    public function getdate_debut() { return $this->date_debut; }
    public function getdate_fin() { return $this->date_fin; }
    public function getmontant() { return $this->montant; }
    public function getpourcentage() { return $this->pourcentage; }

	public function readObject($array = array()) {
		$qry = "SELECT * FROM " . CODE_PROMO;
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
			$this->setcodePromoId($record['codePromoId']);
            $this->setcode($record['code']);
            $this->setdate_debut($record['date_debut']);
            $this->setdate_fin($record['date_fin']);
            $this->setmontant($record['montant']);
            $this->setpourcentage($record['pourcentage']);

			return true;
		}
	}
	public static function readArray($array = array())
	{
		$qry = "SELECT *  FROM " . CODE_PROMO;
		$and = " WHERE ";

		foreach($array as $key => $value) {
			if ($array[$key] != "") {
				$qry .= $and.$key." = '".$array[$key]."'" ;
				$and = "AND ";
			}
		}

		$qry .= " ORDER BY codePromoId ASC";
		$recordset     = Database::select($qry);
		$class_objects = array();
		if (is_array($recordset) == true) {
			while (list($i, $record) = each($recordset)) {
				$class_object = new Code_promo();

				$class_object->setcodePromoId($record['codePromoId']);
                $class_object->setcode($record['code']);
                $class_object->setdate_debut($record['date_debut']);
                $class_object->setdate_fin($record['date_fin']);
                $class_object->setmontant($record['montant']);
                $class_object->setpourcentage($record['pourcentage']);

				$class_objects[$class_object->getcodePromoId()] = $class_object;
			}
		}
		return $class_objects;
	}
	public function insert()
	{
		if ($this->getcodePromoId() != '') {
			$qry = "UPDATE " . CODE_PROMO . " SET
            codePromoId = '" . $this->getcodePromoId() .
            "', code = '" . addslashes($this->getcode()) .
            "', date_debut = '" . addslashes($this->getdate_debut()) .
            "', date_fin = '" . addslashes($this->getdate_fin()) .
            "', montant = '" . addslashes($this->getmontant()) .
            "', pourcentage = '" . addslashes($this->getpourcentage()) .
            "' WHERE codePromoId = " . $this->getcodePromoId() ;
            //echo $qry;
			Database::insert($qry);
		} else {
			$qry = "INSERT INTO " . CODE_PROMO . " ( codePromoId, code, date_debut, date_fin, montant, pourcentage) VALUES (" .
            "'" . $this->getcodePromoId() .
            "','" . addslashes($this->getcode()) .
            "','" . addslashes($this->getdate_debut()) .
            "','" . addslashes($this->getdate_fin()) .
            "','" . addslashes($this->getmontant()) .
            "','" . addslashes($this->getpourcentage()) .
            "')" ;
			//echo $qry;
			$this->setcodePromoId(Database::insert($qry));
		}
	}
	public function delete($array = array())
	{
		$qry = "DELETE FROM " . CODE_PROMO;
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