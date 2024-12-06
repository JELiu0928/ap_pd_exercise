<?php 
namespace App\Helpers;

class GlobalData
{
    private static $data = [];

    public static function setValue($key, $value)
    {
        static::$data[$key] = $value;
    }

    public static function getValue($key, $default = null)
    {
        return static::$data[$key] ?? $default;
    }
}