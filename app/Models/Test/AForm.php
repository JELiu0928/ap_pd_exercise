<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;
use App\Models\FrontBase;

class AForm extends FrontBase
{
    protected $guarded = [];
    protected $table = 'a_form';
    protected $primaryKey = 'id';
    static $headType = '';
    static $cellType = '';

    //表頭類型
    const HeadSingle = 0;
    const HeadDouble = 1;

    //儲存格類型
    const CellTextInput = 0;
    const CellTextArea = 1;
    const CellCheckBox = 2;

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $ids = array_reduce(json_decode($model->data_select, true) ?? [], function ($res, $item) {
                // 過濾 select2 選空
                $id = trim($item);
                if (!empty($id)) {
                    array_push($res, (int) $id);
                }

                return $res;
            }, []);
            $model->AData()->sync($ids);
        });

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

    public function AFormHead()
    {
        return $this->hasMany(AFormHead::class, 'form_id')->orderBy('w_rank','asc');
    }

    public function AFormData()
    {
        return $this->hasMany(AFormData::class, 'form_id');
    }

    public function AData()
    {
        return $this->belongsToMany(AData::class, "a_form_data", 'form_id', 'data_id');
    }

    public static function headType(){
        if(static::$headType === '') {
            static::$headType = [];
            static::$headType[self::HeadSingle] = ['key'=>self::HeadSingle, 'title'=>'單層表頭'];
            static::$headType[self::HeadDouble] = ['key'=>self::HeadDouble, 'title'=>'雙層表頭'];
        }
        return static::$headType;
    }

    public static function cellType(){
        if(static::$cellType === '') {
            static::$cellType = [];
            static::$cellType[self::CellTextInput] = ['key'=>self::CellTextInput,'title'=>'文字編輯-單行'];
            static::$cellType[self::CellTextArea] = ['key'=>self::CellTextArea,'title'=>'文字編輯-多行'];
            static::$cellType[self::CellCheckBox] = ['key'=>self::CellCheckBox,'title'=>'勾選匡'];
        }
        return static::$cellType;
    }

}
