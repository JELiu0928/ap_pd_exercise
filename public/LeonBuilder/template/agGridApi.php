<?php
//$db_item = $Panda_Class->_SELECT("db_item");
class DB_Class
{
	function __construct($pdo)
	{
		$this->db = $pdo;
	}
	public function _Create($db_name, $db_data, $db_note)
	{
		$langArray = [
			"tw" => [
				"title" => "繁體中文",
				"en_title" => "Traditional Chinese",
				"abb_title" => "繁中",
				"key" => "tw"
			],
			"cn" => [
				"title" => "簡體中文",
				"en_title" => "Simplified Chinese",
				"abb_title" => "簡中",
				"key" => "cn"
			],
			"en" => [
				"title" => "英文",
				"en_title" => "English",
				"abb_title" => "英文",
				"key" => "en"
			],
			"jp" => [
				"title" => "日文",
				"en_title" => "Japanese",
				"abb_title" => "日文",
				"key" => "jp"
			],
			"kr" => [
				"title" => "韓文",
				"en_title" => "Korean",
				"abb_title" => "韓文",
				"key" => "kr",
			],
		];
		//建立資料表
		$Sql = "CREATE TABLE `" . $db_name . "` (
`id` INT NOT NULL AUTO_INCREMENT COMMENT '編號',
`fantasy_hide` int NOT NULL COMMENT '後台隱藏不顯示',
`w_rank` int NOT NULL COMMENT '排序',
`is_reviewed` int NOT NULL COMMENT '審核',
`is_preview` int NOT NULL COMMENT '預覽',
`is_visible` int NOT NULL COMMENT '顯示',
`wait_del` int NOT NULL COMMENT '申請刪除',
`branch_id` int NOT NULL COMMENT '分館',
`parent_id` int NOT NULL COMMENT '上層',
`second_id` int NOT NULL COMMENT '上層',
`temp_url` varchar(120) NOT NULL COMMENT '預設soe網址',";
		foreach ($db_data as $data) {
			if ($data['type'] == "內容") {
				$Sql .= "`is_swiper` int NOT NULL COMMENT '圖片是否為輪播',";
				$Sql .= "`is_slice` int NOT NULL COMMENT '內文色塊是否對齊邊際',";
				$Sql .= "`img_row` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'x1' COMMENT '多圖並排x1x2x3x4x5',";
				$Sql .= "`img_firstbig` int NOT NULL COMMENT '第一順位img強制100放大',";
				$Sql .= "`img_merge` int NOT NULL COMMENT '隱藏img間距及Description',";
				$Sql .= "`img_size` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img比例設定x11x34x43x169',";
				$Sql .= "`img_flex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img垂直對其設定',";
				$Sql .= "`description_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'img描述文字顏色設定',";
				$Sql .= "`description_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,";
				$Sql .= "`article_style` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落樣式',";
				$Sql .= "`article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',";
				$Sql .= "`article_sub_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落副標題',";
				$Sql .= "`article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',";
				$Sql .= "`instagram_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,";
				$Sql .= "`article_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'article 內容區塊底色設定',";
				$Sql .= "`article_flex` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'article 內容區塊垂直對其方式設定',";
				$Sql .= "`full_img` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊底圖設定',";
				$Sql .= "`full_img_rwd` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull 內容區塊RWD底圖設定',";
				$Sql .= "`full_size` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFull內容區塊尺寸設定sml',";
				$Sql .= "`full_box_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'typeFullBoxBox區塊顏色設定',";
				$Sql .= "`h_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主標題文字顏色設定',";
				$Sql .= "`h_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '主標題文字對齊方式設定',";
				$Sql .= "`subh_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小標題文字顏色設定',";
				$Sql .= "`subh_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '小標題文字對齊方式設定',";
				$Sql .= "`p_color` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文文字顏色設定',";
				$Sql .= "`p_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '內文文字對齊方式設定',";
				$Sql .= "`button` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'button文字',";
				$Sql .= "`button_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'button連結',";
				$Sql .= "`accessible_txt` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '無障礙標題',";
				$Sql .= "`link_type` int NOT NULL COMMENT '連結開啟方式',";
				$Sql .= "`button_color` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,";
				$Sql .= "`button_color_hover` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,";
				$Sql .= "`button_textcolor` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'buttton文字顏色設定',";
				$Sql .= "`button_align` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,";
				$Sql .= "`swiper_num` int NOT NULL DEFAULT '1' COMMENT '一次出現幾張圖片',";
				$Sql .= "`swiper_autoplay` int NOT NULL COMMENT '是否開啟自動播放',";
				$Sql .= "`swiper_loop` int NOT NULL,";
				$Sql .= "`swiper_arrow` int NOT NULL COMMENT '是否啟用左右箭頭按鈕',";
				$Sql .= "`swiper_nav` int NOT NULL COMMENT '是否啟用下方切換選單',";
				//多語系
				$Sql .= "`tw_article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',";
				$Sql .= "`tw_article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',";
				$Sql .= "`en_article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',";
				$Sql .= "`en_article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',";
				$Sql .= "`jp_article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',";
				$Sql .= "`jp_article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',";
				$Sql .= "`cn_article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',";
				$Sql .= "`cn_article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',";
				$Sql .= "`kr_article_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落標題',";
				$Sql .= "`kr_article_inner` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '段落內文',";
			} elseif ($data['type'] == "內容圖片") {
				$Sql .= "`title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '圖片標題',";
				$Sql .= "`image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,";
				$Sql .= "`w_type` int NOT NULL,";
				$Sql .= "`video` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,";
				$Sql .= "`video_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '影片截圖(避免影片本身沒有預覽圖)',";
				$Sql .= "`video_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,";
				$Sql .= "`content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,";
				//v2
				// $Sql .= "`title` varchar(255) NOT NULL COMMENT '圖片標題',";
				// $Sql .= "`image` varchar(30) NOT NULL,";
				// $Sql .= "`type` int NOT NULL,";
				// $Sql .= "`video` text NOT NULL,";
				// $Sql .= "`sw_title` varchar(255) NOT NULL COMMENT 'swiper標題',";
				// $Sql .= "`video_type` varchar(255) NOT NULL,";
				// $Sql .= "`content` text NOT NULL,";
			} elseif ($data['type'] == "SEO" || $data['type'] == "SEO無網址") {
				if (isset($data['lang']) && $data['lang'] == 'true') {
					foreach ($langArray as $val) {
						$Sql .= "`" . $val['key'] . "_seo_title` text NOT NULL COMMENT 'seo title',";
						$Sql .= "`" . $val['key'] . "_seo_h1` text NOT NULL COMMENT 'seo h1',";
						$Sql .= "`" . $val['key'] . "_seo_keyword` text NOT NULL COMMENT 'seo meta keyword',";
						$Sql .= "`" . $val['key'] . "_seo_meta` text NOT NULL COMMENT 'seo meta description',";
						$Sql .= "`" . $val['key'] . "_seo_og_title` text NOT NULL COMMENT '社群分享標題',";
						$Sql .= "`" . $val['key'] . "_seo_description` text NOT NULL COMMENT '社群分享敘述',";
						$Sql .= "`" . $val['key'] . "_seo_structured` text NOT NULL COMMENT '結構化標籤',";
					}
				}
				// $Sql .= "`url_name` text NOT NULL COMMENT 'seo-自訂網址',";
				// $Sql .= "`seo_title` text NOT NULL COMMENT 'seo-網頁標題',";
				// $Sql .= "`seo_keyword` text NOT NULL COMMENT 'seo-Meta關鍵字',";
				// $Sql .= "`seo_meta` text NOT NULL COMMENT 'seo-Meta描述',";
				// $Sql .= "`seo_ga` text NOT NULL COMMENT 'seo-網頁GA碼',";
				// $Sql .= "`seo_gtm` text NOT NULL COMMENT 'seo-網頁GTM碼',";
				// $Sql .= "`seo_img` text NOT NULL COMMENT 'seo-分享縮圖管理',";
				// $Sql .= "`seo_description` text NOT NULL COMMENT 'seo-分享顯示文字',";
				// $Sql .= "`seo_structured` text NOT NULL COMMENT 'seo-結構化標籤程式碼',";		
			} else {
				if ($data['type'] == "json") {
					$Sqltxt = "json NOT NULL COMMENT";
				}
				if ($data['type'] == "text") {
					$Sqltxt = "text NOT NULL COMMENT";
				}
				if ($data['type'] == "date") {
					$Sqltxt = "date NOT NULL COMMENT";
				}
				if ($data['type'] == "datetime") {
					$Sqltxt = "datetime NOT NULL COMMENT";
				}
				if ($data['type'] == "double") {
					$Sqltxt = "double NOT NULL COMMENT";
				}
				if ($data['type'] == "int") {
					$Sqltxt = "int NOT NULL COMMENT";
				}
				if ($data['type'] == "bigint") {
					$Sqltxt = "BIGINT NOT NULL COMMENT";
				}
				if ($data['type'] == "varchar") {
					$Sqltxt = "varchar(100) NOT NULL COMMENT";
				}

				if ($data['formtype'] == "imageGroup_all" || $data['formtype'] == "imageGroup_3size" || $data['formtype'] == "imageGroup_array") {
					if ($data['formtype'] == "imageGroup_array") {
						$array = explode(",", $data['other']);
						foreach ($array as $key => $val) {
							$temp_key = ($key == 0) ? '' : $key;
							$Sql .= "`" . $data['name'] . $temp_key . "` " . $Sqltxt . " '" . $val . "',";
						}
					} else {
						$Sql .= "`" . $data['name'] . "` " . $Sqltxt . " '" . $data['note'] . "_電腦尺寸',";
						$Sql .= "`" . $data['name'] . "_t` " . $Sqltxt . " '" . $data['note'] . "_平板尺寸',";
						$Sql .= "`" . $data['name'] . "_m` " . $Sqltxt . " '" . $data['note'] . "_手機尺寸',";
					}
				} else {
					//多語系
					if (isset($data['lang']) && $data['lang'] == 'true') {
						foreach ($langArray as $val) {
							$Sql .= "`" . $val['key'] . '_' . $data['name'] . "` " . $Sqltxt . " '" . $val['abb_title'] . ' - ' . $data['note'] . "',";
						}
					} else {
						if ($data['formtype'] == "textInputTarget") {
							$Sql .= "`" . $data['name'] . "_target` int NOT NULL COMMENT '新視窗開啟',";
						}
						if ($data['formtype'] == "textInputTargetAcc") {
							$Sql .= "`" . $data['name'] . "_target` int NOT NULL COMMENT '新視窗開啟',";
							$Sql .= "`" . $data['name'] . "_acc` text NOT NULL COMMENT '無障礙內容',";
						}
						if ($data['name'] != 'second_id' && $data['name'] != 'parent_id' && $data['name'] != 'url_name') {
							$Sql .= "`" . $data['name'] . "` " . $Sqltxt . " '" . $data['note'] . "',";
						}
					}
				}
			}
		}
		$Sql .= "`url_name` text NOT NULL COMMENT '網址名稱',";

		$Sql .= "`seo_title` text NOT NULL COMMENT 'seo title',";
		$Sql .= "`seo_h1` text NOT NULL COMMENT 'seo h1',";
		$Sql .= "`seo_keyword` text NOT NULL COMMENT 'seo meta keyword',";
		$Sql .= "`seo_meta` text NOT NULL COMMENT 'seo meta description',";
		$Sql .= "`seo_og_title` text NOT NULL COMMENT '社群分享標題',";
		$Sql .= "`seo_description` text NOT NULL COMMENT '社群分享敘述',";
		$Sql .= "`seo_img` text NOT NULL COMMENT '社群分享圖片',";
		$Sql .= "`seo_ga` text NOT NULL COMMENT 'ga code',";
		$Sql .= "`seo_gtm` text NOT NULL COMMENT 'gtm code',";
		$Sql .= "`seo_pixel` text NOT NULL COMMENT 'fb pixel',";
		$Sql .= "`seo_structured` text NOT NULL COMMENT '結構化標籤',";

		$Sql .= "`updated_at` datetime NOT NULL COMMENT '更新時間',
	`created_at` datetime NOT NULL COMMENT '建立時間',
	`create_id` int NOT NULL COMMENT '建立者',
	PRIMARY KEY (`id`)
	) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT = \"" . $db_note . "\"";
		return $Sql;
	}
	public function _CreateNull($db_name, $db_data, $tableList = [])
	{
		foreach ($db_data as $key => $data) {
			if (!in_array($data['name'], array_column($tableList, 'name'))) {
				$Sqltxt = '';
				if ($data['type'] == "json") {
					$Sqltxt = "json NOT NULL COMMENT";
				}
				if ($data['type'] == "text") {
					$Sqltxt = "text NOT NULL COMMENT";
				}
				if ($data['type'] == "date") {
					$Sqltxt = "date NOT NULL COMMENT";
				}
				if ($data['type'] == "datetime") {
					$Sqltxt = "datetime NOT NULL COMMENT";
				}
				if ($data['type'] == "double") {
					$Sqltxt = "double NOT NULL COMMENT";
				}
				if ($data['type'] == "int") {
					$Sqltxt = "int NOT NULL COMMENT";
				}
				if ($data['type'] == "varchar") {
					$Sqltxt = "varchar(100) NOT NULL COMMENT";
				}
				if ($key == 0) {
					$Sql = "ALTER TABLE `" . $db_name . "` ADD `" . $data['name'] . "` " . $Sqltxt . " '" . $data['note'] . "' AFTER `temp_url`;";
				} else {
					$Sql = "ALTER TABLE `" . $db_name . "` ADD `" . $data['name'] . "` " . $Sqltxt . " '" . $data['note'] . "' AFTER `" . $db_data[$key - 1]['name'] . "`;";
				}
				$this->db->exec(sprintf($Sql));
			}
		}
		return $Sql;
	}
}
$DB_Class = new DB_Class($db);