<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('_Model.php');


$path = '../../resources/views/Fantasy/cms/News_item/index.blade.php';

if (file_exists($path)) {
	$file = fopen($path, "r+");
	$content = '';
	while (!feof($file)) {
		$str = fgets($file);
		$content .= $str;
	}
	fclose($file);
	$re = '/\$menuList = \[(.*)\];/s';
	preg_match($re, $content, $matches, PREG_OFFSET_CAPTURE, 0);
	$ss =  str_replace("=>", ":", preg_replace('/\s(?=)/', '', $matches[1][0]));
	$ss =  str_replace("'", "\"", $ss);
	$ss = substr($ss, 0, -1);
	$Old_menuList = json_decode('{' . $ss . '}', true);
}

// print_r($ss);
// exit();
$MenuListArr = [];
$MenuListArr[] = ["MainForm", "基本設定"];
$MenuListArr[] = ["Form_0", "共用庫存/售價"];
$MenuListArr[] = ["Form_2", "規格庫存/售價"];
$MenuListArr[] = ["Form_3", "規格表"];
$MenuListArr[] = ["Form_4", "商品輪播圖"];
$MenuListArr[] = ["Form_5", "說明事項"];
$MenuListArr[] = ["Form_6", "商品資料介紹"];
$MenuListArr[] = ["Form_1", "SEO設定"];

$new_list = [];
foreach ($Old_menuList as $key => $val) {
	$is_find = false;
	foreach ($MenuListArr as $v) {
		if ($val == $v[1]) {
			$is_find = true;
		}
	}
	if (!$is_find) {
		//unset($Old_menuList[$key]);
	} else {
		$new_list[] = [$key, $val];
	}
}

foreach ($MenuListArr as $key => $val) {
	$is_find = false;
	foreach ($Old_menuList as $v) {
		if ($val[1] == $v) {
			$is_find = true;
		}
	}
	if (!$is_find) {
		$new_list[] = [$val[0], $val[1]];
	}
}

$temp_list = '';
foreach ($new_list as $val) {
	$temp_list .= '"' . $val[0] . '"=>"' . $val[1] . '",' . PHP_EOL;
}

// $json_en = json_encode($new_list, JSON_UNESCAPED_UNICODE);

echo $temp_list;


// $arr = [
// 	'MainForm' => 'aa',
// 	'MainForm2' => 'aa',
// ];



// print_r($myarray);

// $rs = $db->query(sprintf("show FULL columns from basic_cms_menu"))->fetchAll(PDO::FETCH_ASSOC);
// foreach($rs as $v){
	// echo $v['Field'].'</br>';
	// echo $v['Type'].'</br>';
// }
// exit();


// //判斷欄位 不存在則建立
// $basic_branch_origin_unit = $db->query(sprintf("SELECT * FROM basic_branch_origin_unit"))->fetchAll(PDO::FETCH_ASSOC);
// $leon_database = $db->query(sprintf("SELECT * FROM leon_database"))->fetchAll(PDO::FETCH_ASSOC);
// foreach($basic_branch_origin_unit as $val){
	// foreach($leon_database as $value){
		// $db_name = $val['locale'].'_'.$value['db_name'];

		// //判斷欄位是否存在
		// $tableList = array();
		
		// while ($row = $rs->fetch(PDO::FETCH_NUM)) {$tableList[] = array("name"=>$row[0],"type"=>$row[1],"note"=>$row[8]);}
		// if(!in_array('wait_del',array_column($tableList,'name'))){
			// $Sqltxt = "int(11) NOT NULL COMMENT";
			// $Sql = "ALTER TABLE `".$db_name."` ADD `wait_del` ".$Sqltxt." '申請刪除' AFTER `is_visible`;";
			// $db->exec(sprintf($Sql));
			
		// }
		// //$db->exec(sprintf('UPDATE '.$db_name.' SET is_reviewed = 1 WHERE 1'));
	
	// }
	
// }


// $leon_database = $db->query(sprintf("SELECT * FROM leon_database"))->fetchAll(PDO::FETCH_ASSOC);
// foreach($leon_database as $val){
// 	$other_data = json_decode($val['other_data'], true);
// 	$newArray = [];
// 	foreach($other_data as $v){
// 		$new['is_onepage'] = (isset($other_data['is_onepage'])) ? $other_data['is_onepage']:0;
// 		$new['is_visible'] = (isset($other_data['is_visible'])) ? $other_data['is_visible']:0;
// 		$new['is_rank'] = (isset($other_data['is_rank'])) ? $other_data['is_rank']:0;
// 		$new['isDelete'] = (isset($other_data['isDelete'])) ? $other_data['isDelete']:0;
// 		$new['isCreate'] = (isset($other_data['isCreate'])) ? $other_data['isCreate']:0;
// 		$new['isExport'] = (isset($other_data['isExport'])) ? $other_data['isExport']:0;
// 		$new['isClone'] = (isset($other_data['isClone'])) ? $other_data['isClone']:0;
	
		
// 		// $new['show'] = $v[0];
		
// 		// $new['search'] = $v[1];
// 		// $new['son'] = 'false';
// 		// $new['disable'] = 'false';
// 		// $new['note'] = $v[2];
// 		// $new['name'] = $v[3];
// 		// $new['type'] = $v[4];
// 		// $new['formtype'] = $v[5];
// 		// $new['model'] = $v[6];
// 		// $new['tip'] = $v[7];
// 		// $new['tab'] = $v[8];
// 		// $new['img'] = $v[9];
// 		$newArray = $new;
// 	}
// 	$newArray_en = json_encode($newArray,JSON_UNESCAPED_UNICODE);
// 	$SQL_data = array("other_data"=>$newArray_en,"id"=>$val['id']);
// 	$Panda_Class->_UPDATE("leon_database",$SQL_data);
// }


//判斷欄位 不存在則建立
// $basic_branch_origin_unit = $db->query(sprintf("SELECT * FROM basic_branch_origin_unit"))->fetchAll(PDO::FETCH_ASSOC);
// $leon_database = $db->query(sprintf("SELECT * FROM leon_database"))->fetchAll(PDO::FETCH_ASSOC);
// foreach($basic_branch_origin_unit as $val){
	// foreach($leon_database as $value){
		// $db_name = $val['locale'].'_'.$value['db_name'];

		// //判斷欄位是否存在
		// $tableList = array();
		// $rs = $db->query(sprintf("show FULL columns from $db_name"));
		// while ($row = $rs->fetch(PDO::FETCH_NUM)) {$tableList[] = array("name"=>$row[0],"type"=>$row[1],"note"=>$row[8]);}
		// if(!in_array('wait_del',array_column($tableList,'name'))){
			// $Sqltxt = "int(11) NOT NULL COMMENT";
			// $Sql = "ALTER TABLE `".$db_name."` ADD `wait_del` ".$Sqltxt." '申請刪除' AFTER `is_visible`;";
			// $db->exec(sprintf($Sql));
			
		// }
		// //$db->exec(sprintf('UPDATE '.$db_name.' SET is_reviewed = 1 WHERE 1'));
	
	// }
	
// }
	// echo "OK";