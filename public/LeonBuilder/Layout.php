<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('_Model.php');

$starKey = 200;
$web_key_branch_id = '["1"]';
$branch_id = 1;
//全部刪除重建
$db->exec(sprintf("TRUNCATE TABLE basic_cms_child"));
$db->exec(sprintf("TRUNCATE TABLE basic_cms_child_son"));
$db->exec(sprintf("TRUNCATE TABLE basic_cms_menu"));
$db->exec(sprintf("TRUNCATE TABLE basic_cms_menu_use"));
$db->exec(sprintf("TRUNCATE TABLE basic_cms_parent"));
$db->exec(sprintf("TRUNCATE TABLE basic_cms_parent_son"));
$db->exec(sprintf("TRUNCATE TABLE basic_web_key"));

// $db->exec(sprintf("DELETE FROM `basic_cms_menu` WHERE id > 34"));
// $db->exec(sprintf("DELETE FROM `basic_cms_child` WHERE id > 27"));
// $db->exec(sprintf("DELETE FROM `basic_cms_child_son` WHERE id > 11"));
// $db->exec(sprintf("DELETE FROM `basic_cms_parent` WHERE id > 8"));
// $db->exec(sprintf("DELETE FROM `basic_web_key` WHERE id > 2"));

$db->exec(sprintf("ALTER TABLE basic_cms_child AUTO_INCREMENT = $starKey"));
$db->exec(sprintf("ALTER TABLE basic_cms_child_son AUTO_INCREMENT = $starKey"));
$db->exec(sprintf("ALTER TABLE basic_cms_menu AUTO_INCREMENT = $starKey"));
$db->exec(sprintf("ALTER TABLE basic_cms_menu_use AUTO_INCREMENT = $starKey"));
$db->exec(sprintf("ALTER TABLE basic_cms_parent AUTO_INCREMENT = $starKey"));
$db->exec(sprintf("ALTER TABLE basic_cms_parent_son AUTO_INCREMENT = $starKey"));
$db->exec(sprintf("ALTER TABLE basic_web_key AUTO_INCREMENT = $starKey"));

$leon_menu = $db->query(sprintf("SELECT * FROM leon_menu where id = 1"))->fetch(PDO::FETCH_ASSOC);
$leon_database = $db->query(sprintf("SELECT * FROM leon_database"))->fetchAll(PDO::FETCH_ASSOC);
$MenuData =  json_decode($leon_menu['db_data'], true);

//建立第二層blade
foreach ($MenuData as $key => $val) {
	//如果第一層有model		
	if (!empty($val['id'])) {
		$Blade = [];
		$Blade['data'] = json_decode($leon_database[array_search(lcfirst($val['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
		$Blade['other_data'] = json_decode($leon_database[array_search(lcfirst($val['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
		$Blade['branch_name'] = $leon_database[array_search(lcfirst($val['id']), array_column($leon_database, 'db_name'))]['branch_name'];
		if (isset($Blade['other_data']['isClose']) && $Blade['other_data']['isClose'] == 1) {
			continue;
		}
		$Blade['model'] = ucfirst($val['id']);
		//段落編輯
		if (isset($Blade['other_data']['isContent']) && $Blade['other_data']['isContent'] == 1) {
			$leon_database[] = [
				'db_note' => '資料介紹',
				'db_name' => lcfirst($val['id']) . '_content',
				'db_data' => '[{"show":"false","show_rank":"","excel":"false","batch":"false","search":"false","son":"false","disable":"false","lang":"false","note":"文章編輯器","name":"edit","type":"內容","formtype":"","model":"","tip":"","tab":"","img":"","other":""}]',
				'other_data' => '{"is_onepage":"0","is_rank":"0","is_visible":"1","isDelete":"0","isCreate":"0","isExport":"0","isClone":"0"}',
				'branch_name' => $Blade['branch_name'],
			];
			$leon_database[] = [
				'db_note' => '資料圖影',
				'db_name' => lcfirst($val['id']) . '_content_img',
				'db_data' => '[{"show":"false","show_rank":"","excel":"false","batch":"false","search":"false","son":"false","disable":"false","lang":"false","note":"文章編輯器","name":"edit","type":"內容圖片","formtype":"","model":"","tip":"","tab":"","img":"","other":""}]',
				'other_data' => '{"is_onepage":"0","is_rank":"0","is_visible":"1","isDelete":"0","isCreate":"0","isExport":"0","isClone":"0"}',
				'branch_name' => $Blade['branch_name'],
			];
			$MenuData[$key]['children'][] = ['id' => $Blade['model'] . '_content', 'contenta' => '資料介紹', 'children' => [['id' => $Blade['model'] . '_content_img', 'contenta' => '資料圖影']]];
			$val['children'][] = ['id' => $Blade['model'] . '_content', 'contenta' => '資料介紹', 'children' => [['id' => $Blade['model'] . '_content_img', 'contenta' => '資料圖影']]];
		}
		//關聯many
		foreach ($Blade['data'] as $dataVal) {
			if (!empty($dataVal['model']) && $dataVal['formtype'] == 'select2' && strpos($dataVal['model'], 'CC_') === false) {
				$CreateModel->Create_clone_relations(ucfirst($Blade['model']), ucfirst($dataVal['model']), $dataVal['name'], true, 'belongsTo');
				$CreateModel->Create_clone_relations(ucfirst($dataVal['model']), ucfirst($Blade['model']), $dataVal['name'], true, 'hasMany');
			}
		}
		if (isset($val['children'])) {
			foreach ($val['children'] as $key1 => $level1) {
				$Blade['children'][$key1]['data'] = json_decode($leon_database[array_search(lcfirst($level1['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
				$Blade['children'][$key1]['other_data'] = json_decode($leon_database[array_search(lcfirst($level1['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
				$Blade['children'][$key1]['model'] = ucfirst($level1['id']);
				$Blade['children'][$key1]['label'] = $level1['contenta'];
				$CreateModel->Create_clone_relations(ucfirst($Blade['model']), ucfirst($level1['id']), 'parent_id');
				//關聯many
				foreach ($Blade['children'][$key1]['data'] as $dataVal) {
					if (!empty($dataVal['model']) && $dataVal['formtype'] == 'select2' && strpos($dataVal['model'], 'CC_') === false) {
						$CreateModel->Create_clone_relations(ucfirst($level1['id']), ucfirst($dataVal['model']), $dataVal['name'], true, 'belongsTo');
						$CreateModel->Create_clone_relations(ucfirst($dataVal['model']), ucfirst($level1['id']), $dataVal['name'], true);
					}
				}
				//判斷是否有sontable
				$sontable = [];
				if (isset($level1['children'])) {
					foreach ($level1['children'] as $key2 => $v2) {
						$Field = (strpos($level1['id'], 'content_img') !== false) ? 'second_id' : 'parent_id';
						$CreateModel->Create_clone_relations(ucfirst($level1['id']), ucfirst($v2['id']), $Field);
						$Blade['children'][$key1]['children'][$key2]['data'] = json_decode($leon_database[array_search(lcfirst($v2['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
						$Blade['children'][$key1]['children'][$key2]['other_data'] = json_decode($leon_database[array_search(lcfirst($v2['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
						$Blade['children'][$key1]['children'][$key2]['model'] = ucfirst($v2['id']);
						$Blade['children'][$key1]['children'][$key2]['label'] = $v2['contenta'];

						//關聯many
						foreach ($Blade['children'][$key1]['children'][$key2]['data'] as $dataVal) {
							if (!empty($dataVal['model']) && $dataVal['formtype'] == 'select2' && strpos($dataVal['model'], 'CC_') === false) {
								$CreateModel->Create_clone_relations(ucfirst($v2['id']), ucfirst($dataVal['model']), $dataVal['name'], true, 'belongsTo');
								$CreateModel->Create_clone_relations(ucfirst($dataVal['model']), ucfirst($v2['id']), $dataVal['name'], true);
							}
						}
						//判斷是否有treetable
						if (isset($v2['children'])) {
							foreach ($v2['children'] as $key3 => $v3) {
								$CreateModel->Create_clone_relations(ucfirst($v2['id']), ucfirst($v3['id']), 'second_id');
								$Blade['children'][$key1]['children'][$key2]['children'][$key3]['data'] = json_decode($leon_database[array_search(lcfirst($v3['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
								$Blade['children'][$key1]['children'][$key2]['children'][$key3]['other_data'] = json_decode($leon_database[array_search(lcfirst($v3['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
								$Blade['children'][$key1]['children'][$key2]['children'][$key3]['model'] = ucfirst($v3['id']);
								$Blade['children'][$key1]['children'][$key2]['children'][$key3]['label'] = $v3['contenta'];
								//關聯many
								foreach ($Blade['children'][$key1]['children'][$key2]['children'][$key3]['data'] as $dataVal) {
									if (!empty($dataVal['model']) && $dataVal['formtype'] == 'select2' && strpos($dataVal['model'], 'CC_') === false) {
										$CreateModel->Create_clone_relations(ucfirst($v3['id']), ucfirst($dataVal['model']), $dataVal['name'], true, 'belongsTo');
										$CreateModel->Create_clone_relations(ucfirst($dataVal['model']), ucfirst($v3['id']), $dataVal['name'], true);
									}
								}
								//第四層??
								if (isset($v3['children'])) {
									foreach ($v3['children'] as $key4 => $v4) {
										$Blade['children'][$key1]['children'][$key2]['children'][$key3]['children'][$key4]['data'] = json_decode($leon_database[array_search(lcfirst($v4['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
										$Blade['children'][$key1]['children'][$key2]['children'][$key3]['children'][$key4]['other_data'] = json_decode($leon_database[array_search(lcfirst($v4['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
										$Blade['children'][$key1]['children'][$key2]['children'][$key3]['children'][$key4]['model'] = ucfirst($v4['id']);
										$Blade['children'][$key1]['children'][$key2]['children'][$key3]['children'][$key4]['label'] = $v4['contenta'];
									}
								}
							}
						}
					}
				}
			}
		}

		$CreateModel->CreateBlade($Blade['model'], $Blade);
	}
	if (empty($val['id']) && isset($val['children'])) {
		foreach ($val['children'] as $ckey => $level1) {
			$Blade = [];
			$Blade['data'] = json_decode($leon_database[array_search(lcfirst($level1['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
			$Blade['other_data'] = json_decode($leon_database[array_search(lcfirst($level1['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
			$Blade['model'] = ucfirst($level1['id']);
			$Blade['label'] = $level1['contenta'];
			$Blade['branch_name'] = $leon_database[array_search(lcfirst($level1['id']), array_column($leon_database, 'db_name'))]['branch_name'];
			if (isset($Blade['other_data']['isClose']) && $Blade['other_data']['isClose'] == 1) {
				continue;
			}
			//段落編輯
			if (isset($Blade['other_data']['isContent']) && $Blade['other_data']['isContent'] == 1) {
				$leon_database[] = [
					'db_note' => '資料介紹',
					'db_name' => lcfirst($level1['id']) . '_content',
					'db_data' => '[{"show":"false","show_rank":"","excel":"false","batch":"false","search":"false","son":"false","disable":"false","lang":"false","note":"文章編輯器","name":"edit","type":"內容","formtype":"","model":"","tip":"","tab":"","img":"","other":""}]',
					'other_data' => '{"is_onepage":"0","is_rank":"0","is_visible":"1","isDelete":"0","isCreate":"0","isExport":"0","isClone":"0"}',
					'branch_name' => $Blade['branch_name'],
				];
				$leon_database[] = [
					'db_note' => '資料圖影',
					'db_name' => lcfirst($level1['id']) . '_content_img',
					'db_data' => '[{"show":"false","show_rank":"","excel":"false","batch":"false","search":"false","son":"false","disable":"false","lang":"false","note":"文章編輯器","name":"edit","type":"內容圖片","formtype":"","model":"","tip":"","tab":"","img":"","other":""}]',
					'other_data' => '{"is_onepage":"0","is_rank":"0","is_visible":"1","isDelete":"0","isCreate":"0","isExport":"0","isClone":"0"}',
					'branch_name' => $Blade['branch_name'],
				];
				$MenuData[$key]['children'][$ckey]['children'][] = ['id' => $level1['id'] . '_content', 'contenta' => '資料介紹', 'children' => [['id' => $level1['id'] . '_content_img', 'contenta' => '資料圖影']]];
				$level1['children'][] = ['id' => $level1['id'] . '_content', 'contenta' => '資料介紹', 'children' => [['id' => $level1['id'] . '_content_img', 'contenta' => '資料圖影']]];
			}
			//關聯many
			foreach ($Blade['data'] as $dataVal) {
				if (!empty($dataVal['model']) && $dataVal['formtype'] == 'select2' && strpos($dataVal['model'], 'CC_') === false) {
					$CreateModel->Create_clone_relations(ucfirst($Blade['model']), ucfirst($dataVal['model']), $dataVal['name'], true, 'belongsTo');
					$CreateModel->Create_clone_relations(ucfirst($dataVal['model']), ucfirst($Blade['model']), $dataVal['name'], true);
				}
			}
			//判斷是否有sontable
			$sontable = [];
			if (isset($level1['children'])) {
				foreach ($level1['children'] as $key2 => $v2) {
					$Field = (strpos($Blade['model'], 'content_img') !== false) ? 'second_id' : 'parent_id';
					$CreateModel->Create_clone_relations($Blade['model'], ucfirst($v2['id']), $Field);

					$Blade['children'][$key2]['data'] = json_decode($leon_database[array_search(lcfirst($v2['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
					$Blade['children'][$key2]['other_data'] = json_decode($leon_database[array_search(lcfirst($v2['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
					$Blade['children'][$key2]['model'] = ucfirst($v2['id']);
					$Blade['children'][$key2]['label'] = $v2['contenta'];
					//關聯many
					foreach ($Blade['children'][$key2]['data'] as $dataVal) {
						if (!empty($dataVal['model']) && $dataVal['formtype'] == 'select2' && strpos($dataVal['model'], 'CC_') === false) {
							$CreateModel->Create_clone_relations(ucfirst($v2['id']), ucfirst($dataVal['model']), $dataVal['name'], true, 'belongsTo');
							$CreateModel->Create_clone_relations(ucfirst($dataVal['model']), ucfirst($v2['id']), $dataVal['name'], true);
						}
					}
					//判斷是否有treetable
					if (isset($v2['children'])) {
						foreach ($v2['children'] as $key3 => $v3) {
							$CreateModel->Create_clone_relations(ucfirst($v2['id']), ucfirst($v3['id']), 'second_id');
							$Blade['children'][$key2]['children'][$key3]['data'] = json_decode($leon_database[array_search(lcfirst($v3['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
							$Blade['children'][$key2]['children'][$key3]['other_data'] = json_decode($leon_database[array_search(lcfirst($v3['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
							$Blade['children'][$key2]['children'][$key3]['model'] = ucfirst($v3['id']);
							$Blade['children'][$key2]['children'][$key3]['label'] = $v3['contenta'];
							//關聯many
							foreach ($Blade['children'][$key2]['children'][$key3]['data'] as $dataVal) {
								if (!empty($dataVal['model']) && $dataVal['formtype'] == 'select2' && strpos($dataVal['model'], 'CC_') === false) {
									$CreateModel->Create_clone_relations(ucfirst($v3['id']), ucfirst($dataVal['model']), $dataVal['name'], true, 'belongsTo');
									$CreateModel->Create_clone_relations(ucfirst($dataVal['model']), ucfirst($v3['id']), $dataVal['name'], true);
								}
							}
							//第四層??
							if (isset($v3['children'])) {
								foreach ($v3['children'] as $key4 => $v4) {
									$Blade['children'][$key2]['children'][$key3]['children'][$key4]['data'] = json_decode($leon_database[array_search(lcfirst($v4['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
									$Blade['children'][$key2]['children'][$key3]['children'][$key4]['other_data'] = json_decode($leon_database[array_search(lcfirst($v4['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
									$Blade['children'][$key2]['children'][$key3]['children'][$key4]['model'] = ucfirst($v4['id']);
									$Blade['children'][$key2]['children'][$key3]['children'][$key4]['label'] = $v4['contenta'];
								}
							}
						}
					}
				}
			}
			$CreateModel->CreateBlade($Blade['model'], $Blade);
		}
	}
}

//建立basic_cms_menu
$web_key = 0;
$Menu_key = 0;
$parent_id = 0;
$cms_child_key = 0;
$cms_parent_key = 0;

$Controllers_array = [];
foreach ($MenuData as $key => $val) {
	//建立KEY選單
	$basic_web_key = $db->query(sprintf("SELECT * FROM basic_web_key where title = %s and leon_key = %s", SQLStr($val['contenta'], "text"), SQLStr($key, "int")))->fetch(PDO::FETCH_ASSOC);
	if (empty($basic_web_key)) {
		$Panda_Class->_INSERT("basic_web_key", array("leon_key" => $key, "is_setting" => 0, "title" => $val['contenta'], "keyval" => "", "branch_id" => $web_key_branch_id, "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00'));

		$basic_web_key = $db->query(sprintf("SELECT * FROM basic_web_key where title = %s and leon_key = %s", SQLStr($val['contenta'], "text"), SQLStr($key, "int")))->fetch(PDO::FETCH_ASSOC);
	}
	$web_key = $basic_web_key['id'];
	$leon_key = $basic_web_key['leon_key'];
	//最上層===========================================
	//建立主選單
	if (!empty($val['id'])) {
		$CMS_parent = json_decode($leon_database[array_search(lcfirst($val['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
		$CMS_Other = json_decode($leon_database[array_search(lcfirst($val['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
		$locale_type = (isset($CMS_Other['isShareModel']) && $CMS_Other['isShareModel'] == "0") ? 1 : 0;
		$is_hr = (isset($CMS_Other['isHr']) && $CMS_Other['isHr'] == "1") ? 1 : 0;
		$SQL_data = array("is_hr" => $is_hr, "locale_type" => $locale_type, "leon_key" => $leon_key, "w_rank" => 1, "is_active" => 1, "branch_id" => $branch_id, "is_parent" => 0, "title" => $val['contenta'], "key_id" => $web_key, "type" => 2, "is_content" => $CMS_Other['is_onepage'], "parent_id" => 0, "has_auth" => 0, "model" => ucfirst($val['id']), "view_prefix" => ucfirst($val['id']), "options_group" => "", "json_group" => "", "use_type" => 2, "created_at" => "2019-09-22 00:00:00", "updated_at" => "2019-09-22 00:00:00");
		$Controllers_array[] = ['Model' => ucfirst($val['id']), 'children' => []];
	} else {
		$SQL_data = array("is_hr" => 0, "locale_type" => 0, "leon_key" => $leon_key, "w_rank" => 1, "is_active" => 1, "branch_id" => $branch_id, "is_parent" => 0, "title" => $val['contenta'], "key_id" => $web_key, "type" => 1, "is_content" => 0, "parent_id" => 0, "has_auth" => 0, "model" => "", "view_prefix" => "", "options_group" => "", "json_group" => "", "use_type" => 2, "created_at" => "2019-09-22 00:00:00", "updated_at" => "2019-09-22 00:00:00");
	}
	$basic_cms_menu = $db->query(sprintf("SELECT * FROM basic_cms_menu where title = %s and model = %s and leon_key = %s", SQLStr($val['contenta'], "text"), SQLStr($SQL_data['model'], "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);

	if (empty($basic_cms_menu)) {
		$Panda_Class->_INSERT("basic_cms_menu", $SQL_data);
		$Panda_Class->_INSERT("basic_cms_menu_use", $SQL_data);
		$basic_cms_menu = $db->query(sprintf("SELECT * FROM basic_cms_menu where title = %s and model = %s and leon_key = %s", SQLStr($val['contenta'], "text"), SQLStr($SQL_data['model'], "text"), SQLStr($leon_key, "text")))->fetch(PDO::FETCH_ASSOC);
	} else {
		$SQL_data += ['id' => $basic_cms_menu['id']];
		$Panda_Class->_UPDATE("basic_cms_menu", $SQL_data);
		$Panda_Class->_UPDATE("basic_cms_menu_use", $SQL_data);
	}
	$Menu_key = $basic_cms_menu['id'];

	//找選單Model來源
	if (!empty($val['id'])) {
		$CMS_parent = json_decode($leon_database[array_search(lcfirst($val['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
		$CMS_Other = json_decode($leon_database[array_search(lcfirst($val['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
		foreach ($CMS_parent as $CMS_parentVal) {

			if (in_array($CMS_parentVal['formtype'], ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
				if (ucfirst($CMS_parentVal['model']) != "") {
					if (strpos(ucfirst($CMS_parentVal['model']), 'CC_') === false) {
						$with_m = ($CMS_parentVal['son'] == 'true') ? "GetMainData" : "";
						$with_db = ($CMS_parentVal['son'] == 'true') ? "get_main_data" : "";
						$with_name = ($CMS_parentVal['son'] == 'true') ? "w_title" : "";

						$parent_option = (ucfirst($CMS_parentVal['model']) == 'Member') ? 'w_title,w_mobile' : 'w_title,title,tw_title,order_no';
						$t_array = array("leon_key" => $leon_key, "menu_id" => $Menu_key, "parent_model" => ucfirst($CMS_parentVal['model']), "parent_key" => "", "parent_option" => $parent_option, "foreign_key" => "id", "with_m" => $with_m, "with_db" => $with_db, "with_name" => $with_name, "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
						$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($web_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
						if (empty($basic_cms_parent)) {
							$Panda_Class->_INSERT("basic_cms_parent", $t_array);
							$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($web_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
						} else {
							$t_array += ['id' => $basic_cms_parent['id']];
							$Panda_Class->_UPDATE("basic_cms_parent", $t_array);
						}
						$cms_parent_key = $basic_cms_parent['id'];
					} else {
						$with_name = 'title';
					}
					$CreateModel->CreateExcelRelatedFunction(["model" => $val['id'], "field" => $CMS_parentVal['name'], "from_model" => ucfirst($CMS_parentVal['model']), "from_field" => $with_name]);
				}
			}
		}
		//判斷是否有sontable		
		$sontable = [];
		if (isset($val['children'])) {
			foreach ($val['children'] as $key2 => $v2) {
				//basic_cms_child
				//找選單Model來源
				$CMS_parent = json_decode($leon_database[array_search(lcfirst($v2['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
				foreach ($CMS_parent as $CMS_parentVal) {
					if (in_array($CMS_parentVal['formtype'], ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
						if (ucfirst($CMS_parentVal['model']) != "") {
							if (strpos(ucfirst($CMS_parentVal['model']), 'CC_') === false) {
								$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
								$with_m = ($CMS_parentVal['son'] == 'true') ? "GetMainData" : "";
								$with_db = ($CMS_parentVal['son'] == 'true') ? "get_main_data" : "";
								$with_name = ($CMS_parentVal['son'] == 'true') ? "w_title" : "";
								$parent_option = (ucfirst($CMS_parentVal['model']) == 'Member') ? 'w_title,w_mobile' : 'w_title,title,tw_title,order_no';
								$t_array = array("leon_key" => $leon_key, "menu_id" => $Menu_key, "parent_model" => ucfirst($CMS_parentVal['model']), "parent_key" => "", "parent_option" => $parent_option, "foreign_key" => "id", "with_m" => $with_m, "with_db" => $with_db, "with_name" => $with_name, "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
								if (empty($basic_cms_parent)) {
									$Panda_Class->_INSERT("basic_cms_parent", $t_array);
									$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
								} else {
									$t_array += ['id' => $basic_cms_parent['id']];
									$Panda_Class->_UPDATE("basic_cms_parent", $t_array);
								}
								$cms_parent_key = $basic_cms_parent['id'];
							} else {
								$with_name = 'title';
							}
							$CreateModel->CreateExcelRelatedFunction(["model" => $v2['id'], "field" => $CMS_parentVal['name'], "from_model" => ucfirst($CMS_parentVal['model']), "from_field" => $with_name]);
						}
					}
				}
				//$cms_child_key++;
				$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_child where menu_id = %s and child_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($v2['id']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
				$t_array = array("leon_key" => $leon_key, "menu_id" => $Menu_key, "is_rank" => '1', "child_model" => ucfirst($v2['id']), "child_key" => "parent_id", "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
				if (empty($basic_cms_parent)) {
					$Panda_Class->_INSERT("basic_cms_child", $t_array);
					$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_child where menu_id = %s and child_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($v2['id']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
				} else {
					$t_array += ['id' => $basic_cms_parent['id']];
					$Panda_Class->_UPDATE("basic_cms_child", $t_array);
				}
				$cms_child_key = $basic_cms_parent['id'];
				//判斷是否有treetable
				$treetable = [];
				if (isset($v2['children'])) {
					foreach ($v2['children'] as $key3 => $v3) {
						//basic_cms_child_son
						$t_array = array("leon_key" => $leon_key, "is_active" => '1', "model_name" => ucfirst($v3['id']), "child_id" => $cms_child_key, "child_key" => "second_id", "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
						$basic_cms_child_son = $db->query(sprintf("SELECT * FROM basic_cms_child_son where child_id = %s and model_name = %s and leon_key = %s", SQLStr($cms_child_key, "int"), SQLStr(ucfirst($v3['id']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
						if (empty($basic_cms_child_son)) {
							$Panda_Class->_INSERT("basic_cms_child_son", $t_array);
						} else {
							$t_array += ['id' => $basic_cms_child_son['id']];
							$Panda_Class->_UPDATE("basic_cms_child_son", $t_array);
						}

						$CMS_parent = json_decode($leon_database[array_search(lcfirst($v3['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
						foreach ($CMS_parent as $CMS_parentVal) {
							if (in_array($CMS_parentVal['formtype'], ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
								if (ucfirst($CMS_parentVal['model']) != "") {
									//$cms_parent_key++;
									if (strpos(ucfirst($CMS_parentVal['model']), 'CC_') === false) {
										$with_m = ($CMS_parentVal['son'] == 'true') ? "GetMainData" : "";
										$with_db = ($CMS_parentVal['son'] == 'true') ? "get_main_data" : "";
										$with_name = ($CMS_parentVal['son'] == 'true') ? "w_title" : "";
										$t_array = array("leon_key" => $leon_key, "menu_id" => $Menu_key, "parent_model" => ucfirst($CMS_parentVal['model']), "parent_key" => "", "parent_option" => $parent_option, "foreign_key" => "id", "with_m" => $with_m, "with_db" => $with_db, "with_name" => $with_name, "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
										$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
										if (empty($basic_cms_parent)) {
											$Panda_Class->_INSERT("basic_cms_parent", $t_array);
											$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
										} else {
											$t_array += ['id' => $basic_cms_parent['id']];
											$Panda_Class->_UPDATE("basic_cms_parent", $t_array);
										}
										$cms_parent_key = $basic_cms_parent['id'];
									} else {
										$with_name = 'title';
									}
									$CreateModel->CreateExcelRelatedFunction(["model" => $v3['id'], "field" => $CMS_parentVal['name'], "from_model" => ucfirst($CMS_parentVal['model']), "from_field" => $with_name]);
								}
							}
						}
						$treetable[] = ['Model' => ucfirst($v3['id'])];
					}
				}
				$sontable[] = ['Model' => ucfirst($v2['id']), 'children' => $treetable];
			}
		}
		$Controllers_array[] = ['Model' => ucfirst($val['id']), 'children' => $sontable];
	}

	//最上層===========================================
	if (empty($val['id']) && isset($val['children'])) {
		$parent_id = $Menu_key;
		$has_ShareModel = false;
		foreach ($val['children'] as $level1) {
			//找選單Model來源
			$CMS_parent = json_decode($leon_database[array_search(lcfirst($level1['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
			$CMS_Other = json_decode($leon_database[array_search(lcfirst($level1['id']), array_column($leon_database, 'db_name'))]['other_data'], true);
			$locale_type = (isset($CMS_Other['isShareModel']) && $CMS_Other['isShareModel'] == "0") ? 1 : 0;
			$is_hr = (isset($CMS_Other['isHr']) && $CMS_Other['isHr'] == "1") ? 1 : 0;
			if ($locale_type) {
				$has_ShareModel = true;
			}
			$SQL_data = array("is_hr" => $is_hr, "locale_type" => $locale_type, "leon_key" => $leon_key, "w_rank" => 1, "is_active" => 1, "branch_id" => $branch_id, "is_parent" => 0, "title" => $level1['contenta'], "key_id" => $web_key, "type" => 3, "is_content" => $CMS_Other['is_onepage'], "parent_id" => $parent_id, "has_auth" => 0, "model" => ucfirst($level1['id']), "view_prefix" => ucfirst($level1['id']), "options_group" => "", "json_group" => "", "use_type" => 2, "created_at" => "2019-09-22 00:00:00", "updated_at" => "2019-09-22 00:00:00");
			$basic_cms_menu = $db->query(sprintf("SELECT * FROM basic_cms_menu where title = %s and model = %s and leon_key = %s", SQLStr($level1['contenta'], "text"), SQLStr($SQL_data['model'], "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
			if (empty($basic_cms_menu)) {
				$Panda_Class->_INSERT("basic_cms_menu", $SQL_data);
				$Panda_Class->_INSERT("basic_cms_menu_use", $SQL_data);
				$basic_cms_menu = $db->query(sprintf("SELECT * FROM basic_cms_menu where title = %s and model = %s and leon_key = %s", SQLStr($level1['contenta'], "text"), SQLStr($SQL_data['model'], "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
			} else {
				$SQL_data += ['id' => $basic_cms_menu['id']];
				$Panda_Class->_UPDATE("basic_cms_menu", $SQL_data);
				$Panda_Class->_UPDATE("basic_cms_menu_use", $SQL_data);
			}
			$Menu_key = $basic_cms_menu['id'];
			foreach ($CMS_parent as $CMS_parentVal) {
				if (in_array($CMS_parentVal['formtype'], ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
					if (ucfirst($CMS_parentVal['model']) != "") {
						if (strpos(ucfirst($CMS_parentVal['model']), 'CC_') === false) {
							$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
							$with_m = ($CMS_parentVal['son'] == 'true') ? "GetMainData" : "";
							$with_db = ($CMS_parentVal['son'] == 'true') ? "get_main_data" : "";
							$with_name = ($CMS_parentVal['son'] == 'true') ? "w_title" : "";
							$parent_option = (ucfirst($CMS_parentVal['model']) == 'Member') ? 'w_title,w_mobile' : 'w_title,title,tw_title,order_no';
							$t_array = array(
								"leon_key" => $leon_key,
								"menu_id" => $Menu_key,
								"parent_model" => ucfirst($CMS_parentVal['model']),
								"parent_key" => "",
								"parent_option" => $parent_option,
								"foreign_key" => "id",
								"with_m" => $with_m,
								"with_db" => $with_db,
								"with_name" => $with_name,
								"created_at" => '2019-09-22 00:00:00',
								"updated_at" => '2019-09-22 00:00:00'
							);
							if (empty($basic_cms_parent)) {
								$Panda_Class->_INSERT("basic_cms_parent", $t_array);
								$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
							} else {
								$t_array += ['id' => $basic_cms_parent['id']];
								$Panda_Class->_UPDATE("basic_cms_parent", $t_array);
							}
							$cms_parent_key = $basic_cms_parent['id'];
						} else {
							$with_name = 'title';
						}
						$CreateModel->CreateExcelRelatedFunction(["model" => $level1['id'], "field" => $CMS_parentVal['name'], "from_model" => ucfirst($CMS_parentVal['model']), "from_field" => $with_name]);
					}
				}
			}
			//判斷是否有sontable		
			$sontable = [];
			if (isset($level1['children'])) {
				foreach ($level1['children'] as $key2 => $v2) {
					//找選單Model來源
					$CMS_parent = json_decode($leon_database[array_search(lcfirst($v2['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
					foreach ($CMS_parent as $CMS_parentVal) {
						if (in_array($CMS_parentVal['formtype'], ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
							if (ucfirst($CMS_parentVal['model']) != "") {
								//$cms_parent_key++;
								if (strpos(ucfirst($CMS_parentVal['model']), 'CC_') === false) {
									$with_m = ($CMS_parentVal['son'] == 'true') ? "GetMainData" : "";
									$with_db = ($CMS_parentVal['son'] == 'true') ? "get_main_data" : "";
									$with_name = ($CMS_parentVal['son'] == 'true') ? "w_title" : "";
									$parent_option = (ucfirst($CMS_parentVal['model']) == 'Member') ? 'w_title,w_mobile' : 'w_title,title,tw_title,order_no';

									$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
									$t_array = array("leon_key" => $leon_key, "menu_id" => $Menu_key, "parent_model" => ucfirst($CMS_parentVal['model']), "parent_key" => "", "parent_option" => $parent_option, "foreign_key" => "id", "with_m" => $with_m, "with_db" => $with_db, "with_name" => $with_name, "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
									if (empty($basic_cms_parent)) {
										$Panda_Class->_INSERT("basic_cms_parent", $t_array);
										$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
									} else {
										$t_array += ['id' => $basic_cms_parent['id']];
										$Panda_Class->_UPDATE("basic_cms_parent", $t_array);
									}
									$cms_parent_key = $basic_cms_parent['id'];
								} else {
									$with_name = 'title';
								}
								$CreateModel->CreateExcelRelatedFunction(["model" => $v2['id'], "field" => $CMS_parentVal['name'], "from_model" => ucfirst($CMS_parentVal['model']), "from_field" => $with_name]);
							}
						}
					}
					$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_child where menu_id = %s and child_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($v2['id']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
					$t_array = array("leon_key" => $leon_key, "menu_id" => $Menu_key, "is_rank" => '1', "child_model" => ucfirst($v2['id']), "child_key" => "parent_id", "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
					if (empty($basic_cms_parent)) {
						$Panda_Class->_INSERT("basic_cms_child", $t_array);
						$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_child where menu_id = %s and child_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($v2['id']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
					} else {
						$t_array += ['id' => $basic_cms_parent['id']];
						$Panda_Class->_UPDATE("basic_cms_child", $t_array);
					}
					$cms_child_key = $basic_cms_parent['id'];
					//判斷是否有treetable
					$treetable = [];
					if (isset($v2['children'])) {
						foreach ($v2['children'] as $key3 => $v3) {
							$t_array = array("leon_key" => $leon_key, "is_active" => '1', "model_name" => ucfirst($v3['id']), "child_id" => $cms_child_key, "child_key" => "second_id", "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
							$basic_cms_child_son = $db->query(sprintf("SELECT * FROM basic_cms_child_son where child_id = %s and model_name = %s and leon_key = %s", SQLStr($cms_child_key, "int"), SQLStr(ucfirst($v3['id']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
							if (empty($basic_cms_child_son)) {
								$Panda_Class->_INSERT("basic_cms_child_son", $t_array);
							} else {
								$t_array += ['id' => $basic_cms_child_son['id']];
								$Panda_Class->_UPDATE("basic_cms_child_son", $t_array);
							}
							$CMS_parent = json_decode($leon_database[array_search(lcfirst($v3['id']), array_column($leon_database, 'db_name'))]['db_data'], true);
							foreach ($CMS_parent as $CMS_parentVal) {
								if (in_array($CMS_parentVal['formtype'], ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
									if (ucfirst($CMS_parentVal['model']) != "") {
										if (strpos(ucfirst($CMS_parentVal['model']), 'CC_') === false) {
											//$cms_parent_key++;
											$with_m = ($CMS_parentVal['son'] == 'true') ? "GetMainData" : "";
											$with_db = ($CMS_parentVal['son'] == 'true') ? "get_main_data" : "";
											$with_name = ($CMS_parentVal['son'] == 'true') ? "w_title" : "";
											$parent_option = (ucfirst($CMS_parentVal['model']) == 'Member') ? 'w_title,w_mobile' : 'w_title,title,tw_title,order_no';
											$t_array = array("leon_key" => $leon_key, "menu_id" => $Menu_key, "parent_model" => ucfirst($CMS_parentVal['model']), "parent_key" => "", "parent_option" => $parent_option, "foreign_key" => "id", "with_m" => $with_m, "with_db" => $with_db, "with_name" => $with_name, "created_at" => '2019-09-22 00:00:00', "updated_at" => '2019-09-22 00:00:00');
											$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
											if (empty($basic_cms_parent)) {
												$Panda_Class->_INSERT("basic_cms_parent", $t_array);
												$basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent where menu_id = %s and parent_model = %s and leon_key = %s", SQLStr($Menu_key, "int"), SQLStr(ucfirst($CMS_parentVal['model']), "text"), SQLStr($leon_key, "int")))->fetch(PDO::FETCH_ASSOC);
											} else {
												$t_array += ['id' => $basic_cms_parent['id']];
												$Panda_Class->_UPDATE("basic_cms_parent", $t_array);
											}
											$cms_parent_key = $basic_cms_parent['id'];
										} else {
											$with_name = 'title';
										}
										$CreateModel->CreateExcelRelatedFunction(["model" => $v3['id'], "field" => $CMS_parentVal['name'], "from_model" => ucfirst($CMS_parentVal['model']), "from_field" => $with_name]);
									}
								}
							}
							$treetable[] = ['Model' => ucfirst($v3['id'])];
						}
					}
					$sontable[] = ['Model' => ucfirst($v2['id']), 'children' => $treetable];
				}
			}
			$Controllers_array[] = ['Model' => ucfirst($level1['id']), 'children' => $sontable];
		}
		if ($has_ShareModel) {
			$SQL_data = array("locale_type" => 1, "id" => $parent_id);
			$Panda_Class->_UPDATE("basic_cms_menu", $SQL_data);
			$Panda_Class->_UPDATE("basic_cms_menu_use", $SQL_data);
		}
	}
}

//自動更新權限
$db->query(sprintf("UPDATE `basic_cms_menu` SET `use_id`=`id` WHERE 1"));
$leon_database_data = $db->query(sprintf("SELECT * FROM basic_cms_menu"))->fetchAll(PDO::FETCH_ASSOC);
$Cmsrole = [];
foreach ($leon_database_data as $val) {
	$Cmsrole[$val['id']] = ";1;1;1;1";
}
$Cmsrole = json_encode($Cmsrole, JSON_UNESCAPED_UNICODE);
$db->exec(sprintf("UPDATE basic_cms_role SET roles = %s", SQLStr($Cmsrole, "text")));

exit();
