<?php

namespace App\Services\Cms\api;

use App\Http\Resources\Export\ExportSample;
use App\Models\branch_backend_main\BackendMain;
use App\Models\branch_backend_main\BackendMainCategory;
use App\Models\branch_backend_main\BackendMainType;
use App\Services\Cms\agGrid\ColumnSet;
use App\Services\Cms\api\method\GetExport;
use App\Services\Cms\api\method\GetTable;
use App\Services\Cms\api\response\ExportResponse;
use App\Services\Cms\api\response\TableResponse;
use App\Services\Cms\api\traits\BasicRole;
use App\Services\Cms\api\traits\BasicSql;
use App\Services\Cms\classes\CmsApi;
use Illuminate\Database\Eloquent\Builder;

class SampleApi extends CmsApi implements GetTable, GetExport
{
    use BasicSql, BasicRole;

    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {
        return $builder;
    }
    public function getTable(): TableResponse
    {
        // $perPage = 6;
        // $page = $this->req->page ?? 1;

        $sql = $this->basicSql(BackendMain::class);
        $data = (clone $sql)
        // ->skip(($page - 1) * $perPage)
        // ->take($perPage)
            ->formatFiles(['img'])
            ->with('contents')
            ->get();

        $count = $sql->count();
        // $totalPage = ceil($count / $perPage);

        $colSetting = ColumnSet::make()
            ->textCol('title', '標題', 250)
            ->imageCol('img', '圖片')
            ->rankInputCol('w_rank', '排序')
            ->selectMultiCol('category_ids', '所屬類別', BackendMainCategory::getCategoryList())
            ->selectCol('type_id', '資料型態', BackendMainType::getTypeList())
            ->selectCol('select2', 'select2', BackendMainType::getTypeList())
            ->textCol([
                'textInput' => '單行輸入',
                'textArea' => '多行輸入',
                'colorPicker' => '顏色選擇器',
            ])
            ->radioButtonCol([
                'is_preview' => '預覽',
                'is_visible' => '顯示狀態',
            ])
            ->dateCol('datePicker', '日期選擇器')
            ->with('Contents', '文章內容', ColumnSet::make()
                    ->textCol([
                        'id' => '#',
                        'article_style' => '段落類型',
                    ]))
            ->timestampCol('updated_at', '最後更新日期')
            ->setConfig([
                'draggable' => true,
                'selectable' => true,
                'multiSortable' => true,
            ])
            ->setDefault('sortable', true);

        $role = $this->basicRole(true);

        return TableResponse::create($colSetting, 'BackendMain', $data, $this->cmsMenu, $role, 'SampleApi');
    }

    public function getExport(): ExportResponse
    {
        $sql = $this->basicSql(BackendMain::class);
        $data = (clone $sql)
            ->with('Contents')
            ->get();

        $colSetting = ColumnSet::make()
            ->textCol([
                'title' => '標題',
                'is_visible' => '顯示狀態',
                'is_preview' => '預覽狀態',
                'category_ids' => '所屬類別',
                'type_id' => '資料型態',
                'textInput' => '單行輸入',
                'textArea' => '多行輸入',
                'colorPicker' => '顏色選擇器',
                'datePicker' => '日期選擇器',
                'updated_at' => '最後更新日期',
            ])->with('Contents', '文章內容', ColumnSet::make()
                ->textCol([
                    'id' => '#',
                    'article_style' => '段落類型',
                ]));

        return ExportResponse::create($colSetting, ExportSample::collection($data));
    }

    protected function check(): bool
    {
        // return $this->cmsMenu->use_id === 3;
        return true;
    }
}
