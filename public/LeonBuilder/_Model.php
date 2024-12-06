<?php
class CreateModel
{
	function __construct($pdo)
	{
		$this->db = $pdo;
	}
	//Model的scopeisVisible / 審核或不用審核
	public function Leon_show()
	{
		$leon_menu = $this->db->query(sprintf("SELECT * FROM leon_menu WHERE id = 1"))->fetch(PDO::FETCH_ASSOC);
		$setting_data = json_decode($leon_menu['w_setting'], true);
		$Leon_show = ($setting_data['is_review']) ? 'is_reviewed' : 'is_visible';
		return $Leon_show;
	}
	public function Leon_other_domain()
	{
		$leon_menu = $this->db->query(sprintf("SELECT * FROM leon_menu WHERE id = 1"))->fetch(PDO::FETCH_ASSOC);
		$setting_data = json_decode($leon_menu['w_setting'], true);
		$sub_domain = explode(",", $setting_data['sub_domain']);
		$sub_domain_str = '';
		foreach ($sub_domain as $key => $val) {
			if ((count($sub_domain) - 1) == $key) {
				$sub_domain_str .= '"' . $val . '."';
			} else {
				$sub_domain_str .= '"' . $val . '.",';
			}
		}
		return '[' . $sub_domain_str . '],""';
	}

	public function CreateThreetableUnit($Maker, $data, $Model)
	{
		$disabled = ($data['disable'] == 'true') ? 'disabled' : '';
		$tip = '';
		if ($data['tip'] != 'x') {
			//$tip = (!empty($data['tip'])) ? $data['tip'] : "請填寫" . $data['note'];
			$tip = (!empty($data['tip'])) ? $data['tip'] : "";
		}
		if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "colorPicker", "datePicker", "filePicker", "radio_area"])) {
			if ($data['tip'] != 'x') {
				//$tip = (!empty($data['tip'])) ? $data['tip'] : "請選擇" . $data['note'];
				$tip = (!empty($data['tip'])) ? $data['tip'] : "";
			}
		}
		if (in_array($Maker, ["textInput", "textArea"])) {
			if ($data['name'] == "url_name") {
				$tip = '網址名稱僅能輸入<a style="color:#ff0000;">英文、數字、中文，符號僅支援 _-，且不可有相同名稱</a>';
			} else {
				if (empty($tip)) {
					$tip = ($Maker == 'textInput') ? "單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。" : "可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。";
					if (strpos($data['name'], 'url') !== false) {
						$tip = '請輸入完整網址，若須於新視窗開啟網址，請啟用於新視窗開啟';
					}
				}
			}
		}
		if (!empty($disabled)) {
			$tip = '';
		}

		$tableSet = "";
		if ($data['type'] == "內容圖片") {
			$tableSet .= '
						[
							\'type\' => \'textInput\',
							\'title\' => \'名稱\',
							\'value\' => \'title\',
							\'tip\' => \'單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。\'
						],
						[
							\'type\' => \'image_group\',
							\'title\' => \'圖片\',
							\'tip\' => \'圖片建議尺寸: 最大寬1040px。\',
							\'image_array\' => 
							[
								[
									\'title\' => \'圖片\',
									\'value\' => \'image\',
									\'set_size\' => \'no\',
								]
							]
						],
						[
							\'type\' => \'textInput\',
							\'title\' => \'Youtube影片代碼\',
							\'value\' => \'video\',
							\'tip\' => \'在欄位內輸入Youtube影片網址V後面的英文數字。<br>例：https://www.youtube.com/watch?v=abcdef，請輸入abcdef。\'
						],
';
		}
		if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
			if ($data['model'] == "") {
				$this->CreateOptionFunction($Model . '_' . $data['name'], $data['note']);
				$Model = 'OptionFunction::' . $Model . '_' . $data['name'] . '()';
			} else {
				//判斷有無使用同一個自訂function
				if (strpos($data['model'], 'CC_') !== false) {
					$this->CreateOptionFunction(str_replace("CC_", "", $data['model']), $data['note']);
					$Model = 'OptionFunction::' . str_replace("CC_", "", $data['model']) . '()';
				} else {
					$Model = '$options[\'' . ucfirst($data['model']) . '\']';
				}
			}

			$tableSet .= '
						[
							\'type\' => \'' . $Maker . '\',
							\'value\' => \'' . $data['name'] . '\',
							\'title\' => \'' . $data['note'] . '\',
							\'options\' => ' . $Model . ',
							\'tip\'  => \'' . $tip . '\',
							\'default\' => \'\',
							\'disabled\'  => \'' . $disabled . '\',
						],';
		}
		if (in_array($Maker, ["textInput", "textArea", "colorPicker", "radio_btn", "numberInput", "datePicker", "filePicker"])) {
			if ($Maker == "textInput" || $Maker == "textArea") {
				if ($data['name'] == "url_name") {
					$tip = '網址名稱僅能輸入<a style="color:#ff0000;">英文、數字、中文，符號僅支援 _-，且不可有相同名稱</a>';
				} else {
					if (empty($tip)) {
						$tip = ($Maker == 'textInput') ? "單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。" : "可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。";
					}
				}
			}
			if (!empty($disabled)) {
				$tip = '';
			}
			$tableSet .= '
						[
							\'type\' => \'' . $Maker . '\',
							\'value\' => \'' . $data['name'] . '\',
							\'title\' => \'' . $data['note'] . '\',
							\'tip\'  => \'' . $tip . '\',
							\'default\' => \'\',
							\'disabled\'  => \'' . $disabled . '\',
							\'class\'  => \'' . ((in_array($data['type'], ['int', 'double', 'float'])) ? 'onlyInt' : '') . '\',
						],';
		}
		if ($Maker == "imageGroup") {
			$tableSet .= '
						[
							\'type\' => \'image_group\',
							\'title\' => \'' . $data['note'] . '\',
							\'image_array\' =>
							[
								[
									\'title\' => \'' . $data['note'] . '\',
									\'value\' => \'' . $data['name'] . '\',
									\'set_size\' => \'yes\',
									\'width\' => \'400\',
									\'height\' => \'370\',
								],
							],
							\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
						],';
		}
		if ($Maker == "imageGroup_all") {
			$tableSet .= '
						[
							\'type\' => \'image_group\',
							\'title\' => \'' . $data['note'] . '\',
							\'image_array\' =>
							[
								[
									\'title\' => \'電腦版圖片\',
									\'value\' => \'' . $data['name'] . '\',
									\'set_size\' => \'yes\',
									\'width\' => \'400\',
									\'height\' => \'370\',
								],
								[
									\'title\' => \'手機版圖片\',
									\'value\' => \'' . $data['name'] . '_m\',
									\'set_size\' => \'yes\',
									\'width\' => \'400\',
									\'height\' => \'370\',
								],
							],
							\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
						],';
		}
		if ($Maker == "imageGroup_3size") {
			$tableSet .= '
						[
							\'type\' => \'image_group\',
							\'title\' => \'' . $data['note'] . '\',
							\'image_array\' =>
							[
								[
									\'title\' => \'電腦版圖片\',
									\'value\' => \'' . $data['name'] . '\',
									\'set_size\' => \'yes\',
									\'width\' => \'400\',
									\'height\' => \'370\',
								],
								[
									\'title\' => \'平板版圖片\',
									\'value\' => \'' . $data['name'] . '_t\',
									\'set_size\' => \'yes\',
									\'width\' => \'400\',
									\'height\' => \'370\',
								],
								[
									\'title\' => \'手機版圖片\',
									\'value\' => \'' . $data['name'] . '_m\',
									\'set_size\' => \'yes\',
									\'width\' => \'400\',
									\'height\' => \'370\',
								],
							],
							\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
						],';
		}
		if ($Maker == "imageGroup_array") {
			$array = explode(",", $data['other']);
			$imageGroup_array_str = '';
			foreach ($array as $key => $val) {
				$temp_key = ($key == 0) ? '' : $key;
				$imageGroup_array_str .= '								[
					\'title\' => \'' . $val . '\',
					\'value\' => \'' . $data['name'] . $temp_key . '\',
					\'set_size\' => \'yes\',
					\'width\' => \'400\',
					\'height\' => \'370\',
				],';
			}
			$tableSet .= '
						[
							\'type\' => \'image_group\',
							\'title\' => \'' . $data['note'] . '\',
							\'image_array\' =>
							[
								' . $imageGroup_array_str . '
							],
							\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
						],';
		}
		return $tableSet;
	}
	public function CreateSontableUnit($Maker, $data, $Model)
	{
		$disabled = ($data['disable'] == 'true') ? 'disabled' : '';
		$tip = '';
		if ($data['tip'] != 'x') {
			//$tip = (!empty($data['tip'])) ? $data['tip'] : "請填寫" . $data['note'];
			$tip = (!empty($data['tip'])) ? $data['tip'] : "";
		}
		if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "colorPicker", "datePicker", "filePicker", "radio_area"])) {
			//$tip = (!empty($data['tip'])) ? $data['tip'] : "請選擇" . $data['note'];
			$tip = (!empty($data['tip'])) ? $data['tip'] : "";
		}
		if (in_array($Maker, ["textInput", "textInputTarget", "textInputTargetAcc", "textArea"])) {
			if ($data['name'] == "url_name") {
				$tip = '網址名稱僅能輸入<a style="color:#ff0000;">英文、數字、中文，符號僅支援 _-，且不可有相同名稱</a>';
			} else {
				if (empty($tip)) {
					$tip = ($Maker == 'textInput') ? "單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。" : "可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。";
				}
				if (strpos($data['name'], 'url') !== false) {
					$tip = '請輸入完整網址，若須於新視窗開啟網址，請啟用於新視窗開啟';
				}
			}
		}
		if (!empty($disabled)) {
			$tip = '';
		}
		$tableSet = "";

		//如果是文章編輯器
		if ($data['type'] == "內容") {
			$tableSet .= '
					//內容元件												
					[
						\'type\' => \'select2\',
						\'title\' => \'段落樣式\',
						\'value\' => \'article_style\',
						\'default\' => \'\',
						\'options\' =>article_options()[\'Style\'],
					],
					[
						\'type\' => \'select2\',
						\'title\' => \'多圖並排 (僅多張圖片時使用)\',
						\'value\' => \'is_row\',
						\'default\' => \'\',
						\'options\' =>[
										\'0\'=> ["title" => "不使用並排","key" => \'0\'],
										\'--row2\'=> ["title" => "兩張圖並排","key" => \'--row2\'],
										\'--row3\'=> ["title" => "三張圖並排(僅基本段落/文章置上下使用)","key" => \'--row3\'],
										\'--row4\'=> ["title" => "四張圖並排(僅基本段落/文章置上下使用)","key" => \'--row4\'],
										\'--row5\'=> ["title" => "五張圖並排(僅基本段落/文章置上下使用)","key" => \'--row5\'],
									],
					],
					[
						\'type\' => \'radio_btn\',
						\'title\' => \'是否使用拼圖模式\',
						\'value\' => \'is_ex\',
						\'tip\' => \'使用後圖片會以拼接方式呈現。\'
						// when it open , class add \' --ex\'
					],
					[
						\'type\' => \'radio_btn\',
						\'title\' => \'是否圖片置中\',
						\'value\' => \'is_vcenter\',
						\'tip\' => \'使用後對所有併排圖片做垂直置中設定。 (僅基本段落/文章置上下使用)\'
						// when it open , class add \' --vcenter\'
					],
					[
						\'type\' => \'radio_btn\',
						\'title\' => \'是否限制圖片寬度\',
						\'value\' => \'is_wauto\',
						\'tip\' => \'使用後限制圖片寬度為500px。 (僅基本段落/文章置上下使用)\'
						// when it open , class add \' --wauto\'
					],
					[
						\'type\' => \'textInput\',
						\'title\' => \'段落名稱 (a標籤)\',
						\'value\' => \'article_title\',
						\'tip\' => \'單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。\'
					],
					[
						\'type\' => \'textArea\',
						\'title\' => \'段落內容\',
						\'value\' => \'article_inner\',
						\'tip\' => \'可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Shift+Enter，輸入區域可拖曳右下角縮放。\'
					],';
		} else {
			if ($Maker == "lang_textInput" || $Maker == "lang_textArea") {
				if (empty($tip)) {
					$tip = ($Maker == 'lang_textInput') ? "單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。" : "可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。";
				}
				$tableSet .= '
				[
					\'type\' => \'' . $Maker . '\',
					\'value\' => \'' . $data['name'] . '\',
					\'title\' => \'' . $data['note'] . '\',
					\'tip\'  => \'' . $tip . '\',
					\'default\' => \'\',
					\'auto\' => true,	
					\'disabled\'  => \'' . $disabled . '\',
				],';
			}
			if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
				if ($data['model'] == "") {
					$this->CreateOptionFunction($Model . '_' . $data['name'], $data['note']);
					$Model = 'OptionFunction::' . $Model . '_' . $data['name'] . '()';
				} else {
					//判斷有無使用同一個自訂function
					if (strpos($data['model'], 'CC_') !== false) {
						$this->CreateOptionFunction(str_replace("CC_", "", $data['model']), $data['note']);
						$Model = 'OptionFunction::' . str_replace("CC_", "", $data['model']) . '()';
					} else {
						$Model = '$options[\'' . ucfirst($data['model']) . '\']';
					}
				}
				$tableSet .= '
					[
						\'type\' => \'' . $Maker . '\',
						\'value\' => \'' . $data['name'] . '\',
						\'title\' => \'' . $data['note'] . '\',
						\'options\' => ' . $Model . ',
						\'tip\'  => \'' . $tip . '\',
						\'default\' => \'\',
						\'auto\' => true,	
						\'disabled\'  => \'' . $disabled . '\',
					],';
			}
			if (in_array($Maker, ["textInput", "textInputTarget", "textInputTargetAcc", "textArea", "colorPicker", "radio_btn", "numberInput", "datePicker", "filePicker"])) {
				if ($Maker == "textInput" || $Maker == "textArea") {
					if ($data['name'] == "url_name") {
						$tip = '網址名稱僅能輸入<a style="color:#ff0000;">英文、數字、中文，符號僅支援 _-，且不可有相同名稱</a>';
					} else {
						if (empty($tip)) {
							$tip = ($Maker == 'textInput') ? "單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。" : "可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。";
						}
						if (strpos($data['name'], 'url') !== false) {
							$tip = '請輸入完整網址，若須於新視窗開啟網址，請啟用於新視窗開啟';
						}
					}
				}
				if (!empty($disabled)) {
					$tip = '';
				}
				$other_txt = '';
				if ($Maker == "textInputTarget") {
					$other_txt .= PHP_EOL . '						\'target\'=>[\'name\'=>\'' . $data['name'] . '_target\'],';
				}
				if ($Maker == "textInputTargetAcc") {
					$other_txt .= PHP_EOL . '						\'target\'=>[\'name\'=>\'' . $data['name'] . '_target\'],';
					$other_txt .= PHP_EOL . '						\'accessible\'=>[\'name\'=>\'' . $data['name'] . '_acc\'],';
				}
				$tableSet .= '
					[
						\'type\' => \'' . $Maker . '\',
						\'value\' => \'' . $data['name'] . '\',
						\'title\' => \'' . $data['note'] . '\',
						\'tip\'  => \'' . $tip . '\',
						\'default\' => \'\',
						\'auto\' => true,	
						\'disabled\'  => \'' . $disabled . '\',
						\'class\'  => \'' . ((in_array($data['type'], ['int', 'double', 'float'])) ? 'onlyInt' : '') . '\',' . $other_txt . '
					],';
			}
			if ($Maker == "imageGroup") {
				$tableSet .= '
					[
						\'type\' => \'image_group\',
						\'title\' => \'' . $data['note'] . '\',
						\'image_array\' =>
						[
							[
								\'title\' => \'' . $data['note'] . '\',
								\'value\' => \'' . $data['name'] . '\',
								\'set_size\' => \'yes\',
								\'width\' => \'400\',
								\'height\' => \'370\',
							],
						],
						\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
					],';
			}
			if ($Maker == "imageGroup_all") {
				$tableSet .= '
					[
						\'type\' => \'image_group\',
						\'title\' => \'' . $data['note'] . '\',
						\'image_array\' =>
						[
							[
								\'title\' => \'電腦版圖片\',
								\'value\' => \'' . $data['name'] . '\',
								\'set_size\' => \'yes\',
								\'width\' => \'400\',
								\'height\' => \'370\',
							],
							[
								\'title\' => \'手機版圖片\',
								\'value\' => \'' . $data['name'] . '_m\',
								\'set_size\' => \'yes\',
								\'width\' => \'400\',
								\'height\' => \'370\',
							],
						],
						\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
					],';
			}
			if ($Maker == "imageGroup_3size") {
				$tableSet .= '
					[
						\'type\' => \'image_group\',
						\'title\' => \'' . $data['note'] . '\',
						\'image_array\' =>
						[
							[
								\'title\' => \'電腦版圖片\',
								\'value\' => \'' . $data['name'] . '\',
								\'set_size\' => \'yes\',
								\'width\' => \'400\',
								\'height\' => \'370\',
							],
							[
								\'title\' => \'平板版圖片\',
								\'value\' => \'' . $data['name'] . '_t\',
								\'set_size\' => \'yes\',
								\'width\' => \'400\',
								\'height\' => \'370\',
							],
							[
								\'title\' => \'手機版圖片\',
								\'value\' => \'' . $data['name'] . '_m\',
								\'set_size\' => \'yes\',
								\'width\' => \'400\',
								\'height\' => \'370\',
							],
						],
						\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
					],';
			}
			if ($Maker == "imageGroup_array") {
				$array = explode(",", $data['other']);
				$imageGroup_array_str = '';
				foreach ($array as $key => $val) {
					$temp_key = ($key == 0) ? '' : $key;
					$imageGroup_array_str .= '								[
						\'title\' => \'' . $val . '\',
						\'value\' => \'' . $data['name'] . $temp_key . '\',
						\'set_size\' => \'yes\',
						\'width\' => \'400\',
						\'height\' => \'370\',
					],';
				}
				$tableSet .= '
							[
								\'type\' => \'image_group\',
								\'title\' => \'' . $data['note'] . '\',
								\'image_array\' =>
								[
									' . $imageGroup_array_str . '
								],
								\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
							],';
			}
			if ($data['type'] == 'SEO' && $data['note'] == 'SEO') {
				$tableSet .= '
				[
					\'type\' => \'textInput\',
					\'title\' => \'seo-自訂網址\',
					\'value\' => \'url_name\',
					\'tip\' => \'網址名稱僅能輸入<a style="color:#ff0000;">英文、數字、中文，符號僅支援 _-，且不可有相同名稱</a>\'
				],
				[
					\'type\' => \'textInput\',
					\'title\' => \'seo-網頁標題\',
					\'value\' => \'seo_title\',
					\'tip\' => \'上限100字元，單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法。\'
				],
				[
					\'type\' => \'textInput\',
					\'title\' => \'seo-Meta關鍵字\',
					\'value\' => \'seo_keyword\',
					\'tip\' => \'上限300字元，內容支援HTML，不支援CSS、JQ、JS等語法。\'
				],
				[
					\'type\' => \'textArea\',
					\'title\' => \'seo-Meta描述\',
					\'value\' => \'seo_meta\',
					\'tip\' => \'上限300字元，內容支援HTML，不支援CSS、JQ、JS等語法。\'
				],
				[
					\'type\' => \'textArea\',
					\'title\' => \'seo-分享顯示文字\',
					\'value\' => \'seo_description\',
					\'tip\' => \'上限300字元，內容支援HTML，不支援CSS、JQ、JS等語法。\'
				],
				[
					\'type\' => \'image_group\',
					\'title\' => \'seo-分享縮圖管理\',
					\'image_array\' =>
					[
						[
							\'title\' => \'seo-分享縮圖管理\',
							\'value\' => \'seo_img\',
							\'set_size\' => \'yes\',
							\'width\' => \'400\',
							\'height\' => \'370\',
						],
					],
					\'tip\' => \'建議尺寸：寬高不超過1200px<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
				],
				[
					\'type\' => \'textInput\',
					\'title\' => \'seo-網頁GA碼\',
					\'value\' => \'seo_ga\',
					\'tip\' => \'輸入編號即可，不需要整段程式碼。\'
				],
				[
					\'type\' => \'textInput\',
					\'title\' => \'seo-網頁GTM碼\',
					\'value\' => \'seo_gtm\',
					\'tip\' => \'輸入編號即可，不需要整段程式碼。\'
				],
				[
					\'type\' => \'textArea\',
					\'title\' => \'seo-結構化標籤程式碼\',
					\'value\' => \'seo_json\',
					\'tip\' => \'填入整段結構化標籤Json格式。\'
				],
				';
			}
		}
		return $tableSet;
	}
	public function CreateUnit($Maker, $data, $Model)
	{
		$disabled = ($data['disable'] == 'true') ? 'disabled' : '';
		$tip = '';
		if ($data['tip'] != 'x') {
			//$tip = (!empty($data['tip'])) ? $data['tip'] : "請填寫" . $data['note'];
			$tip = (!empty($data['tip'])) ? $data['tip'] : "";
		}
		if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "colorPicker", "datePicker", "filePicker", "radio_area"])) {
			if ($data['tip'] != 'x') {
				//$tip = (!empty($data['tip'])) ? $data['tip'] : "請選擇" . $data['note'];
				$tip = (!empty($data['tip'])) ? $data['tip'] : "";
			}
		}
		if (in_array($Maker, ["textInput", "textInputTarget", "textInputTargetAcc", "textArea", "lang_textInput", "lang_textArea"])) {
			if ($data['name'] == "url_name") {
				$tip = '網址名稱僅能輸入<a style="color:#ff0000;">英文、數字、中文，符號僅支援 _-，且不可有相同名稱</a>';
			} else {
				if (empty($tip)) {
					$tip = ($Maker == 'textInput' || $Maker == 'lang_textInput') ? "單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。" : "可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。";
					if (strpos($data['name'], 'url') !== false) {
						$tip = '請輸入完整網址，若須於新視窗開啟網址，請啟用於新視窗開啟';
					}
				}
			}
		}
		if (!empty($disabled)) {
			$tip = '';
		}
		$tableSet = "";
		if ($Maker == "lang_textInput" || $Maker == "lang_textArea") {
			$tableSet .= '
	{{UnitMaker::' . $Maker . '([
		\'model\' => $model,
		\'name\' => \'' . $data['name'] . '\',
		\'title\' => \'' . $data['note'] . '\',
		\'tip\' => \'' . $tip . '\',
		\'value\' => $data,
		\'disabled\'  => \'' . $disabled . '\',
	])}}';
		}

		if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {

			if ($data['model'] == "") {
				$this->CreateOptionFunction($Model . '_' . $data['name'], $data['note']);
				$Model = 'OptionFunction::' . $Model . '_' . $data['name'] . '()';
			} else {
				//判斷有無使用同一個自訂function
				if (strpos($data['model'], 'CC_') !== false) {
					$this->CreateOptionFunction(str_replace("CC_", "", $data['model']), $data['note']);
					$Model = 'OptionFunction::' . str_replace("CC_", "", $data['model']) . '()';
				} else {
					$Model = '$options[\'' . ucfirst($data['model']) . '\']';
				}
			}
			$tableSet .= '
	{{UnitMaker::' . $Maker . '([
		\'name\' => $model.\'[' . $data['name'] . ']\',
		\'title\' => \'' . $data['note'] . '\',
		\'value\' => ( !empty($data[\'' . $data['name'] . '\']) )? $data[\'' . $data['name'] . '\'] : \'\',
		\'options\' => ' . $Model . ',
		\'tip\'  => \'' . $tip . '\',
		\'disabled\'  => \'' . $disabled . '\',
	])}}';
		}
		if (in_array($Maker, ["textInput", "textInputTarget", "textInputTargetAcc", "textArea", "colorPicker", "radio_btn", "numberInput", "datePicker", "dateRange", "filePicker", "inputHidden"])) {
			if ($Maker == "textInput" || $Maker == "textArea") {
				if ($data['name'] == "url_name") {
					$tip = '網址名稱僅能輸入<a style="color:#ff0000;">英文、數字、中文，符號僅支援 _-，且不可有相同名稱</a>';
				} else {
					if (empty($tip)) {
						$tip = ($Maker == 'textInput') ? "單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。" : "可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。";
						if (strpos($data['name'], 'url') !== false) {
							$tip = '請輸入完整網址，若須於新視窗開啟網址，請啟用於新視窗開啟';
						}
					}
				}
			}
			if (!empty($disabled)) {
				$tip = '';
			}

			$other = $data['other'] ?? '';
			$other_arr = explode(",", $other);
			$other_txt = '';
			if ($Maker == "textInputTarget") {
				$other_txt .= PHP_EOL . '\'target\'=>[\'name\'=>$model.\'[' . $data['name'] . '_target]\',\'value\'=>$data[\'' . $data['name'] . '_target\'] ?? \'\'],';
			}
			if ($Maker == "textInputTargetAcc") {
				$other_txt .= PHP_EOL . '\'target\'=>[\'name\'=>$model.\'[' . $data['name'] . '_target]\',\'value\'=>$data[\'' . $data['name'] . '_target\'] ?? \'\'],';
				$other_txt .= PHP_EOL . '\'accessible\'=>[\'name\'=>$model.\'[' . $data['name'] . '_acc]\',\'value\'=>$data[\'' .  $data['name'] . '_acc\'] ?? \'\'],';
			}
			foreach ($other_arr as $other_arrVal) {
				$array = explode("=", $other_arrVal);
				if ($array[0] == 'target') {
					$other_txt .= PHP_EOL . '\'target\'=>[\'name\'=>$model.\'[' . $array[1] . ']\',\'value\'=>$data[\'' . $array[1] . '\'] ?? \'\'],';
				}
				if ($array[0] == 'accessible') {
					$other_txt .= PHP_EOL . '\'accessible\'=>[\'name\'=>$model.\'[' . $array[1] . ']\',\'value\'=>$data[\'' . $array[1] . '\'] ?? \'\'],';
				}
			}


			$tableSet .= '
	{{UnitMaker::' . $Maker . '([
		\'name\' => $model.\'[' . $data['name'] . ']\',
		\'title\' => \'' . $data['note'] . '\',
		\'tip\' => \'' . $tip . '\',
		\'value\' => ( !empty($data[\'' . $data['name'] . '\']) )? $data[\'' . $data['name'] . '\'] : \'\',
		\'disabled\'  => \'' . $disabled . '\',
		\'class\'  => \'' . ((in_array($data['type'], ['int', 'double', 'float'])) ? 'onlyInt' : '') . '\',' . $other_txt . '
	])}}';
		}
		if ($Maker == "imageGroup") {
			$tableSet .= '
	{{UnitMaker::imageGroup([
		\'title\' => \'' . $data['note'] . '\',
		\'image_array\' =>
		[
			[
				\'name\' => $model.\'[' . $data['name'] . ']\',
				\'title\' => \'' . $data['note'] . '\',
				\'value\' => ( !empty($data[\'' . $data['name'] . '\']) )? $data[\'' . $data['name'] . '\'] : \'\',
				\'set_size\' => \'yes\',
				\'width\' => \'400\',
				\'height\' => \'370\',
			],
		],
		
		\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
	])}}';
		}
		if ($Maker == "imageGroup_all") {
			$tableSet .= '
	{{UnitMaker::imageGroup([
		\'title\' => \'' . $data['note'] . '\',
		\'image_array\' =>
		[
			[
				\'name\' => $model.\'[' . $data['name'] . ']\',
				\'title\' => \'電腦版圖片\',
				\'value\' => ( !empty($data[\'' . $data['name'] . '\']) )? $data[\'' . $data['name'] . '\'] : \'\',
				\'set_size\' => \'yes\',
				\'width\' => \'400\',
				\'height\' => \'370\',
			],
			[
				\'name\' => $model.\'[' . $data['name'] . '_m]\',
				\'title\' => \'手機版圖片\',
				\'value\' => ( !empty($data[\'' . $data['name'] . '_m\']) )? $data[\'' . $data['name'] . '_m\'] : \'\',
				\'set_size\' => \'yes\',
				\'width\' => \'400\',
				\'height\' => \'370\',
			],
		],
		\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
	])}}';
		}
		if ($Maker == "imageGroup_3size") {
			$tableSet .= '
	{{UnitMaker::imageGroup([
		\'title\' => \'' . $data['note'] . '\',
		\'image_array\' =>
		[
			[
				\'name\' => $model.\'[' . $data['name'] . ']\',
				\'title\' => \'電腦版圖片\',
				\'value\' => ( !empty($data[\'' . $data['name'] . '\']) )? $data[\'' . $data['name'] . '\'] : \'\',
				\'set_size\' => \'yes\',
				\'width\' => \'400\',
				\'height\' => \'370\',
			],
			[
				\'name\' => $model.\'[' . $data['name'] . '_t]\',
				\'title\' => \'平板版圖片\',
				\'value\' => ( !empty($data[\'' . $data['name'] . '_t\']) )? $data[\'' . $data['name'] . '_t\'] : \'\',
				\'set_size\' => \'yes\',
				\'width\' => \'400\',
				\'height\' => \'370\',
			],
			[
				\'name\' => $model.\'[' . $data['name'] . '_m]\',
				\'title\' => \'手機版圖片\',
				\'value\' => ( !empty($data[\'' . $data['name'] . '_m\']) )? $data[\'' . $data['name'] . '_m\'] : \'\',
				\'set_size\' => \'yes\',
				\'width\' => \'400\',
				\'height\' => \'370\',
			],
		],
		\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
	])}}';
		}
		if ($Maker == "imageGroup_array") {
			$array = explode(",", $data['other']);
			$imageGroup_array_str = '';
			foreach ($array as $key => $val) {
				$temp_key = ($key == 0) ? '' : $key;
				$imageGroup_array_str .= '					[
					\'name\' => $model.\'[' . $data['name'] . $temp_key . ']\',
					\'title\' => \'' . $val . '\',
					\'value\' => ( !empty($data[\'' . $data['name'] . $temp_key . '\']) )? $data[\'' . $data['name'] . $temp_key . '\'] : \'\',
					\'set_size\' => \'yes\',
					\'width\' => \'400\',
					\'height\' => \'370\',
				],';
			}
			$tableSet .= '
			{{UnitMaker::imageGroup([
				\'title\' => \'' . $data['note'] . '\',
				\'image_array\' =>
				[
					' . $imageGroup_array_str . '
				],
				\'tip\' => \'' . (!empty($data['tip']) ? '建議尺寸：' . $data['tip'] . '<br>' : '') . '圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
			])}}';
		}
		if ($data['type'] == 'SEO無網址') {
			if (isset($data['lang']) && $data['lang'] == 'true') {
				$tableSet .= '@include(\'Fantasy.cms.includes.lang_seo_form\')';
			} else {
				$tableSet .= '@include(\'Fantasy.cms.includes.seo_form\')';
			}
		}
		if ($data['type'] == 'SEO') {
			$tableSet .= '
	{{UnitMaker::textInput([
		\'name\' => $model.\'[url_name]\',
		\'title\' => \'網址名稱\',
		\'tip\' => \'此商品項目網址名稱，可使用中文，<a style="color:#ff0000;">不可留白有空格、不可重複、不可使用特殊符號如「 . ;　/　?　:　@　=　&　<　>　"　#　%　{　}　|　\　^　~　[　]　`　」</a>\',
		\'value\' => ( !empty($data[\'url_name\']) )? $data[\'url_name\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::textInput([
		\'name\' => $model.\'[seo_title]\',
		\'title\' => \'網頁名稱\',
		\'tip\' => \'上限100字元，單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法。\',
		\'value\' => ( !empty($data[\'seo_title\']) )? $data[\'seo_title\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::textInput([
		\'name\' => $model.\'[seo_keyword]\',
		\'title\' => \'meta keyword\',
		\'tip\' => \'上限300字元，內容支援HTML，不支援CSS、JQ、JS等語法。\',
		\'value\' => ( !empty($data[\'seo_keyword\']) )? $data[\'seo_keyword\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::textArea([
		\'name\' => $model.\'[seo_meta]\',
		\'title\' => \'meta description\',
		\'tip\' => \'上限300字元，內容支援HTML，不支援CSS、JQ、JS等語法。\',
		\'value\' => ( !empty($data[\'seo_meta\']) )? $data[\'seo_meta\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::textInput([
		\'name\' => $model.\'[seo_og_title]\',
		\'title\' => \'社群分享標題\',
		\'tip\' => \'上限100字元，內容支援HTML，不支援CSS、JQ、JS等語法。\',
		\'value\' => ( !empty($data[\'seo_og_title\']) )? $data[\'seo_og_title\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::textArea([
		\'name\' => $model.\'[seo_description]\',
		\'title\' => \'社群分享敘述\',
		\'tip\' => \'上限300字元，內容支援HTML，不支援CSS、JQ、JS等語法。\',
		\'value\' => ( !empty($data[\'seo_description\']) )? $data[\'seo_description\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::imageGroup([
		\'title\' => \'社群分享圖片\',
		\'image_array\' =>
		[
			[
				\'name\' => $model.\'[seo_img]\',
				\'title\' => \'社群分享圖片\',
				\'value\' => ( !empty($data[\'seo_img\']) )? $data[\'seo_img\'] : \'\',
				\'set_size\' => \'yes\',
				\'width\' => \'400\',
				\'height\' => \'370\',
			],
		],
		\'tip\' => \'建議尺寸：寬高不超過1200px<br>圖片解析度限制:72DPI，檔案格式限定:JPG、PNG、GIF。\'
	])}}
	{{UnitMaker::textInput([
		\'name\' => $model.\'[seo_ga]\',
		\'title\' => \'ga code\',
		\'tip\' => \'輸入編號即可，不需要整段程式碼。\',
		\'value\' => ( !empty($data[\'seo_ga\']) )? $data[\'seo_ga\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::textInput([
		\'name\' => $model.\'[seo_gtm]\',
		\'title\' => \'gtm code\',
		\'tip\' => \'輸入編號即可，不需要整段程式碼。\',
		\'value\' => ( !empty($data[\'seo_gtm\']) )? $data[\'seo_gtm\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::textInput([
		\'name\' => $model.\'[seo_pixel]\',
		\'title\' => \'fb pixel\',
		\'tip\' => \'輸入編號即可，不需要整段程式碼。\',
		\'value\' => ( !empty($data[\'seo_pixel\']) )? $data[\'seo_pixel\'] : \'\',
		\'disabled\'  => \'\',
	])}}
	{{UnitMaker::textArea([
		\'name\' => $model.\'[seo_json]\',
		\'title\' => \'結構化標籤\',
		\'tip\' => \'填入整段結構化標籤Json格式。\',
		\'value\' => ( !empty($data[\'seo_json\']) )? $data[\'seo_json\'] : \'\',
		\'disabled\'  => \'\',
	])}}';
		}
		return $tableSet;
	}
	public function CreateBladeIndex($data, $Old_menuList)
	{
		$Old_menuList = [];
		$MenuListArr = [];
		$formKeySet = 0;
		//如果第一筆就是分頁
		$MenuList = '"MainForm"=>"基本設定",';

		$MenuListArr[] = ['MainForm', '基本設定'];
		if (isset($data['data'][0]['tab']) && preg_replace('/\s(?=)/', '', $data['data'][0]['tab']) != "") {
			$MenuList = '';
			$MenuListArr = [];
		}

		$seo_tab = [];
		$have_mainform = false;
		foreach ($data['data'] as $val) {
			if (preg_replace('/\s(?=)/', '', $val['tab']) != "") {
				if (strpos(strtolower($val['tab']), 'seo') !== false) {
					// $seo_tab[] = '"Form_' . $formKeySet . '"=>"' . $val['tab'] . '",';
					$seo_tab[] = ['Form_' . $formKeySet, $val['tab']];
					$formKeySet++;
				} else {
					$MenuList .= '"Form_' . $formKeySet . '"=>"' . $val['tab'] . '",';
					$MenuListArr[] = ['Form_' . $formKeySet, $val['tab']];
					$formKeySet++;
				}
			}
			if ($val['formtype'] != "") {
				$have_mainform = true;
			}
		}

		$MenuList = ($have_mainform) ? $MenuList : '';

		if (isset($data['children'])) {
			foreach ($data['children'] as $Key => $sontable) {
				$MenuList .= '"Form_' . $formKeySet . '"=>"' . $sontable['label'] . '",';
				$MenuListArr[] = ['Form_' . $formKeySet, $sontable['label']];
				$formKeySet++;
			}
		}
		if (isset($data['other_data']['isSeo']) && $data['other_data']['isSeo']) {
			$MenuListArr[] = ['Form_seo', 'seo設定'];
		}
		foreach ($seo_tab as $val) {
			// $MenuList .= $val;
			$MenuListArr[] = $val;
		}
		$isDelete_set = ($data['other_data']['isDelete'] == "1") ? 'false' : '$isDelete';

		$isDelete 	= (isset($data['other_data']['isDelete']) && $data['other_data']['isDelete']) ? 'false' : 'true';
		$isCreate 	= (isset($data['other_data']['isCreate']) && $data['other_data']['isCreate']) ? 'false' : 'true';
		$isExport 	= (isset($data['other_data']['isExport']) && $data['other_data']['isExport']) ? 'false' : 'true';
		$isClone 	= (isset($data['other_data']['isClone']) && $data['other_data']['isClone']) ? 'false' : 'true';

		//選單
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

		$table = '@php
	$menuList = [
		' . $temp_list . '
	];
	$isEdit = $isEdit;
	$isDelete = ' . $isDelete_set . ';
	$isCreate = $isCreate;
	$isSearch = true;
	$isClone = ' . $isClone . ';
	$isExport = ' . $isExport . ';
	$exportName = $exportName;
	$isContentClass = ($isContent) ? \'isContent\':\'\';
@endphp
@extends(\'Fantasy.template\')
@section(\'bodySetting\', \'fixed-header cms_theme uiv2 \'.$isContentClass)
  @section(\'css\')
    <link href="/vender/assets/css/cms_style.css" rel="stylesheet" type="text/css">
  @stop
  @section(\'css_back\')
  @stop
@section(\'content\')
	<!-- mainNav 系統主選單 -->
	@include(\'Fantasy.includes.sidebar\')
	<!-- mainNav 系統主選單 -->
	@include(\'Fantasy.cms.includes.cms_index_content\')  

	<!-- 圖片 / 影片管理 燈箱 -->
	@include(\'Fantasy.cms.includes.partImg_lightbox\')
	<!-- 圖片 / 影片管理 燈箱 -->
 
  @section(\'script\')
    <script type="text/javascript" src="/vender/backend/js/cms/cms.js"></script>
  @stop
  @section(\'script_back\')
    <script type="text/javascript" src="/vender/backend/js/cms/cms_unit.js"></script>
    @if ($isContent==1)
      <script>
		$(".main-table").hide();
		$(".trash").hide();
		$(".editContentArea").css({"width": "100%", "position": "static"});
		$(".editContentArea .hiddenArea_frame").css({"height": "calc(100vh - 110px)", "position": "relative", "width": "100%"});
		@if(!empty($data))
			$(\'.open_builder:first\').click();
		@else
			$(\'.createBtn:first-child\').click();
		@endif
      </script>
    @endif
	@if(isset($data_id) && !empty($data_id))
	<script>
		$(\'.open_builder:first\').click();
	</script>
	@endif
  @stop
@stop
';
		return $table;
	}
	public function CreateBladeSearch($data, $Model)
	{
		$leon_menu = $this->db->query(sprintf("SELECT * FROM leon_menu WHERE id = 1"))->fetch(PDO::FETCH_ASSOC);
		$setting_data = json_decode($leon_menu['w_setting'], true);

		$tableSet = '';
		foreach ($data as $val) {
			if ($val['search'] == "true") {
				$Maker = $val['formtype'];
				if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
					if ($val['model'] == "") {
						$this->CreateOptionFunction($Model . '_' . $val['name'], $val['note']);
						$Model = 'OptionFunction::' . $Model . '_' . $val['name'] . '()';
					} else {
						//判斷有無使用同一個自訂function
						if (strpos($val['model'], 'CC_') !== false) {
							$this->CreateOptionFunction(str_replace("CC_", "", $val['model']), $val['note']);
							$Model = 'OptionFunction::' . str_replace("CC_", "", $val['model']) . '()';
						} else {
							$Model = '$options[\'' . ucfirst($val['model']) . '\']';
						}
					}
					$tableSet .= '
						{{UnitMaker::' . $Maker . '([
							\'name\' => \'' . $val['name'] . '\',
							\'title\' => \'' . $val['note'] . '\',
							\'value\' => ( !empty($data[\'' . $val['name'] . '\']) )? $data[\'' . $val['name'] . '\'] : \'\',
							\'options\' => ' . $Model . ',
							\'search\' => true,
						])}}';
				}
				if (in_array($Maker, ["textInput", "textArea", "colorPicker", "radio_btn", "numberInput", "datePicker", "filePicker", "inputHidden"])) {
					$Maker = ($Maker == 'datePicker') ? 'dateRange' : $Maker;
					$tableSet .= '
					{{UnitMaker::' . $Maker . '([
						\'name\' => \'' . $val['name'] . '\',
						\'title\' => \'' . $val['note'] . '\',
						\'value\' => \'\',
						\'search\' => true,
					])}}';
				}
			}
		}
		if ($setting_data['is_review']) {
			$tableSet .= '
	{{UnitMaker::radio_btn([
		\'name\' => \'wait_del\',
		\'title\' => \'申請刪除\',
		\'value\' => \'\',
		\'search\' => true,
	])}}';
			$tableSet .= '
		{{UnitMaker::radio_btn([
			\'name\' => \'is_visible\',
			\'title\' => \'發佈審核\',
			\'value\' => \'\',
			\'search\' => true,
		])}}';
		}
		return $tableSet;
	}
	public function CreateBladeBatch($data, $Model)
	{
		$leon_menu = $this->db->query(sprintf("SELECT * FROM leon_menu WHERE id = 1"))->fetch(PDO::FETCH_ASSOC);
		$setting_data = json_decode($leon_menu['w_setting'], true);

		$tableSet = '';
		foreach ($data as $val) {
			$val['batch'] = $val['batch'] ?? "";
			if ($val['batch'] == "true") {
				$Maker = $val['formtype'];

				$tip = '';
				if ($val['tip'] != 'x') {
					$tip = (!empty($val['tip'])) ? $val['tip'] : "";
				}
				if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "colorPicker", "datePicker", "filePicker", "radio_area"])) {
					if ($val['tip'] != 'x') {
						$tip = (!empty($val['tip'])) ? $val['tip'] : "";
					}
				}
				if (in_array($Maker, ["textInput", "textInputTarget", "textInputTargetAcc", "textArea"])) {
					if ($val['name'] == "url_name") {
						$tip = '網址名稱僅能輸入<a style="color:#ff0000;">英文、數字、中文，符號僅支援 _-，且不可有相同名稱</a>';
					} else {
						if (empty($tip)) {
							$tip = ($Maker == 'textInput') ? "單行輸入，內容支援HTML，不支援CSS、JQ、JS等語法，特殊符號如 : @#$%?/\|*.及全形也盡量避免。" : "可輸入多行文字，內容支援HTML，不支援CSS、JQ、JS等語法，斷行請多利用Enter，輸入區域可拖曳右下角縮放。";
							if (strpos($val['name'], 'url') !== false) {
								$tip = '請輸入完整網址，若須於新視窗開啟網址，請啟用於新視窗開啟';
							}
						}
					}
				}
				if (!empty($disabled)) {
					$tip = '';
				}

				if (in_array($Maker, ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
					if ($val['model'] == "") {
						$this->CreateOptionFunction($Model . '_' . $val['name'], $val['note']);
						$Model = 'OptionFunction::' . $Model . '_' . $val['name'] . '()';
					} else {
						//判斷有無使用同一個自訂function
						if (strpos($val['model'], 'CC_') !== false) {
							$this->CreateOptionFunction(str_replace("CC_", "", $val['model']), $val['note']);
							$Model = 'OptionFunction::' . str_replace("CC_", "", $val['model']) . '()';
						} else {
							$Model = '$options[\'' . ucfirst($val['model']) . '\']';
						}
					}
					$tableSet .= '
						{{UnitMaker::' . $Maker . '([
							\'name\' => \'' . $val['name'] . '\',
							\'title\' => \'' . $val['note'] . '\',
							\'value\' => ( !empty($data[\'' . $val['name'] . '\']) )? $data[\'' . $val['name'] . '\'] : \'\',
							\'options\' => ' . $Model . ',
							\'tip\' => \'' . $tip . '\',
							\'batch\' => true,
						])}}';
				}
				if (in_array($Maker, ["textInput", "textArea", "colorPicker", "radio_btn", "numberInput", "datePicker", "filePicker", "inputHidden"])) {
					//$Maker = ($Maker == 'datePicker') ? 'dateRange' : $Maker;
					$tableSet .= '
					{{UnitMaker::' . $Maker . '([
						\'name\' => \'' . $val['name'] . '\',
						\'title\' => \'' . $val['note'] . '\',
						\'value\' => \'\',
						\'tip\' => \'' . $tip . '\',
						\'batch\' => true,
					])}}';
				}
			}
		}
		if ($setting_data['is_review']) {
			$tableSet .= '
	{{UnitMaker::radio_btn([
		\'name\' => \'wait_del\',
		\'title\' => \'申請刪除\',
		\'value\' => \'\',
		\'batch\' => true,
	])}}';
			$tableSet .= '
		{{UnitMaker::radio_btn([
			\'name\' => \'is_visible\',
			\'title\' => \'發佈審核\',
			\'value\' => \'\',
			\'batch\' => true,
		])}}';
		}
		return $tableSet;
	}
	public function CreateBladeTable($data, $Model)
	{
		if (!empty($data['branch_name'])) {
			$path = '../../resources/views/Fantasy/cms/' . $data['branch_name'] . '/' . $Model;
		} else {
			$path = '../../resources/views/Fantasy/cms/' . $Model;
		}
		if (!is_dir($path)) {
			mkdir($path, 0755);
		}

		//先抓出不刪除的程式碼
		$content = '';

		if (file_exists($path . "/table.blade.php")) {

			$file = fopen($path . "/table.blade.php", "r+");

			$i = 0;
			$appento = 0;
			$is_find = false;

			while (!feof($file)) {
				$str = fgets($file);
				if (strpos($str, '//覆蓋不刪除的程式碼請貼這裡-End') !== false) {
					$is_find = false;
				}
				if ($is_find) {
					$content .= $str;
				}
				if (strpos($str, '//覆蓋不刪除的程式碼請貼這裡-Star') !== false) {
					$is_find = true;
				}
			}
			fclose($file);
		}




		$tableSet = [];
		$tableSet_radio = "";
		$fastsearch = [];
		$other_data = $data['other_data'];

		$isDelete 	= (isset($other_data['isDelete']) && $other_data['isDelete']) ? 'false' : '$isDelete';
		$isCreate 	= (isset($other_data['isCreate']) && $other_data['isCreate']) ? 'false' : '$isCreate';
		$isExport 	= (isset($other_data['isExport']) && $other_data['isExport']) ? 'false' : '$isExport';
		$isClone 	= (isset($other_data['isClone']) && $other_data['isClone']) ? 'false' : '$isClone';
		$isAdminhide 	= (isset($other_data['isAdminhide']) && $other_data['isAdminhide']) ? true : false;

		//判斷有無需要篩選
		$isSearch = 'false';
		$isSearchCount = 0;
		foreach ($data['data'] as $val) {
			if ($val['search'] == "true") {
				$isSearchCount++;
				$val['lang'] = $val['lang'] ?? '';
				if ($val['lang'] == "true") {
					$fastsearch[] = 'tw_' . $val['name'];
					$fastsearch[] = 'en_' . $val['name'];
					$fastsearch[] = 'cn_' . $val['name'];
					$fastsearch[] = 'jp_' . $val['name'];
					$fastsearch[] = 'kr_' . $val['name'];
				} else {
					$fastsearch[] = $val['name'];
				}
			}
		}
		if ($isSearchCount > 1) {
			$isSearch = 'true';
		}
		$temp_rank = 100;
		foreach ($data['data'] as $val) {
			if ($val['show'] == "true") {
				$temp_rank++;
				$val['lang'] = $val['lang'] ?? '';
				$val['show_rank'] = $val['show_rank'] ?? '';
				$val['show_rank'] = $val['show_rank'] ?: $temp_rank;
				if ($val['lang'] == "true") {
					$fastsearch[] = 'tw_' . $val['name'];
					$fastsearch[] = 'en_' . $val['name'];
					$fastsearch[] = 'cn_' . $val['name'];
					$fastsearch[] = 'jp_' . $val['name'];
					$fastsearch[] = 'kr_' . $val['name'];
				} else {
					$fastsearch[] = $val['name'];
				}
				//如果是圖文顯示
				if (!empty($val['img'])) {
					$val['lang'] = $val['lang'] ?? '';
					$tableSet[$val['show_rank']] = '[			
						\'type\' => \'text_image\',
						\'width\' => \'\',
						\'text-center\' => false,
						\'title\' => \'' . $val['note'] . '\',
						\'columns\' => \'' . (($val['lang'] == 'true') ? 'tw_' : '') . $val['name'] . '\',
						\'img\' => \'' . $val['img'] . '\',
					],';
				} else {
					//單選
					if (in_array($val['formtype'], ["select", "select2", "radio_area"])) {
						$options = (strpos($val['model'], 'CC_') !== false) ? 'OptionFunction::' . str_replace("CC_", "", $val['model']) . '()' : '$options[\'' . ucfirst($val['model']) . '\']';
						$tableSet[$val['show_rank']] = '[			
			\'type\' => \'select\',
			\'width\' => \'\',
			\'text-center\' => false,
			\'title\' => \'' . $val['note'] . '\',
			\'columns\' => \'' . $val['name'] . '\',
			\'options\' => ' . $options . ',
		],';
					} elseif (in_array($val['formtype'], ["selectMulti", "select2Multi"])) {
						$options = (strpos($val['model'], 'CC_') !== false) ? 'OptionFunction::' . str_replace("CC_", "", $val['model']) . '()' : '$options[\'' . ucfirst($val['model']) . '\']';
						//$options = ($val['model'] == "") ? 'OptionFunction::'.$Model.'_'.$val['name'].'()':'$options[\''.ucfirst($val['model']).'\']';
						$tableSet[$val['show_rank']] = '[			
			\'type\' => \'selectMulti\',
			\'width\' => \'\',
			\'text-center\' => false,
			\'title\' => \'' . $val['note'] . '\',
			\'columns\' => \'' . $val['name'] . '\',
			\'options\' => ' . $options . ',
		],';
					} elseif (in_array($val['formtype'], ["radio_btn"])) {
						$tableSet_radio .= '[			
			\'type\' => \'radio\',
			\'width\' => \'\',
			\'text-center\' => false,
			\'title\' => \'' . $val['note'] . '\',
			\'columns\' => \'' . $val['name'] . '\'
		],';
					} else {
						$val['lang'] = $val['lang'] ?? '';
						if ($val['lang'] == "true") {
							$tableSet[$val['show_rank']] = '[
								"type" => "text",
								"width" => "",
								"text-center" => false,
								"title" => "' . $val['note'] . '",
								"columns" => "tw_' . $val['name'] . '",		
							],';
						} else {
							$tableSet[$val['show_rank']] = '[
								"type" => "text",
								"width" => "",
								"text-center" => false,
								"title" => "' . $val['note'] . '",
								"columns" => "' . $val['name'] . '",		
							],';
						}
					}
				}
			}
		}
		ksort($tableSet);
		$tableSet = implode("", $tableSet);

		$tableSet .= PHP_EOL . '		//覆蓋不刪除的程式碼請貼這裡-Star' . PHP_EOL;
		$tableSet .= $content;
		$tableSet .= '		//覆蓋不刪除的程式碼請貼這裡-End';

		if ($this->Leon_show() == 'is_reviewed') {
			if ($other_data['is_rank']) {
				$tableSet .= '
		[
			"type" => "w_rank"    
		],';
			}
			if ($other_data['is_visible']) {
				$tableSet .= '
		[
			"type" => "review"          
		],';
			}
			if ($isCreate != 'false' && !$isAdminhide) {
				$tableSet .= '
        [
            "type" => "admin"         
        ],';
			}
			$tableSet .= '
        [
            "type" => "updated"        
        ],';
		} else {
			if ($other_data['is_rank']) {
				$tableSet .= '
		[
			"type" => "w_rank"    
		],';
			}
			if ($other_data['is_visible']) {
				$tableSet .= '
		[
		 	"type" => "preview"         
		],
		[
			"type" => "visible"          
		],';
			}
			$tableSet .= PHP_EOL . $tableSet_radio;
			if ($isCreate != 'false' && !$isAdminhide) {
				$tableSet .= '
        [
            "type" => "admin"         
        ],';
			}
			$tableSet .= '
        [
            "type" => "updated"        
        ],';
		}


		$table = '{{TableMaker::listNewTable([	
    \'menuList\' => isset($menuList) ? $menuList : "",
    \'viewRoute\' => isset($viewRoute) ? $viewRoute : "",
    \'pageKey\' => isset($pageKey) ? $pageKey : "",
    \'need_Review\' => isset($need_Review) ? $need_Review : "",
    \'can_review\' => isset($can_review) ? $can_review : "",
    \'pageTitle\' => $pageTitle,  //標題
    \'pageId\' => $pageId,  
    \'pageIntroduction\' => \'\',
    \'hasAuth\' => $hasAuth, 
    \'QuickSearch\' => \'' . implode(",", $fastsearch) . '\', //快速搜尋的欄位
    \'modelName\' => $modelName,
    \'isEdit\' => $isEdit,
	\'isDelete\' => ' . $isDelete . ',
	\'isCreate\' => ' . $isCreate . ',
	\'isSearch\' => ' . $isSearch . ',
	\'isClone\' => ' . $isClone . ',
	\'isBatch\' => $isBatch,
    \'page\' => $page,
    \'search\' => $search,
    \'search_type\' => $search_type ?? \'basic\',
	\'count\' => $count,
    \'data\' => $data,
    \'pn\' => $pn,
	\'isExport\' => $isExport,
	\'exportName\' => $exportName,
	\'menu_id\' => $pageKey,
	
	// 寬度w50 / w80 / w100 / w120 / w130 / w140 / w150 / w160 / w170 / w180 
	\'tableSet\' => [
		' . $tableSet . '
	],
])}}			
			';
		return $table;
	}

	public function CreateBlade($Model, $Blade)
	{
		$leon_menu = $this->db->query(sprintf("SELECT * FROM leon_menu WHERE id = 1"))->fetch(PDO::FETCH_ASSOC);
		$setting_data = json_decode($leon_menu['w_setting'], true);

		$formKeySet = 0;
		//在cms資料夾建立
		if (!empty($Blade['branch_name'])) {
			$path = '../../resources/views/Fantasy/cms/' . $Blade['branch_name'] . '/' . $Model;
			if (!is_dir('../../resources/views/Fantasy/cms/' . $Blade['branch_name'])) {
				mkdir('../../resources/views/Fantasy/cms/' . $Blade['branch_name'], 0755);
			}
		} else {
			$path = '../../resources/views/Fantasy/cms/' . $Model;
		}
		if (!is_dir($path)) {
			mkdir($path, 0755);
		}
		//index


		$menuList = [];
		if (file_exists($path . '/index.blade.php')) {
			$file = fopen($path . '/index.blade.php', "r+");
			$content = '';
			while (!feof($file)) {
				$str = fgets($file);
				$content .= $str;
			}
			fclose($file);
			$re = '/\$menuList = \[(.*)\];/s';
			preg_match($re, $content, $matches, PREG_OFFSET_CAPTURE, 0);
			$ss =  substr(str_replace("=>", ":", preg_replace('/\s(?=)/', '', $matches[1][0])), 0, -1);
			$ss =  str_replace("'", "\"", $ss);
			$menuList = json_decode('{' . $ss . '}', true);
		}


		if (!is_array($menuList)) {
			echo $path;
		}
		$myfile = fopen($path . '/index.blade.php', "w");
		$BladeTable = $this->CreateBladeIndex($Blade, $menuList);
		fwrite($myfile, $BladeTable);
		fclose($myfile);
		//search
		$myfile = fopen($path . '/search.blade.php', "w");
		$BladeTable = $this->CreateBladeSearch($Blade['data'], $Model);
		fwrite($myfile, $BladeTable);
		fclose($myfile);
		//batch
		$myfile = fopen($path . '/batch.blade.php', "w");
		$BladeTable = $this->CreateBladeBatch($Blade['data'], $Model);
		fwrite($myfile, $BladeTable);
		fclose($myfile);
		//table
		$BladeTable = $this->CreateBladeTable($Blade, $Model);
		$myfile = fopen($path . '/table.blade.php', "w");

		fwrite($myfile, $BladeTable);
		fclose($myfile);
		//edit
		$myfile = fopen($path . '/edit.blade.php', "w");
		//$BladeTable = $this->CreateBladeEdit($data);
		$have_mainform = false;
		foreach ($Blade['data'] as $val) {
			if ($val['formtype'] != "") {
				$have_mainform = true;
			}
		}
		$table = '{{-- 表名跟哪一筆資料 --}}
<input type="hidden" name="modelName" value="{{ $model }}">
@if(isset($data[\'id\']))
	<input type="hidden" name="dataId" value="{{ $data[\'id\'] }}" class="editContentDataId">
@else
	<input type="hidden" name="dataId" value="" class="editContentDataId">
@endif
<input type="hidden" name="{{$model}}[branch_id]" value="{{$baseBranchId}}">
<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="menu_id" value="{{$menu_id}}">
<input type="hidden" name="{{$model}}[temp_url]" value="">
<!--內容-->
<div class="backEnd_quill">
    <article class="work_frame">
        <section class="content_box">
            <div class="for_ajax_content">
                <section class="content_a">
                    <ul class="frame">';
		if ($have_mainform) {
			$table .= '@if($formKey == \'MainForm\')';
		}
		//基本
		if (!empty($Blade['other_data'])) {
			if ($Blade['other_data']['is_visible']) {
				if ($this->Leon_show() == 'is_reviewed') {
					$table .= '
                        {{UnitMaker::reviewed_radio_btn([
		\'need_review\' => $need_review,
		\'can_review\' => $can_review,
		\'name\' => $model.\'[is_visible]\',
		\'value\' => ( !empty($data[\'is_visible\']) )? $data[\'is_visible\'] : \'\',
		\'tip\' => \'主要決定資料是否於前端網頁發佈的設定，設定不發佈，資料將不會出現在任一頁面上，也無法被搜尋引擎尋找。\',
	])}}';
				} else {
					$table .= '
                        {{UnitMaker::radio_btn([
		\'name\' => $model.\'[is_visible]\',
		\'title\' => \'是否顯示\',
		\'tip\' => \'主要決定資料是否於前端網頁發佈的設定，設定不發佈，資料將不會出現在任一頁面上，也無法被搜尋引擎尋找。\',
		\'value\' => ( !empty($data[\'is_visible\']) )? $data[\'is_visible\'] : \'\'
	])}}';
				}
				if ($setting_data['is_review'] != 1) {
					$table .= '
					{{UnitMaker::radio_btn([
						\'name\' => $model.\'[is_preview]\',
						\'title\' => \'是否顯示於預覽站\',
						\'tip\' => \'主要決定資料是否於預覽站發佈的設定，與是否顯示於正式網頁無關。\',
						\'value\' => ( !empty($data[\'is_preview\']) )? $data[\'is_preview\'] : \'\'
					])}}';
				}
			}
			if ($Blade['other_data']['is_rank']) {
				$table .= '
                        {{UnitMaker::numberInput([
		\'name\' => $model.\'[w_rank]\',
		\'title\' => \'排序\',
		\'tip\' => \'數字由小至大\',
		\'value\' => ( !empty($data[\'w_rank\']) )? $data[\'w_rank\'] : \'\'
	])}}';
			}
		}
		foreach ($Blade['data'] as $val) {
			if (preg_replace('/\s(?=)/', '', $val['tab']) == "") {
				$table .= $this->CreateUnit($val['formtype'], $val, $Model);
			} else {
				$table .= '
                        @elseif($formKey == \'Form_' . $formKeySet . '\')';
				$table .= $this->CreateUnit($val['formtype'], $val, $Model);
				$formKeySet++;
			}
		}

		if (isset($Blade['other_data']['isSeo']) && $Blade['other_data']['isSeo']) {
			$table .= '@elseif($formKey == \'Form_seo\')';
			$table .= '@include(\'Fantasy.cms.includes.seo_form\')';
		}
		//sontable
		$first_state = true;
		if (isset($Blade['children'])) {
			foreach ($Blade['children'] as $sontableKey => $sontable) {
				if ($have_mainform) {
					$table .= '
                        @elseif($formKey == \'Form_' . $formKeySet . '\')';
				} else {
					if ($first_state) {
						$table .= '
                        @if($formKey == \'Form_' . $formKeySet . '\')';
						$first_state = false;
					} else {
						$table .= '
                        @elseif($formKey == \'Form_' . $formKeySet . '\')';
					}
				}

				// $table .= '
				// @elseif($formKey == \'Form_'.$formKeySet.'\')';
				// sontable 基本
				$children_is_visible = (isset($sontable['other_data']['is_visible']) &&
					$sontable['other_data']['is_visible']) ? true : false;
				$children_is_rank = (isset($sontable['other_data']['is_rank']) &&
					$sontable['other_data']['is_rank']) ? 'yes' : 'no';
				$children_isDelete = (isset($sontable['other_data']['isDelete']) &&
					$sontable['other_data']['isDelete']) ? 'no' : 'yes';
				$children_isCreate = (isset($sontable['other_data']['isCreate']) &&
					$sontable['other_data']['isCreate']) ? 'no' : 'yes';
				$hasContent = 'no';
				$copy = 'yes';
				$hasImages = '';
				if (isset($sontable['data'][0]['type']) && $sontable['data'][0]['type'] == '內容') {
					$table .=
						PHP_EOL . '@include(\'Fantasy.cms.back_article_v3\',[\'Model\'=>\'' . $sontable['model'] .
						'\',\'ThreeModel\'=>\'' . $sontable['model'] . '_img' . '\'])';
				} else {
					foreach ($sontable['data'] as $key => $sontableVal) {
						if (!empty($sontableVal['formtype'])) {
							$hasContent = 'yes';
						}
						if (in_array($sontableVal['formtype'], ["imageGroup"]) && empty($hasImages)) {
							if ($children_isCreate == 'yes') {
								$hasImages = '
                        \'MultiImgcreate\' => \'yes\', //使用多筆圖片
                        \'imageColumn\' => \'' . $sontableVal['name'] . '\', //預設圖片欄位';
							}
						}
					}

					$table .= '
                        {{UnitMaker::WNsonTable([
		\'sort\' => \'' . $children_is_rank . '\',//是否可以調整順序
		\'sort_field\'=>\'w_rank\',//自訂排序欄位
		\'teach\' => \'no\',
		\'hasContent\' => \'' . $hasContent . '\', //是否可展開
		\'tip\' => \'' . $sontable['label'] . '\',
		\'create\' => \'' . $children_isCreate . '\', //是否可新增
		\'delete\' => \'' . $children_isDelete . '\', //是否可刪除
		\'copy\' => \'' . $copy . '\', //是否可複製' . $hasImages . '
		\'value\' => ( !empty($associationData[\'son\'][\'' . $sontable['model'] . '\']) )? $associationData[\'son\'][\'' . $sontable['model'] . '\'] : [],
		\'name\' => \'' . $sontable['model'] . '\',
		\'tableSet\' => 
		[';
					foreach ($sontable['data'] as $sontableVal) {
						if ($sontableVal['show'] == "true") {
							if (in_array($sontableVal['formtype'], ["select", "select2", "selectMulti", "select2Multi", "radio_area"])) {
								$options = (strpos($sontableVal['model'], 'CC_') !== false) ? 'OptionFunction::' . str_replace("CC_", "", $sontableVal['model']) . '()' : '$options[\'' . ucfirst($sontableVal['model']) . '\']';
								//$options = ($sontableVal['model'] == "") ? 'OptionFunction::'.$Model.'_'.$sontableVal['name'].'()':'$options[\''.ucfirst($sontableVal['model']).'\']';
								$table .= '
			[
				\'type\' => \'select_just_show\',
				\'title\' => \'' . $sontableVal['note'] . '\',
				\'value\' => \'' . $sontableVal['name'] . '\',
				\'options\' => ' . $options . ',
				\'default\' => \'\',	
				\'auto\' => true,				
			],';
							} elseif (in_array($sontableVal['formtype'], ["imageGroup", "imageGroup_all", "imageGroup_3size"])) {
								$table .= '
			[
				\'type\' => \'filesText\',
				\'title\' => \'' . $sontableVal['note'] . '\',
				\'value\' => \'' . $sontableVal['name'] . '\',
				\'auto\' => true,	
			],';
							} else {
								$sontableVal['lang'] = $sontableVal['lang'] ?? '';
								$table .= '
			[
				\'type\' => \'just_show\',
				\'title\' => \'' .  $sontableVal['note'] . '\',
				\'value\' => \'' . (($sontableVal['lang'] == 'true') ? 'tw_' : '') . $sontableVal['name'] . '\',
				\'auto\' => true,	
			],';
							}
						}
					}
					if ($children_is_visible) {
						$table .= '			
						[
							\'type\' => \'radio_btn\',
							\'title\' => \'預覽\',
							\'value\' => \'is_preview\'
						],';
						$table .= '			
			[
				\'type\' => \'radio_btn\',
				\'title\' => \'是否顯示\',
				\'value\' => \'is_visible\'
			],';
					}
					$table .= '	
		],
		\'tabSet\'=>
		[';
					foreach ($sontable['data'] as $key => $sontableVal) {
						if ($key == 0 || $sontableVal['tab'] != "") {
							$title = (!empty($sontableVal['tab'])) ? $sontableVal['tab'] : '內容編輯';

							if ($key > 0) {
								$table .= '
				],
			],';
							}
							$table .= '
			[
				\'title\' => \'' . $title . '\',
				\'content\' => 
				[';
						}

						$table .= $this->CreateSontableUnit($sontableVal['formtype'], $sontableVal, $sontable['model']);
					}
					$table .= '
				],
			],';
					// threetable
					if (isset($sontable['children'])) {
						foreach ($sontable['children'] as $sontable_children) {
							$three_content = '';
							foreach ($sontable_children['data'] as $threetableVal) {
								//文章圖片
								$three_content .= $this->CreateThreetableUnit($threetableVal['formtype'], $threetableVal, $sontable_children['model']);
							}



							$table .= '									
			[
				\'title\' => \'' . $sontable_children['label'] . '\',
				\'content\' => [],
				\'is_three\' => \'yes\',
				\'create\'=>\'yes\',
				\'delete\'=>\'yes\',
				\'copy\'=>\'yes\',
				\'sort_field\'=>\'\',//自訂排序欄位
				\'three_model\' => \'' . $sontable_children['model'] . '\',
				\'three\' =>
				[
					\'SecondIdColumn\' => \'second_id\',
					\'title\' => \'' . $sontable_children['label'] . '\',
					\'tip\' => \'\',
					//\'is_add\' => \'yes\',  /* 單一欄位 */
					//\'is_photo\' => \'yes\',  /* 圖片 */
					//\'is_embed\' => \'no\',  /* 嵌入影片,填影片ID */
					//\'embed_place\' => \'請輸入YouTube影片代碼\',  /* 嵌入影片,填影片ID */
					//\'embed_url\' => \'https://www.youtube.com/embed/\',  /* 嵌入影片,填影片ID */
					//\'is_video\' => \'no\',  /* 上傳影片,現在他沒功能 */
					\'three_tableSet\' => 
					[
						
					],
					\'three_content\' => 
					[	';
							//foreach($sontable_children['data'] as $threetableVal){
							//$table .= $this->CreateThreetableUnit($threetableVal['formtype'],$threetableVal,$sontable_children['model']);
							$table .= $three_content;
							//}
							$table .= '								
					],
				],
			],';
						}
					}
					$table .= '
		]
	])}}
                        ';
				}
				$formKeySet++;
			}
		}
		$table .= '@endif
                    </ul>
                </section>
            </div>
        </section>
    </article>
</div>
';
		fwrite($myfile, $table);
		fclose($myfile);
	}
	public function Create_clone_relations($ModelName, $SubModelName, $Field, $onlymany = false, $type = 'hasMany')
	{

		// $filepath = '../../app/Models/' . ucfirst($val['db_name']) . ".php";
		// $Template = '/Http/Controllers/Builder/Template/Model.php';
		// $tempdata = fopen($Template, "r");
		// $tempdata_html = fread($tempdata, filesize($Template));
		// $tempdata_html = str_replace('{$Model}', ucfirst($val['db_name']), $tempdata_html);
		// $tempdata_html = str_replace('{$TableName}', $language . $val['db_name'], $tempdata_html);

		// $file = fopen($filepath, "w");
		// fwrite($file, $tempdata_html);
		// fclose($file);

		$SubModelName = strtolower($SubModelName);
		$functionName = $SubModelName;
		if ($type == 'belongsTo') {
			$functionName = $functionName . "_one";
		}
		$path = '../../app/Models/' . $ModelName;
		//先抓出不刪除的程式碼
		$all_content = [];
		$content = [];
		$have_not_del = false;
		if (file_exists($path . '/' . $ModelName . ".php")) {
			$file = fopen($path . '/' . $ModelName . ".php", "r+");
			$i = 0;
			$appento = 0;
			$have_sub = false;
			$is_find = false;
			$have_function = false;
			$clone_relations = '';
			while (!feof($file)) {
				$str = fgets($file);
				$all_content[] = $str;
				if (strpos($str, 'const clone_relations') !== false) {
					$clone_relations = $str;
				}
				if (strpos($str, 'public function ' . $functionName . '_many()') !== false) {
					$have_sub = true;
				}
				if (strpos($str, 'public function ' . $functionName . '()') !== false) {
					$have_function = true;
				}
				if (strpos($str, '//覆蓋不刪除的程式碼請貼這裡-End') !== false) {
					$is_find = false;
				}
				if ($is_find) {
					if (strpos($str, 'const clone_relations') !== false) { } else {
						$content[] = $str;
					}
				}
				if (strpos($str, '//覆蓋不刪除的程式碼請貼這裡-Star') !== false) {
					$is_find = true;
				}
			}
			fclose($file);
		}
		if (!isset($clone_relations)) {
			echo $ModelName;
			exit();
		}
		$str = str_replace("const clone_relations = [", "", $clone_relations);
		$str = str_replace("];", "", $str);
		$str = str_replace("'", "", $str);
		$str = str_replace(" ", "", $str);
		$str = str_replace("\n", "", $str);
		$str = str_replace("\r", "", $str);
		$str = str_replace("\t", "", $str);
		$str = str_replace(PHP_EOL, "", $str);
		$clone_relations_arr = array_unique(explode(",", $str));
		if (!in_array($functionName . '_many', $clone_relations_arr) && !$onlymany) {
			$clone_relations_arr[] = $functionName . '_many';
		}
		if (!$have_function) {
			$content[] = ' public function ' . strtolower($functionName) . '()' . PHP_EOL;
			$content[] = ' {' . PHP_EOL;
			if ($type == 'hasMany') {
				if ($Field == 'second_id') {
					$content[] = ' return $this->hasMany(\'App\Models\\' . ucfirst($SubModelName) . '\\' . ucfirst($SubModelName) . '\', \'' . $Field . '\', \'id\')->doSort();' . PHP_EOL;
				} else {
					$content[] = ' return $this->hasMany(\'App\Models\\' . ucfirst($SubModelName) . '\\' . ucfirst($SubModelName) . '\', \'' . $Field . '\', \'id\')->isVisible()->doSort();' . PHP_EOL;
				}
			} else {
				$content[] = ' return $this->belongsTo(\'App\Models\\' . ucfirst($SubModelName) . '\\' . ucfirst($SubModelName) . '\', \'' . $Field . '\', \'id\')->isVisible();' . PHP_EOL;
			}
			$content[] = ' }' . PHP_EOL;
		}

		if (!$have_sub && !$onlymany) {
			$content[] = ' public function ' . $functionName . '_many()' . PHP_EOL;
			$content[] = ' {' . PHP_EOL;
			$content[] = ' return $this->hasMany(\'App\Models\\' . ucfirst($SubModelName) . '\\' . ucfirst($SubModelName) . '\', \'' . $Field . '\', \'id\');' . PHP_EOL;
			$content[] = ' }' . PHP_EOL;
		}

		//在寫回去
		$file = fopen($path . '/' . $ModelName . ".php", "w");
		$write_coustom = false;
		$clone_relations_line = '';
		foreach ($clone_relations_arr as $key => $v) {
			if ($clone_relations_arr[$key] == "") {
				unset($clone_relations_arr[$key]);
			} else {
				$clone_relations_arr[$key] = str_replace(["\n", "\r", "\r\n"], "", $clone_relations_arr[$key]);
				$clone_relations_arr[$key] = str_replace(PHP_EOL, "", $clone_relations_arr[$key]);
				$clone_relations_line .= "'" . $clone_relations_arr[$key] . "',";
			}
		}

		$clone_relations_line = substr($clone_relations_line, 0, -1);
		$clone_relations_arr = array_values($clone_relations_arr);


		//echo $clone_relations_line.PHP_EOL.'_______________'.PHP_EOL;
		foreach ($all_content as $val) {
			if (strpos($val, '//覆蓋不刪除的程式碼請貼這裡-Star') !== false) {
				fwrite($file, $val);
				if (count($clone_relations_arr) > 1) {

					fwrite($file, ' const clone_relations = [' . $clone_relations_line . '];' . PHP_EOL);
				} else {
					if (count($clone_relations_arr) == 1) {
						fwrite($file, ' const clone_relations = [\'' . $clone_relations_arr[0] . '\'];' . PHP_EOL);
					}
				}
				$write_coustom = true;
				foreach ($content as $v) {
					fwrite($file, $v);
				}
			}
			if (strpos($val, '//覆蓋不刪除的程式碼請貼這裡-End') !== false) {
				$write_coustom = false;
			}
			if ($write_coustom == false) {
				if (strpos($val, 'const clone_relations') !== false) { } else {
					fwrite($file, $val);
				}
			}
		}
		fclose($file);

		return "OK";
	}
	public function Create($DBName, $ModelName, $db_data, $other_data)
	{
		$leon_menu = $this->db->query(sprintf("SELECT * FROM leon_menu WHERE id = 1"))->fetch(PDO::FETCH_ASSOC);
		$setting_data = json_decode($leon_menu['w_setting'], true);

		//在Model資料夾建立
		$path = '../../app/Models/' . $ModelName;
		if (!is_dir($path)) {
			mkdir($path, 0755);
		}
		//先抓出不刪除的程式碼
		$content = '';
		$have_not_del = false;
		if (file_exists($path . '/' . $ModelName . ".php")) {
			$file = fopen($path . '/' . $ModelName . ".php", "r+");
			$i = 0;
			$appento = 0;
			$is_find = false;
			while (!feof($file)) {
				$str = fgets($file);
				if (strpos($str, '//若更新資料需要判斷的話可以在這判斷') !== false) {
					$have_not_del = true;
				}
				if (strpos($str, '//覆蓋不刪除的程式碼請貼這裡-End') !== false) {
					$is_find = false;
				}
				if ($is_find) {
					$temp_str = $str;
					$temp_str = str_replace("\n", "", $temp_str);
					$temp_str = str_replace("\r", "", $temp_str);
					$temp_str = str_replace("\t", "", $temp_str);
					$temp_str = str_replace(PHP_EOL, "", $temp_str);
					if (!empty($temp_str)) {
						$content .= $str;
					}
				}
				if (strpos($str, '//覆蓋不刪除的程式碼請貼這裡-Star') !== false) {
					$is_find = true;
				}
			}
			fclose($file);
		}
		if (!$have_not_del) {
			$content .= ' //若更新資料需要判斷的話可以在這判斷
protected function performUpdate(Model_Builder $query)
{
$dirty = $this->getDirty();
if (count($dirty) > 0) { }
return parent::performUpdate($query);
}';
		}


		$myfile = fopen($path . '/' . $ModelName . ".php", "w");
		$export_field = [];
		$jsonValue = [];

		foreach ($db_data as $data) {
			if ($data['type'] == "json") {
				$jsonValue[] = "'" . $data['name'] . "' => '[]'";
			}
			if (isset($data['excel']) && $data['excel'] == 'true') {
				$export_field[] = "'" . $data['name'] . "'";
			}
		}
		$GetMainData = 'false';
		if (strpos($ModelName, '_son') !== false) {
			$MainModel = str_replace(["_son", "_item", "_sub"], "", $ModelName);
			$GetMainData = '$this->belongsTo(\'App\Models\\' . $MainModel . '\\' . $MainModel . '\',\'parent_id\',\'id\')';
		}
		if (strpos($ModelName, '_item') !== false) {
			$MainModel = str_replace(["_son", "_item", "_sub"], "", $ModelName);
			$GetMainData = '$this->belongsTo(\'App\Models\\' . $MainModel . '\\' . $MainModel . '\',\'parent_id\',\'id\')';
		}
		if (strpos($ModelName, '_sub') !== false) {
			$MainModel = str_replace(["_son", "_item", "_sub"], "", $ModelName);
			$GetMainData = '$this->belongsTo(\'App\Models\\' . $MainModel . '\\' . $MainModel . '\',\'parent_id\',\'id\')';
		}
		if (strpos($ModelName, '_format') !== false) {
			$MainModel = str_replace(["_format"], "", $ModelName);
			$GetMainData = '$this->belongsTo(\'App\Models\\' . $MainModel . '\\' . $MainModel . '\',\'parent_id\',\'id\')';
		}
		//判斷是否為共用資料表
		$__construct = '$TableName = "' . $DBName . '";' . PHP_EOL;
		if (isset($other_data['isShareModel']) && $other_data['isShareModel']) {
			$__construct .= ' $this->setTable($TableName);';
		} else {
			$__construct .= ' $dataBasePrefix = Config::get(\'app.dataBasePrefix\');' . PHP_EOL;
			$__construct .= ' if(!empty($dataBasePrefix)){$TableName = (strpos($dataBasePrefix,\'preview\') !== false) ? str_replace("preview_","",$dataBasePrefix).$TableName : $dataBasePrefix.$TableName;}' . PHP_EOL;
			$__construct .= ' $this->setTable($TableName);';
		}
		//判斷是否審核功能
		if ($setting_data['is_review']) {
			$__scopeisVisible = 'return ($is_pre) ? $query->where($dbname.\'branch_id\', $branch_id)->where($dbname.\'is_preview\',1) : $query->where($dbname.\'branch_id\', $branch_id)->where($dbname.\'is_visible\', 1);';
		} else {
			$__scopeisVisible = 'return ($is_pre) ? $query->where($dbname.\'branch_id\', $branch_id)->where($dbname.\'is_preview\',1) : $query->where($dbname.\'branch_id\', $branch_id)->where($dbname.\'is_visible\', 1);';
		}


		$txt = '<?php
namespace App\\Models\\' . $ModelName . ';
use Config;
use BaseFunction;
use Session;
use DB;
use Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as Model_Builder;
use App\Models\FrontBase;

class ' . $ModelName . ' extends FrontBase
{
	public function __construct()
	{
		' . $__construct . '
	}
	//覆蓋不刪除的程式碼請貼這裡-Star
' . $content . '
	//覆蓋不刪除的程式碼請貼這裡-End
	//Leon 這給次分類選項用
    public function GetMainData()
    {
        return ' . $GetMainData . ';
    }
	//資料下架判斷
	public function scopedoPostClose($query)
	{
		return $query->where(
			function ($query1) {
				$query1 = $query1->where(\'is_always\', 1);
				$query1 = $query1->orwhere(
					function ($query2) {
						$query2 = $query2->whereDate(\'post_date\', \'<=\', Carbon::today())->whereDate(\'close_date\', \'>\', Carbon::today());
					}
				);
			}
		);
	}
    // 排序
    public function scopedoSort($query)
    {
        return $query->orderby(\'w_rank\', \'asc\')->orderby(\'id\', \'desc\');
    }
	//用ID或url_name判斷資料
	public function scopeurlname($query,$url_name){
		return $query->where(function($quert1)use($url_name){
			$quert1 = $quert1->where(\'temp_url\',$url_name)->orwhere(\'url_name\', $url_name);
		});
	}
	public function scopedoCMSSort($query)
	{
		return $query->orderby(\'id\', \'DESC\');
	}
	protected $attributes = [
		' . implode(",", $jsonValue) . '
    ];
	const export_field = [' . implode(",", $export_field) . '];
}
';
		fwrite($myfile, $txt);
		fclose($myfile);
		//更改models檔案
		$file = fopen("../../config/models.php", "r+");
		$content = array();
		$i = 0;
		$appento = 0;
		$is_find = false;
		while (!feof($file)) {
			$str = fgets($file);
			if (strpos($str, $ModelName . '\\' . $ModelName . '::class') !== false) {
				$is_find = true;
			}
			if ((strpos($str, 'AddModelUp') !== false) && $is_find == false) {
				$content[$i] = '	"' . $ModelName . '" => 		App\Models\\' . $ModelName . '\\' . $ModelName . '::class,' . PHP_EOL;
				$i++;
			}
			$content[$i] = $str;
			$i++;
		}
		fclose($file);
		$content = array_filter($content);
		//在寫回去
		$file = fopen("../../config/models.php", "w");
		foreach ($content as $val) {
			fwrite($file, $val);
		}
		fclose($file);

		return "OK";
	}
	public function CreateOptionFunction($ModelName, $title)
	{

		$file = fopen("../../app/Http/Controllers/OptionFunction.php", "r+");
		$content = array();
		$i = 0;
		$appento = 0;
		$is_find = false;
		while (!feof($file)) {
			$str = fgets($file);
			//先判斷是否存在
			if (strpos($str, $ModelName . '()') !== false) {
				$is_find = true;
			}
			if (strpos($str, $ModelName . '($key = null)') !== false) {
				$is_find = true;
			}
			if ((strpos($str, 'AddModelUp') !== false) && $is_find == false) {
				$content[$i] = '
	//' . $title . '	
	public static function ' . $ModelName . '($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];		
		return ($key !== null) ? findkeyval($array,\'key\',$key) : $array;
	}' . PHP_EOL;
				$i++;
			}
			$content[$i] = $str;
			$i++;
		}
		fclose($file);
		$content = array_filter($content);
		//在寫回去
		$file = fopen("../../app/Http/Controllers/OptionFunction.php", "w");
		foreach ($content as $val) {
			fwrite($file, $val);
		}
		fclose($file);
	}
	public function CreateExcelRelatedFunction($data)
	{

		$file = fopen("../../app/Http/Controllers/ExcelRelatedFunction.php", "r+");
		$content = array();
		$i = 0;
		$appento = 0;
		$is_find = false;
		while (!feof($file)) {
			$str = fgets($file);
			//先判斷是否存在
			if (strpos($str, '["model"=>"' . $data['model'] . '","field"=>"' . $data['field'] . '","from_model"=>"' . $data['from_model'] . '","from_field"=>"' . $data['from_field'] . '"],') !== false) {
				$is_find = true;
			}
			if ((strpos($str, 'AddModelUp') !== false) && $is_find == false) {
				$content[$i] = '["model"=>"' . $data['model'] . '","field"=>"' . $data['field'] . '","from_model"=>"' . $data['from_model'] . '","from_field"=>"' . $data['from_field'] . '"],' . PHP_EOL;
				$i++;
			}
			$content[$i] = $str;
			$i++;
		}
		fclose($file);
		$content = array_filter($content);
		//在寫回去
		$file = fopen("../../app/Http/Controllers/ExcelRelatedFunction.php", "w");
		foreach ($content as $val) {
			fwrite($file, $val);
		}
		fclose($file);
	}
	public function FastHtmlCoverToPhpFunction($phpfile)
	{
		$file = fopen($phpfile, "r+");
		$content = array();
		$i = 0;
		$appento = 0;
		$is_find = false;
		while (!feof($file)) {
			$str = fgets($file);
			//先判斷是否存在
			if (strpos($str, '<body') !== false) {
				$is_find = true;
			}
			if (strpos($str, '<body') !== false) {
				$is_find = true;
			}
			if ((strpos($str, '<body') !== false)) {
				$content[$i] = $str;
				$i++;
			}
			$content[$i] = $str;
			$i++;
		}
		fclose($file);
		$content = array_filter($content);
		//在寫回去
		$file = fopen("../../app/Http/Controllers/OptionFunction.php", "w");
		foreach ($content as $val) {
			fwrite($file, $val);
		}
		fclose($file);
	}
	public function CreateControllers($Models)
	{
		foreach ($Models as $Model) {
			//在cms資料夾建立
			$path = '../../app/Http/Controllers/Front/';
			if (!is_file($path . '/' . $Model['Model'] . 'Controller.php')) {
				$myfile = fopen($path . '/' . $Model['Model'] . 'Controller.php', "w");
				$BladeTable = $this->CreateControllersphp($Model['Model'], $Model['children']);
				fwrite($myfile, $BladeTable);
				fclose($myfile);
			}
		}
	}
	public function CreateControllersphp($Models, $ORM)
	{
		$tableSet = '<?php
namespace App\Http\Controllers\Front;
/**原生函式**/
use Illuminate\Http\Request;
use View;
use ItemMaker;
use Cache;
use Excel;
use DateTime;
use Redirect;
use Mail;
use Session;
use Hash;
use Crypt;
use Validator;
use Carbon\Carbon;
use DB;
use Config;
use Illuminate\Support\Facades\Storage;

use UnitMaker;
use TableMaker;
use BaseFunction;
//API and option
use App\Http\Controllers\OptionFunction;
/**相關Controller**/
use Illuminate\Routing\Controller as BaseController;
/**相關repository**/

/**相關Models**/
class ' . $Models . 'Controller extends BaseController{
	public function __construct()
	{
		BaseFunction::checkRouteLang();
	}
	//預設主頁面 $class_main/主分類 $class_sub/次分類
	public function index($branch,$locale,$class_main = "",$class_sub = "")
	{

	}
	//資料最終頁
	public function detail($branch,$locale,$class_main = "",$class_sub = "",$id = "")
	{

	}
	//POST接收
	public function GetPost_Data($branch,$locale,Request $request)
	{

	}
}';
		return $tableSet;
	}
}
$CreateModel = new CreateModel($db);
