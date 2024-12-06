<?php 
namespace App\Helpers;

use Illuminate\Support\Carbon;

class Date
{
    public static $months = [
        1 => ['tw' => '一月', 'en' => 'January'], 
        2 => ['tw' => '二月', 'en' => 'February'], 
        3 => ['tw' => '三月', 'en' => 'March'], 
        4 => ['tw' => '四月', 'en' => 'April'], 
        5 => ['tw' => '五月', 'en' => 'May'], 
        6 => ['tw' => '六月', 'en' => 'June'],
        7 => ['tw' => '七月', 'en' => 'July'], 
        8 => ['tw' => '八月', 'en' => 'August'], 
        9 => ['tw' => '九月', 'en' => 'September'], 
        10 => ['tw' => '十月', 'en' => 'October'], 
        11 => ['tw' => '十一月', 'en' => 'November'], 
        12 => ['tw' => '十二月', 'en' => 'December']
    ];

    public static function format($date = null, $outputPattern = 'Y.m.d', $inputPattern = 'Y-m-d')
    {
        $date = $date ? $date : date($inputPattern);

        return Carbon::createFromFormat($inputPattern, $date)
                ->format($outputPattern);
    }

    public static function monthOptions()
    {
        $list = [];

        $locale = app()->getLocale() ?: 'tw';

        foreach (static::$months as $key => $month) {
            $list[$key] = ['key' => $key, 'title' => ($locale == 'tw' ? $month['tw'] : $month['en'] )];
        }

        return $list;
    }
}