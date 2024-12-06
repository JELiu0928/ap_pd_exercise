<?php

return [
  //禁止匯出的欄位備註
  'columns_note' => [
    '物流狀態', '付款狀態', '金流回傳', '宅配公司', '活動ID', '後台隱藏不顯示', '申請刪除', '上層', '預設soe網址', '密碼', '編號', '排序', '審核', '預覽', '顯示', '分館', '建立者',
    'seo-自訂網址',
    'seo-網頁標題',
    'seo-Meta關鍵字',
    'seo-Meta描述',
    'seo-網頁GA碼',
    'seo-網頁GTM碼',
    'seo-分享縮圖管理',
    'seo-分享顯示文字',
    'seo-結構化標籤程式碼',
    'seo-分享標題',
    'FB像素'
  ],

  //禁止匯出的欄位
  'columns' => [
    'pay_state', 'send_state', 'pay_callback', 'delivery_company_id', 'event_id', 'fantasy_hide', 'wait_del', 'parent_id', 'temp_url', 'second_id', 'w_pass', 'id', 'w_rank', 'is_reviewed', 'is_preview', 'is_visible', 'branch_id', 'create_id',
    'url_name',
    'seo_title',
    'seo_keyword',
    'seo_meta',
    'seo_ga',
    'seo_gtm',
    'seo_img',
    'seo_description',
    'seo_json',
    'seo_og_title',
    'seo_pixel',
  ],
];