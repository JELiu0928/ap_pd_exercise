<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use App\Models\FrontBase;

class AFormData extends FrontBase
{
    protected $guarded = [];
    protected $table = 'a_form_data';
    protected $primaryKey = 'id';

    public function AForm()
    {
        return $this->belongsTo(AForm::class, 'form_id');
    }
    public function AData()
    {
        return $this->belongsTo(AData::class, 'data_id');
    }
}
