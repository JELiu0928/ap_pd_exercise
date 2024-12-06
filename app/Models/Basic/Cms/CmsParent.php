<?php

namespace App\Models\Basic\Cms;

use Config;

use Illuminate\Database\Eloquent\Model;

class CmsParent extends Model
{
    public function __construct()
    {
        $this->setTable("basic_cms_parent");
    }

    public function CmsMenu()
    {
        return $this->belongsTo('App\Models\Basic\Cms\CmsMenu','menu_id');
    }

    public function CmsParentSon()
    {
        return $this->hasMany('App\Models\Basic\Cms\CmsParentSon','parent_id','id');
    }

}
