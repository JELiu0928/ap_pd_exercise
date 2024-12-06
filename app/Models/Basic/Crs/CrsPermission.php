<?php

namespace App\Models\Basic\Crs;

use Config;

use Illuminate\Database\Eloquent\Model;

class CrsPermission extends Model
{
    public function __construct()
    {
        $this->setTable("basic_crs_permission");
    }

    public function CrsRole()
    {
        return $this->belongsTo('App\Models\Basic\Crs\CrsRole','crs_role_id');
    }

    public function CmsMenu()
    {
        return $this->belongsTo('App\Models\Basic\Cms\CmsMenu','cms_menu_id');
    }

}
