<?php

namespace App\Models\Basic\Fms;

use Config;

use Illuminate\Database\Eloquent\Model;

class FmsFirst extends Model
{
    public function __construct()
    {
        $this->setTable("basic_fms_first");
    }

    public function FmsSecond()
    {
        return $this->hasMany('App\Models\Basic\Fms\FmsSecond','first_id','id');
    }

    public function FmsFile()
    {
        return $this->hasMany('App\Models\Basic\Fms\FmsFile','first_id','id');
    }
    public function FmsZero()
    {
        return $this->belongsTo('App\Models\Basic\Fms\FmsZero', 'zero_id');
    }

    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('id', 'desc');
    }
}
