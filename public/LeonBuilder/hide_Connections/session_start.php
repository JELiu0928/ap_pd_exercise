<?php
class PDO_Session
{
	public function __construct($pdo)
	{
		$this->db = $pdo;
		session_set_save_handler(array($this, "_open"), array($this, "_close"), array($this, "_read"), array($this, "_write"), array($this, "_destroy"), array($this, "_gc"));
		session_start();
	}
	public function _open()
	{
		if ($this->db) {
			return true;
		}
		return false;
	}
	public function _close()
	{
		return true;
	}
	public function _read($session_key)
	{
		$rs = $this->db->prepare('SELECT session_data FROM mysession WHERE session_key = :session_key');
		$rs->bindValue(':session_key', $session_key, PDO::PARAM_STR);
		if ($rs->execute()) {
			$db_data = $rs->fetch(PDO::FETCH_ASSOC);
			return (isset($db_data['session_data'])) ? $db_data['session_data'] : '';
		} else {
			return '';
		}
	}
	public function _write($session_key, $session_data)
	{
		$session_expiry = time();
		$rs = $this->db->prepare('REPLACE INTO mysession VALUES (:session_key, :session_data, :session_expiry)');
		$rs->bindValue(':session_key', $session_key, PDO::PARAM_STR);
		$rs->bindValue(':session_data', $session_data, PDO::PARAM_STR);
		$rs->bindValue(':session_expiry', $session_expiry, PDO::PARAM_INT);
		if ($rs->execute()) {
			return true;
		}
		return false;
	}
	public function _destroy($session_key)
	{
		$rs = $this->db->prepare('DELETE FROM mysession WHERE session_key = :session_key');
		$rs->bindValue(':session_key', $session_key, PDO::PARAM_STR);
		if ($rs->execute()) {
			return true;
		}
		return false;
	}
	public function _gc($max)
	{
		$old = time() - $max;
		$rs = $this->db->prepare('DELETE FROM mysession WHERE session_expiry < :old');
		$rs->bindValue(':old', $old, PDO::PARAM_INT);
		if ($rs->execute()) {
			return true;
		}
		return false;
	}
}

set_time_limit(0);
date_default_timezone_set("Asia/Taipei");
$set_host = "127.0.0.1";

if (strpos($_SERVER['HTTP_HOST'], '.test') !== false) { } else {
	exit();
}

$file = fopen('../../.env', "r+");
$_DATABASE = ['DB_DATABASE' => '', 'DB_USERNAME' => '', 'DB_PASSWORD' => ''];
while (!feof($file)) {
	$str = fgets($file);
	if (strpos($str, 'DB_HOST') !== false && strpos($str, '# DB_HOST') === false) {
		$set_host = trim(str_replace("DB_HOST=", "", $str));
	}
	if (strpos($str, 'DB_DATABASE') !== false && strpos($str, '# DB_DATABASE') === false) {
		$_DATABASE['DB_DATABASE'] = trim(str_replace("DB_DATABASE=", "", $str));
	}
	if (strpos($str, 'DB_USERNAME') !== false && strpos($str, '# DB_USERNAME') === false) {
		$_DATABASE['DB_USERNAME'] = trim(str_replace("DB_USERNAME=", "", $str));
	}
	if (strpos($str, 'DB_PASSWORD') !== false && strpos($str, '# DB_PASSWORD') === false) {
		$_DATABASE['DB_PASSWORD'] = trim(str_replace("DB_PASSWORD=", "", $str));
	}
}
fclose($file);

$set_database = $_DATABASE['DB_DATABASE'];
$set_username = $_DATABASE['DB_USERNAME'];
$set_password = $_DATABASE['DB_PASSWORD'];

$sql_details = array('user' => $set_username, 'pass' => $set_password, 'db' => $set_database, 'host' => $set_host);
$AEs_key = "sa15df1eFDEf5ee2e6fe6fes2f3q3sd6";
$dsn = "mysql:host=$set_host;dbname=$set_database;port=3306";
$db = new PDO($dsn, $set_username, $set_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
$PDO_Session = new PDO_Session($db);
$PDO_Session->_gc(86400);
//資料庫資料防寫 SQLStr
if (!function_exists("SQLStr")) {
	function SQLStr($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
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
			$theValue = ($theValue != "") ? "'" . $theValue . "'" : "0000-00-00";
		}
		return $theValue;
	}
}
//時間 
function getDateTime($date, $format, $modification)
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
$now_intdate = getDateTime('now', 'Ymd', null);
$now_date = getDateTime('now', 'Y-m-d', null);
$now_datetime = getDateTime('now', 'Y-m-d/H:i:s', null);
//建立分頁 $PageStr = "&id=1";
function creat_pages($PageStr, $pages, $page, $pageNum, $start, $end, $next, $pre)
{
	if ($pages > 1) {
		echo "<ul class='pagination'>";
		if ($page > 1) {
			echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?page=1' . $PageStr . '">第一頁</a></li>';
			echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $pre . $PageStr . '">&laquo;</a></li>';
		}
		if ($pages <= $pageNum) {
			for ($i = $start; $i <= $pages; $i++) {
				if ($i == $page) {
					echo '<li class="active"><a>' . $i . '</a></li>';
				} else {
					echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $i . $PageStr . '">' . $i . '</a></li>';
				}
			}
		} else {
			if ($page > 2) {
				$end = $page + ($pageNum - 3);
				if ($end > $pages) {
					$end = $pages;
				}
				$start = $end - ($pageNum - 1);
				for ($i = $start; $i <= $end; $i++) {
					if ($i == $page) {
						echo '<li class="active"><a>' . $i . '</a></li>';
					} else {
						echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $i . $PageStr . '">' . $i . '</a></li>';
					}
				}
			} else {
				if ($end > $pages) {
					$end = $pages;
				}
				for ($i = $start; $i <= $end; $i++) {
					if ($i == $page) {
						echo '<li class="active"><a>' . $i . '</a></li>';
					} else {
						echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $i . $PageStr . '">' . $i . '</a></li>';
					}
				}
			}
		}
		if ($page < $pages) {
			echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $next . $PageStr . '">&raquo;</a></li>';
			echo '<li><a href="' . $_SERVER['PHP_SELF'] . '?page=' . $pages . $PageStr . '">最末頁</a></li>';
		}
		echo "</ul>";
	}
}
//隱藏字串
function hideStr($string, $bengin = 0, $len = 4, $type = 0, $glue = "@")
{
	if (empty($string)) return false;
	$array = array();
	if ($type == 0 || $type == 1 || $type == 4) {
		$strlen = $length = mb_strlen($string);
		while ($strlen) {
			$array[] = mb_substr($string, 0, 1, "utf8");
			$string = mb_substr($string, 1, $strlen, "utf8");
			$strlen = mb_strlen($string);
		}
	}
	if ($type == 0) {
		for ($i = $bengin; $i < ($bengin + $len); $i++) {
			if (isset($array[$i])) $array[$i] = "*";
		}
		$string = implode("", $array);
	} else if ($type == 1) {
		$array = array_reverse($array);
		for ($i = $bengin; $i < ($bengin + $len); $i++) {
			if (isset($array[$i])) $array[$i] = "*";
		}
		$string = implode("", array_reverse($array));
	} else if ($type == 2) {
		$array = explode($glue, $string);
		$array[0] = hideStr($array[0], $bengin, $len, 1);
		$string = implode($glue, $array);
	} else if ($type == 3) {
		$array = explode($glue, $string);
		$array[1] = hideStr($array[1], $bengin, $len, 0);
		$string = implode($glue, $array);
	} else if ($type == 4) {
		$left = $bengin;
		$right = $len;
		$tem = array();
		for ($i = 0; $i < ($length - $right); $i++) {
			if (isset($array[$i])) $tem[] = $i >= $left ? "*" : $array[$i];
		}
		$array = array_chunk(array_reverse($array), $right);
		$array = array_reverse($array[0]);
		for ($i = 0; $i < $right; $i++) {
			$tem[] = $array[$i];
		}
		$string = implode("", $tem);
	}
	return $string;
}
//錯誤頁面
function error_page()
{
	header("Location: error.html");
	exit();
}
//資料加密
function aes_hide($str, $AEs_key)
{
	$the_value = "AES_ENCRYPT('$str','$AEs_key')";
	return $the_value;
}
//資料解密
function aes_show($str, $AEs_key)
{
	$the_value = " CONVERT (AES_DECRYPT($str ,'$AEs_key') USING utf8) as $str ";
	return $the_value;
}
