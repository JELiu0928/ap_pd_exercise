<?php

return [
    //是否使用 aws s3
    's3_use' => false,
    //s3檔案域名
    's3_route' => env('AWS_URL'),
    //公開資料夾名稱
    's3_prefix' => 'public',

    // 預設縮圖尺寸
    'thumbnail'=>[
        'width'=>300,
        'height'=>300,
    ],

    // 檔案類型
    'mime_type'=>[

        'jpg'=>'image',
        'png'=>'image',
        'jpeg'=>'image',
        'gif'=>'image',
        'svg'=>'image',
        'image/jpeg'=>'image',
        'image/gif'=>'image',
        'image/png'=>'image',
        'image/bmp'=>'image',
        'image/svg+xml'=>'image',

        'mp4'=>'video',
        'avi'=>'video',
        'mpeg'=>'video',
        'mpg'=>'video',
        'wmv'=>'video',

        'ppt'=>'ppt',
        'pptx'=>'ppt',

        'xls'=>'excel',
        'xlsx'=>'excel',

        'doc'=>'word',
        'docx'=>'word',

        'pdf'=>'pdf',
        'zip' => 'zip',
    ],

    // 依檔案類型要顯示的資訊
    'mime_type_info'=>[
        'image'=>[
            'title'=>'影像',
            'cls'=>'fa-file-image-o',
            'img'=>'',
        ],
        'video'=>[
            'title'=>'影片',
            'cls'=>'fa-file-video-o',
            'img' => '/vender/assets/img/icon/video.jpg',
        ],
        'ppt'=>[
            'title'=>'PowerPoint',
            'cls'=>'fa-file-powerpoint-o',
            'img' => '/vender/assets/img/icon/ppt.jpg',
        ],
        'excel'=>[
            'title'=>'Excel',
            'cls'=>'fa-file-excel-o',
            'img' => '/vender/assets/img/icon/xls.jpg',
        ],
        'word'=>[
            'title'=>'Word',
            'cls'=>'fa-file-word-o',
            'img' => '/vender/assets/img/icon/doc.jpg',
        ],
        'pdf'=>[
            'title'=>'PDF',
            'cls'=>'fa-file-pdf-o',
            'img' => '/vender/assets/img/icon/pdf.jpg',
        ],
        'zip' => [
            'title' => 'ZIP',
            'cls' => 'fa-file-zip-o',
            'img' => '/vender/assets/img/icon/zip.jpg',
        ],
        'default'=>[
            'title'=>'檔案',
            'cls'=>'fa-file-o',
            'img'=> '/vender/assets/img/file.png',
        ],
    ],
];
