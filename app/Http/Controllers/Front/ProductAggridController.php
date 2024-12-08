<?php

namespace App\Http\Controllers\Front;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCategoryOverview;
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
        // $unitSet = ProductSet::formatFiles(['banner_pc_img', 'banner_pad_img', 'banner_m_img'])->first();
        // dd($unitSet);
        // $productCategories = ProductCategory::formatFiles(['list_img'])->doSort()->first();
        // dd($productCategories);
        $view = view('aggrid._productSpecificationCmsView', [
            'productCategories' => $productCategories,
            // 'formCaption' => $formCaption,
            // 'use_self_caption' => $itemData['use_self_caption'],
        ])->render();

        return response()->json([
            'view' => $view,
        ]);
    
    }
    
}
