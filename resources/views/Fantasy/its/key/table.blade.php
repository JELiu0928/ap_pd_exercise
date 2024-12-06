{{TableMaker::listNewTable([
  'pageTitle' => '單元鍵值設定',  //標題
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
        "type" => "text",
        "width" => "",
        'text-center' => false,
        "title" => "名稱",
        "columns" => "title",
    ],
    [
        "type" => "text",
        "width" => "",
        'text-center' => false,
        "title" => "Key",
        "columns" => "key",
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