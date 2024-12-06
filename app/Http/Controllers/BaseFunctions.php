<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use Request;
use View;
use Redirect;
use Auth;
use Debugbar;
use Route;
use App;
use DB;
use Config;
use Session;
use Carbon\Carbon;

use App\Services\Front\ProductService;

use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Cms\CmsMenu;
use App\Models\Basic\Cms\CmsDataAuth;
use App\Models\Basic\Fms\FmsFile;
use App\Models\Basic\Fms\FmsFirst;
use App\Models\Basic\Fms\FmsSecond;
use App\Models\Basic\Fms\FmsThird;
use App\Models\Basic\LogData;
use App\Models\Website\Seo;
use App\Models\Set\BasicSetting;
use App\Models\Product\ProductTheme;

class BaseFunctions extends BaseController
{

	public function __construct()
	{
		parent::__construct();
	}

	public static function checkRouteLang()
	{
		$parameters = Route::current()->parameters();
		/*補上資料庫語系前綴*/
		// if (isset($parameters['locale']) and !empty($parameters['locale'])) {
		// 	$branch_arr = explode(".", $parameters['branch']);
		// 	$branch_end = end($branch_arr);
		// 	//Leon 預覽站
		// 	$leon_locale = $parameters['locale'];
		// 	if (strpos($parameters['locale'], 'preview') !== false) {
		// 		$leon_locale = str_replace("preview_", "", $parameters['locale']);
		// 		//如果沒登入
		// 		if (!Session::has('fantasy_user')) {
		// 			return redirect()->to(str_replace("preview.", "", b_url('', true)))->send();
		// 		}
		// 	}
		// 	$basic_branch_origin = DB::table('basic_branch_origin')->where('en_title', $branch_end)->first();
		// 	if (!empty($basic_branch_origin)) {
		// 		$basic_branch_origin_unit = DB::table('basic_branch_origin_unit')->where('origin_id', $basic_branch_origin->id)->where('locale', $leon_locale)->first();
		// 		if (!empty($basic_branch_origin_unit)) {
		// 			Config::set('app.dataBasePrefix', '' . $parameters['locale'] . '_');
		// 			View::share('baseLocale', $parameters['locale']);
		// 		} else {
		// 			return redirect()->to('/')->send();
		// 		}
		// 	} else {
		// 		return redirect()->to('/')->send();
		// 	}
		// }
		// if (!Session::has('fantasy_user') && isset($parameters['locale']) && (strpos($parameters['locale'], 'preview') !== false)) {
		// 	return redirect()->to(str_replace("preview.", "", b_url('', true)))->send();
		// }

		$locale = str_replace('preview_', '', $parameters['locale']);
		App::setLocale($locale);
		//替換多語系切換網址
		$uri = \URL::full();
		$replace_locale = (count($parameters) == 2) ? '/' . $parameters['locale'] : '/' . $parameters['locale'] . '/';
		$replace_locale_to = (count($parameters) == 2) ? '' : '/';
		$locale_url = [
			'now' => $parameters['locale'],
			'tw' => str_replace($replace_locale, "/tw" . $replace_locale_to, $uri),
			'en' => str_replace($replace_locale, "/en" . $replace_locale_to, $uri),
			'cn' => str_replace($replace_locale, "/cn" . $replace_locale_to, $uri)
		];
		View::share('locale_url', $locale_url);
	}
    public static function encryptData($value){
        $length = mb_strlen($value);
        $array = [];
        for ($i = 0; $i < $length - 1; $i++) {
            $array[] = mb_substr($value, $i, 1);
        }
        foreach($array as $key=>$val){
            $array[$key] = openssl_encrypt($val, 'AES-256-ECB', config('app.key'));
        }
        return implode(',',$array);
    }
	public static function processTitleToUrl($title)
	{
		$replace1 = str_replace(' ', '*', $title);
		$replace2 = str_replace('/', '^', $replace1);
		$replace3 = str_replace('.', '`', $replace2);
		$replace4 = str_replace('?', '@', $replace3);

		return $replace4;
	}


	public static function revertUrlToTitle($url)
	{
		$replace1 = str_replace('*', ' ', $url);
		$replace2 = str_replace('^', '/', $replace1);
		$replace3 = str_replace('`', '.', $replace2);
		$replace4 = str_replace('@', '?', $replace3);

		return $replace4;
	}

	/*抓網址有分舘and語系*/
	public static function b_url($url, $basic = false)
	{
        $parameters = Route::current()->parameters();

        // if(preg_match('/^https?/',$url)){
		// 	return $url;
		// }
		if (isset($parameters['locale']) and !empty($parameters['locale'])) {
			$locale = $parameters['locale'];
			if ($basic) {
				$locale = str_replace("preview_", "", $locale);
			}
		} else {
			$locale = '';
		}

		if (isset($parameters['branch_url']) and !empty($parameters['branch_url'])) {
			$branch = $parameters['branch_url'];
		} else {
			$branch = '';
		}

		$path = ($branch=='' ? '':'/'.$branch).($locale=='' ? '':'/'.$locale).'/'.$url;
		//$path = $locale . '/' . $url;	//此為無分館要把分館層級移除的方法

		return url($path);
	}
    public static function preview_url($url = null)
	{
        $parameters = Route::current()->parameters();

        $locale = str_replace("preview_", "", $parameters['locale'] ?? '');
        $branch = !empty($parameters['branch_url']) ? $parameters['branch_url'] : $parameters['branch'];

        //若 $parameters['branch'] 是第一個模板則特例處理
        $firstBranch = BranchOrigin::first();

        if($branch==$firstBranch['url_title']){
            $path = 'preview_'.$locale.'/'.( !empty($url) ? $url : '');
        }
        else{
            $path = $branch.'/preview_'.$locale.'/'.( !empty($url) ? $url : '');
        }
        return url($path);
    }
	public static function p_url($url)
	{
		$parameters = Route::current()->parameters();

		if (isset($parameters['locale']) and !empty($parameters['locale'])) {
			$locale = $parameters['locale'];
		} else {
			$locale = app()->getLocale();
		}

		if (isset($parameters['branch']) and !empty($parameters['branch'])) {
			$branch = $parameters['branch'];
		} else {
			$branch = app()->getLocale();
		}

		$path = $branch . '/' . $locale . '/' . $url;

		return $path;
	}
	/*抓網址有分舘and語系(後台用)*/
	public static function f_url($url)
	{
		$parameters = Route::current()->parameters();

		if (isset($parameters['locale']) and !empty($parameters['locale'])) {
			$locale = $parameters['locale'];
		} else {
			$locale = app()->getLocale();
		}

		if (isset($parameters['branch']) and !empty($parameters['branch'])) {
			$branch = $parameters['branch'];
		} else {
			$branch = 'branch_default_quill';
		}

		$path = '/Fantasy/' . $branch . '/' . $locale . '/' . $url;

		return url($path);
	}
	/*抓網址有分舘and語系(CMS用)*/
	public static function cms_url($url)
	{
		$parameters = Route::current()->parameters();
		if (isset($parameters['locale']) and !empty($parameters['locale'])) {
			$locale = $parameters['locale'];
		} else {
			$locale = app()->getLocale();
		}

		if (isset($parameters['branch']) and !empty($parameters['branch'])) {
			$branch = $parameters['branch'];
		} else {
			$branch = 'branch_default_quill';
		}

		$path = '/Fantasy/Cms/' . $branch . '/' . $locale . '/unit/' . $url;

		return url($path);
	}

	/*抓preview網址有分舘and語系(CMS用)*/
	public static function cms_preview_url($url)
	{
		$parameters = Route::current()->parameters();
		if (isset($parameters['locale']) and !empty($parameters['locale'])) {
			$locale = $parameters['locale'];
		} else {
			$locale = app()->getLocale();
		}

		if (isset($parameters['branch']) and !empty($parameters['branch'])) {
			$branch = $parameters['branch'];
		} else {
			$branch = 'branch_default_quill';
		}
		$unit = CmsMenu::where('id', $url)->first()->unit;
		
		$template_key = BranchOrigin::where('url_title', $branch)->first()->blade_template;
		$cms_config = collect(config('cms.blade_template'))->where('key', $template_key)->first()['add'];
		if ($cms_config == 0) {
			$preview_path = '/preview_' . $locale . '/' . $unit;
		} else {
			$preview_path = $branch . '/preview_' . $locale . '/' . $unit;
		}

		return url($preview_path);
	}
	
	/*用標題得分館資料*/
	public static function getBranchByTitle($title)
	{
		$data = BranchOrigin::where('url_title', $title)->first();
		$data = (!empty($data)) ? $data->toArray() : [];
		return $data;
	}

	public static function getFilesRouteArray($ids)
	{
		$data = [];
		$file = FmsFile::whereIn('id', $ids)->select('id', 'real_route')->get()->toArray();
		foreach ($file as $key => $value) {
			$data[$value['id']] = $value['real_route'];
		}
		$data[0] = '';

		return $data;
	}
	//抓縮圖
	public static function getFilesRouteArrayM($ids)
	{
		$data = [];
		$file = FmsFile::whereIn('id', $ids)->select('id', 'real_m_route')->get()->toArray();
		foreach ($file as $key => $value) {
			$data[$value['id']] = $value['real_m_route'];
		}
		foreach ($ids as $key => $value) {
			if (empty($data[$value])) {
				$data[$value] = '';
			}
		}
		$data[0] = '';

		return $data;
	}

	public static function getFilesArray($ids)
	{
		$data = [];
		$file = FmsFile::whereIn('file_key', $ids)->get()->toArray();
		foreach ($file as $key => $value) {
			$data[$value['file_key']] = $value;
		}

		return $data;
	}
	public static function getFilesArrayWithKey($ids)
	{
		$data = [];
		$file = FmsFile::whereIn('file_key', $ids)->get()->toArray();
		foreach ($file as $key => $value) {
			$data[$value['file_key']] = $value;
		}

		return $data;
	}

	public static function getAllFilesArray()
	{
		$data = [];
		$file = FmsFile::get()->toArray();
		foreach ($file as $key => $value) {
			$data[$value['id']] = $value;
		}

		return $data;
	}

	public static function getSeoInKey($key = '')
	{
		$globalSeo = Seo::where('key', 'all')->first();
		$globalSeo = !empty($globalSeo) ? $globalSeo->toArray() : [];

		$unitSeo = $key == '' ? [] : Seo::where('key', $key)->first();
		$unitSeo = !empty($unitSeo) ? $unitSeo->toArray() : [];

		$seo = [
			'web_title' => (!empty($unitSeo['web_title'])) ? $unitSeo['web_title'] : $globalSeo['web_title'],
			'meta_keyword' => (!empty($unitSeo['meta_keyword'])) ? $unitSeo['meta_keyword'] : $globalSeo['meta_keyword'],
			'meta_description' => (!empty($unitSeo['meta_description'])) ? $unitSeo['meta_description'] : $globalSeo['meta_description'],
			'ga_code' => (!empty($unitSeo['ga_code'])) ? $unitSeo['ga_code'] : $globalSeo['ga_code'],
			'gtm_code' => (!empty($unitSeo['gtm_code'])) ? $unitSeo['gtm_code'] : $globalSeo['gtm_code'],
			'fb_code' => (!empty($unitSeo['fb_code'])) ? $unitSeo['fb_code'] : $globalSeo['fb_code'],
			'og_title' => (!empty($unitSeo['og_title'])) ? $unitSeo['og_title'] : $globalSeo['og_title'],
			'og_description' => (!empty($unitSeo['og_description'])) ? $unitSeo['og_description'] : $globalSeo['og_description'],
			'og_image' => (!empty($unitSeo['og_image']) and $unitSeo['og_image'] != 0) ? $unitSeo['og_image'] : $globalSeo['og_image'],
			// 結構化標籤
			'structured' => (!empty($unitSeo['structured'])) ? $unitSeo['structured'] : $globalSeo['structured'],
		];

		return $seo;
	}

	public static function getV()
	{
		return date('mdH');
	}

	//Leon 取得所有語系資料
	public static function GetAllLocaleData($Data)
	{
		$data = [];
		$main_data = self::ExplodeModelName($Data['model']);
		foreach ($main_data['locale_list'] as $key => $val) {
			$TableName = ($main_data['SaveToMany']) ? $val . '_' . $main_data['LeonTableName'] : $main_data['LeonTableName'];
			$AllLocaleData = (array) DB::table($TableName)->where('id', $Data['data_id'])->first();
			$AllLocaleData['locale'] = $val;
			if (isset($Data['class_model'])) {
				$class_data = self::ExplodeModelName($Data['class_model']);
				foreach ($class_data['locale_list'] as $Class_key => $Class_val) {
					if ($val == $Class_val) {
						$Class_TableName = ($class_data['SaveToMany']) ? $Class_val . '_' . $class_data['LeonTableName'] : $class_data['LeonTableName'];
						$AllLocaleData[$Data['class_key']] = (array) DB::table($Class_TableName)->where('id', $AllLocaleData[$Data['class_key']])->first();
						if (isset($Data['class_model_first'])) {
							$class_first_data = self::ExplodeModelName($Data['class_model_first']);
							foreach ($class_first_data['locale_list'] as $Class_first_key => $Class_first_val) {
								if ($val == $Class_first_val) {
									$Class_first_TableName = ($class_data['SaveToMany']) ? $Class_first_val . '_' . $class_first_data['LeonTableName'] : $class_first_data['LeonTableName'];
									$AllLocaleData[$Data['class_key_first']] = (array) DB::table($Class_first_TableName)->where('id', $AllLocaleData[$Data['class_key_first']])->first();
								}
							}
						}
					}
				}
			}
			$data[] = $AllLocaleData;
		}
		return idorname($data);
	}

	/*=======複製資料功能=======*/
	public static function cloneData($modelname, $id_array, $locale, $menu_id, $branch)
	{
		$copytoall = Config::get('cms.copytoall');
		$langArray = Config::get('cms.langArray');
		$locale_list = [$locale];
		if ($copytoall) {
			$branch_id = M('BranchOrigin')::where('url_title', $branch)->first()->id;
			$locale_list = array_column(Config::get('models.BranchOriginUnit')::select('locale')->where('origin_id', $branch_id)->groupby('locale')->get()->toArray(), 'locale');
		}
		$LeonTableName = M_table_Config(M($modelname));
		$model_locale = explode("_", $LeonTableName);
		$SaveToMany = false;
		if (count($model_locale) > 1 && in_array($model_locale[0], array_column($langArray, 'key'))) {
			unset($model_locale[0]);
			$LeonTableName = implode("_", $model_locale);
			$SaveToMany = true;
		}
		foreach ($locale_list as $val) {
			$TableName = ($SaveToMany) ? $val . '_' . $LeonTableName : $LeonTableName;
			$data = Config::get('models.' . $modelname)::whereIn('id', $id_array)->get();
			$LastDataID = Config::get('models.' . $modelname)::orderby('id', 'desc')->first()->id;
			$CopyArr = ['title', 'w_title', 'url_title', 'url_name'];
			foreach ($data as $key => $row) {
				foreach ($CopyArr as $v) {
					if (isset($row[$v])) {
						$row[$v] = $row[$v] . '_(複製' . $LastDataID . ')';
					}
				}
				$row['is_reviewed'] = 0;
				$row['is_preview'] = 0;
				$row['is_visible'] = 0;
				// 複製主資料
				$new_row = $row->replicate()->setTable($TableName);
				$new_row->push();
				//自動更新分類權限
				if (!empty($menu_id)) {
					$isAuth = intval(CmsMenu::find($menu_id)->toArray()['has_auth']);
					$branch_id = $row['branch_id'];
					$branch_unit_id = M('BranchOriginUnit')::where('origin_id', $branch_id)->where('locale', $val)->first()->id;
					if ($isAuth > 0) {
						$CmsDataAuth = CmsDataAuth::where('menu_id', $menu_id)->where('lang', $val)->whereHas('CmsRole', function ($query) use ($branch_unit_id) {
							$query->where('user_id', Session::get('fantasy_user.id'))->where('branch_unit_id', $branch_unit_id);
						})->first();
						if (!empty($CmsDataAuth)) {
							$NewDataId = json_decode($CmsDataAuth->data_id, true);
							//如果有pass就不增加
							if (!in_array("pass", $NewDataId)) {
								if (!in_array($new_row->id, $NewDataId)) {
									$NewDataId[] = $new_row->id;
								}
							}
							$CmsDataAuth = CmsDataAuth::where('id', $CmsDataAuth->id)->first();
							$CmsDataAuth->data_id = json_encode($NewDataId);
							$CmsDataAuth->save();
						}
					}
				}

				// 複製關聯資料
				self::cloneDataFn($modelname, $row, $new_row, $val, $key, $locale_list);
				$LastDataID++;
			}
		}
	}

	public static function cloneDataFn($modelname, $old_data, $new_data, $locale, $key, $locale_list)
	{
		$copytoall = Config::get('cms.copytoall');
		$langArray = Config::get('cms.langArray');
		// 清空關聯
		$old_data->relations = [];

		// 判斷是否有要複製的關聯
		if (!defined(Config::get('models.' . $modelname) . '::clone_relations')) return false;

		// 要複製的關聯
		$clone_relations = Config::get('models.' . $modelname)::clone_relations;

		// 複製關聯資料
		foreach ($clone_relations as $model) {
			$TempModel = str_replace("_many", "", $model);
			$LeonTableName = M_table_Config(M($TempModel));
			$model_locale = explode("_", $LeonTableName);
			$SaveToMany = false;
			if (count($model_locale) > 1 && in_array($model_locale[0], array_column($langArray, 'key'))) {
				unset($model_locale[0]);
				$LeonTableName = implode("_", $model_locale);
				$SaveToMany = true;
			}

			$TableName = ($SaveToMany) ? $locale . '_' . $LeonTableName : $LeonTableName;

			//T__T 不知道要幹嘛
			// if ($key != 0) {
			// 	break;
			// }

			// 載入關聯資料
			$old_data->load($model);

			// 有關聯資料才複製
			if ($old_data->has($model) && $old_data->$model()->count() > 0) {
				$relate_data = $old_data->$model()->get();

				$arr_assoc = [];
				foreach ($relate_data as $relate_row) {
					array_push($arr_assoc, $relate_row->replicate()->setTable($TableName));
				}
				if (count($arr_assoc) > 0) {
					// 儲存關聯資料
					$new_data->$model()->saveMany($arr_assoc);

					// 檢查下一層是否有要複製的關聯
					if (defined(Config::get('models.' . str_replace("_many", "", $model)) . '::clone_relations')) {
						// 複製下一層資料
						for ($i = 0; $i < count($relate_data); $i++) {

							self::cloneDataFn(str_replace("_many", "", $model), $relate_data[$i], $arr_assoc[$i], $locale, $key, $locale_list);
						}
					}
				}
			}
		}
	}
	/*=======複製資料功能=======*/

	//
	public static function moveTable($oriTable,$col,$tableYm,$selectYm)
	{
		//目的表名
		$revTable = $oriTable.'_'.$tableYm;

		//取得新增表格sql語法
		// 获取原始表的结构 DB::raw("SHOW CREATE TABLE `$originalTableName`;") 長出的物件在laravel10以上無法丟到 DB::raw中
		// $tableStructure = DB::select(DB::raw("SHOW CREATE TABLE `$originalTableName`;"));
		$tableStructure = DB::select('SHOW CREATE TABLE `'.$oriTable.'`;');
		$createStatement = $tableStructure[0]->{"Create Table"};
		//取代語句中表名
		$createStatement = str_replace("CREATE TABLE `".$oriTable."`", "CREATE TABLE `".$revTable."`", $createStatement);
		//執行新增資料表語句
		DB::statement($createStatement);

		//執行插入語法 DB::raw取出的語法無法使用在 DB::insert laravel10以上
		// DB::insert(DB::raw("INSERT INTO `".$newTableName."` SELECT * FROM `".$originalTableName."`"));
		$insertSql = 'INSERT INTO `'.$revTable.'` SELECT * FROM `'.$oriTable.'` WHERE `'.$col.'` LIKE "'.$selectYm.'%";';
		DB::insert($insertSql);
		$deleteSql = 'DELETE FROM `basic_log_data` WHERE `'.$col.'` LIKE "'.$selectYm.'%";';
		DB::delete($deleteSql);
	}
	//
	public static function logTableInit()
	{
		$nowDateMonth = date('Ym');
		$tableName = 'basic_log_data';

		$flow = false;
		while(!$flow){
			$firstLog = DB::table($tableName)->first();
			if(empty($firstLog)){
				$flow = true;
				continue;
			}
			$saveYM = date('Ym',strtotime($firstLog->create_time));
			if($saveYM==$nowDateMonth){
				$flow = true;
				continue;
			}
			$selectYm = date('Y-m',strtotime($firstLog->create_time));
			self::moveTable($tableName,'create_time',$saveYM,$selectYm);
		}
	}
	//檢查log table是否已處理過舊資料
	public static function checkLogTable()
	{
		$tableName = 'basic_log_data';
		$nowDateMonth = date('Ym');

		//檢查第一筆資料是否是同月份資料
		$firstLog = DB::table($tableName)->first();
		if(!empty($firstLog) && date('Ym',strtotime($firstLog->create_time)) != $nowDateMonth){
			self::logTableInit();
		}
	}
	public static function writeLogData($type, $data)
	{
		self::checkLogTable();
		$logData = new LogData();
		$logData->create_time = date('Y-m-d H:i:s');
		$ChangeData = (isset($data['ChangeData'])) ? $data['ChangeData'] : '';
		$columns = (isset($data['columns'])) ? $data['columns'] : '';
		$classname = (!empty($data['classname'])) ? $data['classname'] : 'CMS';
		$DataExist = false;
		$ViewerIP = !empty($data['ip']) ? $data['ip'] : "";
		if (!empty($ChangeData)) {
			switch ($type) {
				case 'insert':
					$logData->table_name = $data['table'];
					$logData->data_id = $data['id'];
					$logData->log_type = $type;
					$logData->ChangeData = $ChangeData;
					$logData->classname = $classname;
					$logData->ip = $ViewerIP;
					break;
				case 'edit':
					$logData->table_name = $data['table'];
					$logData->data_id = $data['id'];
					$logData->log_type = $type;
					$logData->ChangeData = $ChangeData;
					$logData->classname = $classname;
					$DataExist = (!empty(LogData::select('id')->where('data_id', $data['id'])->where('ChangeData', $ChangeData)->first())) ? true : false;
					$logData->ip = $ViewerIP;
					break;
				case 'login':
					$logData->log_type = 'login';
					$logData->classname = 'Login';
					$logData->ip = $ViewerIP;
					break;
				case 'del':
					$logData->table_name = $data['table'];
					$logData->data_id = $data['id'];
					$logData->log_type = 'del';
					$logData->ChangeData = $ChangeData;
					$logData->classname = $classname;
					$logData->ip = $ViewerIP;
					break;
				default:
					$logData->log_type = 'NONE';
					$logData->ip = $ViewerIP;
					break;
			}
			$logData->user_id = Session::get('fantasy_user.id');
			$logData->user_name = Session::get('fantasy_user.name');
			if (!$DataExist) {
				$logData->save();
			}
		} else {
			if ($type == 'login') {
				$logData->log_type = 'login';
				$logData->classname = 'Login';
				$logData->user_id = Session::get('fantasy_user.id');
				$logData->user_name = Session::get('fantasy_user.name');
				$logData->ip = $ViewerIP;
				$logData->save();
			}
		}
	}

    public static function get_file_path($File)
	{
		$data = config('models.FmsFile')::whereId($File['id'])->with('Topfolder')->first()->toarray();

		$path = '';
		if (!empty($data)) {
			$a = $data['topfolder'];
			if (!empty($a)) {
				do {
					if ($path == '') {
						$path .= $a['title'];
					} else {
						$path = $a['title'] . ' / ' . $path;
					}
					$a = $a['top_folder'];
				} while (!empty($a));
			}
		}

		$path =  '根目錄 / ' . $path;
		return $path;
	}

	public static function cvt_file_size($file_size)
	{
		if ($file_size > 1048576) {
			$new_size = round($file_size / 1048576, 2) . ' MB';
		} else {
			$new_size = round($file_size / 1024, 2) . ' KB';
		}

		return $new_size;
	}

	public static function get_auth_id($menu_id, $branch_id, $useData = "")
	{
		$ReturnArr = [];
		$data_id = CmsDataAuth::where('menu_id', $menu_id)->where('lang', substr(Config::get('app.dataBasePrefix'), 0, 2))->whereHas('CmsRole', function ($query) use ($branch_id) {
			$query->where('user_id', Session::get('fantasy_user.id'))
				->whereHas('BranchOriginUnit', function ($query1) use ($branch_id) {
					$query1->where('origin_id', $branch_id);
				});
		});

		if ($data_id->count() > 0 && $data_id->first()->data_id != '') {
			$ReturnArr = json_decode($data_id->first()->data_id);
		}
		//如果使用內容判斷
		if (!empty($useData)) {
			$data_ids = json_decode($data_id->first()->data_id);
			$CmsMenu = CmsMenu::where('id', $menu_id)->first()->toArray()['model'];
			$CmsMenuL = Config::get('models.' . $CmsMenu)::whereIn('id', $data_ids)->get()->toArray();
			//如果是多條件
			$add = [];
			foreach ($CmsMenuL as $val) {
				$TheData = explode(",", $val[$useData]);
				if (count($TheData) > 1) {
					//切割後找資料的ID
					$add = Config::get('models.' . $CmsMenu)::whereIn($useData, $TheData)->select('id')->get()->toArray();
				}
			}
			$ReturnArr = array_merge(array_column($add, 'id'), json_decode($data_id->first()->data_id));
		}
		//dd($menu_id);
		return $ReturnArr;
	}

	public static function get_folder_level($zero, $first, $second, $third)
	{
		if ($third != 0) {
			$f3 = Config::get('models.FmsThird')::where('id', $third)->first();
			$f2 = Config::get('models.FmsSecond')::where('id', $f3['second_id'])->first();
			$f1 = Config::get('models.FmsFirst')::where('id', $f2['first_id'])->first();
			$f0 = Config::get('models.FmsZero')::where('id', $f1['zero_id'])->first();
		} elseif ($second != 0) {
			$f3 = ['id' => 0];
			$f2 = Config::get('models.FmsSecond')::where('id', $second)->first();
			$f1 = Config::get('models.FmsFirst')::where('id', $f2['first_id'])->first();
			$f0 = Config::get('models.FmsZero')::where('id', $f1['zero_id'])->first();
		} elseif ($first != 0) {
			$f3 = ['id' => 0];
			$f2 = ['id' => 0];
			$f1 = Config::get('models.FmsFirst')::where('id', $first)->first();
			$f0 = Config::get('models.FmsZero')::where('id', $f1['zero_id'])->first();
		} else {
			return [
				$zero, $first, $second, $third
			];
		}

		return [
			$f0['id'], $f1['id'], $f2['id'], $f3['id']
		];
	}

	public static function RealFiles($id = '', $default = true)
	{
		$file = FmsFile::where("file_key", $id)->first();

		if (!empty($file)) {
			return $file['real_route'];
		} else {
			if ($default) {
				return "/noimage.svg";
			} else {
				return "";
			}
		}
	}
	public static function RealFilesM($id = '', $default = true)
	{
		$file = FmsFile::where("id", $id)->first();

		if (!empty($file)) {
			return $file['real_m_route'];
		} else {
			if ($default) {
				return "/noimage.svg";
			} else {
				return "";
			}
		}
	}
	public static function RealFilesSize($id = '')
	{
		$file = FmsFile::where("id", $id)->first();

		$bytes = 0;
		if (!empty($file)) {
			$file = $file->toArray();


			if ($file['size'] < 1048576) return number_format($file['size'] / 1024, 1) . " KB";
			if ($file['size'] >= 1048576 && $file['size'] < 1073741824) return number_format($file['size'] / 1048576, 1) . " MB";
			if ($file['size'] >= 1073741824) return number_format($file['size'] / 1073741824, 1) . " GB";



			//$bytes = number_format($file['size'] / 1024, 2);

		}

		return $bytes . ' KB';
	}
	public static function RealFilesAlt($id = '', $default = true)
	{
		$file = FmsFile::where("id", $id)->first();
		if (!empty($file)) {
			return $file['alt'];
		} else {
			return "";
		}
	}
	public static function C_Format($num)
	{
		if ($num > 1000) {
			$a = round($num);
			$a_number_format = number_format($a);
			$a_array = explode(',', $a_number_format);
			$a_parts = array('k', 'm', 'b', 't');
			$a_count_parts = count($a_array) - 1;
			$a_display = $a;
			$a_display = $a_array[0] . ((int) $a_array[1][0] !== 0 ? '.' . $a_array[1][0] : '');
			$a_display .= $a_parts[$a_count_parts - 1];

			return $a_display;
		}

		return $num;
	}
	public static function RealFilesName($id = '')
	{
		$file = FmsFile::where("id", $id)->first();
		$file_name = '';
		if (!empty($file)) {
			$file = $file->toArray();
			$file_name = $file['title'] . '.' . $file['type'];
		}
		if ($id == 0) {
			$file_name = "";
		}
		return $file_name;
	}

	public static function switchLangUrl($lang = 'en', $url = '')
	{
		$currentPath = request()->path();
		$isPreview = false;

		if (strpos($currentPath, 'preview_') !== false) {
			$currentPath = str_replace('preview_', '', $currentPath);
			$isPreview = true;
		}

		$patternWithSlash = '^([a-zA-Z-]+)(?=\/)'; // 如果除了語系後面還有值的話 ex: en/path1/path2
		$patternWithoutSlash = '^([a-zA-Z-]+)'; // 如果只有語系 ex: en

		$newPath = preg_replace('/' . $patternWithSlash . '|' . $patternWithoutSlash . '/', $lang, $currentPath);
		$newPath = $isPreview ? "preview_{$newPath}" : $newPath;

		return url($newPath);
	}

    public static function imgSrc($filePath)
	{
        $s3_use = config('fms.s3_use');
        $prefix = '/'.config('fms.s3_prefix');
        if( $s3_use && strpos($filePath,$prefix) !== false ) return config('fms.s3_route').$filePath;
        // if($s3_use) return config('fms.s3_route').$filePath;
        else return url($filePath);
    }
}
