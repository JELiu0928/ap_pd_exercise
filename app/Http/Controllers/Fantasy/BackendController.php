<?php

namespace App\Http\Controllers\Fantasy;

use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Fantasy\PermissionController as PermissionFunction;
use View;
use Redirect;
use Auth;
use Debugbar;
use Route;
use App;
use Config;
use Session;
use DB;
use Schema;

use UnitMaker;
use TableMaker;
use BaseFunction;
use App\Helpers\PreviewUrl;
use App\Models\Basic\Cms\CmsMenu;
use Carbon\Carbon;
use App\Services\Search\SearchManager;
use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;

abstract class BackendController extends BaseController
{

	// 疑似未使用#HondaDebug
	// public static $ProjectName = '天下第一武道會';

	// 是否有分館。預計以後全部程式直接讀Config的設定，先保留這個參數避免出錯#Honda181003
	public static $setBranchs = '';
	/*語系預設變數*/
	public static $baseLocale = '';
	/*分館預設變數*/
	public static $baseBranchId = '';
	public static $baseBranchLink = '';
	public static $baseBranchTitle = '';

	// Model設定。預計以後將資料庫邏輯另外寫，先保留這個參數避免出錯#Honda181003
	protected static $ModelsArray = [];

	// 語系設定。預計以後全部程式直接讀Config的設定，先保留這個參數避免出錯#Honda181003
	protected static $langArray = [];

	function __construct()
	{

		// 取得是否有分館設定
		self::$setBranchs = Config::get('cms.setBranchs', false);

		// 取得語系設定
		self::$langArray = Config::get('cms.langArray', []);

		// 取得Model設定
		self::$ModelsArray = Config::get('models', []);

		// 取得目前querystring
		$parameters = Route::current()->parameters();
		$r = Route::current()->uri();

		/*確認路徑中分館*/
		self::checkRouteBranch($parameters);
		/*語系*/
		self::checkRouteLang($parameters);

		// View直接讀Config的設定#Honda181003
		// View::share('ProjectName', self::$ProjectName);

		// 疑似未使用#HondaDebug
		// View::share('setBranchs', Config::get('cms.setBranchs', false));

		//審核
		if (!empty(session('fantasy_user'))) {

			View::share('ReviewNotifyCount', M('ReviewNotify')::select('id')->whereJsonContains('admins', session('fantasy_user')['id'])->count());
			View::share('SelfReviewNotifyCount', M('ReviewNotify')::select('id')->where('user_id', session('fantasy_user')['id'])->count());
		}
	}
	/*補語系*/
	public static function checkRouteLang($parameters)
	{

		$now_locale = array_key_exists('locale', $parameters) ? $parameters['locale'] : '';

		$langArray = Config::get('cms.langArray');

		if (!array_key_exists($now_locale, $langArray)) $now_locale = Config::get('app.locale');

		App::setLocale($now_locale);
		Config::set('app.dataBasePrefix', '' . $now_locale . '_');

		/*讓View與Controller都有語系變數*/
		self::$baseLocale = $now_locale;
		View::share('locale', self::$baseLocale);// 疑似未使用#HondaDebug

		/*讓View與Controller都有語系變數 -- END*/
	}
	/*補分館相關資訊*/
	public static function checkRouteBranch($parameters)
	{
		/*抓分館ID與標題*/
		if (isset($parameters['branch']) and !empty($parameters['branch'])) {
			if ((isset($parameters['locale'])) && $parameters['locale'] != 'branch_default_quill') {
				$branchUrlTitle = $parameters['branch'];
				$branch = BranchOrigin::where('url_title', $branchUrlTitle)->first();
				if (!empty($branch)) {
					/*讓View與Controller都可以使用分館變數*/
					View::share('baseBranchId', $branch->id);
					View::share('baseBranchLink', $branchUrlTitle);
					View::share('baseBranchTitle', $branch->title);
					self::$baseBranchId = $branch->id;
					self::$baseBranchLink = $branchUrlTitle;
					self::$baseBranchTitle = $branch->title;
					/*讓View與Controller都可以使用分館變數 -- END*/
				}
			}
		}
	}
	/*串options以便使用*/
	public static function getOption($set)
	{

		$data = [];

		if ($set == 'menu') {
			/*類型select option*/
			$typeOptions =
				[
					1 => [
						'title' => '第一層(無內容)',
						'key' => '1'
					],
					2 => [
						'title' => '第一層(有內容)',
						'key' => '2'
					],
					3 => [
						'title' => '第二層(有內容)',
						'key' => '3'
					],
					4 => [
						'title' => '第二層(無內容)',
						'key' => '4'
					],
					5 => [
						'title' => '第三層',
						'key' => '5'
					]

				];
			/*資料夾類型*/
			$useOptions =
				[
					1 => [
						'title' => '品牌總覽',
						'key' => '1'
					],
					2 => [
						'title' => '分館',
						'key' => '2'
					]
				];
			$keyOptions = [];
			$menuOptions = [];
			$optionOptions = [];
			/*得網頁key值*/
			$keyData = self::$ModelsArray['WebKey']::get()->toArray();
			/*組 Web Key option*/
			foreach ($keyData as $key => $value) {
				$keyOptions[$value['id']] =
					[
						'title' => $value['title'],
						'key' => $value['id']
					];
			}
			$menuData = self::$ModelsArray['CmsMenu']::get()->toArray();
			/*組爸爸選單*/
			foreach ($menuData as $key => $value) {
				if ($value['type'] == 1) {
					$key_set = $value['id'];
					$menuOptions[$key_set]['title'] = $value['title'];
					$menuOptions[$key_set]['key'] = $value['id'];
				}
			}
			$model_temp = self::$ModelsArray['OptionSet'];
			$optionData = $model_temp::all()->toArray();
			/*組選項選單*/
			foreach ($optionData as $key => $value) {
				$key_set = $value['id'];
				$optionOptions[$key_set]['title'] = $value['title'];
				$optionOptions[$key_set]['key'] = $value['id'];
			}
			$data['typeOptions'] = $typeOptions;
			$data['keyOptions'] = $keyOptions;
			$data['menuOptions'] = $menuOptions;
			$data['optionOptions'] = $optionOptions;
			$data['useOptions'] = $useOptions;
		} else if ($set == 'file') {
			/*資料夾類型*/
			$filesOptions =
				[
					1 => [
						'title' => '共用',
						'key' => '1'
					],
					2 => [
						'title' => '品牌總覽',
						'key' => '2'
					],
					3 => [
						'title' => '分館',
						'key' => '3'
					]
				];
			$keyOptions = [];
			/*得網頁key值*/
			$model_temp = self::$ModelsArray['WebKey'];
			$keyData = $model_temp::all()->toArray();
			/*組 Web Key option*/
			foreach ($keyData as $key => $value) {
				$keyOptions[$value['id']] =
					[
						'title' => $value['title'],
						'key' => $value['id']
					];
			}
			$data['keyOptions'] = $keyOptions;
			$data['filesOptions'] = $filesOptions;
		} else if ($set == 'option') { } else if ($set == 'key') { } else {
			$basic_cms_menu = M('CmsMenu')::where('id', $set)->first();
			$has_auth = $basic_cms_menu->has_auth ?: 0;
			$model_temp = self::$ModelsArray['CmsParent'];
			/*將老爸單元當成選項*/
			if (self::$setBranchs) {
				$parentData = $model_temp::where('menu_id', $basic_cms_menu->use_id)->get()->toArray();
			} else {
				$parentData = $model_temp::where('menu_id', $set)->get()->toArray();
			}
			$auth_id = BaseFunction::get_auth_id($has_auth, self::$baseBranchId);
			foreach ($parentData as $key => $value) {
				if (empty($value['with_m'])) {
					$model_temp = M($value['parent_model']);

					$TableName = with(new $model_temp)->getTable();
					if ((int) method_exists($model_temp, 'scopeget_cms_option')) {
						if (Schema::hasColumn($TableName, 'branch_id')) {
							if (!empty($auth_id)) {
								$tempOptions = $model_temp::wherein('id', $auth_id)->where('branch_id', self::$baseBranchId)->where('id', '>', 0)->get_cms_option($value['parent_option']);
							} else {
								$tempOptions = $model_temp::where('branch_id', self::$baseBranchId)->where('id', '>', 0)->get_cms_option($value['parent_option']);
							}
						} else {
							$tempOptions = $model_temp::get_cms_option($value['parent_option']);
						}
					} else {
						if (!empty($auth_id)) {
							$tempData = $model_temp::wherein('id', $auth_id)->where('branch_id', self::$baseBranchId)->where('id', '>', 0)->get()->toArray();
						} else {
							$tempData = $model_temp::where('branch_id', self::$baseBranchId)->where('id', '>', 0)->get()->toArray();
						}
						$tempOptions = [];
						foreach ($tempData as $key2 => $value2) {
							$Leon_value = explode(",", $value['parent_option']);
							$Leon_title = [];
							$find_title = false;
							foreach ($Leon_value as $val) {
								if (isset($value2[$val])) {
									if ($val == 'title') {
										$find_title = true;
									}
								}
							}
							foreach ($Leon_value as $val) {
								if (isset($value2[$val])) {
									if ($find_title) {
										if (strpos($val, 'title') !== false) {
											if ($val == 'title') {
												$Leon_title[] = $value2[$val];
											}
										} else {
											$Leon_title[] = $value2[$val];
										}
									} else {
										$Leon_title[] = $value2[$val];
									}
								}
							}

							$tempOptions[$value2['id']] =
								[
									'title' => implode(" ", $Leon_title),
									'key' => $value2['id']
								];
						}
					}
				} else {
					$model_temp = self::$ModelsArray[$value['parent_model']];
					$tempData = $model_temp::where('branch_id', self::$baseBranchId)->with($value['with_m'])->get()->toArray();
					$tempOptions = [];
					foreach ($tempData as $key2 => $value2) {
						if (!empty($value2[$value['with_db']])) {
							$Leon_value = explode(",", $value['parent_option']);
							$Leon_title = [];
							$find_title = false;
							foreach ($Leon_value as $val) {
								if (isset($value2[$val])) {
									if ($val == 'title') {
										$find_title = true;
									}
								}
							}
							foreach ($Leon_value as $val) {
								if (isset($value2[$val])) {
									if ($find_title) {
										if (strpos($val, 'title') !== false) {
											if ($val == 'title') {
												$Leon_title[] = $value2[$val];
											}
										} else {
											$Leon_title[] = $value2[$val];
										}
									} else {
										$Leon_title[] = $value2[$val];
									}
								}
							}
							$tempOptions[$value2['id']] =
								[
									'title' => ($value2[$value['with_db']][$value['with_name']] ?? $value2[$value['with_db']]['title']) . ' → ' . implode(" ", $Leon_title),
									'key' => $value2['id']
								];
						}
					}
				}

				$data[$value['parent_model']] = $tempOptions;
			}
			/*get這單元用到關聯*/
			$model_temp = self::$ModelsArray['CmsMenu'];
			$menuData = $model_temp::where('id', $set)->first();
			if (isset($menuData->options_group) and !empty($menuData->options_group)) {
				$options = json_decode($menuData->options_group, true);
				foreach ($options as $key => $value) {
					$tempOptions = [];
					$model_temp = self::$ModelsArray['OptionSet'];
					$tempData = $model_temp::where('branch_id', self::$baseBranchId)->where('id', $value)->with('OptionItem')->first();
					if (!empty($tempData)) {
						$tempData = $tempData->toArray();
						foreach ($tempData['option_item'] as $key2 => $value2) {
							$tempOptions[$value2['key_value']] =
								[
									'title' => $value2['title'],
									'key' => $value2['key_value']
								];
						}
						$data[$tempData['key']] = $tempOptions;
					}
				}
			}
		}
		return $data;
	}
	/********index用資料(頁碼、搜尋條件)********/
	public static function getDataNew($menuData, $page, $search, $search_type, $group, $menu_id = "", $data_id = null)
	{
		$modelName = $menuData->model;

		$has_auth = (Config::get('models.CmsMenu'))::where('id', $menu_id)->first()->has_auth;
		$roles = PermissionFunction::getCmsAuthority($menu_id);
		if ($roles['need_review'] && $roles['can_review']) {
			$has_auth = 0;
		}

		//如果是獨立編輯
		if ($menuData->is_content && M($modelName)::where('branch_id', self::$baseBranchId)->count() == 0) {
			$CreateData = M($modelName, true);
			$CreateData->branch_id = self::$baseBranchId;
			$CreateData->save();
		}

		$data = M($modelName)::where('branch_id', self::$baseBranchId);

		$CustomWhere = (defined(self::$ModelsArray[$modelName] . '::CustomWhere')) ? self::$ModelsArray[$modelName]::CustomWhere : "";
		$jointable = (defined(self::$ModelsArray[$modelName] . '::JoinTable')) ? self::$ModelsArray[$modelName]::JoinTable : "";

		//Leon
		if (!empty($data_id)) {
			$data->where('id', $data_id);
		}

		//Adam
		if ($menu_id != "") {
			$filter = config('models.CmsMenu')::where('id', $menu_id)->first()->filter;
			if (!empty($filter)) {
				foreach (json_decode($filter, true) as $key => $value) {
					$data->where($key, $value);
				}
			}
		}

		// 新增權限篩選
		if (intval($has_auth) != 0) {
			$data->CheckAuth($has_auth, self::$baseBranchId);
		}
		if (!empty($search['sort'])) {
			$sort = $search['sort'];
			$data->orderBy(key($sort), current($sort));
		}
		/*===搜尋條件Start====*/
		if (count($search) > 0) {
			$searchManager = new SearchManager($search, $search_type, $data, $modelName);
			if ($search_type == 'basic') {
			$data = $searchManager->search();
			} else {
				$data = $searchManager->testSearch();
			}
		}
		/*===搜尋條件End====*/
		$data = \App\Http\Controllers\Fantasy\WhereController::Customize($modelName, $menu_id, $data);

		/*===取得總筆數====*/
		$info['count'] = $data->count();

		/*===取得總頁數====*/
		$info['pn'] = ceil($info['count'] / $group);
		if ($info['pn'] > 0 && $page > $info['pn']) $page = $info['pn'];

		/*===排序====*/
		if (Config::get('cms.CMSSort', false) === true) $data->doCMSSort();

		/*===取得資料====*/
		$info['data'] = $data->skip(($page - 1) * $group)->take($group)->get();
		return $info;
	}

	public static function getAssociationData($set, $id)
	{
		$data = [];
		if ($set == 'menu') {
			$data['son']['CmsChild'] = [];
			$data['son']['CmsParent'] = [];
			if (!empty($id)) {
				$data['son']['CmsChild'] = self::$ModelsArray['CmsChild']::where('menu_id', $id)->get()->toArray();
				$data['son']['CmsParent'] = self::$ModelsArray['CmsParent']::where('menu_id', $id)->get()->toArray();
			}
		} else if ($set == 'option') {

			$model_temp = self::$ModelsArray['OptionItem'];
			$data['son']['OptionItem'] = $model_temp::where('option_set_id', $id)->get()->toArray();
		} else if ($set == 'file') { } else if ($set == 'key') { } else {

			$set = M('CmsMenu')::where('id', intval($set))->first()['use_id'];
			$model_temp = self::$ModelsArray['CmsChild'];
			$sonData = $model_temp::where('menu_id', $set)->get()->toArray();

			/*得子關聯資料*/
			if (!empty($id)) {
				foreach ($sonData as $key => $value) {
					$model_temp = self::$ModelsArray[$value['child_model']];
					if ($value['is_rank'] == 1) {
						$data['son'][$value['child_model']] = $model_temp::where($value['child_key'], $id)->orderBy('w_rank', 'asc')->get()->toArray();
					} else {
						$data['son'][$value['child_model']] = $model_temp::where($value['child_key'], $id)->get()->toArray();
					}
					$model_ass_son = self::$ModelsArray['CmsChildSon'];
					$son_son_Data = $model_ass_son::where('child_id', $value['id'])->get()->toArray();
					foreach ($son_son_Data as $key22 => $value22) {
						$model_son_son = self::$ModelsArray[$value22['model_name']];
						foreach ($data['son'][$value['child_model']] as $key33 => $value33) {
							$data['son'][$value['child_model']][$key33]['son'][$value22['model_name']] = $model_son_son::where($value22['child_key'], $value33['id'])->orderBy('w_rank', 'asc')->get()->toArray();
						}
					}
				}
			}
		}

		return $data;
	}
	public static function getJsonArray($set)
	{
		$data = [];

		if ($set == 'menu') { } else if ($set == 'option') { } else if ($set == 'file') { } else if ($set == 'key') { } else if ($set == 'option') { } else {

			$menuData = self::$ModelsArray['CmsMenu']::where('id', $set)->first();

			$data = json_decode($menuData->json_group, true);
		}


		return $data;
	}
}