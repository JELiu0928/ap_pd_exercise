<?php

namespace App\Http\Controllers\Fantasy;

use Illuminate\Http\Request;

use View;
use Route;
use App;
use Config;
use Session;
use DB;

use BaseFunction;
use voku\helper\HtmlDomParser;

class LeonController extends BackendController
{
	public function recursive_dir_copy($src, $dst)
	{
		if (empty($src) || empty($dst)) {
			return false;
		}
		$dir = opendir($src);
		self::dir_mkdir($dst);
		while (false !== ($file = readdir($dir))) {
			if (($file != '.') && ($file != '..')) {
				$srcRecursiveDir = $src . DIRECTORY_SEPARATOR . $file;
				$dstRecursiveDir = $dst . DIRECTORY_SEPARATOR . $file;
				if (is_dir($srcRecursiveDir)) {
					self::recursive_dir_copy($srcRecursiveDir, $dstRecursiveDir);
				} else {
					copy($srcRecursiveDir, $dstRecursiveDir);
				}
			}
		}

		closedir($dir);
		return true;
	}
	public function dir_mkdir($path = '', $mode = 0755, $recursive = true)
	{
		clearstatcache();
		if (!is_dir($path)) {
			mkdir($path, $mode, $recursive);
			return chmod($path, $mode);
		}
		return true;
	}
	public function dir_path($path)
	{
		$path = str_replace('\\', '/', $path);
		if (substr($path, -1) != '/') $path = $path . '/';
		return $path;
	}
	public function dir_list($path, $exts = '', $list = array())
	{
		$path = self::dir_path($path);
		$files = glob($path . '*');
		foreach ($files as $v) {
			if (!$exts || preg_match('/\.($exts)/i', $v)) {
				$list[] = $v;
				if (is_dir($v)) {
					$list = self::dir_list($v, $exts, $list);
				}
			}
		}
		return $list;
	}
	public function index()
	{
		$path = public_path('resources');
		$path = self::dir_path($path);
		$public_resources = glob($path . '*');
		return View::make(
			'Fantasy.Leon.index',
			[
				'public_resources' => $public_resources
			]
		);
	}
	public function uploadDesign(Request $request)
	{
		set_time_limit(0);
		$path = public_path('resources');
		$path = self::dir_path($path);
		$public_resources = glob($path . '*');

		foreach ($public_resources as $public_resources_val) {
			$branch = basename($public_resources_val);
			//分館資料夾
			$upload_path = [];
			$main_folder = [];
			//有分館
			if (!empty($branch)) {
				$folderPath = 'resources/' . $branch;
				DB::table('basic_fms_folder')->updateOrInsert(['folder_key' => $branch, 'parent_id' => 1], [
					'parent_id' => 1,
					'self_level' => 1,
					'is_private' => 0,
					'can_use' => '[]',
					'title' => $branch,
					'create_id' => 1,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]);
				$main_folder = M('Fmsfolder')::where('folder_key', $branch)->where('parent_id', 1)->first();
			} else {
				$folderPath = '';
				$main_folder = M('Fmsfolder')::where('id', 1)->where('parent_id', 1)->first();
			}
			$getPath = $folderPath . '/assets/img';
			if (!file_exists(public_path($getPath))) {
				$getPath = 'assets/img';
			}
			if (!file_exists(public_path($getPath))) {
				$getPath = '';
			}
			if (!empty($getPath)) {
				$upload_path[] = $getPath;
			}
			$getPathVideo = $folderPath . '/assets/video';
			if (!file_exists(public_path($getPathVideo))) {
				$getPathVideo = 'assets/video';
			}
			if (!file_exists(public_path($getPathVideo))) {
				$getPathVideo = '';
			}
			if (!empty($getPathVideo)) {
				$upload_path[] = $getPathVideo;
			}
			foreach ($upload_path as $Path) {
				$r = self::dir_list($Path);
				foreach ($r as $file) {
					if (is_file($file)) {
						$folder = pathinfo(str_replace($Path, '', $file))['dirname'];
						$folder = explode('/', $folder);
						$thisdata = ['folder_key' => $main_folder['folder_key'], 'parent_id' => $main_folder['parent_id']];
						$son_model = $main_folder;
						foreach ($folder as $v) {
							if (!empty($v) && $v != '\\') {
								DB::table('basic_fms_folder')->updateOrInsert(['folder_key' => $v, 'parent_id' => $son_model['id']], [
									'parent_id' => $son_model['id'],
									'self_level' => $son_model['self_level'] + 1,
									'is_private' => 0,
									'can_use' => '[]',
									'title' => $v,
									'create_id' => 1,
									'created_at' => date('Y-m-d H:i:s'),
									'updated_at' => date('Y-m-d H:i:s')
								]);
								$thisdata['folder_key'] = $v;
								$thisdata['parent_id'] = $son_model['id'];
								$son_model = M('Fmsfolder')::where('folder_key', $v)->where('parent_id', $son_model['id'])->first();
							}
						}
						$this_folder = M('Fmsfolder')::where('folder_key', $thisdata['folder_key'])->where('parent_id', $thisdata['parent_id'])->first();

						$filename = pathinfo($file)['filename'];
						$temp_name = str_replace('/', '_', str_replace($Path, '', $file));
						$temp_array = explode('.', $temp_name);
						$ext = end($temp_array);
						$getimagesize = getimagesize($file);
						copy($file, public_path('upload/design/' . $temp_name));
						$real_m_route = '/upload/design/' . $temp_name;
						//超過1000*1000不縮圖
						if (!empty($getimagesize) && !in_array($ext, ['svg', 'gif', 'mp4', 'ico'])) {
							$real_m_route = ($getimagesize[0] <= 1920 && $getimagesize[1] <= 1920) ? FmsController::get_thumbnail('/upload/design', $temp_array[0], $ext) : $real_m_route;
						}
						DB::table('basic_fms_file')->updateOrInsert(['file_key' => $temp_name], [
							'folder_id' => $this_folder['id'],
							'created_user' => 1,
							'title' => $filename,
							'real_route' => '/upload/design/' . $temp_name,
							'real_m_route' => $real_m_route,
							'type' => $ext,
							'size' => filesize($file),
							'img_w' => $getimagesize[0] ?? '',
							'img_h' => $getimagesize[1] ?? '',
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
							'is_auto' => 1
						]);
					}
				}
			}
		}
		dd('ok');
	}
	public function baldeCreate(Request $request)
	{
		$branch_url = Route::current()->parameter('branch_url');
		$staticPrefix = str_replace(["www."], "", \Route::getCurrentRequest()->server('HTTP_HOST'));
		$subdomain = urldecode($branch_url ?: explode(".", $staticPrefix)[0]);
		$branch_origin = M('BranchOrigin')::where('url_title', $subdomain)->orwhere('url_title', 'www.' . $subdomain)->with('BranchOriginUnit')->first();
		//欄位
		$renameMap = $request->_data[0];
		$renameMap['id'] = $renameMap['id'] ?: 'id';
		$renameMap['parent_id'] = $renameMap['parent_id'] ?: 'parent_id';
		$data = [];
		foreach ($request->_data as $key => $val) {
			if ($key > 0) {
				$val = array_combine(array_map(function ($el) use ($renameMap) {
					return $renameMap[$el];
				}, array_keys($val)), array_values($val));
				$data[] = $val;
			}
		}
		$model = $request->_model;
		if (!empty($model)) {
			foreach ($data as $key => $val) {
				$saveArray = [
					'id' => $val['id'] ?: ($key + 1),
					'is_visible' => 1,
					'branch_id' => $branch_origin['id'],
					'w_rank' => $key,
					'parent_id' => $val['parent_id'] ?: 1,
					'create_id' => 1
				];
				foreach ($val as $k => $v) {
					if (substr($k, 0, 2) == 'o_') {
						preg_match("/assets\/img(.*+)/", $val[$k], $matches);
						$temp_name = str_replace('/', '_', $matches[1]);
						$v = str_replace('/', '_', $matches[1]);
					}
					if (!isset($saveArray[$k])) {
						$saveArray[$k] = $v;
					}
				}
				$table = M_table($model);
				DB::table($table)->updateOrInsert(['id' => $val['id'] ?: ($key + 1)], $saveArray);
			}
		}
		return response()->json(['state' => true]);
	}
	public function articleCreate(Request $request)
	{
		$branch_url = Route::current()->parameter('branch_url');
		$staticPrefix = str_replace(["www."], "", \Route::getCurrentRequest()->server('HTTP_HOST'));
		$subdomain = urldecode($branch_url ?: explode(".", $staticPrefix)[0]);
		$branch_origin = M('BranchOrigin')::where('url_title', $subdomain)->orwhere('url_title', 'www.' . $subdomain)->with('BranchOriginUnit')->first();

		$getPath = 'assets/img';
		$action = $request->action;
		$mainModel = $request->model_name;
		$model_name = $request->model_name;
		if (strpos($model_name, "_content") === false) {
			$model_name = $model_name . '_content';
		}
		if ($action == 'CreatArticle') {
			//清空
			M($model_name)::truncate();
			M($model_name . '_img')::truncate();

			$mainModel = M($mainModel)::select('id')->get();
			$json_arr = json_decode($request->article, true);
			foreach ($mainModel as $mainModelData) {
				foreach ($json_arr as $key => $val) {
					//段落類型
					$article_style = explode(" ", $val['article_style']);
					foreach ($article_style as $k => $v) {
						if (!in_array($v, \OptionFunction::article_style())) {
							unset($article_style[$k]);
						}
					}
					$article_style = implode(" ", array_values($article_style));
					$article_style = (!empty($article_style)) ? $article_style : 'typeBasic';

					$data = M($model_name, true);
					$data->w_rank = ($key + 1);
					$data->is_visible = 1;
					$data->parent_id = $mainModelData['id'];
					$data->branch_id = $branch_origin['id'];

					$data->is_swiper = ($val['is_swiper'] == 'on') ? 1 : 0;
					$data->is_slice = ($val['typeFull_slice'] == 'on') ? 1 : 0;
					$data->img_row = $val['img_row'];
					$data->img_firstbig = ($val['img_firstbig'] == 'on') ? 1 : 0;
					$data->img_merge = $val['img_merge'];
					$data->img_size = $val['img_size'];
					$data->img_flex = $val['img_flex'];
					$data->description_color = $val['description_color'];
					$data->description_align = $val['description_align'];
					$data->article_style = $article_style;
					$data->article_title = $val['article_title'];
					$data->article_sub_title = $val['article_sub_title'];
					$data->article_inner = $val['article_inner'];
					// $data->instagram_content = $val['instagram_content'];
					$data->article_color = $val['typeFull_color'];
					$data->article_flex = $val['article_flex'];
					$data->full_size = $val['typefull_size'];
					$data->full_box_color = $val['typeFull_boxcolor'];
					$data->h_color = $val['h_color'];
					$data->h_align = $val['h_align'];
					$data->subh_color = $val['subh_color'];
					$data->subh_align = $val['subh_align'];
					$data->p_color = $val['p_color'];
					$data->p_align = $val['p_align'];
					$data->button = $val['button'];
					$data->button_link = $val['button_link'];
					$data->link_type = 1;
					$data->button_color = $val['button_color'];
					$data->button_color_hover = $val['button_color_hover'];
					$data->button_textcolor = $val['button_textcolor'];
					$data->button_align = $val['button_align'];
					$data->swiper_num = $val['swiper_num'];
					$data->swiper_autoplay = ($val['swiper_autoplay'] == 'on') ? 1 : 0;
					$data->swiper_loop = ($val['swiper_loop'] == 'on') ? 1 : 0;
					$data->swiper_arrow = ($val['swiper_arrow'] == 'on') ? 1 : 0;
					$data->swiper_nav = ($val['swiper_nav'] == 'on') ? 1 : 0;
					$data->button_align = $val['button_align'];
					if (!empty($val['full_img'])) {
						$temp_arr = explode($getPath, $val['full_img']);
						$full_img = $temp_arr[array_key_last($temp_arr)];
						$data->full_img = str_replace('/', '_', $full_img);
					}
					if (!empty($val['full_img_rwd'])) {
						$temp_arr = explode($getPath, $val['full_img_rwd']);
						$full_img_rwd = $temp_arr[array_key_last($temp_arr)];
						$data->full_img_rwd = str_replace('/', '_', $full_img_rwd);
					}
					$data->save();
					$GetSaveSonData = json_decode($val['GetSaveSonData'], true);
					$not_find = '';
					foreach ($GetSaveSonData as $keyson => $sonVal) {
						$son_data = M($model_name . '_img', true);
						$son_data->w_rank = ($keyson + 1);
						$son_data->is_visible = 1;
						$son_data->branch_id = $branch_origin['id'];
						$son_data->second_id = $data->id;
						$son_data->title = $sonVal['title'];
						$son_data->w_type = $sonVal['title'];
						if (!empty($sonVal['image'])) {
							$temp_arr = explode($getPath, $sonVal['image']);
							$image = $temp_arr[array_key_last($temp_arr)];
							$son_data->image = str_replace('/', '_', $image);
						} else {
							$not_find .= pathinfo($sonVal['image'])['filename'] . ':';
						}
						$son_data->video = $sonVal['video'];
						$son_data->video_type = $sonVal['video_type'];
						$son_data->content = $sonVal['content'];
						$son_data->save();
					}
				}
			}
		}
		return ['message' => "OK", 'callback' => $not_find ?? ''];
	}
	public function baldeUI()
	{
		$folderList = [];
		$folder = $_GET['folder'] ?? '';
		if (empty($folder)) {
			$directory = '../resources/views/';
			$items = array_diff(scandir($directory), array('..', '.'));
			foreach ($items as $item) {
				if (is_dir($directory . $item)) {
					$folderList[] = $item;
					echo '<a href="/Leon/baldeUI?folder=' . $item . '">' . $item . '</a><br>';
				}
			}
			return false;
		}

		$langArray = Config::get('cms.langArray');
		$path = resource_path('views/' . $folder);
		$Copypath = resource_path('views/Front-keep/' . $folder . '_' . date('Y-m-d H.i.s'));
		self::recursive_dir_copy($path, $Copypath);

		$pathAll = self::dir_list($path);

		foreach ($pathAll as $pathVal) {
			if (!is_dir($pathVal)) {
				$filename = str_replace(str_replace("\\", "/", resource_path('views/' . $folder . '/')), "", $pathVal);
				$filename = str_replace("/", "_", $filename);
				$filename = str_replace(".blade.php", "", $filename);
				$langKey = \DB::table('basic_language_ui')->where('blade', $filename)->get()->max('langkey_index') ?: 0;
				$text = file_get_contents($pathVal);
				$noedit_arr = [];
				$output = preg_replace_callback('/data-lang=".*?"/u', function ($m) use (&$noedit_arr, &$langKey, $filename, $langArray) {
					//排除
					$break = false;
					if (strpos($m[0], '()') !== false) {
						$break = true;
					}
					if (strpos($m[0], '}}') !== false) {
						$break = true;
					}
					if (strpos($m[0], '{{') !== false) {
						$break = true;
					}
					if (strpos($m[0], '{!!') !== false) {
						$break = true;
					}
					if (strpos($m[0], '!!}') !== false) {
						$break = true;
					}
					if ($break) {
						return $m[0];
					} else {
						$m[0] = str_replace("data-lang=\"", "", $m[0]);
						$m[0] = mb_substr($m[0], 0, -1);

						$langKey++;
						$language_ui = M('language_ui', true);
						$language_ui->is_visible = 1;
						$language_ui->blade = $filename;
						$language_ui->langkey_index = $langKey;
						$language_ui->lankey = $filename . '_' . $langKey;
						foreach ($langArray as $val) {
							$language_ui->{$val['key'] . '_value'} = $m[0];
						}
						$language_ui->save();
						$noedit_arr[] = '{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'hide\'=>true]) !!}';
						return 'data-lang="{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'noedit\'=>true]) !!}"';
					}
				}, $text);
				$output = preg_replace_callback('/data-default=".*?"/u', function ($m) use (&$noedit_arr, &$langKey, $filename, $langArray) {
					//排除
					$break = false;
					if (strpos($m[0], '()') !== false) {
						$break = true;
					}
					if (strpos($m[0], '}}') !== false) {
						$break = true;
					}
					if (strpos($m[0], '{{') !== false) {
						$break = true;
					}
					if (strpos($m[0], '{!!') !== false) {
						$break = true;
					}
					if (strpos($m[0], '!!}') !== false) {
						$break = true;
					}
					if (strpos($m[0], '@if') !== false) {
						$break = true;
					}
					if (strpos($m[0], '@endif') !== false) {
						$break = true;
					}
					if (strpos($m[0], '@lang') !== false) {
						$break = true;
					}
					if ($m[0] == "data-default=\"\"") {
						$break = true;
					}
					if ($break) {
						return $m[0];
					} else {
						$m[0] = str_replace("data-default=\"", "", $m[0]);
						$m[0] = mb_substr($m[0], 0, -1);

						$langKey++;
						$language_ui = M('language_ui', true);
						$language_ui->is_visible = 1;
						$language_ui->blade = $filename;
						$language_ui->langkey_index = $langKey;
						$language_ui->lankey = $filename . '_' . $langKey;
						foreach ($langArray as $val) {
							$language_ui->{$val['key'] . '_value'} = $m[0];
						}
						$language_ui->save();
						$noedit_arr[] = '{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'hide\'=>true]) !!}';
						return 'data-default="{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'noedit\'=>true]) !!}"';
					}
				}, $output);
				$output = preg_replace_callback('/placeholder=".*?"/u', function ($m) use (&$noedit_arr, &$langKey, $filename, $langArray) {
					//排除
					$break = false;
					if (strpos($m[0], '()') !== false) {
						$break = true;
					}
					if (strpos($m[0], '}}') !== false) {
						$break = true;
					}
					if (strpos($m[0], '{{') !== false) {
						$break = true;
					}
					if (strpos($m[0], '{!!') !== false) {
						$break = true;
					}
					if (strpos($m[0], '!!}') !== false) {
						$break = true;
					}
					if (strpos($m[0], '@if') !== false) {
						$break = true;
					}
					if (strpos($m[0], '@endif') !== false) {
						$break = true;
					}
					if (strpos($m[0], '@lang') !== false) {
						$break = true;
					}
					if ($m[0] == "placeholder=\"\"") {
						$break = true;
					}
					if ($break) {
						return $m[0];
					} else {
						$m[0] = str_replace("placeholder=\"", "", $m[0]);
						$m[0] = mb_substr($m[0], 0, -1);
						$langKey++;
						$language_ui = M('language_ui', true);
						$language_ui->is_visible = 1;
						$language_ui->blade = $filename;
						$language_ui->langkey_index = $langKey;
						$language_ui->lankey = $filename . '_' . $langKey;
						foreach ($langArray as $val) {
							$language_ui->{$val['key'] . '_value'} = $m[0];
						}
						$language_ui->save();
						$noedit_arr[] = '{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'hide\'=>true]) !!}';
						return 'placeholder="{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'noedit\'=>true]) !!}"';
					}
				}, $output);
				$output = preg_replace_callback('/<br>/u', function ($m) use ($noedit_arr) {
					return '&nbsp;';
				}, $output);
				$output = preg_replace_callback('/<\/br>/u', function ($m) use ($noedit_arr) {
					return '&nbsp;';
				}, $output);
				$output = preg_replace_callback('/([a-zA-Z0-9"])>(.*?)</u', function ($m) use (&$langKey, $filename, $langArray) {

					if ($m[2] != '') {

						//排除
						$break = false;
						$hasOther = false;
						$exit = false;
						if (strpos($m[2], '()') !== false) {
							$break = true;
						}
						if (strpos($m[2], '}}') !== false) {
							$break = true;
						}
						if (strpos($m[2], '{{') !== false) {
							$break = true;
						}
						if (strpos($m[2], '{!!') !== false) {
							$break = true;
							$exit = true;
						}
						if (strpos($m[2], '!!}') !== false) {
							$break = true;
							$exit = true;
						}
						if (strpos($m[2], '@if') !== false) {
							$break = true;
							$exit = true;
						}
						if (strpos($m[2], '@endif') !== false) {
							$break = true;
							$exit = true;
						}
						if (strpos($m[2], '@lang') !== false) {
							$break = true;
							$exit = true;
						}
						$cancel_arr = [' ', '', '+', '-', '*', '/'];
						if (in_array($m[2], $cancel_arr)) {
							$break = true;
							$exit = true;
						}
						preg_match_all("/{{.*?}}/", $m[2], $matches);
						if (!empty($matches) && count($matches[0]) == 1 && !$exit) {
							$temp = $m[0];
							if (preg_match('/[0-9a-zA-Z\x{4e00}-\x{9fff}]+/u', preg_replace('/x+/', '', preg_replace('/\s+/', '', preg_replace("/{{.*}}/i", '', $m[2]))))) {
								$m[2] = preg_replace("/{{.*}}/i", '[value]', $m[2]);
								if (preg_replace('/\s+/', '', $m[2]) != '>[value]<' && strpos(preg_replace('/\s+/', '', $m[2]), ')?') === false) {
									$matches[0][0] = str_replace("{{", "", $matches[0][0]);
									$matches[0][0] = str_replace("}}", "", $matches[0][0]);
									$break = false;
									$hasOther = true;
								} else {
									$m[2] = $temp;
								}
							}
						}
						if ($break) {
							return $m[0];
						} else {
							if (preg_match('/[0-9a-zA-Z\x{4e00}-\x{9fff}]+/u', $m[2]) || !preg_match('/\$.*?\)/i', $m[2])) {
								// $m[2] = mb_substr($m[2], 1);
								// $m[2] = mb_substr($m[2], 0, -1);
								$langKey++;
								$language_ui = M('language_ui', true);
								$language_ui->is_visible = 1;
								if ($hasOther) {
									$language_ui->has_other = 1;
								}
								$language_ui->blade = $filename;
								$language_ui->langkey_index = $langKey;
								$language_ui->lankey = $filename . '_' . $langKey;
								foreach ($langArray as $val) {
									$language_ui->{$val['key'] . '_value'} = $m[2];
								}
								$language_ui->save();
								if ($hasOther) {
									return $m[1] . '>{!! langkey(\'' . $filename . '_' . $langKey . '\',[\'value\'=>' . $matches[0][0] . ' ]) !!}<';
								} else {
									return $m[1] . '>{!! langkey(\'' . $filename . '_' . $langKey . '\') !!}<';
								}
							} else {
								return $m[0];
							}
						}
					} else {
						return $m[0];
					}
				}, $output);
				$output = preg_replace_callback('/<main/u', function ($m) use ($noedit_arr) {
					return implode(PHP_EOL, $noedit_arr) . PHP_EOL . $m[0];
				}, $output);
				$output = preg_replace_callback('/<!--.*?-->/u', function ($m) use ($noedit_arr) {
					return '';
				}, $output);
				$file = fopen($pathVal, "w");
				fwrite($file, $output);
				fclose($file);
			}
		}
		self::dir_mkdir(resource_path('views/' . $folder . '/lang'));
		$language_ui = M('language_ui')::all();
		$jsonArray = [];
		foreach ($language_ui as $val) {
			$jsonArray[$val['blade']][$val['lankey']] = $val['tw_value'];
		}
		foreach ($jsonArray as $key => $val) {
			$ss = json_encode($val, JSON_UNESCAPED_UNICODE);
			$ss = str_replace("\":\"", "\"=>\"", $ss);
			$ss = str_replace("\",\"", "\"," . PHP_EOL . "\"", $ss);
			$ss = str_replace("{\"", "return [" . PHP_EOL . "\"", $ss);
			$ss = str_replace("\"}", PHP_EOL . "\"];", $ss);
			$file = fopen(resource_path('views/' . $folder . '/lang/' . $key . '.php'), "w");
			fwrite($file, '<?php' . PHP_EOL . $ss);
			fclose($file);
		}
		self::dir_mkdir(resource_path('views/' . $folder . '/csv'));
		foreach ($jsonArray as $key => $val) {
			$file = fopen(resource_path('views/' . $folder . '/csv/' . $key . '.csv'), "w");
			fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
			fputcsv($file, ['欄位(請勿更動)', '待翻譯內容', '翻譯內容']);
			foreach ($val as $k => $v) {
				fputcsv($file, [$k, $v, '']);
			}
			fclose($file);
		}

		dd('ok');
	}
	public function exportSql()
	{
		$tables = array_map(function ($value) {
			return (array) $value;
		}, DB::select('SHOW TABLES'));
		$tables = array_column($tables, array_key_first($tables[0]));

		$removeTables = [
			"basic_ams_role",
			"basic_autoredirect",
			"basic_branch_origin",
			"basic_branch_origin_unit",
			"basic_cms_child",
			"basic_cms_child_son",
			"basic_cms_data_auth",
			"basic_cms_menu",
			"basic_cms_menu_use",
			"basic_cms_parent",
			"basic_cms_parent_son",
			"basic_cms_permission",
			"basic_cms_role",
			"basic_country_codes",
			"basic_crs_permission",
			"basic_crs_role",
			"basic_data_city",
			"basic_data_city_region",
			"basic_fantasy_users",
			"basic_fms_file",
			"basic_fms_folder",
			"basic_language_ui",
			"basic_log_data",
			"basic_option_item",
			"basic_option_set",
			"basic_review_notify",
			"basic_web_key",
			"leon_database",
			"leon_menu",
			"migrations",
			"mysession"
		];
		$setTables = array_diff($tables, $removeTables);
		foreach ($setTables as $tables_val) {
			$db_name = $tables_val[array_key_first($tables_val)];
			$Field = array_column(json_decode(json_encode(\DB::select('show full columns from ' . $db_name)), true), 'Field');
			$data = DB::select('SELECT * FROM `' . $db_name . '`');
		}

		// $database = config('database.connections.mysql.database');
		// $user = config('database.connections.mysql.username');
		// $pwd = config('database.connections.mysql.password');
		// $sqlname = $database . '.sql';

		// $cmd = "mysqldump -u${user} -p'${pwd}' ${database} > ${sqlname}";
		// exec($cmd);
		// if (file_exists($sqlname)) {
		// 	$headers = [
		// 		'Content-Type' => 'application/octet-stream',
		// 		'Content-Transfer-Encoding' => 'Binary',
		// 	];
		// 	return response()->download($sqlname, $sqlname, $headers)->deleteFileAfterSend(true);
		// } else {
		// 	return "fail";
		// }
	}
}
