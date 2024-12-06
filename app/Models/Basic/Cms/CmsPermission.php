<?php

namespace App\Models\Basic\Cms;

use Config;

use Illuminate\Database\Eloquent\Model;

class CmsPermission extends Model
{
    public function __construct()
    {
        $this->setTable("basic_cms_permission");
    }

    public function CmsRole()
    {
        return $this->belongsTo('App\Models\Basic\Cms\CmsRole','cms_role_id');
    }

    public function CmsMenu()
    {
        return $this->belongsTo('App\Models\Basic\Cms\CmsMenu','cms_menu_id');
    }

}
