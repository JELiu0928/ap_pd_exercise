<?php

namespace App\Models\Traits;

trait dataList
{
    private static $list = '';
    
    public static function dataList(string $col = 'title')
    {
        if (static::$list === '') {
            static::$list = static::doSort()->get()->reduce(function ($res, $item)use($col) {
                $res[$item->id] = [
                    'key' => $item->id,
                    'title' => $item->{$col},
                ];
                return $res;
            }, []);
        }
        return static::$list;
    }
}
