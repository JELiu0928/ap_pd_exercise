<?php

namespace App\Models\Basic\Crs;

use Config;

use Illuminate\Database\Eloquent\Model;

class CrsRole extends Model
{
    public function __construct()
    {
        $this->setTable("basic_crs_role");
    }

    public function CrsPermission()
    {
        return $this->hasMany('App\Models\Basic\Crs\CrsPermission', 'crs_role_id', 'id')->where('is_active', 1);
    }

    public function UsersData()
    {
        return $this->belongsTo('App\Models\Basic\FantasyUsers', 'user_id')->with('_photo_image')->select('id', 'name', 'mail', 'photo_image', 'account');
    }
}
