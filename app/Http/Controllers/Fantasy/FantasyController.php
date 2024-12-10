<?php

namespace App\Http\Controllers\Fantasy;

use App;

use App\Models\Basic\FantasyUsers;
use BaseFunction;
use Config;
use DB;
use Illuminate\Http\Request;
use Redirect;
use Session;
use View;
use Crypt;
/*Model*/

/*Model*/
use voku\helper\HtmlDomParser;
use Illuminate\Support\Facades\Schema;

use App\Models\Basic\Fms\Fmsfolder;
use App\Models\Basic\Fms\FmsFile;

class FantasyController extends BackendController
{

    protected $UrlList;
    public function __construct()
    {
        $this->UrlList = [];
        parent::__construct();
        View::share('unitTitle', 'Backstage');
        View::share('unitSubTitle', '');
        View::share('FantasyUser', session('fantasy_user'));
        $FantasyUsersList = (strpos(\Route::getCurrentRequest()->server('HTTP_HOST'), '.test') !== false) ? $FantasyUsersList = FantasyUsers::get()->toArray() : [];
        View::share('FantasyUsersList', $FantasyUsersList);
    }

    public function index()
    {
        $locale = App::getLocale();

        if (Session::get('fantasy_user')) {
            return redirect(BaseFunction::cms_url('/'));
            // return View::make('Fantasy.index',[]);
        } else {
            return redirect('auth/login');
        }
    }
    public function blockade(Request $request)
    {
        return view(
            'Fantasy.cms_view.blockade',
            [

            ]
        );
    }
    public function color(Request $request)
    {
        if (!empty($request->action) && $request->action == 'add') {
            $color = M('color', true);
            $color->color = $request->color;
            $color->save();
        }
        if (!empty($request->action) && $request->action == 'del') {
            M('color')::where('color', $request->color)->delete();
        }
        $color = M('color')::pluck('color');
        return response()->json($color);
    }

    public function LeonSiteMap_GetHtml($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function LeonSiteMap_Scan($url = '')
    {
        $domain = b_url('');
        $url = (!empty($url)) ? $url : $domain;
        $html = self::LeonSiteMap_GetHtml($url);
        $document = HtmlDomParser::str_get_html($html);
        unset($html);
        //掃描本頁面
        foreach ($document->find('a') as $e) {
            if (strpos($e->href, $domain) !== false && strpos($e->href, 'download') === false && !in_array($e->href, array_column($this->UrlList, 'url'))) {
                $pr = number_format(round(1 / count(explode("/", trim(str_ireplace(array("http://", "https://"), "", $e->href), "/"))) + 0.5, 3), 1);
                $this->UrlList[] = ['pr' => $pr, 'url' => $e->href];
            }
        }
    }
    public function autositemapcreat(Request $request)
    {
        $UrlList = json_decode($request->requestData, true);
        $file = fopen(public_path() . '/' . "sitemap.xml", "w");

        $m = '?';
        $xml = "<" . $m . "xml version=\"1.0\" encoding=\"UTF-8\"" . $m . ">";
        $xml .= "<" . $m . "xml-stylesheet type=\"text/xsl\" href=\"http://iprodev.github.io/PHP-XML-Sitemap-Generator/xml-sitemap.xsl\"" . $m . ">";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\" http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\" http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";

        fwrite($file, $xml);
        foreach ($UrlList as $val) {
            $str = "<url>
				<loc>" . htmlentities($val['url']) . "</loc>
				<changefreq>daily</changefreq>
				<priority>" . $val['pr'] . "</priority>
			</url>";
            fwrite($file, $str);
        }
        fwrite($file, "</urlset>");
        fclose($file);
        return response()->json([
            'message' => 'OK',
        ]);
    }
    public function autositemapauto(Request $request)
    {
        self::LeonSiteMap_Scan($request->scan_url);
        return response()->json([
            'message' => 'OK',
            'url' => $this->UrlList,
        ]);
    }
    public function autositemap($url = '')
    {
        return View::make(
            'Fantasy.sitemap',
            []
        );
    }
    public function cleared()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('clear-compiled');
        \Artisan::call('view:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('config:cache');
        return 'ok';
    }
    //檔案下載
    public function download(Request $request)
    {
        try {
            $id = Crypt::decrypt($request->idorname);
            $FmsFile = M('FmsFile')::find($id);
        } catch (DecryptException $e) {
            $url_name = $request->idorname;
            $FmsFile = M('FmsFile')::where('url_name', $url_name)->first();
        }
        if (isset($FmsFile) && !empty($FmsFile)) {
            //pdf直接網頁打開
            if (strtolower($FmsFile['type']) == 'pdf') {
                $header = [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . $FmsFile['title'] . '.' . $FmsFile['type'] . '"'
                ];
                return response()->file(public_path($FmsFile['real_route']), $header);
            }
            return \Response::download(public_path($FmsFile['real_route']), $FmsFile['title'] . '.' . $FmsFile['type']);
        }
    }
    //將資料庫中特定字串作轉換
    public function replaceDatabaseStr()
    {
        $database = config('database.connections.mysql.database');
        $tables = DB::select('SHOW TABLES FROM ' . $database);

        $ori = 'laravel919.wdd.idv.tw'; // 測試站網址 自行修改
        $rev = 'onlineweb.com.tw'; // 正式站網址 自行修改
        //所有資料表
        $tableArr = [];
        foreach ($tables as $key => $row) {
            foreach ($row as $key2 => $row2) {
                $tableArr[] = $row2;
            }
        }
        foreach ($tableArr as $table) {
            $columns = Schema::getColumnListing($table);
            foreach ($columns as $column) {
                DB::table($table)
                    ->where($column, 'like', "%${ori}%")
                    ->update([$column => DB::raw("REPLACE(`$column`, '$ori', '$rev')")]);
            }
        }

        return 'done';
    }
    // 匯出Sql 請自行修改相關參數
    public function exportSql()
    {
        $database = config('database.connections.mysql.database');
        $sqlname = $database . '.sql';
        $user = config('database.connections.mysql.username');
        $pwd = config('database.connections.mysql.password');
        $cmd = "mysqldump -u${user} -p'${pwd}' ${database} > ${sqlname}";
        exec($cmd);
        if (file_exists($sqlname)) {
            $headers = [
                'Content-Type' => 'application/octet-stream',
                'Content-Transfer-Encoding' => 'Binary',
            ];
            return response()->download($sqlname, $sqlname, $headers)->deleteFileAfterSend(true);
        } else {
            return "fail";
        }
    }
    // 匯入Sql 請自行修改相關參數
    public function importSql()
    {
        $database = config('database.connections.mysql.database');
        $sqlPath = public_path($database . '.sql');
        $user = config('database.connections.mysql.username');
        $pwd = config('database.connections.mysql.password');
        $ip = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');
        $cmd = "mysql -u${user} -p'${pwd}' -h${ip} -P${port} ${database} < ${sqlPath}";
        exec($cmd);

        return "import done";
    }
    // 匯入excel
    public function importExcel(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('import_excel', []);
        }
        if ($request->isMethod('post')) {
            $allData = $request->all();

            foreach ($allData as $tableName => $datas) {
                $col = $datas[0];
                array_shift($datas);
                $temp = [];
                foreach ($datas as $data) {
                    $tempRow = [];
                    foreach ($data as $key => $row) {
                        $tempRow[$col[$key]] = $row;
                    }
                    $temp[] = $tempRow;
                }

                DB::table($tableName)->upsert($temp, null);
            }
        }
        return 'done';
    }
    public function exportExcel()
    {
        $database = config('database.connections.mysql.database');
        $tables = DB::select('SHOW TABLES FROM ' . $database);

        //所有資料表
        $tableArr = [];
        foreach ($tables as $key => $row) {
            foreach ($row as $key2 => $row2) {
                $tableArr[] = $row2;
            }
        }

        $dataArr = [];
        foreach ($tableArr as $table) {
            $temp = [];
            $temp['table'] = $table; //資料表名
            $temp['comment'] = []; //備註
            $temp['col'] = []; //第一列 欄位名稱
            $temp['val'] = []; //資料
            $data = DB::table($table)->get();
            $query = "SELECT COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_NAME = '" . $table . "'";
            $comments = DB::select(DB::raw($query));
            foreach ($comments as $key => $row) {
                foreach ($row as $key2 => $row2) {
                    $temp['comment'][] = $row2;
                }
            }

            foreach ($data as $key => $row) {
                $tempVal = [];
                foreach ($row as $key2 => $row2) {
                    if ($key == 0)
                        $temp['col'][] = $key2;
                    $tempVal[] = $row2;
                }
                $temp['val'][] = $tempVal;
            }
            $dataArr[] = $temp;
        }
        $dataArr = json_encode($dataArr, true);
        return view('export_excel', ['dataArr' => $dataArr]);
    }
    public function getSvgDimensions($svgFilePath)
    {
        // 確保文件存在
        if (!file_exists($svgFilePath)) {
            return null;
        }

        // 讀取 SVG 文件內容
        $svgContent = file_get_contents($svgFilePath);

        // 使用正則表達式來匹配 width 和 height
        preg_match('/width=["\']?(\d+)(px)?["\']?/', $svgContent, $widthMatches);
        preg_match('/height=["\']?(\d+)(px)?["\']?/', $svgContent, $heightMatches);

        // 提取數據
        $width = isset($widthMatches[1]) ? (int) $widthMatches[1] : null;
        $height = isset($heightMatches[1]) ? (int) $heightMatches[1] : null;

        return [$width, $height];
    }
    //上傳設計稿圖片
    public function uploadDesign(Request $request)
    {
        $upload = $request->upload ?: '';
        $folder = $request->folder ?: '';
        if (!empty($upload)) {
            set_time_limit(0);
            $SelectPath = public_path($folder);
            $SelectPath = self::dir_path($SelectPath);
            $public_resources = [""];
            if ($folder == '/resources') {
                $public_resources = glob($SelectPath . '*');
            }
            foreach ($public_resources as $public_resources_val) {
                $branch = basename($public_resources_val);
                //分館資料夾
                $upload_path = [];
                $main_folder = [];
                //有分館
                if (!empty($branch)) {
                    $folderPath = 'resources/' . $branch;
                    DB::table('basic_fms_folder')->updateOrInsert(['title' => $branch, 'parent_id' => 1], [
                        'parent_id' => 1,
                        'self_level' => 1,
                        'is_private' => 0,
                        'can_use' => '[]',
                        'title' => $branch,
                        'create_id' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    $main_folder = M('Fmsfolder')::where('title', $branch)->where('parent_id', 1)->first();
                } else {
                    $folderPath = $folder;
                    $main_folder = M('Fmsfolder')::where('id', 1)->first();
                }
                $getPath = $folderPath . '/assets/img';
                if (!file_exists(public_path($getPath))) {
                    $getPath = 'assets/img';
                }
                if (!file_exists(public_path($getPath))) {
                    $getPath = '';
                }
                if (!empty($getPath)) {
                    $upload_path[] = public_path($getPath);
                }
                $getPathVideo = $folderPath . '/assets/video';
                if (!file_exists(public_path($getPathVideo))) {
                    $getPathVideo = 'assets/video';
                }
                if (!file_exists(public_path($getPathVideo))) {
                    $getPathVideo = '';
                }
                if (!empty($getPathVideo)) {
                    $upload_path[] = public_path($getPathVideo);
                }
                foreach ($upload_path as $key => $Path) {
                    //建立根目錄
                    if (!empty($branch)) {
                        $tempPath = str_replace($public_resources_val, '', $Path);
                        $tempPath = public_path('upload/design/' . $branch . $tempPath);
                    } else {
                        $tempPath = str_replace($SelectPath, '', $Path);
                        $tempPath = public_path('upload/design/' . $tempPath);
                    }
                    if (!file_exists($tempPath)) {
                        mkdir($tempPath, 0755, true);
                    }
                    $r = self::dir_list($Path);
                    //先建立資料夾
                    foreach ($r as $file) {
                        if (!is_file($file)) {
                            if (!empty($branch)) {
                                $tempPath = str_replace($public_resources_val, '', $file);
                                $tempPath = public_path('upload/design/' . $branch . $tempPath);
                            } else {
                                $tempPath = str_replace($SelectPath, '', $file);
                                $tempPath = public_path('upload/design/' . $tempPath);
                            }
                            if (!file_exists($tempPath)) {
                                mkdir($tempPath, 0755, true);
                            }
                        }
                    }
                    foreach ($r as $file) {
                        if (is_file($file)) {
                            if (!empty($branch)) {
                                $tempPath = str_replace($public_resources_val, '', $file);
                                $tempPath = $branch . $tempPath;
                            } else {
                                $tempPath = str_replace($SelectPath, '', $file);
                            }
                            $tempPath = str_replace(pathinfo($file)['basename'], '', $tempPath);
                            $folder = pathinfo(str_replace($Path, '', $file))['dirname'];
                            $folder = explode('/', $folder);
                            $thisdata = ['folder_key' => $main_folder['title'], 'parent_id' => $main_folder['parent_id']];
                            $son_model = $main_folder;
                            foreach ($folder as $v) {
                                if (!empty($v) && $v != '\\') {
                                    DB::table('basic_fms_folder')->updateOrInsert(['title' => $v, 'parent_id' => $son_model['id']], [
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
                                    $son_model = M('Fmsfolder')::where('title', $v)->where('parent_id', $son_model['id'])->first();
                                }
                            }
                            $this_folder = M('Fmsfolder')::where('title', $thisdata['folder_key'])->where('parent_id', $thisdata['parent_id'])->first();
                            $fileInfo = pathinfo($file);
                            $fileKey = md5($tempPath . $fileInfo['basename']);
                            $getimagesize = getimagesize($file);
                            if ($fileInfo['extension'] == 'svg') {
                                $getimagesize = self::getSvgDimensions($file);
                            }
                            copy($file, public_path('upload/design/' . $tempPath . $fileInfo['basename']));
                            $real_m_route = '/upload/design/' . $tempPath . $fileInfo['basename'];
                            //超過1000*1000不縮圖
                            if (!empty($getimagesize) && !in_array($fileInfo['extension'], ['svg', 'gif', 'mp4', 'ico'])) {
                                $real_m_route = ($getimagesize[0] <= 1920 && $getimagesize[1] <= 1920) ? FmsController::get_thumbnail('/upload/design/' . $tempPath, $fileInfo['filename'], $fileInfo['extension']) : $real_m_route;
                            }
                            DB::table('basic_fms_file')->updateOrInsert(['file_key' => $fileKey], [
                                'folder_id' => $this_folder['id'],
                                'created_user' => 1,
                                'title' => $fileInfo['filename'],
                                'real_route' => '/upload/design/' . $tempPath . $fileInfo['basename'],
                                'real_m_route' => $real_m_route,
                                'type' => $fileInfo['extension'],
                                'size' => filesize($file),
                                'resolution' => ($getimagesize[0] ?? '') . 'x' . ($getimagesize[1] ?? ''),
                                'img_w' => $getimagesize[0] ?? '',
                                'img_h' => $getimagesize[1] ?? '',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                }
            }
            dd('ok');
        } else {
            echo '<p>如果多分館不同切版,要放在resources裡面,例如：resources/site1  resources/site2</p>';
            $folderList = collect(array_diff(scandir(public_path($folder)), array('..', '.')))->filter(function ($item, $key) use ($folder) {
                return is_dir(public_path($folder . '/' . $item));
            });
            echo '<table>';
            foreach ($folderList as $val) {
                echo '<tr>';
                echo '<td><a href="/uploadDesign?folder=' . urlencode($folder . '/' . $val) . '">' . $folder . '/' . $val . '</a></td><td><a style="margin-left: 30px;" href="/uploadDesign?upload=true&folder=' . urlencode($folder . '/' . $val) . '">上傳</a></td>';
                echo '</tr>';
            }
            echo '</table>';
        }
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
        if (substr($path, -1) != '/') {
            $path = $path . '/';
        }

        return $path;
    }


    public function uploadDesignWithFolder(Request $request)
    {
        dump('start:' . date('Y-m-d H:i:s'));
        // 想上傳的資料夾位置(切版資料)
        // $upload_path = 'downloadOri/Audio';
        // // 想傳到哪邊
        // $fms_folder = 'downloadOri/wddTest';
        // // FMS第一層名稱
        // $first_folder_name = 'wddUpload';
        // 想上傳的資料夾位置(切版資料)
        $upload_path = 'dist/assets/img';
        // 想傳到哪邊
        $fms_folder = 'upload/design';
        // FMS第一層名稱
        $first_folder_name = '設計稿';

        $this->upload_path_temp = $upload_path;

        // 建立fms資料夾
        DB::table('basic_fms_folder')->updateOrInsert(['parent_id' => 0, 'title' => $first_folder_name], [
            'parent_id' => 0,
            'self_level' => 0,
            'is_private' => 0,
            'can_use' => '[]',
            'last_edit_user' => 1,
            'is_active' => 1,
            'branch_id' => 1,
            'title' => $first_folder_name,
            'create_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if (!is_dir(public_path($fms_folder))) {
            mkdir(public_path($fms_folder), 0755, true);
        }

        $r = self::dir_list_recursive($upload_path);
        // dd($r);
        foreach ($r as $file) {
            self::uploadFile($file, $upload_path, $first_folder_name, 0, $fms_folder);
        }
        dd('done!!!:' . date('Y-m-d H:i:s'));
    }
    public function dir_list_recursive($path, $exts = '', $list = array())
    {
        $path = self::dir_path($path);
        $files = glob($path . '*');
        foreach ($files as $v) {
            if (!$exts || preg_match('/\.($exts)/i', $v)) {
                if (!is_dir($v)) {
                    $list[] = ['name' => $v];
                } else {
                    $list[] = ['name' => $v, 'in_forder' => self::dir_list_recursive($v)];
                }
            }
        }
        return $list;
    }
    public function uploadFile($file, $upload_path, $parent_folder_title, $parent_folder_level, $fms_folder)
    {
        // 若此檔不是資料夾
        if (!isset($file['in_forder'])) {
            $file = $file['name'];
            // dd($folder);

            $folder = pathinfo(str_replace($upload_path, '', $file))['dirname'];
            $folder = explode('/', $folder);

            $filename = pathinfo($file)['filename'];
            $fms_file_name = str_replace('/', '_', str_replace($this->upload_path_temp, '', $file));
            if (strpos($fms_file_name, '.') !== false) {
                $fms_file_name = substr($fms_file_name, 0, strpos($fms_file_name, '.'));
            }
            $temp_name = str_replace('/', '_', str_replace($upload_path . '/', '', $file));
            $temp_array = explode('.', $temp_name);
            $ext = end($temp_array);
            $getimagesize = getimagesize($file);
            echo ($temp_name . "檔案更新\t");
            if (is_file(public_path($fms_folder . '/' . $temp_name))) {
                unlink(public_path($fms_folder . '/' . $temp_name));
            }
            copy($file, public_path($fms_folder . '/' . $temp_name));
            $real_m_route = '/' . $fms_folder . '/' . $temp_name;
            //超過1000*1000不縮圖
            if (!empty($getimagesize) && !in_array($ext, ['svg', 'gif', 'mp4', 'ico'])) {
                $real_m_route = ($getimagesize[0] <= 1920 && $getimagesize[1] <= 1920) ? FmsController::get_thumbnail('/' . $fms_folder, $temp_array[0], $ext) : $real_m_route;
            }
            $parent_folder_temp = M('Fmsfolder')::where('parent_id', $parent_folder_level)->where('title', $parent_folder_title)->first();
            DB::table('basic_fms_file')->updateOrInsert(['file_key' => $fms_file_name], [
                'folder_id' => $parent_folder_temp['id'],
                'created_user' => 1,
                'title' => $filename,
                'real_route' => '/' . $fms_folder . '/' . $temp_name,
                'real_m_route' => $real_m_route,
                'type' => $ext,
                'size' => filesize($file),
                'img_w' => $getimagesize[0] ?? '',
                'img_h' => $getimagesize[1] ?? '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            // rename(public_path($file),public_path($fms_folder .'/'. $temp_name));
        }
        // 遞迴檢查資料夾
        else {
            $parent_folder_temp = M('Fmsfolder')::where('parent_id', $parent_folder_level)->where('title', $parent_folder_title)->first();
            $folder_title_temp = pathinfo(str_replace($upload_path, '', $file['name']))['basename'];
            DB::table('basic_fms_folder')->updateOrInsert(['parent_id' => $parent_folder_temp['id'], 'title' => $folder_title_temp], [
                'parent_id' => $parent_folder_temp['id'],
                'self_level' => $parent_folder_temp['self_level'] + 1,
                'is_private' => 0,
                'can_use' => '[]',
                'last_edit_user' => 1,
                'is_active' => 1,
                'branch_id' => 1,
                'title' => $folder_title_temp,
                'create_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $fms_folder = $fms_folder . '/' . $folder_title_temp;
            $upload_path = $file['name'];
            if (!is_dir(public_path($fms_folder))) {
                mkdir(public_path($fms_folder), 0755, true);
            }
            $r = self::dir_list_recursive($upload_path);
            foreach ($r as $file) {
                self::uploadFile($file, $upload_path, $folder_title_temp, $parent_folder_temp['id'], $fms_folder);
            }
            dump($folder_title_temp . ' 完成:' . date('Y-m-d H:i:s'));
        }
    }

    //sitemap產生入口
    public function autositemapMain()
    {
        $website_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

        // 執行爬蟲並生成 sitemap.xml
        $urls = self::crawlWebsite($website_url);
        $this->UrlList[key($this->UrlList)] = 1;

        file_put_contents(public_path('sitemap.json'), json_encode($this->UrlList, true));
        return redirect(url('autositemapSub'));
    }
    //sitemap產生子程序 若執行出錯可以繼續呼叫此方法
    public function autositemapSub()
    {
        $this->UrlList = file_get_contents(public_path('sitemap.json'));
        $this->UrlList = json_decode($this->UrlList, true);
        foreach ($this->UrlList as $key => $row) {
            if ($row == 0) {
                $this->UrlList[$key] = 1;
                // dump($key);
                self::crawlWebsite($key);
                file_put_contents(public_path('sitemap.json'), json_encode($this->UrlList, true));
                return redirect(url('autositemapSub'));
            }
        }
        self::generateSitemap($this->UrlList);
        return 'done';
    }
    // 爬取網站的所有a，可自行修改為特定的頁面或搜尋特定網站的頁面
    public function crawlWebsite($url)
    {
        $website_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
        try {
            $html = file_get_contents($url);
        } catch (\Throwable $th) {
            return false;
        }

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        libxml_clear_errors();

        $links = [];

        $a_tags = $doc->getElementsByTagName('a');
        foreach ($a_tags as $a) {
            $link = $a->getAttribute('href');
            // 排除非內部網址和錨點
            if (strpos($link, $website_url) !== false && strpos($link, '#') === false) {
                if (!isset($this->UrlList[$link]))
                    $this->UrlList[$link] = 0;
            }
        }
    }

    // 生成 sitemap.xml
    public function generateSitemap($urls)
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        $host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

        foreach ($urls as $url => $val) {
            $uri = str_replace($host, '', $url);
            $uriArr = explode('/', $uri);
            unset($uriArr[0]);
            $count = (count($uriArr) - 1) > 0 ? count($uriArr) - 1 : 0;

            $urlNode = $xml->addChild('url');
            $urlNode->addChild('loc', $url);
            $urlNode->addChild('changefreq', 'daily');
            $urlNode->addChild('priority', pow(0.8, $count));
        }

        $xml->asXML(public_path('sitemap.xml'));
    }
    //載入aws s3 所有檔案生成 fms_file fms_folder
    public function loadS3AllFile()
    {
        //取得所有檔案含資料夾路徑
        $files = \Storage::disk('s3')->allFiles('/');
        $prefix = config('fms.s3_prefix') . '/';
        //只抓取 public資料夾下的檔案
        foreach ($files as $key => $row) {
            if (strpos($row, 'public/') !== false)
                $files[$key] = str_replace($prefix, '', $row);
            else
                unset($files[$key]);
        }

        //製作folder file
        $s3Folder = Fmsfolder::where('self_level', 0)
            ->where('title', 's3')
            ->first();
        if (empty($s3Folder)) {
            $s3Folder = new Fmsfolder;
            $s3Folder['parent_id'] = 0;
            $s3Folder['self_level'] = 0;
            $s3Folder['is_active'] = 1;
            $s3Folder['branch_id'] = 1;
            $s3Folder['create_id'] = 1;
            $s3Folder['title'] = 's3';
            $s3Folder->save();
        }
        $folder = [];
        $folder['s3'] = $s3Folder['id'];
        foreach ($files as $key => $row) {
            $temp = explode('/', $row);
            $file = array_pop($temp);
            if (isset($folder[implode('/', $temp)])) {
                $folderID = $folder[implode('/', $temp)];
            } else {
                $folderID = self::S3GenerateFolder($temp, $folder['s3']);
                $folder[implode('/', $temp)] = $folderID;
            }

            self::S3GenerateFile($folderID, $row);
        }

        return 'done';
    }

    public function S3GenerateFolder(array $folderNameArr, $parentID)
    {
        //第幾層資料夾
        $lv = 1;

        foreach ($folderNameArr as $key => $row) {
            $check = Fmsfolder::where('self_level', $lv)
                ->where('title', $row)
                ->first();
            if (!empty($check))
                $parentID = $check['id'];
            else {
                $db = new Fmsfolder;
                $db['parent_id'] = $parentID;
                $db['self_level'] = $lv;
                $db['is_active'] = 1;
                $db['branch_id'] = 1;
                $db['create_id'] = 1;
                $db['title'] = $row;
                $db->save();

                $parentID = $db['id'];
            }
            $lv++;
        }
        return $parentID;
    }
    public function S3GenerateFile(int $folderID, string $fileRoute)
    {
        $prefix = config('fms.s3_prefix') . '/';
        $n1 = explode('/', $fileRoute);
        $n2 = array_pop($n1);
        $n3 = explode('.', $n2);
        $fileName = array_shift($n3);
        $type = array_pop($n3);
        $fileKey = $fileRoute;
        $db = new FmsFile;
        $db['use_s3'] = 1;
        $db['file_key'] = '_' . str_replace(' ', '_', str_replace('/', '_', $fileKey));
        $db['folder_id'] = $folderID;
        $db['branch_id'] = 1;
        $db['title'] = $fileName;
        $db['real_route'] = '/' . $prefix . $fileRoute;
        $db['real_m_route'] = '/' . $prefix . $fileRoute;
        $db['type'] = $type;
        $db['size'] = \Storage::disk('s3')->size($prefix . $fileRoute);
        $db->save();
    }

    public function uploadDesignToS3()
    {
        // 想上傳的資料夾位置(切版資料)
        $upload_path = 'dist/assets/img';
        // 想傳到哪邊
        $fms_folder = 'upload/design';
        // FMS第一層名稱
        $folder_name = '設計稿';

        // 建立fms資料夾
        DB::table('basic_fms_folder')->updateOrInsert(['parent_id' => 0, 'title' => $folder_name], [
            'parent_id' => 0,
            'self_level' => 0,
            'is_private' => 0,
            'can_use' => '[]',
            'last_edit_user' => 1,
            'is_active' => 1,
            'branch_id' => 1,
            'title' => $folder_name,
            'create_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $folder = Fmsfolder::where('parent_id', 0)->where('title', $folder_name)->first();

        $datas = self::dir_list_recursive($upload_path);

        self::uploadFileToS3_recursive($datas, $folder['id']);

        return 'done';
    }

    public function uploadFileToS3_recursive($datas, $folderID)
    {
        $upload_path = 'dist/assets/img';
        $fms_folder = 'upload/design';

        $s3 = \Storage::disk('s3');
        $prefix = '/' . config('fms.s3_prefix');
        $filePath = $prefix . '/' . $fms_folder;
        $folder = Fmsfolder::where('id', $folderID)->first();
        foreach ($datas as $key => $row) {
            if (!empty($row['in_forder'])) {
                $temp_name = explode('/', $row['name']);
                $temp_name = array_pop($temp_name);
                DB::table('basic_fms_folder')
                    ->updateOrInsert(
                        [
                            'parent_id' => $folder['id'],
                            'title' => $temp_name
                        ],
                        [
                            'parent_id' => $folder['id'],
                            'self_level' => $folder['self_level'] + 1,
                            'is_private' => 0,
                            'can_use' => '[]',
                            'last_edit_user' => 1,
                            'is_active' => 1,
                            'branch_id' => 1,
                            'title' => $temp_name,
                            'create_id' => 1,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]
                    );
                $nextFolder = Fmsfolder::where('parent_id', $folder['id'])->where('title', $temp_name)->first();
                dump($row['name']);
                self::uploadFileToS3_recursive($row['in_forder'], $nextFolder['id']);
            } else {
                $info = pathinfo($row['name']);
                $getimagesize = getimagesize($row['name']);

                $saveS3 = $s3->put($filePath . '/' . $row['name'], file_get_contents($row['name']), 'public');
                $temp_name = explode('/', $row['name']);
                $temp_name = array_pop($temp_name);
                $temp_name_arr = explode('.', $temp_name);
                array_pop($temp_name_arr);
                $temp_name = implode('.', $temp_name_arr);
                if ($saveS3) {
                    DB::table('basic_fms_file')->updateOrInsert(['file_key' => str_replace('/', '_', $row['name'])], [
                        'folder_id' => $folder['id'],
                        'created_user' => 1,
                        'title' => $temp_name,
                        'real_route' => $prefix . '/' . $fms_folder . '/' . $row['name'],
                        'real_m_route' => $prefix . '/' . $fms_folder . '/' . $row['name'],
                        'type' => $info['extension'],
                        'size' => filesize($row['name']),
                        'img_w' => $getimagesize[0] ?? '',
                        'img_h' => $getimagesize[1] ?? '',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
    }

    public function envRsaKeyCreate()
    {
        $keyPair = openssl_pkey_new(array(
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ));

        openssl_pkey_export($keyPair, $privateKey);

        $keyDetails = openssl_pkey_get_details($keyPair);
        $publicKey = $keyDetails['key'];

        dump($publicKey);
        dd($privateKey);
    }

    public function changePWD(Request $req)
    {
        // dd(Session::get('fantasy_user'));
        $user = Session::get('fantasy_user');
        if (!$user) {
            $type = 'no-login';
            return $type;
        }

        if ($req->pwd !== $req->pwd2) {
            $type = 'pwd';
            return $type;
        }


        $user = FantasyUsers::find($user['id']);
        $user['password'] = bcrypt($req->pwd);
        $user->save();
        Session::forget('fantasy_user');
        $type = 'success';
        return $type;
        // dd($req->all());
    }
}
