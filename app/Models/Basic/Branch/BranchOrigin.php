<?php

namespace App\Models\Basic\Branch;

use Config;

use Illuminate\Database\Eloquent\Model;

class BranchOrigin extends Model
{
    public function __construct()
    {
        $this->setTable("basic_branch_origin");
    }

    public function BranchOriginUnit()
    {
        return $this->hasMany('App\Models\Basic\Branch\BranchOriginUnit', 'origin_id', 'id')->where('is_active', 1);
    }
    public static function getList()
    {
        return self::select('id as key', 'title')->get()->keyBy('key')->toArray();
    }
}
