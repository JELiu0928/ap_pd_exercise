{{TableMaker::listNewTable([
  'pageTitle' => '選項設定',  //標題
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
        'title' => 'PHP用key',
        'columns' => 'key',//資料庫欄位名稱
    ],
    [
        'type' => 'text',
        'width' => '',
        'text-center' => false,
        'title' => '名稱',
        'columns' => 'title',//資料庫欄位名稱
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