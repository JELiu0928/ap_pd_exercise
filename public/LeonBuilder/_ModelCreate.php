<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('_Class.php');
require_once('_Model.php');
if (isset($_POST['Create'])) {
	$type = $_POST['type'];
	$leon_database = $db->query(sprintf("SELECT * FROM leon_database"))->fetchAll(PDO::FETCH_ASSOC);
	$basic_branch_origin_unit = $db->query(sprintf("SELECT * FROM basic_branch_origin_unit"))->fetchAll(PDO::FETCH_ASSOC);
	foreach ($leon_database as $val) {
		$db_data = json_decode($val['db_data'], true);
		$other_data = json_decode($val['other_data'], true);

		if ($type == 0) {
			$CreateModel->Create($val['db_name'], ucfirst($val['db_name']), $db_data, $other_data);
			//段落編輯
			if (isset($other_data['isContent']) && $other_data['isContent']) {
				$content = json_decode('[{"show":"false","show_rank":"","excel":"false","batch":"false","search":"false","son":"false","disable":"false","lang":"false","note":"文章編輯器","name":"edit","type":"內容","formtype":"","model":"","tip":"","tab":"","img":"","other":""}]', true);
				$content_other = json_decode('{"is_onepage":"0","is_rank":"0","is_visible":"1","isDelete":"0","isCreate":"0","isExport":"0","isClone":"0"}', true);
				$CreateModel->Create($val['db_name'] . '_content', ucfirst($val['db_name'] . '_content'), $content, $content_other);

				$content_img = json_decode('[{"show":"false","show_rank":"","excel":"false","batch":"false","search":"false","son":"false","disable":"false","lang":"false","note":"文章編輯器","name":"edit","type":"內容圖片","formtype":"","model":"","tip":"","tab":"","img":"","other":""}]', true);
				$content_img_other = json_decode('{"is_onepage":"0","is_rank":"0","is_visible":"1","isDelete":"0","isCreate":"0","isExport":"0","isClone":"0"}', true);
				$CreateModel->Create($val['db_name'] . '_content_img', ucfirst($val['db_name'] . '_content_img'), $content_img, $content_img_other);
			}
		}
		foreach ($basic_branch_origin_unit as $branck) {
			if (isset($other_data['isShareModel']) && $other_data['isShareModel']) {
				$db_name = $val['db_name'];
			} else {
				$db_name = $branck['locale'] . '_' . $val['db_name'];
			}
			if ($type == 2) {
				$db->exec("DROP TABLE " . $db_name);
			}
			$Sql = $DB_Class->_Create($db_name, $db_data, $val['db_note']);
			try {
				$db->exec($Sql);
			} catch (Exception $e) {
				//print_r($val);
			}
			if (isset($other_data['isContent']) && $other_data['isContent']) {

				$content = json_decode('[{"show":"false","show_rank":"","excel":"false","batch":"false","search":"false","son":"false","disable":"false","lang":"false","note":"文章編輯器","name":"edit","type":"內容","formtype":"","model":"","tip":"","tab":"","img":"","other":""}]', true);
				$Sql_content = $DB_Class->_Create($db_name . '_content', $content, '資料介紹');

				try {
					$db->exec($Sql_content);
				} catch (Exception $e) {
					//print_r($val);
				}
				$content_img = json_decode('[{"show":"false","show_rank":"","excel":"false","batch":"false","search":"false","son":"false","disable":"false","lang":"false","note":"文章編輯器","name":"edit","type":"內容圖片","formtype":"","model":"","tip":"","tab":"","img":"","other":""}]', true);
				$Sql_content_img = $DB_Class->_Create($db_name . '_content_img', $content_img, '資料圖影');

				try {
					$db->exec($Sql_content_img);
				} catch (Exception $e) {
					//print_r($val);
				}
			}
		}
	}
	echo "ok";
}