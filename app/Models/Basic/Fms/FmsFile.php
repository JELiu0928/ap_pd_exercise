<?php

namespace App\Models\Basic\Fms;

use Config;
use Storage;

use Illuminate\Database\Eloquent\Model;

class FmsFile extends Model
{
    public function __construct()
    {
        $this->setTable("basic_fms_file");
    }
    public function create_user()
    {
        // create_id 修正 created_user
        return $this->belongsTo('App\Models\Basic\FantasyUsers', 'created_user');
    }

    public function FmsFirst()
    {
        return $this->belongsTo('App\Models\Basic\Fms\FmsFirst', 'first_id');
    }

    public function FmsSecond()
    {
        return $this->belongsTo('App\Models\Basic\Fms\FmsSecond', 'second_id');
    }

    public function FmsThird()
    {
        return $this->belongsTo('App\Models\Basic\Fms\FmsThird', 'third_id');
    }

    // 刪除資料時順便刪除檔案
    // public function delete(){

    //     // 刪除檔案
    //     $trueSrc = str_replace('/upload/','',$this->attributes['real_route']);
    //     if (Storage::disk('localPublic')->exists($trueSrc)) Storage::disk('localPublic')->delete($trueSrc);

    //     // 刪除縮圖檔案
    //     if(array_key_exists('real_m_route', $this->attributes)){
    //         $true_m_Src = str_replace('/upload/','',$this->attributes['real_m_route']);
    //         if (Storage::disk('localPublic')->exists($true_m_Src)) Storage::disk('localPublic')->delete($true_m_Src);
    //     }
    //     return parent::delete();
    // }

    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('id', 'desc');
    }

    public function Topfolder()
    {
        return $this->belongsTo('App\Models\Basic\Fms\Fmsfolder', 'folder_id', 'id')->with('top_folder');
    }

    public function scopeCheckValid($query)
    {
        $user = session('fantasy_user');
        $query->when($user['fms_admin'] != 1, function ($q) use ($user) {
            $q->where(function ($q2) use ($user) {
                $q2->orwhere('is_private', 0)->orwhere('create_id', $user['id'])->orwhere('can_use', 'LIKE', '%"' . $user['id'] . '"%');
            });
        });
    }
}
