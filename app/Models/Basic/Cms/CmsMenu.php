<?php

namespace App\Models\Basic\Cms;

use Config;
use Illuminate\Database\Eloquent\Model;

class CmsMenu extends Model
{
    public function __construct()
    {
        $this->setTable("basic_cms_menu");
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

    public function crumb()
    {
        return $this->belongsTo(CmsMenu::class, 'parent_id');
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

    public function getCmsOptions()
    {
        if ($this->has_auth == $this->id) {
            return config('models.' . $this->model)::where('branch_id', $this->branch_id)->get()
                ->map(function ($item) {
                    return [
                        'key' => $item->id,
                        'title' => $item->title,
                    ];
                })->prepend([
                'key' => 'pass',
                'title' => 'ALL',
            ])->all();
        }

        return [];
    }
}
