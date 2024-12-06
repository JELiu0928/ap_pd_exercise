<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;

class AFormMiddleSingle extends Model
{
    protected $guarded = [];
    protected $table = 'a_form_middle_single';
    protected $primaryKey = 'id';

    public function AData()
    {
        return $this->belongsTo(AData::class, 'data_id');
    }
    public function AFormHead()
    {
        return $this->belongsTo(AFormHead::class, 'head_id');
    }
}
