<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use App\Models\FrontBase;

class AData extends FrontBase
{
    protected $guarded = [];
    protected $table = 'a_data';
    protected $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            if(!empty($model->form_id)){
                $ids = [];
                $ids[] = (int)$model->form_id;
                $model->AForm()->sync($ids);
            }
        });

    }

    public function AFormMiddleSingle()
    {
        return $this->hasMany(AFormMiddleSingle::class, 'data_id');
    }

    public function AFormMiddleDouble()
    {
        return $this->hasMany(AFormMiddleDouble::class, 'data_id');
    }

    public function AForm()
    {
        return $this->belongsToMany(AForm::class, "a_form_data", 'data_id', 'form_id');
    }

    public function dataHead()
    {
        return $this->belongsToMany(AFormHead::class, "a_form_middle_single", 'data_id', 'head_id');
    }
    public function dataHeadSub()
    {
        return $this->belongsToMany(AFormHeadSub::class, "a_form_middle_double", 'data_id', 'head_sub_id');
    }

    public static function getList()
    {
        return self::select('id','title')->get()->map(function ($item, $key) {
            return [
                'key' => $item['id'],
                'title' => $item['title']
            ];
        })->keyBy('key');
    }
}
