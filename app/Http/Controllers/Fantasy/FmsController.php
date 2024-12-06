<?php

namespace App\Http\Controllers\Fantasy;

use App\Http\Controllers\Fantasy\MenuController as MenuFunction;
use App\Models\Basic\FantasyUsers;
use App\Models\Basic\Fms\FmsFile;
use App\Models\Basic\Fms\FmsFirst;
use App\Models\Basic\Fms\Fmsfolder;
use App\Models\Basic\Fms\FmsSecond;
use App\Models\Basic\Fms\FmsThird;
use App\Models\Basic\Fms\FmsZero;
use BaseFunction;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Session;
use View;

class FmsController extends BackendController
{

    /**
     * @var array $allowFileType Upload File Rule
     */
    public static $allowFileMimeType = [
        'img'=>[
            'image/bmp' => ['bmp'],
            'image/x-bmp' => ['bmp'],
            'image/jpeg' => ['jpg', 'jpeg', 'jpe'],
            'image/png' => ['png'],
            'image/gif' => ['gif'],
            'image/tiff' => ['tiff', 'tif'],
            'image/heic' => ['heic'],
            'image/svg+xml' => ['svg'],
        ],
        'file'=>[
            'application/pdf' => ['pdf'],
            'application/x-bzip2' => ['bz2'],
            'application/x-gzip' => ['gz'],
            'application/vnd.rar' => ['rar'],
            'application/x-rar' => ['rar'],
            'application/zip' => ['zip'],
            'video/mp4' => ['mp4'],
            'video/quicktime' => ['mov'],
            'video/x-matroska' => ['mkv'],
            'video/webm' => ['webm'],
        ],
        //切片上傳的 MimeType 會解析成這個
        'application/octet-stream' => ['bmp','jpg','jpeg','jpe','png','gif','tiff','tif','heic','svg','pdf','bz2']
    ];

    public function __construct()
    {

        parent::__construct();
        // parent::checkRouteLang();
        // parent::checkRouteBranch();
        View::share('unitTitle', 'Fms');
        View::share('unitSubTitle', 'File Management System');
        View::share('FantasyUser', session('fantasy_user'));
        $FantasyUsersList = (strpos(\Route::getCurrentRequest()->server('HTTP_HOST'), '.test') !== false) ? $FantasyUsersList = FantasyUsers::get() : [];
        View::share('FantasyUsersList', $FantasyUsersList);
    }
    public function dir_path($path)
    {
        $path = str_replace('\\', '/', $path);
        if (substr($path, -1) != '/') $path = $path . '/';
        return $path;
    }
    public function file_search(Request $request){
        $imageUrl = $request->imageUrl;
        $path = public_path('resources');
        $path = self::dir_path($path);
        $public_resources = glob($path . '*');
        $resources_path = [];
        foreach ($public_resources as $public_resources_val) {
            $branch = basename($public_resources_val);
            $folderPath = 'resources/' . $branch;
            $getPath = $folderPath . '/assets/img';
            $resources_path[] = ['branch' => $branch, 'path' => $getPath];
        }
        if(count($resources_path) == 0){
            preg_match("/assets\/img(.*+)/", $imageUrl, $matches);
            $file_key = md5($matches[0]);
        }else{
            foreach ($resources_path as $p) {
                if (strpos($val[$k], $p['path']) !== false) {
                    preg_match("/assets\/img(.*+)/", $imageUrl, $matches);
                    $file_key = md5($p['branch'] . '/' . $matches[0]);
                }
            }
        }
        $file = FmsFile::where('file_key',$file_key)->first();
        return response()->json(['file' => $file]);
    }
    public function GetFmsfolder($action, $folder_id = 0)
    {
        $user = Session::get('fantasy_user');
        //有哪些分管的使用權限
        // $authBranch = config('models.CmsRole')::where("is_active", 1)->where("user_id", $user['id'])->with('BranchOriginUnit.BranchOrigin')->get();
        // $authBranchID = [];
        // foreach ($authBranch as $key => $row) {
        //     array_push($authBranchID, $row['BranchOriginUnit']['BranchOrigin']['id']);
        // }

        if ($action == 'all') {
            Fmsfolder::setRole('all');
            $folder = Fmsfolder::where('self_level', 0)
                ->with('son_folder_withSession')
                ->with('create_user')
                ->orderby('parent_id', 'desc')
                ->get();
            // $folder = Fmsfolder::where('self_level', 0)->with(['son_folder' => function ($q) {
            //     $q->where("is_delete", 0);
            // }])->orderby('parent_id', 'desc')->get()->toArray();
            //設定直接打開的資料夾class
            $folder = self::setOpenFolderClass($folder, $folder_id);
            //設定 可以打開/不能打開 的資料夾class
            $folder = self::setFolderAuthority($folder);
            //改寫第0層使用權限
            // foreach ($folder as $key => $row) {
            //     if (!in_array($row['branch_id'], $authBranchID)) {
            //         $folder[$key]['use_auth'] = 'cant_use lock';
            //     }
            // }
        }
        if ($action == 'me') {
            Fmsfolder::setRole('me');
            $folder = Fmsfolder::where('self_level', 0)
                ->with('son_folder_withSession')
                ->with('create_user')
                ->orderby('parent_id', 'desc')
                ->get();
            //剔除不能使用的資料夾
            // foreach ($folder as $key => $row) {
            //     if (!in_array($row['branch_id'], $authBranchID)) {
            //         unset($folder[$key]);
            //     }
            // }
            $folder = self::setFolderAuthority($folder);
        }
        return $folder;
    }
    public function GetFmsFile($type = "all", $folder_id = 0, $search_value = "")
    {
        $file = [];
        if ($type === 'img' || $type === 'img_list') {
            $types = collect(self::$allowFileMimeType['img'])->flatten()->unique()->toArray();
            if (!empty($search_value)) {
                $file = FmsFile::whereIn('type', $types)->with('create_user')->where('title', 'like', '%' . $search_value . '%')->where('is_delete', 0)->orderby('id', 'desc')->get();
            } else {
                if ($folder_id === 'trash') {
                    $file = FmsFile::where('is_delete', 1)->with('create_user')->orderby('id', 'desc')->get();
                } else {
                    $file = FmsFile::whereIn('type', $types)->with('create_user')->where('folder_id', $folder_id)->where('is_delete', 0)->orderby('id', 'desc')->get();
                }
            }
        } else if ($type === 'file') {
            $types = collect(self::$allowFileMimeType)->flatten()->unique()->toArray();
            if (!empty($search_value)) {
                $file = FmsFile::whereIn('type', $types)->with('create_user')->where('title', 'like', '%' . $search_value . '%')->where('is_delete', 0)->orderby('id', 'desc')->get();
            } else {
                if ($folder_id === 'trash') {
                    $file = FmsFile::where('is_delete', 1)->with('create_user')->orderby('id', 'desc')->get();
                } else {
                    $file = FmsFile::whereIn('type', $types)->with('create_user')->where('folder_id', $folder_id)->where('is_delete', 0)->orderby('id', 'desc')->get();
                }
            }
        } elseif ($type === 'sontable') {
            $types = collect(self::$allowFileMimeType['img'])->flatten()->unique()->toArray();
            if (!empty($search_value)) {
                $file = FmsFile::whereIn('type', $types)->with('create_user')->where('title', 'like', '%' . $search_value . '%')->where('is_delete', 0)->orderby('id', 'desc')->get();
            } else {
                if ($folder_id === 'trash') {
                    $file = FmsFile::where('is_delete', 1)->with('create_user')->orderby('id', 'desc')->get();
                } else {
                    $file = FmsFile::whereIn('type', $types)->with('create_user')->where('folder_id', $folder_id)->where('is_delete', 0)->orderby('id', 'desc')->get();
                }
            }
        } else {
            if (!empty($search_value)) {
                $file = FmsFile::with('create_user')->where('title', 'like', '%' . $search_value . '%')->where('is_delete', 0)->orderby('id', 'desc')->get();
            } else {
                if ($folder_id === 'trash') {
                    $file = FmsFile::where('is_delete', 1)->with('create_user')->orderby('id', 'desc')->get();
                } else {
                    $file = FmsFile::with('create_user')->where('folder_id', $folder_id)->where('is_delete', 0)->orderby('id', 'desc')->get();
                }
            }
        }
        $user = session('fantasy_user');
        // 過濾軟刪除的檔案 && 無權限
        $file = $file->filter(function ($item) use ($user) {
            return !$item->is_private || (!empty($user['ams']) && !empty($user['ams']['is_folder'])) ||
            $item->create_user === $user['id'] ||
            in_array((string) $user['id'], json_decode($item->can_use, true) ?? []);
        });

        return $file;
    }
    public function index(Request $request)
    {
        ini_set('memory_limit', '2048M');
        $open_type = $request->open_type ?: 'all';
        $search_value = $request->search_value;

        $isAjax = $request->ajax;
        //直接打開的資料夾ID(及上層)
        $folder_id = $request->folder_id ?: 0;
        // $first_folder = Fmsfolder::where('self_level', 0)->first();
        // if (!empty($first_folder)) {
        //     $folder_id = $first_folder->id;
        // }
        if (!empty($request->folder_id)) {
            $folder_id = $request->folder_id;
        }

        //資料夾 - all(全部顯示) / me(只顯示有權限)
        $folder = self::GetFmsfolder('all', $folder_id);

        $folderAll = self::GetFmsfolder('me');

        $file = self::GetFmsFile($open_type, $folder_id, $search_value);
        $all_owner = FantasyUsers::get();
        //資料夾麵包屑 資料由下到上
        $nowFolderPath = Fmsfolder::where('id', $folder_id)->with('top_folder')->first();

        if (empty($isAjax)) {
            return View::make(
                'Fantasy.fms.index',
                [
                    'nowFolderPath' => $nowFolderPath,
                    'folder' => $folder,
                    'folderAll' => $folderAll,
                    'folder_id' => $folder_id,
                    'file' => $file,
                    'all_owner' => $all_owner,
                ]
            );
        } else {
            $search_column = $request->search_column;
            $column_sort = $request->column_sort;
            $search_column_str = '';
            switch ($search_column) {
                case 1:
                    $search_column_str = 'title';
                    break;
                case 2:
                    $search_column_str = 'type';
                    break;
                case 3:
                    $search_column_str = 'type';
                    break;
                case 4:
                    $search_column_str = 'size';
                    break;
                case 5:
                    $search_column_str = 'img_w';
                    break;
                case 6:
                    $search_column_str = 'updated_at';
                    break;
            }
            if (!empty($search_column)) {
                $file = ($column_sort) ? collect($file)->sortBy($search_column_str) : collect($file)->sortByDesc($search_column_str);
            }
            $folder_rev = View::make('Fantasy.fms.son_folder_rev', ['folderAll' => $folderAll, 'firstTime' => 1])->render();
            $folder = View::make('Fantasy.fms.son_folder', ['for_son_folder' => $folderAll, 'type' => 'fms_list'])->render();
            $blade = View::make('Fantasy.fms.file_list', ['file' => $file])->render();
            return ['files' => $blade, 'folder' => $folder, 'folder_rev' => $folder_rev];
        }
    }

    public function setOpenFolderClass($folder, $folder_id)
    {
        $user = Session::get('fantasy_user');
        $temp = '"' . $user['id'] . '"';
        //if ($folder_id == 0) return $folder;
        foreach ($folder as $key => $row) {
            if ($row['id'] == $folder_id && (strpos($row['can_use'], $temp) || $row['create_id'] == $user['id'] || $row['is_private'] == 0)) {
                $folder[$key]['open_class'] = 'ready-tree';
            } else {
                $folder[$key]['open_class'] = '';
            }

            if (!empty($row['son_folder'])) {
                $folder[$key]['son_folder'] = self::setOpenFolderClass($row['son_folder'], $folder_id);
            }
        }
        return $folder;
    }

    //檔案移動位置
    public function postEditFilesExchange(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $user = Session::get('fantasy_user');
        $form_data = $request->all();
        $res = [];
        $res['status'] = 'success';
        $res['msg'] = 'success';

        $parent_folder_level = $form_data['parent_folder_level'];
        $parent_folder_id = $form_data['parent_folder_id'];
        $parent_branch = $form_data['parent_branch'];
        $json_file = $form_data['json_file'];
        $json_folder = $form_data['json_folder'];
        $save_folder_level = $parent_folder_level * 1 + 1;

        $file_idArr = json_decode($json_file, true);
        $folder_idArr = json_decode($json_folder, true);
        if (empty($file_idArr)) {
            $file_idArr = [];
        }

        if (empty($folder_idArr)) {
            $folder_idArr = [];
        }

        if (empty($file_idArr) && empty($folder_idArr)) {
            $res['status'] = 'fail';
            $res['msg'] = '沒有選擇檔案';
            return $res;
        }

        if (!empty($file_idArr)) {
            FmsFile::whereIn('id', $file_idArr)->update(['folder_id' => $parent_folder_id, 'branch_id' => $parent_branch, 'last_edit_user' => $user['id']]);
        }
        if (!empty($folder_idArr)) {
            Fmsfolder::whereIn('id', $folder_idArr)->update(['parent_id' => $parent_folder_id, 'self_level' => $save_folder_level, 'branch_id' => $parent_branch, 'last_edit_user' => $user['id']]);
        }

        return $res;
    }

    public function setFolderAuthority($folder)
    {
        $user = Session::get('fantasy_user');
        $temp = '"' . $user['id'] . '"';
        foreach ($folder as $key => $row) {
            if (preg_match($temp, $row['can_use']) || $row['create_id'] == $user['id'] || $row['is_private'] == 0 || (!empty($user['ams']) && $user['ams']['is_folder'])) {
                $folder[$key]['use_auth'] = 'can_use';
            } else {
                $folder[$key]['use_auth'] = 'cant_use lock';
            }
            if (isset($row['son_folder']) && !empty($row['son_folder'])) {
                $folder[$key]['son_folder'] = self::setFolderAuthority($row['son_folder']);
            }
            if (isset($row['son_folder_withSession']) && !empty($row['son_folder_withSession'])) {
                $folder[$key]['son_folder_withSession'] = self::setFolderAuthority($row['son_folder_withSession']);
            }
        }
        return $folder;
    }
    //切片上傳 此方法還沒有寫傳輸到s3的方法
    public function postFilesFmsChunk(Request $request)
    {
        $data = $request->all();
        $file = $request->file('file');
        $mimeName = $file->getClientOriginalName();
        $mimeSize = $file->getSize();
        $fileMimeType = $file->getMimeType();
        $filePath = storage_path('app/uploads/') . $file->getClientOriginalName();
        $chunkFilePath = $filePath;

        //切片資料存到暫時目錄
        $chunkFile = $filePath . '_chunk_' . $request->input('dzchunkindex');
        $file->move(storage_path('app/uploads/tmp'), $chunkFile);

        //最後一個切片做整合
        if ($request['dzchunkindex'] == $request['dztotalchunkcount']-1) {
            $chunks = glob(storage_path('app/uploads/tmp/') . $file->getClientOriginalName() . '_chunk_*');
            natsort($chunks);
            $mergedFile = fopen($filePath, 'a');
            foreach ($chunks as $chunk) {
                $fileContent = file_get_contents($chunk);
                fwrite($mergedFile, $fileContent);
                unlink($chunk);
            }
            fclose($mergedFile);

            $member = Session::get('fantasy_user');
            /*隨機6碼*/
            $length = 6;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomWord = '';
            for ($i = 0; $i < $length; $i++) {
                $randomWord .= $characters[rand(0, $charactersLength - 1)];
            }

            $fileName = $member['id'] . '_' . date("YmdHis") . $randomWord . $data['key'];
            $name = $fileName;
            $folder = '/upload/' . date("Y_m_d");

            $chunkFileArr = [];
            $chunkFileArr['mimeName'] = $mimeName;
            $chunkFileArr['mimeSize'] = $mimeSize;
            $chunkFileArr['fileMimeType'] = $fileMimeType;
            $chunkFileArr['chunkFilePath'] = $chunkFilePath;
            $chunkFileArr['totalSize'] = $data['dztotalfilesize'];
            $message = self::saveFileToDBAndServer($data, $fileName, $folder, $member['id'], $data['folder_id'], $data['branch'], $chunkFile,0,$chunkFileArr);

            return $message;
        }

        return response()->json(['success' => true]);
    }
    public function postFilesFms(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $member = Session::get('fantasy_user');
        $data = $request->all();
        /*隨機6碼*/
        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomWord = '';
        for ($i = 0; $i < $length; $i++) {
            $randomWord .= $characters[rand(0, $charactersLength - 1)];
        }

        $fileName = $member['id'] . '_' . date("YmdHis") . $randomWord . $data['key'];
        $folder = '/upload/' . date("Y_m_d");

        $s3_use = config('fms.s3_use');
        if($s3_use){
            $message = self::saveFileToDBAndS3($data, $fileName, $folder, $member['id'], $data['folder_id'], $data['branch'], $data['file']);
        }
        else{
            $message = self::saveFileToDBAndServer($data, $fileName, $folder, $member['id'], $data['folder_id'], $data['branch'], $data['file']);
        }

        return json_encode($message, JSON_UNESCAPED_UNICODE);
    }
    public function postNewFolder(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $area = $request->all();
        if ($area['area_first'] == 0) {
            if ($area['area_second'] == 0) {
                // 因為只會在第一第二層做用 所以第三層就不判斷了
                $back['an'] = false;
                $back['message'] = '請選擇第一層或第二層資料夾';
                return $back;
            } else {

                $FmsThird = new FmsThird;
                $FmsThird->second_id = $area['area_second'];
                $FmsThird->title = $area['newFolder'];
                if ($FmsThird->save()) {
                    $back['an'] = true;
                    $back['lastId'] = $FmsThird->id;
                    return $back;
                } else {
                    $back['an'] = false;
                    $back['message'] = '存檔成失敗';
                    return $back;
                }
            }
        } else {
            $FmsSecond = new FmsSecond;
            $FmsSecond->first_id = $area['area_first'];
            $FmsSecond->title = $area['newFolder'];
            if ($FmsSecond->save()) {
                $back['an'] = true;
                $back['lastId'] = $FmsSecond->id;
                return $back;
            } else {
                $back['an'] = false;
                $back['message'] = '存檔成失敗';
                return $back;
            }
        }
    }

    public function postNameFolder(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $area = $request->all();

        if ($area['area_first'] == 0) {

            if ($area['area_second'] == 0) {
                if ($area['area_third'] == 0) {

                    $back['an'] = false;
                    $back['message'] = '存檔失敗';
                    return $back;
                } else {
                    $FmsThird = FmsThird::FindOrFail($area['area_third']);
                    $FmsThird['title'] = $area['nameFolder'];
                    if ($FmsThird->save()) {
                        $back['an'] = true;
                        return $back;
                    } else {
                        $back['an'] = false;
                        $back['message'] = '存檔失敗';
                        return $back;
                    }
                }
            } else {

                $FmsSecond = FmsSecond::FindOrFail($area['area_second']);
                $FmsSecond['title'] = $area['nameFolder'];
                if ($FmsSecond->save()) {
                    $back['an'] = true;
                    return $back;
                } else {
                    $back['an'] = false;
                    $back['message'] = '存檔失敗';
                    return $back;
                }
            }
        } else {

            $FmsFirst = FmsFirst::FindOrFail($area['area_first']);
            $FmsFirst['title'] = $area['nameFolder'];
            if ($FmsFirst->save()) {
                $back['an'] = true;
                return $back;
            } else {
                $back['an'] = false;
                $back['message'] = '存檔失敗';
                return $back;
            }
        }
    }

    public function postDeleteFolder(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $area = $request->all();
        if ($area['fms_shot'] == 'one_shot') {
            if ($area['area_first'] == 0) {

                if ($area['area_second'] == 0) {

                    if ($area['area_third'] == 0) {

                        $back['an'] = false;
                        $back['message'] = '請選擇資料夾';
                        return $back;
                    } else {

                        $FmsThird = FmsThird::FindOrFail($area['area_third']);
                        $isdelete = self::check_user($FmsThird['created_user']);
                        if ($isdelete) {
                            if ($FmsThird->delete()) {
                                $back['an'] = true;
                                return $back;
                            } else {
                                $back['an'] = false;
                                $back['message'] = '刪除失敗';
                                return $back;
                            }
                        } else {
                            $back['an'] = false;
                            $back['message'] = '您非該資料夾的擁有者，無法刪除該資料夾。';
                            return $back;
                        }
                    }
                } else {
                    $FmsSecond = FmsSecond::FindOrFail($area['area_second']);
                    $isdelete = self::check_user($FmsSecond['created_user']);
                    if ($isdelete) {
                        if ($FmsSecond->delete()) {
                            $back['an'] = true;
                            return $back;
                        } else {
                            $back['an'] = false;
                            $back['message'] = '刪除失敗';
                            return $back;
                        }
                    } else {
                        $back['an'] = false;
                        $back['message'] = '您非該資料夾的擁有者，無法刪除該資料夾。';
                        return $back;
                    }
                }
            } else {
                $FmsFirst = FmsFirst::FindOrFail($area['area_first']);
                $isdelete = self::check_user($FmsFirst['created_user']);
                if ($isdelete) {
                    if ($FmsFirst->delete()) {
                        $back['an'] = true;
                        return $back;
                    } else {
                        $back['an'] = false;
                        $back['message'] = '刪除失敗';
                        return $back;
                    }
                } else {
                    $back['an'] = false;
                    $back['message'] = '您非該資料夾的擁有者，無法刪除該資料夾。';
                    return $back;
                }
            }
        }

        if ($area['fms_shot'] == 'multi_shot') {
            $undeleteFilder = [];

            foreach ($area['folder_level'] as $key => $value) {
                switch ($value) {
                    case 'first':
                        $FmsFirst = FmsFirst::FindOrFail($area['folder_id'][$key]);
                        $isdelete = self::check_user($FmsFirst['created_user']);
                        if ($isdelete) {
                            if ($FmsFirst->delete()) {} else {
                                array_push($undeleteFilder, $FmsFirst['title'] . '刪除失敗');
                            }
                        } else {
                            array_push($undeleteFilder, '您非該資料夾' . $FmsFirst['title'] . '的擁有者，無法刪除該資料夾。');
                        }
                        break;
                    case 'second':
                        $FmsSecond = FmsSecond::FindOrFail($area['folder_id'][$key]);
                        $isdelete = self::check_user($FmsSecond['created_user']);
                        if ($isdelete) {
                            if ($FmsSecond->delete()) {} else {
                                array_push($undeleteFilder, $FmsSecond['title'] . '刪除失敗');
                            }
                        } else {
                            array_push($undeleteFilder, '您非該資料夾' . $FmsSecond['title'] . '的擁有者，無法刪除該資料夾。');
                        }
                        break;
                    case 'third':
                        $FmsThird = FmsThird::FindOrFail($area['folder_id'][$key]);
                        $isdelete = self::check_user($FmsThird['created_user']);
                        if ($isdelete) {
                            if ($FmsThird->delete()) {} else {
                                array_push($undeleteFilder, $FmsThird['title'] . '刪除失敗');
                            }
                        } else {
                            array_push($undeleteFilder, '您並非資料夾:' . $FmsThird['title'] . '的擁有者，無法刪除該資料夾。');
                        }
                        break;
                }
            }
            if (count($undeleteFilder) > 0) {
                $back['an'] = false;
                $back['message'] = implode(" ,\n ", $undeleteFilder);
                return $back;
            } else {
                $back['an'] = true;
                return $back;
            }
        }
    }
    public function postEditFiles(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $form_data = $request->all();
        $new_file['data'] = '';
        $member = Session::get('fantasy_user');
        $upload = FmsFile::find($form_data['id']);
        if (true) {

            /*隨機6碼*/
            $length = 6;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomWord = '';
            for ($i = 0; $i < $length; $i++) {
                $randomWord .= $characters[rand(0, $charactersLength - 1)];
            }

            $fileName = $member['id'] . '_' . date("YmdHis") . $randomWord . 0;
            $folder = '/upload/' . date("Y_m_d");

            if (!empty($form_data['file'])) {
                $s3_use = config('fms.s3_use');
                if($s3_use){
                    $new_file = self::saveFileToDBAndS3($form_data, $fileName, $folder, $member['id'], $form_data['folder_id'], 1, $form_data['file'], $form_data['id']);
                }
                else{
                    $new_file = self::saveFileToDBAndServer($form_data, $fileName, $folder, $member['id'], $form_data['folder_id'], $upload['branch_id'], $form_data['file'], $form_data['id']);
                }
            }

            $upload->folder_id = $form_data['folder_id'];
            $upload->title = $form_data['title'];
            $upload->url_name = $form_data['url_name'];
            $upload->alt = $form_data['alt'];
            $upload->note = $form_data['note'];
            $upload->last_edit_user = $member['id'];
            $upload->is_delete = 0;
            $upload->is_private = $form_data['is_private'];
            $upload->can_use = $form_data['can_use'];
            $upload->save();

            if ($upload) {
                $data = $upload;
                $attributes_en = json_encode($data, JSON_UNESCAPED_UNICODE);
                BaseFunction::writeLogData('edit', ['table' => 'basic_fms_file', 'id' => $form_data['id'], 'ChangeData' => $attributes_en, 'classname' => 'FMS']);

                $ext = strtolower(pathinfo($data['real_m_route'], PATHINFO_EXTENSION));
                $filepath = '/vender/assets/img/icon/' . $ext . '.png';
                $notImgStyle = '';
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webm'])) {
                    $filepath = $data['real_m_route'];
                    $notImgStyle = 'open_img_box';
                }
                $data['real_m_route'] = $filepath;
                $data['notImgStyle'] = $notImgStyle;

                $back['an'] = true;
                $back['data'] = $data;
                return $back;
            } else {
                $back['an'] = false;
                $back['data'] = "";
                $back['message'] = '編輯失敗';
                return $back;
            }
        } else {
            $back['an'] = false;
            $back['data'] = "";
            $back['message'] = '您非檔案擁有者，無法編輯該檔案';
            return $back;
        }
    }

    public function postEditFilesChunk(Request $request)
    {
        $data = $request->all();
        $file = $request->file('file');
        $mimeName = $file->getClientOriginalName();
        $mimeSize = $file->getSize();
        $fileMimeType = $file->getMimeType();
        $filePath = storage_path('app/uploads/') . $file->getClientOriginalName();
        $chunkFilePath = $filePath;

        //切片資料存到暫時目錄
        $chunkFile = $filePath . '_chunk_' . $request->input('dzchunkindex');
        $file->move(storage_path('app/uploads/tmp'), $chunkFile);

        //最後一個切片做整合
        if ($request['dzchunkindex'] == $request['dztotalchunkcount']-1) {
            $chunks = glob(storage_path('app/uploads/tmp/') . $file->getClientOriginalName() . '_chunk_*');
            natsort($chunks);
            $mergedFile = fopen($filePath, 'a');
            foreach ($chunks as $chunk) {
                $fileContent = file_get_contents($chunk);
                fwrite($mergedFile, $fileContent);
                unlink($chunk);
            }
            fclose($mergedFile);

            $chunkFileArr = [];
            $chunkFileArr['mimeName'] = $mimeName;
            $chunkFileArr['mimeSize'] = $mimeSize;
            $chunkFileArr['fileMimeType'] = $fileMimeType;
            $chunkFileArr['chunkFilePath'] = $chunkFilePath;
            // end chunk

            $form_data = $request->all();
            $new_file['data'] = '';
            $member = Session::get('fantasy_user');
            $upload = FmsFile::find($form_data['id']);
            $isdelete = self::check_user($upload['created_user']);
            if ($isdelete) {

                /*隨機6碼*/
                $length = 6;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randomWord = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomWord .= $characters[rand(0, $charactersLength - 1)];
                }

                $fileName = $member['id'] . '_' . date("YmdHis") . $randomWord . 0;
                $folder = '/upload/' . date("Y_m_d");

                $new_file = self::saveFileToDBAndServer($form_data, $fileName, $folder, $member['id'], $form_data['folder_id'], $upload['branch_id'], $chunkFile, $form_data['id'],$chunkFileArr);

                $upload->folder_id = $form_data['folder_id'];
                $upload->title = $form_data['title'];
                $upload->url_name = $form_data['url_name'];
                $upload->alt = $form_data['alt'];
                $upload->note = $form_data['note'];
                $upload->last_edit_user = $member['id'];
                $upload->is_delete = 0;
                $upload->is_private = $form_data['is_private'];
                $upload->can_use = $form_data['can_use'];
                $upload->save();

                if ($upload) {
                    $data = $upload;
                    $attributes_en = json_encode($data, JSON_UNESCAPED_UNICODE);
                    BaseFunction::writeLogData('edit', ['table' => 'basic_fms_file', 'id' => $form_data['id'], 'ChangeData' => $attributes_en, 'classname' => 'FMS']);

                    $ext = strtolower(pathinfo($data['real_m_route'], PATHINFO_EXTENSION));
                    $filepath = '/vender/assets/img/icon/' . $ext . '.png';
                    $notImgStyle = '';
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webm'])) {
                        $filepath = $data['real_m_route'];
                        $notImgStyle = 'open_img_box';
                    }
                    $data['real_m_route'] = $filepath;
                    $data['notImgStyle'] = $notImgStyle;

                    $back['an'] = true;
                    $back['data'] = $data;
                    return $back;
                } else {
                    $back['an'] = false;
                    $back['data'] = "";
                    $back['message'] = '編輯失敗';
                    return $back;
                }
            } else {
                $back['an'] = false;
                $back['data'] = "";
                $back['message'] = '您非檔案擁有者，無法編輯該檔案';
                return $back;
            }
        }

        return response()->json(['success' => true]);
    }

    public function postEditFolderNew(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $user = Session::get('fantasy_user');
        $form_data = $request->all();
        if ($form_data['id'] == 0) {
            $db = new Fmsfolder;
            $db['title'] = $form_data['title'];
            $db['note'] = $form_data['note'];
            if (isset($form_data['is_private'])) {
                $db['is_private'] = $form_data['is_private'];
                $db['can_use'] = $form_data['can_use'];
            }
            $db['branch_id'] = $form_data['parent_branch'];
            $db['parent_id'] = $form_data['parent_folder_id'];
            $db['self_level'] = ($form_data['parent_folder_id'] != 0) ? $form_data['parent_folder_level'] * 1 + 1 : 0;
            $db['last_edit_user'] = $user['id'];
            $db['create_id'] = $user['id'];
            $db['is_active'] = 1;
            $db->save();
        } else {
            $db = Fmsfolder::where('id', $form_data['id'])->first();
            if (empty($db)) {
                return "";
            }

            $db['title'] = $form_data['title'];
            $db['note'] = $form_data['note'];
            if (isset($form_data['is_private'])) {
                $db['is_private'] = $form_data['is_private'];
                $db['can_use'] = $form_data['can_use'];
            }
            $db['branch_id'] = $form_data['parent_branch'];
            $db['parent_id'] = $form_data['parent_folder_id'];
            $db['self_level'] = ($form_data['parent_folder_id'] != 0) ? $form_data['parent_folder_level'] * 1 + 1 : 0;
            $db['last_edit_user'] = $user['id'];
            $db->save();
        }
        return "";
    }

    public function postEditFolder(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $form_data = $request->all();

        if ($form_data['id'] != '0') { //等於0就是新增

            $member = Session::get('fantasy_user');
            $data = [];

            // 有移動路徑 -> 搬移資料夾
            if ($form_data['id'] != $form_data['folder_id'] || $form_data['origin_folder_level'] != $form_data['folder_level']) {
                self::AddNewFolderAndMoveTheFileThenCheckTheSubFolder($form_data['id'], $form_data['origin_folder_level'], $form_data['folder_id'], $form_data['folder_level']);

                $back['an'] = true;
                return $back;
            } else {
                if ($form_data['folder_level'] == '1') {
                    $upload = FmsFirst::where('id', $form_data['id'])
                        ->update([
                            'title' => $form_data['title'],
                            // 'share_group' => $form_data['share_group'],
                            'note' => $form_data['note'],
                            'last_edit_user' => $member['id'],
                            //'zero_id' => $form_data['note']
                        ]);
                } elseif ($form_data['folder_level'] == '2') {
                    $upload = FmsSecond::where('id', $form_data['id'])
                        ->update([
                            'title' => $form_data['title'],
                            // 'share_group' => $form_data['share_group'],
                            'note' => $form_data['note'],
                            'last_edit_user' => $member['id'],
                        ]);
                } elseif ($form_data['folder_level'] == '3') {
                    $upload = FmsThird::where('id', $form_data['id'])
                        ->update([
                            'title' => $form_data['title'],
                            // 'share_group' => $form_data['share_group'],
                            'note' => $form_data['note'],
                            'last_edit_user' => $member['id'],
                        ]);
                }

                if ($upload) {
                    $back['an'] = true;
                    return $back;
                } else {
                    $back['an'] = false;
                    $back['message'] = '編輯失敗';
                    return $back;
                }
            }
        } else {
            $member = Session::get('fantasy_user');
            $data = [];
            $now_date = date("Y-m-d H:i:s");
            if ($form_data['folder_level'] == '1') {
                $upload = FmsSecond::insert([
                    'title' => $form_data['title'],
                    // 'share_group' => $form_data['share_group'],
                    'note' => $form_data['note'],
                    'last_edit_user' => $member['id'],
                    'first_id' => $form_data['folder_id'],
                    'created_user' => $member['id'],
                    'created_at' => $now_date,
                    'updated_at' => $now_date,

                ]);
            } elseif ($form_data['folder_level'] == '2') {
                $upload = FmsThird::insert([
                    'title' => $form_data['title'],
                    // 'share_group' => $form_data['share_group'],
                    'note' => $form_data['note'],
                    'last_edit_user' => $member['id'],
                    'second_id' => $form_data['folder_id'],
                    'created_user' => $member['id'],
                    'created_at' => $now_date,
                    'updated_at' => $now_date,
                ]);
            } elseif ($form_data['folder_level'] == '0') {
                $upload = FmsFirst::insert([
                    'title' => $form_data['title'],
                    // 'share_group' => $form_data['share_group'],
                    'note' => $form_data['note'],
                    'last_edit_user' => $member['id'],
                    'created_user' => $member['id'],
                    'created_at' => $now_date,
                    'updated_at' => $now_date,
                    'zero_id' => $form_data['folder_id'],
                    'is_active' => '1',
                    'type' => '1',
                ]);
            }

            if ($upload) {
                $back['an'] = true;
                return $back;
            } else {
                $back['an'] = false;
                $back['message'] = '新增失敗';
                return $back;
            }
        }
    }

    public function AddNewFolderAndMoveTheFileThenCheckTheSubFolder($OriginalFolderId, $OriginalFolderLevel, $NewFolderId, $NewFolderLevel)
    {
        // 原本的資料夾 && 底下的檔案/資料夾
        switch ($OriginalFolderLevel) {
            case 1:
                $AbdicateFolder = FmsFirst::whereId($OriginalFolderId)->first();
                $MovingFile = FmsFile::where('first_id', $OriginalFolderId)->where('second_id', 0)->where('third_id', 0);
                $MovingFolder = FmsSecond::where('first_id', $OriginalFolderId)->get();
                $MovingFolderLevel = 2;
                break;
            case 2:
                $AbdicateFolder = FmsSecond::whereId($OriginalFolderId)->first();
                $MovingFile = FmsFile::where('first_id', 0)->where('second_id', $OriginalFolderId)->where('third_id', 0);
                $MovingFolder = FmsThird::where('second_id', $OriginalFolderId)->get();
                $MovingFolderLevel = 3;
                break;
            case 3:
                $AbdicateFolder = FmsThird::whereId($OriginalFolderId)->first();
                $MovingFile = FmsFile::where('first_id', 0)->where('second_id', 0)->where('third_id', $OriginalFolderId);
                $MovingFolder = collect([]);
                break;
        }

        // 建立新的資料夾 && 移動檔案
        switch ($NewFolderLevel) {
            case 0:
                $BildeFolderLevel = 1;
                $BildeFolderID = FmsFirst::insertGetId([
                    'title' => $AbdicateFolder['title'],
                    'note' => $AbdicateFolder['note'],
                    'last_edit_user' => $AbdicateFolder['last_edit_user'],
                    'created_user' => $AbdicateFolder['created_user'],
                    'created_at' => $AbdicateFolder['created_at'],
                    'updated_at' => $AbdicateFolder['updated_at'],
                    'zero_id' => $NewFolderId,
                    'is_active' => '1',
                    'type' => '1',
                ]);
                $MovingFile->update(['first_id' => $BildeFolderID, 'second_id' => 0, 'third_id' => 0]);
                break;
            case 1:
                $BildeFolderLevel = 2;
                $BildeFolderID = FmsSecond::insertGetId([
                    'title' => $AbdicateFolder['title'],
                    'note' => $AbdicateFolder['note'],
                    'last_edit_user' => $AbdicateFolder['last_edit_user'],
                    'created_user' => $AbdicateFolder['created_user'],
                    'created_at' => $AbdicateFolder['created_at'],
                    'updated_at' => $AbdicateFolder['updated_at'],
                    'first_id' => $NewFolderId,
                ]);
                $MovingFile->update(['first_id' => 0, 'second_id' => $BildeFolderID, 'third_id' => 0]);
                break;
            case 2:
                $BildeFolderLevel = 3;
                $BildeFolderID = FmsThird::insertGetId([
                    'title' => $AbdicateFolder['title'],
                    'note' => $AbdicateFolder['note'],
                    'last_edit_user' => $AbdicateFolder['last_edit_user'],
                    'created_user' => $AbdicateFolder['created_user'],
                    'created_at' => $AbdicateFolder['created_at'],
                    'updated_at' => $AbdicateFolder['updated_at'],
                    'second_id' => $NewFolderId,
                ]);
                $MovingFile->update(['first_id' => 0, 'second_id' => 0, 'third_id' => $BildeFolderID]);
                break;
            case 3:
                $UpId = FmsThird::where('id', $NewFolderId)->first();
                $OldFolderId = FmsThird::where('id', $OriginalFolderId)->update(['second_id' => $UpId['second_id']]);
                break;
        }

        // 刪除原本的資料夾
        switch ($OriginalFolderLevel) {
            case 1:
                FmsFirst::whereId($OriginalFolderId)->delete();
                break;
            case 2:
                FmsSecond::whereId($OriginalFolderId)->delete();
                break;
            case 3:
                if ($NewFolderLevel != 3) {
                    FmsThird::whereId($OriginalFolderId)->delete();
                }
                break;
        }

        // 移動底下的資料夾
        if (count($MovingFolder) > 0) {
            foreach ($MovingFolder as $key => $value) {
                self::AddNewFolderAndMoveTheFileThenCheckTheSubFolder($value['id'], $MovingFolderLevel, $BildeFolderID, $BildeFolderLevel);
            }
        }
    }

    public function postEditDelete(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $form_data = $request->all();
        $member = Session::get('fantasy_user');

        $data = [];
        if ($form_data['folder_level'] == '1') {
            $delete = FmsFirst::where('id', $form_data['this_id'])->first();
            $isdelete = self::check_user($delete['created_user']);
            if ($isdelete) {
                $delete->delete();
            } else {
                $back['an'] = false;
                $back['message'] = '您非該資料夾的擁有者，無法刪除該資料夾。';
                return $back;
            }
        } elseif ($form_data['folder_level'] == '2') {
            $delete = FmsSecond::where('id', $form_data['this_id'])->first();
            $isdelete = self::check_user($delete['created_user']);
            if ($isdelete) {
                $delete->delete();
            } else {
                $back['an'] = false;
                $back['message'] = '您非該資料夾的擁有者，無法刪除該資料夾。';
                return $back;
            }
        } elseif ($form_data['folder_level'] == '3') {
            $delete = FmsThird::where('id', $form_data['this_id'])->first();
            $isdelete = self::check_user($delete['created_user']);
            if ($isdelete) {
                $delete->delete();
            } else {
                $back['an'] = false;
                $back['message'] = '您非該資料夾的擁有者，無法刪除該資料夾。';
                return $back;
            }
        }

        if ($delete) {
            $back['an'] = true;
            return $back;
        } else {
            $back['an'] = false;
            $back['message'] = '刪除失敗';
            return $back;
        }
    }

    public function postDeleteFiles(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $FileData = $request->all();
        if ($request->is_delete == "true") {
            FmsFile::where('id', $request->id)->delete();
        } else {
            $user = Session::get('fantasy_user');
            FmsFile::where('id', $request->id)
                ->where(function ($q) use ($user) {
                    $q->orwhere('is_private', 0)->orwhere('create_id', $user['id'])->orwhere('can_use', '%"' . $user['id'] . '"%');
                })
                ->update(['is_delete' => 1]);
        }
        $back['an'] = true;
        return $back;
    }
    public function postDownloadFiles(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $area = $request->all();
        $id = $area['id'];
        $src = $area['src'];
        $trueSrc = str_replace('/upload/', '', $area['src']);

        if (Storage::disk('localPublic')->exists($trueSrc)) {

            $file = asset($src);
            $back['an'] = true;
            $back['src'] = $file;
            return $back;
        } else {
            $back['an'] = false;
            $back['message'] = '下載失敗';
            return $back;
        }
    }

    public static function saveFileToDBAndServer($data, $name, $folder, $user, $folder_id, $branch, $file, $edit_id = 0,$chunkFileArr=[])
    {
        $member = Session::get('fantasy_user');
        if(empty($chunkFileArr)){
            $mimeName = $file->getClientOriginalName();
            $mimeSize = $file->getSize();
            $fileMimeType = $file->getMimeType();
        }
        else{
            $mimeName = $chunkFileArr['mimeName'];
            $mimeSize = $chunkFileArr['totalSize'];
            $fileMimeType = $chunkFileArr['fileMimeType'];
        }
        $fileType = pathinfo($mimeName, PATHINFO_EXTENSION);
        $back = [];
        $back['an'] = false;
        $back['data'] = "";
        $back['message'] = '檔案上傳失敗';

        if (!in_array(strtolower($fileType), collect(static::$allowFileMimeType['img'])->merge(collect(static::$allowFileMimeType['file']))->flatten()->unique()->all() ?? [])) {
            return $back;
        }

        $fileOriginalName = str_replace('.' . $fileType, '', $mimeName);
        $fileName = $name . '.' . $fileType;
        $path = public_path() . $folder;
        $filePath = $path . '/' . $fileName;
        //切片上傳
        if(!empty($chunkFileArr)){
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            rename($chunkFileArr['chunkFilePath'],$filePath); //搬移資料
        }
        else $file->move($path, $fileName);

        if (file_exists($filePath)) {
            $fileImformation = getimagesize($filePath);
            //檔案key
            $length = 2;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomWord = '';
            for ($i = 0; $i < $length; $i++) {
                $randomWord .= $characters[rand(0, $charactersLength - 1)];
            }
            $file_key = str_pad($member['id'], 2, "0", STR_PAD_LEFT) . date("ymdH") . $randomWord . substr(floor((microtime(true) * 1000)), -6);

            //如果是更新檔案
            if ($edit_id != 0) {
                $modelData = FmsFile::where('id', $edit_id)->first();
                $file_key = $modelData->file_key;
            } else {
                $modelData = new FmsFile;
                $modelData->title = $fileOriginalName;
                $modelData->created_user = $user;
                $modelData->create_id = $member['id'];
            }

            $modelData->real_route = $folder . '/' . $fileName;
            $modelData->real_m_route = $folder . '/' . $fileName;
            //超過1000*1000不縮圖
            if (!empty($fileImformation)) {
                $modelData->real_m_route = ($fileImformation[0] <= 1000 && $fileImformation[1] <= 1000) ? self::get_thumbnail($folder, $name, $fileType) : $modelData->real_m_route;
            }
            $modelData->file_key = $file_key;
            $modelData->folder_id = $folder_id;
            $modelData->branch_id = $branch;
            $modelData->type = $fileType;
            $modelData->size = $mimeSize;
            $modelData->img_w = (!empty($fileImformation)) ? $fileImformation[0] : 0;
            $modelData->img_h = (!empty($fileImformation)) ? $fileImformation[1] : 0;

            $modelData->is_private = $data['is_private'];
            $modelData->can_use = $data['can_use'];

            if ($modelData->save()) {
                //如果是新增
                if ($edit_id == 0) {
                    $data = $modelData;
                    $attributes_en = json_encode($data, JSON_UNESCAPED_UNICODE);
                    BaseFunction::writeLogData('insert', ['table' => 'basic_fms_file', 'id' => $data['id'], 'ChangeData' => $attributes_en, 'classname' => 'FMS']);
                }

                $back['an'] = true;
                $back['data'] = $modelData;
                $back['message'] = '檔案上傳成功';
                return $back;
            }
        }
        return $back;
    }

    public static function saveFileToDBAndS3($data, $name, $folder, $user, $folder_id, $branch, $file, $edit_id = 0)
    {
        $member = Session::get('fantasy_user');
        $mimeName = $file->getClientOriginalName();
        $mimeSize = $file->getSize();
        $fileMimeType = $file->getMimeType();
        $fileType = pathinfo($mimeName, PATHINFO_EXTENSION);
        $fileImformation = getimagesize($file);

        $s3 = \Storage::disk('s3');
        $prefix = '/'.config('fms.s3_prefix');


        $back = [];
        $back['an'] = false;
        $back['data'] = "";
        $back['message'] = '檔案上傳失敗';
        if (!in_array($fileType, collect(static::$allowFileMimeType['img'])->merge(collect(static::$allowFileMimeType['file']))->flatten()->unique()->all() ?? [])) {
            return $back;
        }

        $fileOriginalName = str_replace('.' . $fileType, '', $mimeName);
        $fileName = $name . '.' . $fileType;
        $path = $prefix . $folder;
        $filePath = $path . '/' . $fileName;
        // $file->move($path, $fileName);
        $saveS3 = $s3->put($filePath, file_get_contents($file),'public');

        if($saveS3){
            //檔案key
            $length = 2;
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomWord = '';
            for ($i = 0; $i < $length; $i++) {
                $randomWord .= $characters[rand(0, $charactersLength - 1)];
            }
            $file_key = str_pad($member['id'], 2, "0", STR_PAD_LEFT) . date("ymdH") . $randomWord . substr(floor((microtime(true) * 1000)), -6);

            //如果是更新檔案
            if ($edit_id != 0) {
                $modelData = FmsFile::where('id', $edit_id)->first();
                $file_key = $modelData->file_key;
            } else {
                $modelData = new FmsFile;
                $modelData->title = $fileOriginalName;
                $modelData->created_user = $user;
                $modelData->create_id = $member['id'];
            }

            $modelData->real_route = $prefix.$folder . '/' . $fileName;
            $modelData->real_m_route = $prefix.$folder . '/' . $fileName;
            //超過1000*1000不縮圖
            // if (!empty($fileImformation)) {
            //     $modelData->real_m_route = ($fileImformation[0] <= 1000 && $fileImformation[1] <= 1000) ? self::get_thumbnail($folder, $name, $fileType) : $modelData->real_m_route;
            // }
            $modelData->file_key = $file_key;
            $modelData->folder_id = $folder_id;
            $modelData->branch_id = $branch;
            $modelData->type = $fileType;
            $modelData->size = $mimeSize;
            $modelData->img_w = (!empty($fileImformation)) ? $fileImformation[0] : 0;
            $modelData->img_h = (!empty($fileImformation)) ? $fileImformation[1] : 0;

            $modelData->is_private = $data['is_private'];
            $modelData->can_use = $data['can_use'];

            if ($modelData->save()) {
                //如果是新增
                if ($edit_id == 0) {
                    $data = $modelData;
                    $attributes_en = json_encode($data, JSON_UNESCAPED_UNICODE);
                    BaseFunction::writeLogData('insert', ['table' => 'basic_fms_file', 'id' => $data['id'], 'ChangeData' => $attributes_en, 'classname' => 'FMS']);
                }

                $back['an'] = true;
                $back['data'] = $modelData;
                $back['message'] = '檔案上傳成功';
                return $back;
            }
        }

        return $back;
        // $ext = $image->extension();
        // $image_name = $image->getClientOriginalName();
        // $s3 = \Storage::disk('s3');
        // //儲存至不存在的資料夾會直接建立出來
        // $filePath = '/public/test/' . $image_name;
        // //public 公開, private 私有(還是以Bucket policy為主), null默認(通常為私有，需要寫Bucket policy)
        // $publicUrl = $s3->put($filePath, file_get_contents($image),'private');
        // if($publicUrl){
        //     //儲存成功
        // }
        // else{
        //     // 儲存失敗
        // }
        //判斷檔案/資料夾是否存在
        // if (\Storage::disk('s3')->exists('狗狗.jpg')) {
            //檔案刪除 true | false
            // $delete = \Storage::disk('s3')->delete('狗狗.jpg');
            //資料夾刪除
            // $delete = Storage::disk('s3')->deleteDirectory('/public/test');
        // }
        // 取得單一資料夾中的檔案 (不含資料夾)
        // $files = Storage::disk('s3')->files('/');
        // 取得所有檔案 (多層路徑)
        // $files = Storage::disk('s3')->allFiles('/');
        // 取得資料夾
        // $folder = Storage::disk('s3')->directories('/');
    }

    public function f_lbox_full($branch, $locale, $getType, $getKey, $fileId, Request $request)
    {
        $branch = $request->branch;
        $locale = $request->locale;
        $getType = $request->type;
        $getKey = $request->key;
        $fileId = $request->id;

        $folder = [];
        $folderLevel = 'first';
        $file = [];

        FmsFile::chunkById(100, function ($data) use (&$file) {
            foreach ($data as $val) {
                $file[] = $val;
            }
        });
        $zero = ($request->input('zero') != 'undefined') ? $request->input('zero') : (FmsZero::where('is_active', 1)->first()->id);
        $isBranch = parent::$setBranchs;

        if ($getType == 'img') {
            $one_class = 'one_shot';
        } else if ($getType == 'file') {
            $one_class = 'one_shot';
        } else {
            $one_class = 'multi_shot';
        }

        $getList = MenuFunction::getFmsFolderMenu(1, '', $zero);
        $menuList = $getList['list'];
        $zeroList = $getList['zero'];
        if ($zero != '') {
            $nowZero = collect($zeroList)->where('id', $zero)->first();
        } else {
            $nowZero = $zeroList[0];
        }

        return View::make(
            'Fantasy.fms.lbox_full',
            [
                'zeroList' => $zeroList,
                'nowZero' => $nowZero,
                'menuList' => $menuList,
                'now_type' => 1,
                'unit_type' => $getType,
                'one_class' => $one_class,
                'img_key' => $getKey,
                'first' => 0,
                'second' => 0,
                'third' => 0,
                'folder' => $folder,
                'folderLevel' => $folderLevel,
                'file' => $file,
                'countFile' => count($file),
            ]
        );
    }
    public function f_lbox($branch, $locale, $getType, $getKey, $fileId, Request $request)
    {
        $branch = $request->branch;
        $locale = $request->locale;
        $getType = $request->type;
        $getKey = $request->key;
        $fileId = $request->id;
        $cms_open = $request->cms_open;

        if ($cms_open && !empty($fileId)) {
            $request->folder_id = FmsFile::where('file_key', $fileId)->first()->folder_id ?? 0;
        }

        ini_set('memory_limit', '2048M');

        //直接打開的資料夾ID(及上層)
        // $folder_id = (!empty($request->folder_id)) ? $request->folder_id : Fmsfolder::where('self_level', 0)->first()->id;
        $folder_id = (!empty($request->folder_id)) ? $request->folder_id : 0;

        //資料夾 - all(全部顯示) / me(只顯示有權限)
        $folderAll = self::GetFmsfolder('me');

        //資料夾麵包屑 資料由下到上
        $nowFolderPath = Fmsfolder::where('id', $folder_id)->with('top_folder')->first();

        $isBranch = parent::$setBranchs;
        if ($getType == 'img') {
            $one_class = 'one_shot';
        } else if ($getType == 'file') {
            $one_class = 'one_shot';
        } else {
            $one_class = 'multi_shot';
        }
        $file = [];

        $menuList = [];
        $blade = View::make(
            'Fantasy.fms.lbox',
            [

                'menuList' => $menuList,
                'now_type' => 1,
                'unit_type' => $getType,
                'one_class' => $one_class,
                'img_key' => $getKey,
                'folderAll' => $folderAll,
                'folder_id' => $folder_id,
                'nowFolderPath' => $nowFolderPath,
                'file' => $file,
                'cms_open' => true,
                'first' => 0,
                'second' => 0,
                'third' => 0,
            ]
        )->render();
        return response()->json(['blade' => $blade, 'folder_id' => $folder_id]);
    }
    public function fms_sort($branch, $locale, Request $request)
    {

        $branch = $request->branch;
        $locale = $request->locale;

        $search_column = $request->search_column;
        $column_sort = $request->column_sort;

        $folder = self::GetFmsfolder('all', $request->folder_id);
        $file = self::GetFmsFile('img');

        $search_column_str = '';
        switch ($search_column) {
            case 1:
                $search_column_str = 'title';
                break;
            case 2:
                $search_column_str = 'type';
                break;
            case 3:
                $search_column_str = 'type';
                break;
            case 4:
                $search_column_str = 'size';
                break;
            case 5:
                $search_column_str = 'img_w';
                break;
            case 6:
                $search_column_str = 'updated_at';
                break;
        }

        if ($column_sort) {
            $collection_file = collect($file)->sortBy($search_column_str);
            if ($search_column_str == 'updated_at') {
                $folder = collect($folder)->sortBy($search_column_str);
            }
        } else {
            $collection_file = collect($file)->sortByDesc($search_column_str);
            if ($search_column_str == 'updated_at') {
                $folder = collect($folder)->sortByDesc($search_column_str);
            }
        }

        $content['view'] = View::make(
            'Fantasy.fms.lbox_sort',
            [
                'folder_id' => $request->folder_id,
                'folder' => $folder,
                'file' => $collection_file,
            ]
        )->render();
        return $content;
    }
    public function file_new($branch, $locale, Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $folderAll = self::GetFmsfolder('me');
        return View::make(
            'Fantasy.fms.folder_all_select',
            [
                'folderAll' => $folderAll,
            ]
        );
    }
    public function get_file_folder($branch, $locale, $list_type, $first, $second, $third, $type, Request $request)
    {

        $branch = $request->branch;
        $locale = $request->locale;
        $list_type = $request->list_type;
        $first = $request->first;
        $second = $request->second;
        $third = $request->third;
        $type = $request->type;

        $zero = ($request->input('zero') != 'undefined') ? $request->input('zero') : (FmsZero::where('is_active', 1)->first()->id);
        if ($first != 0) {
            $folder = FmsSecond::where('first_id', $first);
            $folderLevel = 'second';
            $file = FmsFile::where('first_id', $first);
        } else {
            if ($second != 0) {
                $folder = FmsThird::where('second_id', $second);
                $folderLevel = 'third';
                $file = FmsFile::where('second_id', $second);
            } else {
                if ($third != 0) {
                    $folder = [];
                    $folderLevel = '';
                    $file = FmsFile::where('third_id', $third);
                } else {
                    $folder = FmsFirst::where('zero_id', $zero);
                    $folderLevel = 'first';
                    $file = FmsFile::where('zero_id', $zero)
                        ->where('first_id', '0')->where('second_id', '0')->where('third_id', '0');
                }
            }
        }
        if (!empty($_GET['w_rank'])) {
            switch ($_GET['w_rank']) {
                case 'title':
                    $folder = ($folder == []) ? [] : $folder->orderBy('title')->get();
                    $file = $file->orderBy('title')->get();
                    break;

                case 'type':
                    $folder = ($folder == []) ? [] : $folder->get();
                    $file = $file->orderBy('type')->get();
                    break;

                case 'file_type':
                    $folder = ($folder == []) ? [] : $folder->get();
                    $file = $file->orderBy('type')->get();
                    break;

                case 'size':
                    $folder = ($folder == []) ? [] : $folder->get();
                    $file = $file->orderBy('size')->get();
                    break;

                case 'resolution':
                    $folder = ($folder == []) ? [] : $folder->get();
                    $file = $file->orderBy('resolution')->get();
                    break;

                case 'updated_at':
                    $folder = ($folder == []) ? [] : $folder->orderBy('updated_at')->get();
                    $file = $file->orderBy('updated_at')->get();
                    break;

                case 'created_at':
                    $folder = ($folder == []) ? [] : $folder->orderBy('created_at')->get();
                    $file = $file->orderBy('created_at')->get();
                    break;

                case 'create_id':
                    $folder = ($folder == []) ? [] : $folder->orderBy('created_user')->get();
                    $file = $file->orderBy('created_user')->get();
                    break;

                default:
                    $folder = ($folder == []) ? [] : $folder->get();
                    $file = $file->get();

                    break;
            }
        } else {
            $folder = ($folder == []) ? [] : $folder->get();
            if (!empty($file)) {
                $file = $file->get();
            } else {
                $file = [];
            }
        }

        foreach ($file as $key => $value) {
            $file[$key]['file_type'] = self::get_file_type($value['type']);
            $file[$key]['_this_size'] = BaseFunction::cvt_file_size($value['size']);
        }

        if ($list_type == 'lt_mode') {
            $view = 'Fantasy.fms.lt_mode';
        } else if ($list_type == 'lp_mode') {
            $view = 'Fantasy.fms.lp_mode';
        } else if ($list_type == 'gd_mode') {
            $view = 'Fantasy.fms.gd_mode';
        }
        return View::make(
            $view,
            [
                'folder' => $folder,
                'folderLevel' => $folderLevel,
                'file' => $file,
                'countFile' => count($file),
            ]
        );
    }
    public function get_fms_sidebar($branch, $locale, $first, $second, $third, Request $request)
    {

        $branch = $request->branch;
        $locale = $request->locale;
        $first = $request->first;
        $second = $request->second;
        $third = $request->third;

        $zero = ($request->input('zero') != 'undefined') ? $request->input('zero') : (FmsZero::where('is_active', 1)->first()->id);
        $isBranch = parent::$setBranchs;

        $getList = MenuFunction::getFmsFolderMenu(1, '', $zero);
        $menuList = $getList['list'];
        $zeroList = $getList['zero'];
        if ($zero != '') {
            $nowZero = collect($zeroList)->where('id', $zero)->first();
        } else {
            $nowZero = $zeroList[0];
        }
        return View::make(
            'Fantasy.fms.sidebar',
            [
                'zeroList' => $zeroList,
                'nowZero' => $nowZero,
                'menuList' => $menuList,
                'first' => $first,
                'second' => $second,
                'third' => $third,
                'now_type' => 1,
            ]
        );
    }
    public function get_file_detail($branch, $locale, $file_id, Request $request)
    {

        $branch = $request->branch;
        $locale = $request->locale;
        $file_id = $request->file_id;

        $File = FmsFile::FindOrFail($file_id);
        if (!$File) {
            return 0;
        } else {
            $owner = FantasyUsers::where('id', $File['created_user'])->first();
            $last_edit_user = FantasyUsers::where('id', $File['last_edit_user'])->first();
            //檔案大小
            $File['_this_size'] = BaseFunction::cvt_file_size($File['size']);

            //路徑
            $file_path = BaseFunction::get_file_path($File);

            $count_file = FmsFile::where('first_id', $File['first_id'])
                ->where('second_id', $File['second_id'])
                ->where('third_id', $File['third_id'])
                ->count();

            $file_type = self::get_file_type($File['type']);
            //0220 jax add 洗擁有權限的名子
            $share_user = [];

            if ($File['share_group'] != '' && $File['share_group'] != '[""]') {
                // var_dump($File['share_group']);
                // die();
                $share_user_array = json_decode($File['share_group']);
                foreach ($share_user_array as $key => $row) {
                    $user = $owner = FantasyUsers::where('id', $row)->first();
                    array_push($share_user, $user['name']);
                }
            }
            return View::make(
                'Fantasy.fms.file_detail',
                [
                    'File' => $File,
                    'file_path' => $file_path,
                    'count_file' => $count_file,
                    'file_type' => $file_type,
                    'owner' => $owner,
                    'share_user' => $share_user,
                    'last_edit_user' => $last_edit_user,
                    'area_title' => 'FILE INFORMATION 檔案資訊',
                    'area_detail' => '檔案',
                ]
            );
        }
    }
    public function get_file_edit($branch, $locale, $file_id, $is_delete, Request $request)
    {
        $branch = $request->branch;
        $locale = $request->locale;
        $file_id = $request->file_id;
        $is_delete = $request->is_delete;

        $user = Session::get('fantasy_user');
        $File = FmsFile::FindOrFail($file_id);
        //當前資料夾層及/路徑
        $nowFolderPath = Fmsfolder::where('id', $File->folder_id)->with('top_folder')->first();

        $nowFolderPathText = "";
        $nowFolderPathText = self::get_not_folder_path($nowFolderPathText, $nowFolderPath);
        //資料夾 - all(全部顯示) / me(只顯示有權限)
        $folderAll = self::GetFmsfolder('me');
        $owner = FantasyUsers::where('id', $File['created_user'])->first();
        $last_edit_user = FantasyUsers::where('id', $File['last_edit_user'])->first();
        $file_type = self::get_file_type($File['type']);
        $all_owner = FantasyUsers::get();

        //判斷權限
        $temp = '"' . $user['id'] . '"';
        if (preg_match($temp, $File['can_use']) || $File['create_id'] == $user['id'] || $File['is_private'] == 0 || $user['fms_admin'] == 1) {
            $File['use_auth'] = 'can_use';
        } else {
            $File['use_auth'] = 'cant_use lock';
        }

        return View::make(
            'Fantasy.fms.file_edit',
            [
                'File' => $File,
                'folderAll' => $folderAll,
                'nowFolderPathText' => $nowFolderPathText,
                'is_delete' => $is_delete,
                'owner' => $owner,
                'all_owner' => $all_owner,
                'last_edit_user' => $last_edit_user,
                'user' => $user,
                'file_type' => $file_type,
                'area_title' => 'FILE EDIT 檔案編輯',
                'area_detail' => '檔案',
            ]
        );
    }

    public function get_file_exchange(Request $request)
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $user = Session::get('fantasy_user');

        $folder_id = (!empty($request->folder_id)) ? $request->folder_id : Fmsfolder::where('self_level', 0)->first()->id;

        $json_file = json_decode($request->json_file, true);
        $json_folder = json_decode($request->json_folder, true);
        $json_file = (!empty($json_file)) ? $json_file : [];
        $json_folder = (!empty($json_folder)) ? $json_folder : [];

        $res = [];
        $res['status'] = 'success';
        $res['msg'] = '編輯成功';

        $isRecovery = $request['recovery'];
        if (empty($isRecovery)) {
            $isDelete = 0;
        }

        //復原
        if ($isRecovery) {
            FmsFile::whereIn('id', $json_file)
                ->where(function ($q) use ($user) {
                    $q->orwhere('is_private', 0)->orwhere('create_id', $user['id'])->orwhere('can_use', '%"' . $user['id'] . '"%');
                })->update(['is_delete' => 0]);
            Fmsfolder::whereIn('id', $json_folder)
                ->where(function ($q) use ($user) {
                    $q->orwhere('is_private', 0)->orwhere('create_id', $user['id'])->orwhere('can_use', '%"' . $user['id'] . '"%');
                })->update(['is_delete' => 0]);
            $res['msg'] = '資料已復原';
            return $res;
        }
        //永久刪除
        $realDelete = $request->realDelete;
        if (empty($realDelete)) {
            $realDelete = 0;
        }

        if ($realDelete) {
            FmsFile::whereIn('id', $json_file)
                ->where(function ($q) use ($user) {
                    $q->orwhere('is_private', 0)->orwhere('create_id', $user['id'])->orwhere('can_use', '%"' . $user['id'] . '"%');
                })->delete();
            Fmsfolder::whereIn('id', $json_folder)
                ->where(function ($q) use ($user) {
                    $q->orwhere('is_private', 0)->orwhere('create_id', $user['id'])->orwhere('can_use', '%"' . $user['id'] . '"%');
                })->delete();
            $res['msg'] = '資料已刪除';
            return $res;
        }
        $isDelete = $request['delete'];
        if (empty($isDelete)) {
            $isDelete = 0;
        }

        //進行軟刪除
        if ($isDelete) {
            FmsFile::whereIn('id', $json_file)
                ->checkValid()
                ->update(['is_delete' => 1]);
            Fmsfolder::whereIn('id', $json_folder)
                ->checkValid()
                ->update(['is_delete' => 1]);
            $res['msg'] = '資料已刪除';
            return $res;
        }

        $nowFolderID = $request['nowFolder'];
        // if (empty($nowFolderID)) {
        //     $res['status'] = 'fail';
        //     $res['msg'] = '資料選擇錯誤，請重新整理頁面';
        //     return $res;
        // }
        $parent = Fmsfolder::where("id", $nowFolderID)->first();
        // if (empty($parent)) {
        //     $res['status'] = 'fail';
        //     $res['msg'] = '資料選擇錯誤，請重新整理頁面';
        //     return $res;
        // }
        if (empty($parent)) {
            $parent = [];
            $parent['id'] = 0;
            $parent['self_level'] = 0;
            $parent['branch_id'] = 1;
        }

        //選擇檔案總數
        $allCount = FmsFile::whereIn('id', $json_file)->get()->count();
        $allCount = $allCount + Fmsfolder::whereIn('id', $json_folder)->get()->count();

        $File = FmsFile::whereIn('id', $json_file)
            ->where("folder_id", $nowFolderID)
            ->checkValid()
            ->get();
        $Folder = Fmsfolder::whereIn('id', $json_folder)
            ->where("parent_id", $nowFolderID)
            ->checkValid()
            ->get();

        //數量/權限不對
        if ((count($File) + count($Folder)) != $allCount) {
            $res['status'] = 'fail';
            $res['msg'] = '請選擇同一資料夾中的資料進行操作，或資料選擇錯誤。';
            return $res;
        }

        //當前資料夾層及/路徑
        $nowFolderPath = Fmsfolder::where('id', $nowFolderID)->with('top_folder')->first();

        $nowFolderPathText = "";
        $nowFolderPathText = self::get_not_folder_path($nowFolderPathText, $nowFolderPath);
        //資料夾 - all(全部顯示) / me(只顯示有權限)
        $folderAll = self::GetFmsfolder('me');
        $res['view'] = View::make(
            'Fantasy.fms.file_exchange',
            [
                'parent' => $parent,

                'folder_id' => $folder_id,
                'file_id_json' => json_encode($json_file, JSON_UNESCAPED_UNICODE),
                'folder_id_json' => json_encode($json_folder, JSON_UNESCAPED_UNICODE),

                'json_folder' => $json_folder,
                'nowFolderPathText' => $nowFolderPathText,
                'folderAll' => $folderAll,

                'allCount' => $allCount,
                'area_title' => 'FILE EDIT 檔案位置移動',
                'area_detail' => '檔案',
            ]
        )->render();
        return $res;
    }

    public function get_folder_detail($branch, $locale, $folder_type, $folder_id, Request $request)
    {

        $branch = $request->branch;
        $locale = $request->locale;
        $folder_type = $request->folder_type;
        $folder_id = $request->folder_id;

        if ($folder_type == 1) {
            $folder = FmsFirst::where('id', $folder_id)->first();
            $f0 = FmsZero::where('id', $folder['zero_id'])->first();
            $file_path = $f0['title'] . ' / ' . $folder['title'];

            $count_file = FmsFile::where('first_id', $folder_id)->count();
            $folder_size = FmsFile::where('first_id', $folder_id)->sum('size');
        } elseif ($folder_type == 2) {
            $folder = FmsSecond::where('id', $folder_id)
                ->with('FmsFirst')
                ->first();
            $f0 = FmsZero::where('id', $folder->FmsFirst['zero_id'])->first();
            $file_path = $f0['title'] . ' / ' . $folder->FmsFirst['title'] . ' / ' . $folder['title'];

            $count_file = FmsFile::where('second_id', $folder_id)->count();
            $f_folder_size = FmsFile::where('first_id', $folder->FmsFirst['id'])->sum('size');
            $s_folder_size = FmsFile::where('second_id', $folder_id)->sum('size');
            $folder_size = $f_folder_size + $s_folder_size;
        } elseif ($folder_type == 3) {
            $folder = FmsThird::where('id', $folder_id)
                ->with('FmsSecond')
                ->first();
            $f_folder = FmsFirst::where('id', $folder->FmsSecond['first_id'])->first();
            $f0 = FmsZero::where('id', $f_folder['zero_id'])->first();
            $file_path = $f0['title'] . ' / ' . $f_folder['title'] . ' / ' . $folder->FmsSecond['title'] . ' / ' . $folder['title'];

            $count_file = FmsFile::where('third_id', $folder_id)->count();
            $f_folder_size = FmsFile::where('first_id', $f_folder['id'])->sum('size');
            $s_folder_size = FmsFile::where('second_id', $folder->FmsSecond['id'])->sum('size');
            $t_folder_size = FmsFile::where('third_id', $folder_id)->sum('size');
            $folder_size = $f_folder_size + $s_folder_size + $t_folder_size;
        }
        if (!$folder) {
            return 0;
        } else {
            $folder['_this_size'] = BaseFunction::cvt_file_size($folder_size);

            $folder['resolution'] = 'x';
            $file_type['title'] = '資料夾';
            $file_type['img'] = '/vender/assets/img/folder.png';
            $owner = FantasyUsers::where('id', $folder['created_user'])->first();

            return View::make(
                'Fantasy.fms.file_detail',
                [
                    'File' => $folder,
                    'file_path' => $file_path,
                    'count_file' => $count_file,
                    'file_type' => $file_type,
                    'folder_type' => $folder_type,
                    'owner' => $owner,
                    'area_title' => 'FOLDER INFORMATION 資料夾資訊',
                    'area_detail' => '資料夾',
                ]
            );
        }
    }
    public function get_folder_edit($branch, $locale, $folder_id, $nowFolderID, Request $request)
    {

        $branch = $request->branch;
        $locale = $request->locale;
        $folder_id = $request->folder_id;
        $nowFolderID = $request->nowFolderID;

        $all_owner = FantasyUsers::where('is_active', '1')->get();
        $Fmsfolder = Fmsfolder::find($folder_id);
        $folderAll = self::GetFmsfolder('me');
        $owner = FantasyUsers::where('id', $Fmsfolder['created_user'])->first();

        //當前資料夾層及/路徑
        $nowFolderPath = Fmsfolder::where('id', $nowFolderID)->with('top_folder')->first();

        $nowFolderPathText = '';
        $nowFolderPathText = self::get_not_folder_path($nowFolderPathText, $nowFolderPath);
        return View::make(
            'Fantasy.fms.folder_edit',
            [
                'folder' => $Fmsfolder,
                'folderAll' => $folderAll,
                'owner' => $owner,
                'nowFolderPathText' => $nowFolderPathText,
                'area_title' => 'FOLDER EDIT 資料夾編輯',
                'area_detail' => '資料夾',
            ]
        );
    }

    public function get_folder_edit_new($branch, $locale, $parent_id, $id = 0, Request $request)
    {
        $branch = $request->branch;
        $locale = $request->locale;
        $parent_id = $request->parent_id;
        $id = $request->id ?? 0;

        $owner = Session::get('fantasy_user');

        if ($id != 0) {
            $selfFolder = Fmsfolder::where('id', $id)->checkValid()->first();
            if (empty($selfFolder)) {
                return false;
            }
        }
        $parent = Fmsfolder::where("id", $parent_id)->first();
        $self_level = -1;
        $branch_id = 1;
        if (!empty($parent)) {
            $self_level = $parent['self_level'];
            $branch_id = $parent['branch_id'];
        }
        $folderData = [
            'id' => $id,
            'title' => '未命名資料夾',
            'note' => '',
            'parent_id' => $parent_id,
            'parent_level' => $self_level,
            'parent_branch' => $branch_id,
        ];
        $all_owner = FantasyUsers::where('is_active', '1')->get();

        //資料夾 - all(全部顯示) / me(只顯示有權限)
        $folderAll = self::GetFmsfolder('me');

        //當前資料夾層及/路徑  根目錄會是null
        $nowFolderPath = Fmsfolder::where('id', $parent_id)->with('top_folder')->first();

        $nowFolderPathText = '';
        $nowFolderPathText = self::get_not_folder_path($nowFolderPathText, $nowFolderPath);
        if ($id != 0) {
            $folderData['title'] = $selfFolder['title'];
            $folderData['note'] = $selfFolder['note'];
            $last_edit_user = FantasyUsers::where('id', $selfFolder['last_edit_user'])->first();
            if (empty($last_edit_user)) {
                $last_edit_user = [];
            }
        } else {
            $selfFolder = [];
            $last_edit_user = [];
        }
        $json_folder = [$id];

        return View::make(
            'Fantasy.fms.folder_edit_rev',
            [
                'folderData' => $folderData,
                'folderAll' => $folderAll,
                'nowFolderPathText' => $nowFolderPathText,
                'selfFolder' => $selfFolder,
                'json_folder' => $json_folder,

                // 'folder_data' => $folder_data,
                'last_edit_user' => $last_edit_user,
                'owner' => $owner,
                'all_owner' => $all_owner,
                'area_title' => 'FILE EDIT 檔案編輯',
                'area_detail' => '檔案',
            ]
        );
    }
    public function get_not_folder_path($nowFolderPathText, $nowFolder)
    {
        if ($nowFolder) {
            //有上層資料夾的話就串接 遞回檢查更上層資料夾
            $nowFolderPathText = self::get_not_folder_path($nowFolder['title'] . "/" . $nowFolderPathText, $nowFolder['top_folder']);
            return $nowFolderPathText;
        } else {
            //最後接上根目錄
            return "根目錄/" . $nowFolderPathText;
        }
    }
    public function get_file_type($f_extension)
    {
        $f_extension = strtolower($f_extension);
        return Config::get('fms.mime_type_info.' . Config::get('fms.mime_type.' . $f_extension, 'default'));
    }

    // 若上傳的為圖檔，則回傳縮圖路徑
    public static function get_thumbnail($folder, $name, $ext)
    {

        $file_path = public_path() . $folder . '/' . $name . '.' . $ext;

        // 判斷檔案是否存在
        if (file_exists($file_path)) {
            // 判斷檔案是否為圖檔，若不是圖檔回傳空值，否則產生縮圖後回傳路徑
            $file_type = mime_content_type($file_path);

            if ($file_type == 'image/svg+xml' || $file_type == 'svg') {
                return $folder . '/' . $name . '.' . $ext;
            }

            if (Config::get('fms.mime_type.' . $file_type, '') !== 'image') {
                return '';
            } else {
                $img = Image::make($file_path);
                $new_img = $folder . '/' . $name . '_m.' . $ext;
                // 上傳圖檔尺寸
                $w = $img->width();
                $h = $img->height();

                // 縮圖尺寸
                $tw = Config::get('fms.thumbnail.width');
                $th = Config::get('fms.thumbnail.height');

                // 產生縮圖
                if ($w == $h) {
                    $img->resize($tw, $th)->save(public_path() . $new_img);
                } else if ($w > $h) {
                    $img->resize($tw, floor($h * $tw / $w))->save(public_path() . $new_img);
                } else {
                    $img->resize(floor($w * $th / $h), $th)->save(public_path() . $new_img);
                }

                return $new_img;
            }
        } else {
            return '';
        }
    }

    public function check_user($file_user_id)
    {
        $user = Session::get('fantasy_user');
        if ($file_user_id == $user['id'] || $user['fms_admin'] == '1') {
            return true;
        } else {
            return false;
        }
    }

    public function getSontableMultiImage(Request $request)
    {
        $data = $request->all();

        $file = FmsFile::whereIn('file_key', json_decode($data['file_id']))->get();

        foreach ($file as $value) {
            $value['randomCode'] = Str::random(5);
            $value['this_file_path'] = BaseFunction::get_file_path($value);
        }

        return response()->json(array(
            'file' => $file,
            'data' => $data,
        ));
    }
}
