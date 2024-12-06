<?php

return [
    // 是否有分館
    'setBranchs' => true,
    //是否可新增分館  可新增分館true   不可新增false
    'branch_create' => true,
    // 分站網址位於網域
    'branchUrlInDomain' => false,
    //分館模板
    'blade_template' => [
        ['key' => 1, 'title' => '總館', 'add' => 0, 'blade_folder' => 'Front', 'route' => 'routes_main'],
        ['key' => 2, 'title' => '分館', 'add' => 1, 'blade_folder' => 'Front_sub', 'route' => 'routes_sub'],
    ],


    'langArray' => [
        "tw" => [
            "title" => "繁體中文",
            "en_title" => "Traditional Chinese",
            "abb_title" => "繁中",
            "key" => "tw"
        ],
        // "cn" => [
        //     "title" => "簡體中文",
        //     "en_title" => "Simplified Chinese",
        //     "abb_title" => "簡中",
        //     "key" => "cn"
        // ],
        "en" => [
            "title" => "英文",
            "en_title" => "English",
            "abb_title" => "英文",
            "key" => "en"
        ],
        // "jp" => [
        //     "title" => "日文",
        //     "en_title" => "Japanese",
        //     "abb_title" => "日文",
        //     "key" => "jp"
        // ],
        // "kr" => [
        //     "title" => "韓文",
        //     "en_title" => "Korean",
        //     "abb_title" => "韓文",
        //     "key" => "kr",
        // ],
    ],

    //是否開啟審核功能
    'reviewfunction' => false,

    // 新增資料是否同步到其他語系
    'copytoall' => false,

    // 預設一頁要顯示幾筆資料
    'pageSize' => 25,

    // CMS Model是否有排序功能
    'CMSSort' => true,

    //後台登入品牌名稱
    'ProjectName' => '©WADE DIGITAL DESIGN CO, LTD.',

    // 預覽站網址
    'PreviewUrl' => 'javascript:void(0);',

    //
    'file_table' => 'basic_fms_file'
];
