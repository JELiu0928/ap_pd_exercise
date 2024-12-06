<?php

namespace App\Models\Basic\Option;

use Config;

use Illuminate\Database\Eloquent\Model;

class OptionSet extends Model
{
    public function __construct()
    {
        $this->setTable("basic_option_set");
    }

    public function OptionItem()
    {
        return $this->hasMany('App\Models\Basic\Option\OptionItem','option_set_id','id')->where('is_active',1);
    }

    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('id', 'desc');
    }
}
