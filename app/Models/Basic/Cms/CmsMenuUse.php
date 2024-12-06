<?php

namespace App\Models\Basic\Cms;

use Config;

use Illuminate\Database\Eloquent\Model;

class CmsMenuUse extends Model
{
    public function __construct()
    {
        $this->setTable("basic_cms_menu_use");
    }

    public function CmsMenu()
    {
        return $this->hasMany('App\Models\Basic\Cms\CmsMenu', 'parent_id', 'id')->where('is_active', 1);
    }

    public function CmsPermission()
    {
        return $this->hasMany('App\Models\Basic\Cms\CmsPermission', 'cms_menu_id', 'id')->where('is_active', 1);
    }

    public function CrsPermission()
    {
        return $this->hasMany('App\Models\Basic\Crs\CrsPermission', 'crs_menu_id', 'id')->where('is_active', 1);
    }

    public function CmsChild()
    {
        return $this->hasMany('App\Models\Basic\Crs\CmsChild', 'menu_id', 'id');
    }

    public function CmsParent()
    {
        return $this->hasMany('App\Models\Basic\Crs\CmsParent', 'menu_id', 'id');
    }

    public function WebKey()
    {
        return $this->belongsto('App\Models\Basic\WebKey', 'key_id', 'id');
    }
    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('w_rank', 'asc')->orderby('id', 'asc');
    }
}
