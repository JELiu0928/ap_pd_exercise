<?php

namespace App\Models\Basic\Cms;

use Config;

use Illuminate\Database\Eloquent\Model;

class CmsChild extends Model
{
    public function __construct()
    {
        $this->setTable("basic_cms_child");
    }

    public function CmsMenu()
    {
        return $this->belongsTo('App\Models\Basic\Cms\CmsMenu','menu_id');
    }

    public function CmsChildSon()
    {
        return $this->hasMany('App\Models\Basic\Cms\CmsChildSon','child_id','id')->where('is_active',1);
    }

}
