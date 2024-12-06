{{TableMaker::listNewTable([
  'pageTitle' => 'FMS資料夾設定',  //標題
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
        'type' => 'select',
        'width' => '',
        'text-center' => false,
        'title' => '用途',
        'columns' => 'type',//資料庫欄位名稱
        'options' => $options['filesOptions']
    ],
    [
        'type' => 'select',
        'width' => 'w100',
        'text-center' => false,
        'title' => 'KEY',
        'columns' => 'key_id',//資料庫欄位名稱
        'options' => $options['keyOptions']
    ],
    [
        "type" => "text",
        "width" => "w100",
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