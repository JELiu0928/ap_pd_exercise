{{TableMaker::listNewTable([
  'pageTitle' => '選單設定',  //標題
  // 'hasAuth' => $hasAuth,
  'QuickSearch' => 'title', //快速搜尋的欄位
  'modelName' => $modelName,
  'isEdit' => $isEdit,
  'isDelete' => $isDelete,
  'isCreate' => $isCreate,
  'page' => $page,
  'search' => $search,
  'data' => $data,
  'pn' => $pn,
  'tableSet' => [
    [
        'type' => 'text',
        'width' => '',
        'text-center' => false,
        'title' => '名稱',
        'columns' => 'title',//資料庫欄位名稱
    ],
    [
        'type' => 'text',
        'width' => '',
        'text-center' => false,
        'title' => 'Model',
        'columns' => 'model',//資料庫欄位名稱
    ],
    [
        'type' => 'select',
        'width' => '',
        'text-center' => false,
        'title' => '類型',
        'columns' => 'type',//資料庫欄位名稱
        'options' => $options['typeOptions']
    ],
    [
        'type' => 'select',
        'width' => '',
        'text-center' => false,
        'title' => '用途',
        'columns' => 'use_type',//資料庫欄位名稱
        'options' => $options['useOptions']
    ],
    [
        'type' => 'select',
        'width' => '',
        'text-center' => false,
        'title' => 'KEY',
        'columns' => 'key_id',//資料庫欄位名稱
        'options' => $options['keyOptions']
    ],
    [
        'type' => 'select',
        'width' => '',
        'text-center' => false,
        'title' => '父層級',
        'columns' => 'parent_id',//資料庫欄位名稱
        'options' => $options['menuOptions']
    ],
    [
        'type' => 'text',
        'width' => '',
        'text-center' => false,
        'title' => 'View Route',
        'columns' => 'view_prefix',//資料庫欄位名稱
    ],

    [
        "type" => "text",
        "width" => "",
        'text-center' => true,
        "title" => "排序",
        "columns" => "w_rank"
    ],
    [
        "type" => "visible",
        "width" => "w120",
        'text-center' => true,
        "title" => "發佈狀態",
        "columns" => "is_visible"
    ],
    [
        "type" => "text",
        "width" => "w180",
        'text-center' => false,
        "title" => "最後異動日期",
        "columns" => "updated_at",
    ],
  ],
])}}