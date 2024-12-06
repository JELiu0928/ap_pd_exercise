<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use App\Models\FrontBase;

class AFormHead extends FrontBase
{
    protected $guarded = [];
    protected $table = 'a_form_head';
    protected $primaryKey = 'id';

    public function AFormHeadSub()
    {
        return $this->hasMany(AFormHeadSub::class, 'head_id');
    }

    public function AFormMiddleSingle()
    {
        return $this->hasMany(AFormMiddleSingle::class, 'head_id');
    }

    public function AForm()
    {
        return $this->belongsTo(AForm::class, 'form_id');
    }

    public function headData()
    {
        return $this->belongsToMany(AFormData::class, "a_form_middle_single", 'head_id', 'form_data_id');
    }
}
