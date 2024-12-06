<?php

namespace App\Services\Cms\api\traits;

use ErrorException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait BasicSql
{
    /**
     * @param string $model model class namespace
     * @return Builder
     */
    private function basicSql($model, $search = "")
    {
        if (!is_subclass_of($model, Model::class)) {
            throw new ErrorException($model . ' is not a Model Class.', 500);
        }

        $check = array_filter(json_decode($this->req->ids, true) ?? [], function ($id) {
            return !empty($id);
        });

        $data = $model::where('branch_id', $this->branchOrigin->id)
            ->when(!empty($check), function ($q) use ($check) {
                $str = implode(', ', $check);
                $q->whereIn('id', $check)->orderBy(DB::raw("FIELD(id,{$str})"));
            });

        // 新增權限篩選
        if (!empty($this->cmsMenu['CmsMenuUse']['has_auth'])) {
            $data->CheckAuth($this->cmsMenu->use_id, $this->branchOrigin->id);
        }

       //針對欄位篩選分類項目
        if(!empty($this->cmsMenu['CmsMenuUse']['auth_filter']) && $this->cmsMenu['CmsMenuUse']['auth_filter'] > 0){
        $data->CheckAuthFilter(
            $this->cmsMenu['CmsMenuUse']['auth_filter'], 
            $this->getRoles()['id'],
            $model,
            $this->FilterField
        );
        }

        /*===搜尋條件Start====*/
        $search = json_decode($search, true) ?? [];
        if (!empty($search)) {
            foreach ($search['data'] as $key => $val) {
                if ($val != "") {
                    //加密資料搜尋
                    $val = (strpos($key, 'aes_') !== false) ? \BaseFunction::encryptData($val) : $val;
                    
                    if (is_array($val)) {
                        foreach ($val as $v) {
                            $data->where($key, 'LIKE', '%"'.$v.'"%');
                        }
                    } else if(!empty($search['is_select2'])&& $search['is_select2']=='select2')
                    {
                        $data->where($key,$val);
                    }else {
                        if (strpos($key, "_range_start") !== false || strpos($key, "_range_end") !== false) {
                            if (strpos($key, "_range_end") !== false) continue;
                            $data->whereBetween(str_replace("_range_start", "", $key), [$search['data'][$key], $search['data'][str_replace("_range_start", "", $key) . '_range_end']]);
                        } else {
                            $data->where($key, 'LIKE', '%' . $val . '%');
                        }
                    }
                }
            }
        }
        /*===排序====*/
        if (empty($check) && config('cms.CMSSort', false) === true) {
            $data->doCMSSort();
        }

        return $data;
    }
}
