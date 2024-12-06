<?php

namespace App\Models\Basic\Fms;

use Config;

use Illuminate\Database\Eloquent\Model;

use App\Models\Basic\Fms\FmsThird;

class FmsSecond extends Model
{
    public function __construct()
    {
        $this->setTable("basic_fms_second");
    }

    public function FmsThird()
    {
        return $this->hasMany('App\Models\Basic\Fms\FmsThird','second_id','id');
    }

    public function FmsFile()
    {
        return $this->hasMany('App\Models\Basic\Fms\FmsFile','second_id','id');
    }

    public function FmsFirst()
    {
        return $this->belongsTo('App\Models\Basic\Fms\FmsFirst','first_id');
    }

    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('id', 'desc');
    }

    // 刪除時順便刪除底下檔案
    // public function delete(){

    //     // 取得此資料夾底下所有檔案
    //     $del_third_data = FmsThird::where('second_id', $this->attributes['id'])->get();
    //     $del_file_data = $this->FmsFile()->get();

    //     // 刪除所屬資料夾
    //     foreach($del_third_data as $row){
    //         $row->delete();
    //     }

    //     // 刪除所屬檔案
    //     foreach($del_file_data as $row){
    //         $row->delete();
    //     }

    //     return parent::delete();
    // }
}
