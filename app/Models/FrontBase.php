<?php

namespace App\Models;

use BaseFunction;
use Config;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Cache;

class FrontBase extends Model
{
    public function newQuery($excludeDeleted = true)
    {
        $tableName = (new static())->getTable();
        $ColumnList = \Schema::getColumnListing($tableName);
        $imagesCols = preg_grep('/^o_(\w+)/i', $ColumnList);
        $fileTable = 'basic_fms_file';
        $query = parent::newQuery($excludeDeleted);
        $select = "{$tableName}.*";
        if (strpos(\Route::current()->action['prefix'], 'Fantasy') === false) {
            foreach ($imagesCols as $key => $field) {
                $tableAlias = "t{$key}";
                $select = "{$select}, {$tableAlias}.fms_real_route AS {$field}, {$tableAlias}.fms_alt AS {$field}_alt, {$tableAlias}.fms_id AS {$field}_id, {$tableAlias}.fms_url_name AS {$field}_url_name, {$tableAlias}.fms_title AS {$field}_title";
                $query->leftJoinSub("SELECT `id` as fms_id, `title` as fms_title,`real_route` as fms_real_route, `alt` as fms_alt, `file_key` as fms_file_key ,`url_name` as fms_url_name FROM {$fileTable}", $tableAlias, "{$tableName}.{$field}", '=', "{$tableAlias}.fms_file_key");
            }
            return $query->selectRaw($select);
        }
        return parent::newQuery($excludeDeleted);
    }
    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('id', 'desc');
    }
    //json欄位搜尋
    public function scopedoJsonSearch($query, $name, $search, $val)
    {
        return $query->whereRaw('json_length(' . $name . ') > 0 and JSON_SEARCH(' . $name . ', \'all\', ?,NULL,\'$.' . $search . '.val\') IS NOT NULL', [$val]);
    }
    // 排序
    public function scopedoSort($query)
    {
        return $query->orderby('w_rank', 'asc')->orderby('id', 'desc');
    }
    public function scopeselect2_option($query, $field = "title,w_title")
    {
        $Leon_value = explode(",", $field);
        $option = $query->get()->mapwithkeys(function ($item) use ($Leon_value) {
            $Leon_title = [];
            foreach ($Leon_value as $val) {
                if (isset($item->$val)) {
                    $Leon_title[] = $item->$val;
                }
            }
            return [$item['id'] => ['id' => $item->id, 'text' => implode(" ", $Leon_title)]];
        })->all();
        // array_unshift($option, ['id' => '', 'text' => '-']);
        return $option;
    }
    public function scopeget_cms_option($query, $field = "title,w_title")
    {
        $Leon_value = explode(",", $field);
        $option = $query->get()->mapwithkeys(function ($item) use ($Leon_value) {
            $Leon_title = [];
            $find_title = false;
            foreach ($Leon_value as $val) {
                if (isset($item->$val)) {
                    if ($val == 'title') {
                        $find_title = true;
                    }
                }
            }
            foreach ($Leon_value as $val) {
                if (isset($item->$val)) {
                    if ($find_title) {
                        if (strpos($val, 'title') !== false) {
                            if ($val == 'title') {
                                $Leon_title[] = $item->$val;
                            }
                        } else {
                            $Leon_title[] = $item->$val;
                        }
                    } else {
                        $Leon_title[] = $item->$val;
                    }
                }
            }
            return [$item['id'] => ['key' => $item->id, 'title' => implode(" ", $Leon_title)]];
        })->all();
        array_unshift($option, ['key' => '', 'title' => '-']);
        return $option;
    }
    // 取得該分館獨立編輯資料
    public function scopeonBrand($query)
    {
        $branch = str_replace(["preview.", "www."], "", \Route::current()->parameter('branch'));
        $branch = explode(".", $branch)[0] ?? '';
        $branch_url = \Route::current()->parameter('branch_url');
        $all = (strpos(\URL::full(), 'Fantasy') !== false);

        $subdomain = $branch_url ?: $branch;

        $branch_origin = M('BranchOrigin')::where(function ($q) use ($subdomain) {
            $q->where('url_title', $subdomain)->orwhere('url_title', 'www.' . $subdomain);
        })->first();
        $query = $query->where('branch_id', $branch_origin->id);
        return $query;
    }
    // 取得該分館可見資料
    public function scopeisVisible($query, $all = false)
    {
        $branch = str_replace(["preview.", "www."], "", \Route::current()->parameter('branch'));
        $branch = explode(".", $branch)[0] ?? '';
        $branch_url = \Route::current()->parameter('branch_url');
        $all = (strpos(\URL::full(), 'Fantasy') !== false);

        $subdomain = $branch_url ?: $branch;

        $locale = \Route::current()->parameter('locale');
        $is_pre = strpos($locale, 'preview_') !== false ? 1 : 0;

        $branch_origin = Cache::get('branch_'.$subdomain);
        if(empty($branch_origin)){
            $branch_origin = M('BranchOrigin')::where(function ($q) use ($subdomain) {
                $q->where('url_title', $subdomain)->orwhere('url_title', 'www.' . $subdomain);
            })->first();
            Cache::forever('branch_'.$subdomain, $branch_origin);
        }

        if ($all) {
            $query = $query->where('branch_id', $branch_origin->id);
        } else {
            if ($is_pre) {
                $query = $query->where('branch_id', $branch_origin->id)->where('is_preview', 1);
            } else {
                $query = $query->where('branch_id', $branch_origin->id)->where('is_visible', 1);
            }
        }
        if (config('cms.reviewfunction') && in_array($locale, json_decode($branch_origin->local_review_set) ?: [])) {
            $query = $query->where('is_reviewed', 1);
        }
        return $query;
    }
    //資料關聯子層使用subVisible 否則在審核環境中會撈不到資料
    public function scopesubVisible($query, $all = false)
    {
        $branch = str_replace(["preview.", "www."], "", \Route::current()->parameter('branch'));
        $branch = explode(".", $branch)[0] ?? '';
        $branch_url = \Route::current()->parameter('branch_url');
        $all = (strpos(\URL::full(), 'Fantasy') !== false);

        $subdomain = $branch_url ?: $branch;

        $locale = \Route::current()->parameter('locale');
        $is_pre = strpos($locale, 'preview_') !== false ? 1 : 0;

        $branch_origin = Cache::get('branch_'.$subdomain);
        if(empty($branch_origin)){
            $branch_origin = M('BranchOrigin')::where(function ($q) use ($subdomain) {
                $q->where('url_title', $subdomain)->orwhere('url_title', 'www.' . $subdomain);
            })->first();
            Cache::forever('branch_'.$subdomain, $branch_origin);
        }

        if ($all) {
            $query = $query->where('branch_id', $branch_origin->id);
        } else {
            if ($is_pre) {
                $query = $query->where('branch_id', $branch_origin->id)->where('is_preview', 1);
            } else {
                $query = $query->where('branch_id', $branch_origin->id)->where('is_visible', 1);
            }
        }
        return $query;
    }
    /**
     *  @example > menu_id => has_auth 欄位
     *  @example > 預設用id篩選，請複寫所需欄位，例:parent_id,f_id
     */
    public function scopeCheckAuth($query, int $menu_id, int $branch_id, string $col = 'id')
    {
        $auth_id = BaseFunction::get_auth_id($menu_id, $branch_id);
        if (in_array("pass", $auth_id)) {
            return $query;
        }

        $query->whereIn($col, $auth_id);
    }

    /**
     * @var $imagesCols 對應目標model的圖片欄位, ['img', 'img_mobile', ....]
     *
     * 請注意是用此方法後, 之後的select都要在欄位前加入表名
     * 若實作的model為某個model的子表, 在進行複製時需要注意
     */
    public function scopeformatFiles($query, array $imagesCols)
    {
        $tableName = (new static())->getTable();
        $fileTable = config('cms.file_table');
        $select = "";
        foreach ($imagesCols as $key => $field) {
            $tableAlias = "t{$key}";
            $select .= ($key > 0 ? ',' : '') . "{$tableAlias}.fms_real_route AS {$field}_url, {$tableAlias}.fms_real_m_route AS {$field}_thumbnail, {$tableAlias}.fms_alt AS {$field}_alt";
            $query->leftJoinSub("SELECT `id` as fms_id, `title` as fms_title,`real_route` as fms_real_route,`real_m_route` as fms_real_m_route, `alt` as fms_alt, `file_key` as fms_file_key ,`url_name` as fms_url_name FROM {$fileTable}", $tableAlias, "{$tableName}.{$field}", '=', "{$tableAlias}.fms_file_key");
        }
        $query->selectRaw("{$tableName}.*, " . $select);
    }
    public function scopeimageCol($query, array $imagesCols)
    {
        $tableName = (new static())->getTable();
        $fileTable = config('cms.file_table');
        $select = "";
        foreach ($imagesCols as $key => $field) {
            $tableAlias = "t{$key}";
            $select .= ($key > 0 ? ',' : '') . "{$tableAlias}.fms_real_route AS {$field}_thumbnail, {$tableAlias}.fms_alt AS {$field}_alt";
            $query->leftJoinSub("SELECT `id` as fms_id, `title` as fms_title,`real_m_route` as fms_real_route, `alt` as fms_alt, `file_key` as fms_file_key ,`url_name` as fms_url_name FROM {$fileTable}", $tableAlias, "{$tableName}.{$field}", '=', "{$tableAlias}.fms_file_key");
        }
        $query->selectRaw("{$tableName}.*, " . $select);
    }
    public function scopegetList($query,$empty = false,$keyword = "")
    {
        $data = self::select('id as key', 'title');
        if(!empty($keyword)){
            $data = $data->where('title','LIKE','%'.$keyword.'%');
        }
        if(is_int($empty)){
            $data = $data->orderby('id','desc')->get()->take($empty)->keyBy('key')->toArray();
        }else{
            $data = $data->orderby('id','desc')->get()->keyBy('key')->toArray();
        if($empty){
            array_unshift($data, ['key'=>0,'title'=>'-']);
            }
        }
        return $data;
    }
    public function scopegetListSon($query,$mainModel,$count = 0,$keyword = "")
    {
        $mainData = M($mainModel)::get()->keyBy('id');
        $data = self::select('id as key', 'title', 'parent_id');
        if(!empty($keyword)){
            $data = $data->where('title','LIKE','%'.$keyword.'%');
        }
        if($count > 0){
            $data = $data->orderby('id','desc')->get()->take($count)->keyBy('key')->toArray();
        }else{
            $data = $data->orderby('id','desc')->get()->keyBy('key')->toArray();
        }
        foreach($data as $key=>$val){
            $data[$key]['title'] = $mainData[$val['parent_id']]['title'] .' -> '. $val['title'];
        }
        return $data;
    }
    public function scopedoPostClose($query)
    {
        return $query->where(function ($query1) {
            $query1->where('publish_always', 1)->orWhere(function ($query2) {
                $query2->where('publish_always', 0)
                ->whereRaw('TIMESTAMP(`publish_open`,`publish_open_his`) <= ?', [Carbon::now()->toDateTimeString()])
                ->whereRaw('TIMESTAMP(`publish_close`,`publish_close_his`) >= ?', [Carbon::now()->toDateTimeString()]);
            });
        });
    }
}
