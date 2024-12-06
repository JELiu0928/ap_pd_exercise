<?php
//$db_item = $Panda_Class->_SELECT("db_item");

class Panda_Class
{
	function __construct($pdo)
	{
		$this->db = $pdo;
	}
	public function SQLStr($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
	{
		if (PHP_VERSION < 6) {
			$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
		}
		if ($theType == "text") {
			$theValue = str_replace('"', '\"', $theValue);
			$theValue = str_replace("'", "\'", $theValue);
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "''";
		}
		if ($theType == "int") {
			$theValue = ($theValue != "") ? intval($theValue) : "0";
		}
		if ($theType == "double") {
			$theValue = ($theValue != "") ? doubleval($theValue) : "0";
		}
		if ($theType == "date") {
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : $this->getDateTime('now', 'Y-m-d', null);
		}
		return $theValue;
	}
	public function getDateTime($date, $format, $modification)
	{
		$timeZone = "Asia/Taipei";
		$timeZone = new DateTimeZone($timeZone);
		$dateObject = new DateTime($date, $timeZone);
		if ($modification == null) {
			$formatted = $dateObject->format($format);
		}
		if ($modification != null) {
			$dateObjectClone = clone $dateObject;
			$dateObjectClone->add(new DateInterval($modification));
			$formatted = $dateObjectClone->format($format);
		}
		unset($timeZone);
		unset($dateObject);
		unset($dateObjectClone);
		return $formatted;
	}

	public function _SELECT($DB_name)
	{
		$rs = $this->db->query(sprintf("SELECT * FROM " . $DB_name));
		return $rs->fetchAll(PDO::FETCH_ASSOC);
	}
	public function _INSERTS($DB_name, $SQL_data)
	{
		//補沒有的欄位
		$columns = $this->db->query(sprintf("show FULL columns from " . $DB_name))->fetchAll(PDO::FETCH_ASSOC);

		$data = $question_marks = $insert_values = array();
		$data = $SQL_data;
		if (count($SQL_data) > 0) {
			$datafields = array_keys($SQL_data[0]);
			foreach ($columns as $v) {
				// echo $v['Field'].'</br>';
				// echo $v['Type'].'</br>';
				if (!in_array($v['Field'], $datafields)) {
					$datafields[] = $v['Field'];
					foreach ($data as $key => $vs) {
						$t_val = '';
						if (strpos($v['Type'], 'json') !== false) {
							$t_val = '[]';
						}
						if (strpos($v['Type'], 'date') !== false) {
							$t_val = '2020-01-01';
						}
						if (strpos($v['Type'], 'datetime') !== false) {
							$t_val = '2020-01-01 16:38:25';
						}
						if (strpos($v['Type'], 'double') !== false) {
							$t_val = 0;
						}
						if (strpos($v['Type'], 'int') !== false) {
							$t_val = 0;
						}
						$data[$key][] = $t_val;
					}
				}
			}
			foreach ($data as $rowData) {
				$result = array();
				if (sizeof($rowData) > 0) {
					for ($x = 0; $x < sizeof($rowData); $x++) {
						$result[] = '?';
					}
				}
				$question_marks[] = '('  . implode(",", $result) . ')';
				foreach ($rowData as $rowField) {
					$insert_values[] = $rowField;
				}
			}
			// $sql = "INSERT ignore INTO " . $DB_name . " (" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
			$sql = "INSERT INTO " . $DB_name . " (" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
			$stmt = $this->db->prepare($sql);
			try {
				$stmt->execute($insert_values);
			} catch (PDOException $e) {
				return false;
			}
		}
		return true;
	}
	public function _INSERT($DB_name, $SQL_data)
	{
		$columns = $this->db->query(sprintf("show FULL columns from " . $DB_name))->fetchAll(PDO::FETCH_ASSOC);

		$data = $question_marks = $insert_values = array();
		$data[] = $SQL_data;
		$datafields = array_keys($SQL_data);
		foreach ($columns as $v) {
			if (!in_array($v['Field'], $datafields)) {
				$datafields[] = $v['Field'];
				foreach ($data as $key => $vs) {
					$t_val = '';
					if (strpos($v['Type'], 'json') !== false) {
						$t_val = '[]';
					}
					if (strpos($v['Type'], 'date') !== false) {
						$t_val = '2020-01-01';
					}
					if (strpos($v['Type'], 'datetime') !== false) {
						$t_val = '2020-01-01 16:38:25';
					}
					if (strpos($v['Type'], 'double') !== false) {
						$t_val = 0;
					}
					if (strpos($v['Type'], 'int') !== false) {
						$t_val = 0;
					}
					$data[$key][] = $t_val;
				}
			}
		}
		foreach ($data as $rowData) {
			$result = array();
			if (sizeof($rowData) > 0) {
				for ($x = 0; $x < sizeof($rowData); $x++) {
					$result[] = '?';
				}
			}
			$question_marks[] = '('  . implode(",", $result) . ')';
			foreach ($rowData as $rowField) {
				$insert_values[] = $rowField;
			}
		}
		$sql = "INSERT ignore INTO " . $DB_name . " (" . implode(",", $datafields) . ") VALUES " . implode(',', $question_marks);
		$stmt = $this->db->prepare($sql);
		try {
			$stmt->execute($insert_values);
		} catch (PDOException $e) {
			return false;
		}
		return true;
	}
	public function _UPDATE($DB_name, $SQL_data)
	{
		$data = $question_marks = $insert_values = $result = $pach = array();
		$data[] = $SQL_data;
		$datafields = array_keys($SQL_data);
		foreach ($datafields as $key => $val) {
			if (count($datafields) == ($key + 1)) {
				$pach[] = $val . '=:' . $val;
			} else {
				$result[] = $val . '=:' . $val;
			}
		}
		$question_marks[] = implode(",", $result);
		$question_pach[] = implode(",", $pach);
		$sql = "UPDATE " . $DB_name . " SET " . implode(',', $question_marks) . " WHERE " . implode(',', $question_pach);
		//return $sql;
		$stmt = $this->db->prepare($sql);
		try {
			$stmt->execute($SQL_data);
		} catch (PDOException $e) {
			return false;
		}
		return true;
	}
}
$Panda_Class = new Panda_Class($db);