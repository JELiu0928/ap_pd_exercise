<?php

namespace App\Models\Basic\Cms;

use Config;

use Illuminate\Database\Eloquent\Model;

class CmsParentSon extends Model
{
    public function __construct()
    {
        $this->setTable("basic_cms_parent_son");
    }

    public function CmsParent()
    {
        return $this->belongsTo('App\Models\Basic\Cms\CmsParent','parent_id');
    }

}
