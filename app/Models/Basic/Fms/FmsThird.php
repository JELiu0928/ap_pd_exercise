<?php

namespace App\Models\Basic\Fms;

use Config;

use Illuminate\Database\Eloquent\Model;

class FmsThird extends Model
{
    public function __construct()
    {
        $this->setTable("basic_fms_third");
    }


    public function FmsFile()
    {
        return $this->hasMany('App\Models\Basic\Fms\FmsFile','third_id','id');
    }

    public function FmsSecond()
    {
        return $this->belongsTo('App\Models\Basic\Fms\FmsSecond','second_id');
    }

    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('id', 'desc');
    }

    // 刪除時順便刪除底下檔案
    // public function delete(){

    //     // 取得此資料夾底下所有檔案
    //     $del_file_data = $this->FmsFile()->get();

    //     // 刪除所屬檔案
    //     foreach($del_file_data as $row){
    //         $row->delete();
    //     }

    //     return parent::delete();
    // }
}
