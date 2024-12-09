<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCategoryOverview;
use App\Models\Product\ProductItemSpecContent;
use App\Models\Product\ProductItemSpecTitle;
use App\Models\Product\ProductSeries;
use App\Models\Product\ProductSet;
use Illuminate\Http\Request;
use View;
use BaseFunction;
use App\Http\Controllers\OptionFunction;
use App\Models\Product\ProductItem;

class ProductAggridController extends FrontBaseController
{
    static $unit;
    public function __construct()
    {
        parent::__construct();
        BaseFunction::checkRouteLang();
    }
    public function itemSpecificationCmsView(Request $request)
    {
        $itemId = $request->itemId ?? 0;
        $productItem = ProductItem::with('ProductItemSpecTitle.ProductItemSpecContent', 'ProductItemPart')->where('id', $itemId)->first();
        // $reqData =  $request->all()['data'];

        $formSpecTitles = []; // 表頭數據
        $productParts = []; // 型號數據
        // $productParts[] = ['colId' => 'part_id', 'field' => "part_id", 'hide' => false];

        $formSpecTitles[] = [
            'headerName' => '型號', // 表頭名稱
            'field' => 'part', // 對應的欄位名稱
            'editable' => false, // 型號欄位不允許編輯
            'pinned' => 'left', // 固定在左側
            'width' => 150, // 設定欄寬
            'headerTooltip' => '型號', // 工具提示
        ];

        if ($productItem) {
            // 1. 取得表頭資料（ProductItemSpecTitle）
            if ($productItem->ProductItemSpecTitle) {
                foreach ($productItem->ProductItemSpecTitle as $specTitle) {
                    $formSpecTitles[] = [
                        'headerName' => $specTitle->title, // 使用規格標題作為表頭
                        'field' => (string) $specTitle->id, // 'field' 是用來對應資料模型中的欄位，它告訴表格元件每一個列（column）應該顯示哪個資料欄位的值。
                        'editable' => true, // 使得列可編輯
                        'pinned' => 'left', // 將表頭固定在左側
                        'width' => 200, // 設定列寬
                        'headerTooltip' => $specTitle->title, // 顯示規格的工具提示
                    ];

                }
            }
            // 2. 取得型號資料（ProductItemPart）
            if ($productItem->ProductItemPart) {
                foreach ($productItem->ProductItemPart as $part) {
                    // 型號（如 A-01, A-02）作為一行的首列
                    $rowData = [
                        'part_id' => $part->id,
                        'part' => $part->title
                    ];

                    // 為每個規格添加數據，如果有的話
                    foreach ($productItem->ProductItemSpecTitle as $specTitle) {
                        // 這裡簡單的透過 `spec_title_id` 來範例，你需要依照實際資料結構去填充
                        // $rowData[(string) $specTitle->id] = ''; // 目前的 `spec_content` 是空的，你需要進一步填充
                        //找spec_id與part_id的那欄
                        $specContent = $productItem->ProductItemSpecTitle->where('id', $specTitle->id)
                            ->first()
                            ->ProductItemSpecContent
                            ->where('part_id', $part->id)
                            ->first();
                        // dd($specContent);
                        // 將規格內容加入 rowData 中，若沒有內容則為空
                        $rowData[(string) $specTitle->id] = $specContent ? $specContent->content : '';
                    }
                    $productParts[] = $rowData; // 將行資料加入到清單中
                }
            }
        }

        // 將資料轉換為 JSON 格式，方便前端使用
        $formSpecTitlesJson = json_encode($formSpecTitles);
        $productPartsJson = json_encode($productParts);
        // $formSpecTitlesJson = json_encode($formSpecTitles);
        $view = view('aggrid._productSpecificationCmsView', [
            'formSpecTitlesJson' => $formSpecTitlesJson,
            'productPartsJson' => $productPartsJson,
            'itemId' => $itemId
            // 'use_self_caption' => $itemData['use_self_caption'],
        ])->render();

        return response()->json([
            'view' => $view,
        ]);

    }
    public function updateSpecificationInfo(Request $request)
    {
        $reqData = $request->all()['data']; //已轉陣列 不用json_decode
        // $json = $request->all()['data']; //已轉陣列 不用json_decode
        // $reqData = json_decode($json, true);
        $res = [];
        $res['status'] = false;
        // // 獲取產品id
        $itemId = $request->itemId;
        // dd($reqData);
        foreach ($reqData as $row) {
            $partId = $row['part_id'];
            foreach ($row as $specId => $content) {
                // dd('=>', $content);
                if (is_numeric($specId)) {

                    ProductItemSpecContent::updateOrInsert(
                        [
                            'part_id' => $partId,
                            'spec_id' => $specId,
                            // 'content' => $content[$specId],
                            'item_id' => $itemId
                        ],
                        [
                            'content' => $content    // 規格內容
                        ]
                    );
                }
            }
        }
        $productItem = ProductItem::with('ProductItemSpecTitle.ProductItemSpecContent', 'ProductItemPart')->where('id', $itemId)->first();
        // $rowData = [];
        $productParts = [];
        if ($productItem->ProductItemPart) {
            foreach ($productItem->ProductItemPart as $part) {
                // 型號（如 A-01, A-02）作為一行的首列
                $rowData = [
                    'part_id' => $part->id,
                    'part' => $part->title
                ];

                // 為每個規格添加數據，如果有的話
                foreach ($productItem->ProductItemSpecTitle as $specTitle) {
                    // 這裡簡單的透過 `spec_title_id` 來範例，你需要依照實際資料結構去填充
                    // $rowData[(string) $specTitle->id] = ''; // 目前的 `spec_content` 是空的，你需要進一步填充
                    //找spec_id與part_id的那欄
                    $specContent = $productItem->ProductItemSpecTitle->where('id', $specTitle->id)
                        ->first()
                        ->ProductItemSpecContent
                        ->where('part_id', $part->id)
                        ->first();
                    // dd($specContent);
                    // 將規格內容加入 rowData 中，若沒有內容則為空
                    $rowData[(string) $specTitle->id] = $specContent ? $specContent->content : '';
                }
                $productParts[] = $rowData; // 將行資料加入到清單中
            }
        }
        $productParts = json_encode($productParts, true);

        $res['status'] = true;
        $res['resData'] = $productParts;

        // 回傳資料給前端
        return $res;
    }



    // dd($productItem);
}

