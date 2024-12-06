<?php

namespace App\Cms\Api\Product;

use App\Http\Controllers\OptionFunction;
use App\Services\Cms\agGrid\ColumnSet;
use App\Services\Cms\api\method\GetExport;
use App\Services\Cms\api\method\GetTable;
use App\Services\Cms\api\response\ExportResponse;
use App\Services\Cms\api\response\TableResponse;
use App\Services\Cms\api\traits\BasicRole;
use App\Services\Cms\api\traits\BasicSql;
use App\Services\Cms\classes\CmsApi;
use Illuminate\Database\Eloquent\Builder;

use App\Models\PHP\Datalist;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductCategoryOverview;
use App\Models\Product\ProductCategoryOverviewList;
use App\Models\Product\ProductCategoryAdvantagesTags;
use App\Models\Product\ProductCategoryAdvantagesLists;
// use App\Models\Product;
class ProductCategoryApi extends CmsApi implements GetTable, GetExport
{
    use BasicSql, BasicRole;
    protected $FilterField = '{FilterField}';

    protected $modelArray = [
        'ProductCategory' => ProductCategory::class,
        'ProductCategoryOverview' => ProductCategoryOverview::class, //ProductCateIntro
        'ProductCategoryOverviewList' => ProductCategoryOverviewList::class, //ProductCateSeries
        'ProductCategoryAdvantagesTags' => ProductCategoryAdvantagesTags::class,
        'ProductCategoryAdvantagesLists' => ProductCategoryAdvantagesLists::class,
    ];
    protected $copyArray = [
        // 'Datalist_content' => ['Datalist_content_img' => 'second_id'],
        // 'Datalist_son' => ['Datalist_three' => 'second_id'],
        // 'Datalist' => ['Datalist_content' => 'parent_id', 'Datalist_son' => 'parent_id'],
    ];
    protected $deleteArray = [
        // 'Datalist_content' => ['Datalist_content_img' => 'second_id'],
        // 'Datalist_son' => ['Datalist_three' => 'second_id'],
        // 'Datalist' => ['Datalist_content' => 'parent_id', 'Datalist_son' => 'parent_id'],
    ];
    /** format when update, create, copy */
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {

        if ($modelClass === ProductCategory::class) {
            // $builder->imageCol(['o_img', 'o_img_m']);
        }
        if ($modelClass === 'editContent') {
            $builder->with([
                'ProductCategoryOverview',
                'ProductCategoryOverviewList',
                'ProductCategoryAdvantagesTags.ProductCategoryAdvantagesLists'

            ]);
            //     ->with([
            //         'Datalist_son' => function ($q) {
            //             $q->with([
            //                 'Datalist_three' => function ($q2) {
            //                     $q2->orderBy('w_rank');
            //                 },
            //             ])->orderBy('w_rank');
            //         }
            //     ]);
        }
        return $builder;
    }
    protected function getRoles(): array
    {
        $roles = parent::getRoles();
        $roles['maxLines'] = 2;
        $roles['maxAddCount'] = "";
        $roles['search'] = true;
        $roles['canBatch'] = true;
        return $roles;
    }
    public function getTable(): TableResponse
    {
        $sql = $this->formatBuilder(ProductCategory::class, $this->basicSql(ProductCategory::class, $this->req->search));
        $totalCount = (clone $sql)->count();
        $perCount = 100; //每頁筆數
        $site_page = (!empty($this->req->page)) ? $this->req->page : 1;
        $skip = ($site_page - 1) * $perCount;
        $totalPage = ceil($totalCount / $perCount);
        $data = (clone $sql)->skip($skip)->take($perCount)->get();
        $pagination = ($totalCount > $perCount) ? false : true;
        $getList = [
            1 => ['key' => '1', 'title' => '分類1'],
            2 => ['key' => '2', 'title' => '分類2'],
            3 => ['key' => '3', 'title' => '分類3'],
            4 => ['key' => '4', 'title' => '分類4'],
            5 => ['key' => '5', 'title' => '分類5'],
            6 => ['key' => '6', 'title' => '分類6'],
            7 => ['key' => '7', 'title' => '分類7'],
            8 => ['key' => '8', 'title' => '分類8'],
            9 => ['key' => '9', 'title' => '分類9'],
            10 => ['key' => '10', 'title' => '分類10'],
            11 => ['key' => '11', 'title' => '分類11'],
            12 => ['key' => '12', 'title' => '分類12'],
            13 => ['key' => '13', 'title' => '分類13'],
            14 => ['key' => '14', 'title' => '分類14'],
        ];
        $getListMuti = [
            1 => ['key' => '1', 'title' => '多筆分類1'],
            2 => ['key' => '2', 'title' => '多筆分類2'],
            3 => ['key' => '3', 'title' => '多筆分類3'],
            4 => ['key' => '4', 'title' => '多筆分類4'],
        ];
        $colSetting = ColumnSet::make()
            // ->imageCol('list_img', '圖片')
            ->textCol('simple_title', '標題', 250)
            // ->longTextCol('intro', '簡述', 250)
            ->textCol('url_name', '網址名稱', 250)
            // ->selectCol('category_id', '所屬分類', $getListMuti)
            // ->dateCol('news_date', '消息日期')
            ->rankInputCol('w_rank', '排序')
            ->radioButtonCol(['is_preview' => '預覽', 'is_visible' => '顯示狀態',])
            ->timestampCol('updated_at', '最後更新日期')
            ->setConfig(['draggable' => true, 'selectable' => true, 'multiSortable' => true, 'pagination' => $pagination])
            ->setDefault('sortable', true);


        $role = $this->getRoles();

        return TableResponse::create($colSetting, 'ProductCategory', $data, $this->cmsMenu, $role, '類別管理', (int) $totalPage, (int) $site_page, (int) $perCount, (int) $totalCount);
    }
    public function getExport(): ExportResponse
    {
        $sql = $this->basicSql(ProductCategory::class);
        $data = (clone $sql)->get();
        $colSetting = ColumnSet::make()->textCol(['textInput' => 'textInput', 'lang_textInput' => 'lang_textInput', 'textInputTarget' => 'textInputTarget', 'textInputTargetAcc' => 'textInputTargetAcc', 'textArea' => 'textArea', 'lang_textArea' => 'lang_textArea', 'radio_btn' => 'radio_btn',]);
        return ExportResponse::create($colSetting, $data);
    }

    protected function check(): bool
    {
        // dd($this->cmsMenu->use_id);
        return $this->cmsMenu->use_id == 14;
    }
}
