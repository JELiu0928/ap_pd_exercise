<?php

$models = [
    /*分舘用*/
    "BranchOrigin" => App\Models\Basic\Branch\BranchOrigin::class,
    "BranchOriginUnit" => App\Models\Basic\Branch\BranchOriginUnit::class,
    /*Cms*/
    "CmsMenu" => App\Models\Basic\Cms\CmsMenu::class,
    "CmsMenuUse" => App\Models\Basic\Cms\CmsMenuUse::class,
    "CmsPermission" => App\Models\Basic\Cms\CmsPermission::class,
    "CmsRole" => App\Models\Basic\Cms\CmsRole::class,
    "CmsChild" => App\Models\Basic\Cms\CmsChild::class,
    "CmsParent" => App\Models\Basic\Cms\CmsParent::class,
    "CmsChildSon" => App\Models\Basic\Cms\CmsChildSon::class,
    "CmsParentSon" => App\Models\Basic\Cms\CmsParentSon::class,
    "Autoredirect" => App\Models\Basic\Ams\Autoredirect::class,
    /*Crs*/
    "CrsPermission" => App\Models\Basic\Crs\CrsPermission::class,
    "CrsRole" => App\Models\Basic\Crs\CrsRole::class,
    /*Data*/
    "DataGeoArea" => App\Models\Basic\Data\DataGeoArea::class,
    "DataCity" => App\Models\Basic\Data\DataCity::class,
    "DataCityRegion" => App\Models\Basic\Data\DataCityRegion::class,
    "CountryCodes" => App\Models\Basic\Data\CountryCodes::class,
    "CountryData" => App\Models\Basic\Data\CountryData::class,
    /*Auth*/
    "FantasyUsers" => App\Models\Basic\FantasyUsers::class,
    /*Fms*/
    "FmsFirst" => App\Models\Basic\Fms\FmsFirst::class,
    "FmsSecond" => App\Models\Basic\Fms\FmsSecond::class,
    "FmsThird" => App\Models\Basic\Fms\FmsThird::class,
    "FmsFile" => App\Models\Basic\Fms\FmsFile::class,
    "FmsZero" => App\Models\Basic\Fms\FmsZero::class,
    "Fmsfolder" => App\Models\Basic\Fms\Fmsfolder::class,
    /*Option*/
    "OptionItem" => App\Models\Basic\Option\OptionItem::class,
    "OptionSet" => App\Models\Basic\Option\OptionSet::class,
    /*Basic*/
    "WebKey" => App\Models\Basic\WebKey::class,
    "Color" => App\Models\Basic\Color::class,
    "ReviewNotify" => App\Models\Basic\ReviewNotify::class,
    /*AMS*/
    "AmsRole" => App\Models\Basic\Ams\AmsRole::class,

    /*----------------我是分隔線-以上為後台基本資料表-----------------*/

    "One_page" =>         App\Models\One_page\One_page::class,
    "Datalist" =>         App\Models\Datalist\Datalist::class,
    "Datalist_son" =>         App\Models\Datalist_son\Datalist_son::class,
    "Datalist_three" =>         App\Models\Datalist_three\Datalist_three::class,
    "Datalist_content" =>         App\Models\Datalist_content\Datalist_content::class,
    "Datalist_content_img" =>         App\Models\Datalist_content_img\Datalist_content_img::class,
    //AddModelUp
];

$files = scandir(__DIR__ . '/model');
if ($files) {
    foreach ($files as $file) {
        $path = __DIR__ . '/model/' . $file;
        if (is_file($path)) {
            $array = include $path;
            $models = array_merge($models, $array);
        }
    }
}

return $models;
