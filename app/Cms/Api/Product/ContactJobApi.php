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

use App\Models\Product\ConsultJob;
class ContactJobApi extends CmsApi implements GetTable
{
    use BasicSql, BasicRole;
    protected $FilterField = '{FilterField}';

    protected $modelArray = [
        'ConsultJob' => ConsultJob::class,

    ];
    protected $copyArray = [

    ];
    protected $deleteArray = [

    ];
    /** format when update, create, copy */
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {

        if ($modelClass === ConsultJob::class) {
        }
        if ($modelClass === 'editContent') {

        }
        return $builder;
    }
    protected function getRoles(): array
    {
        $roles = parent::getRoles();
        $roles['maxLines'] = 2;
        $roles['maxAddCount'] = "";
        // $roles['search'] = true;
        // $roles['canBatch'] = true;
        return $roles;
    }
    public function getTable(): TableResponse
    {
        $sql = $this->formatBuilder(ConsultJob::class, $this->basicSql(ConsultJob::class, $this->req->search));
        $totalCount = (clone $sql)->count();
        $perCount = 100; //每頁筆數
        $site_page = (!empty($this->req->page)) ? $this->req->page : 1;
        $skip = ($site_page - 1) * $perCount;
        $totalPage = ceil($totalCount / $perCount);
        $data = (clone $sql)->skip($skip)->take($perCount)->get();
        $pagination = ($totalCount > $perCount) ? false : true;

        $colSetting = ColumnSet::make()
            // ->imageCol('o_img', 'imageGroup')
            ->textCol('title', '職務名稱', 250)
            ->rankInputCol('w_rank', '排序')->radioButtonCol(['is_preview' => '預覽', 'is_visible' => '顯示狀態',]);
        // ->textCol('textArea', 'textArea', 250)
        // ->radioButtonCol('radio_btn', 'radio_btn')
        // ->selectCol('radio_area', 'radio_area', OptionFunction::ProductSet_radio_area())
        // ->selectCol('select2', 'select2', $getList)
        // ->selectMultiCol('select2Multi', 'select2Multi', $getListMuti)
        // ->colorCol('colorPicker', 'colorPicker')
        // ->dateCol('datePicker', 'datePicker')
        // ->timestampCol('updated_at', '最後更新日期')
        // ->setConfig(['draggable' => true, 'selectable' => true, 'multiSortable' => true, 'pagination' => $pagination])
        // ->setDefault('sortable', true);

        $role = $this->getRoles();
        // $role = $this->basicRole(true);

        return TableResponse::create($colSetting, 'ConsultJob', $data, $this->cmsMenu, $role, '職務管理', (int) $totalPage, (int) $site_page, (int) $perCount, (int) $totalCount);
    }
    // public function getExport(): ExportResponse
    // {
    //     $sql = $this->basicSql(ProductSet::class);
    //     $data = (clone $sql)->get();
    //     $colSetting = ColumnSet::make()->textCol(['textInput' => 'textInput', 'lang_textInput' => 'lang_textInput', 'textInputTarget' => 'textInputTarget', 'textInputTargetAcc' => 'textInputTargetAcc', 'textArea' => 'textArea', 'lang_textArea' => 'lang_textArea', 'radio_btn' => 'radio_btn',]);
    //     return ExportResponse::create($colSetting, $data);
    // }

    protected function check(): bool
    {
        // dd($this->cmsMenu->use_id);
        return $this->cmsMenu->use_id == 18;
    }
}
