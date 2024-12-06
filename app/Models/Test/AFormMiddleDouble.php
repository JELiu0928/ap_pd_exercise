<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;

class AFormMiddleDouble extends Model
{
    protected $guarded = [];
    protected $table = 'a_form_middle_double';
    protected $primaryKey = 'id';

    public function AData()
    {
        return $this->belongsTo(AData::class, 'data_id');
    }
    public function AFormHeadSub()
    {
        return $this->belongsTo(AFormHeadSub::class, 'head_sub_id');
    }
}
