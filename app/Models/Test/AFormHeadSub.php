<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use App\Models\FrontBase;

class AFormHeadSub extends FrontBase
{
    protected $guarded = [];
    protected $table = 'a_form_head_sub';
    protected $primaryKey = 'id';

    public function AFormHead()
    {
        return $this->belongsTo(AFormHead::class, 'head_id');
    }

    public function AFormMiddleDouble()
    {
        return $this->hasMany(AFormMiddleDouble::class, 'head_sub_id');
    }

}
