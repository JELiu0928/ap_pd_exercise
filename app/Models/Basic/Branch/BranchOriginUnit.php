<?php

namespace App\Models\Basic\Branch;

use Config;

use Illuminate\Database\Eloquent\Model;

class BranchOriginUnit extends Model
{
    public function __construct()
    {
        $this->setTable("basic_branch_origin_unit");
    }

    public function BranchOrigin()
    {
        return $this->belongsTo('App\Models\Basic\Branch\BranchOrigin','origin_id');
    }
}
