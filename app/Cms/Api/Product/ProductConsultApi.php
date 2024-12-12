<?php

namespace App\Cms\Api\Product;

use App\Http\Controllers\OptionFunction;
use App\Models\Product\ProductConsult;
use App\Models\Product\ProductConsultList;
use App\Models\Product\ProductItemPart;
use App\Services\Cms\agGrid\ColumnSet;
use App\Services\Cms\api\method\GetExport;
use App\Services\Cms\api\method\GetTable;
use App\Services\Cms\api\response\ExportResponse;
use App\Services\Cms\api\response\TableResponse;
use App\Services\Cms\api\traits\BasicRole;
use App\Services\Cms\api\traits\BasicSql;
use App\Services\Cms\classes\CmsApi;
use Illuminate\Database\Eloquent\Builder;

class ProductConsultApi extends CmsApi implements GetTable
{
    use BasicSql, BasicRole;
    protected $FilterField = '{FilterField}';

    protected $modelArray = [
        'ProductConsult' => ProductConsult::class,
        'ProductConsultList' => ProductConsultList::class,
        'ProductItemPart' => ProductItemPart::class,

    ];
    protected $copyArray = [

    ];
    protected $deleteArray = [
    ];
    /** format when update, create, copy */
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {

        if ($modelClass === 'editContent') {
            $builder->with('ProductConsultList');
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
        $sql = $this->formatBuilder(ProductConsult::class, $this->basicSql(ProductConsult::class, $this->req->search));
        $totalCount = (clone $sql)->count();
        $perCount = 100; //每頁筆數
        $site_page = (!empty($this->req->page)) ? $this->req->page : 1;
        $skip = ($site_page - 1) * $perCount;
        $totalPage = ceil($totalCount / $perCount);
        $data = (clone $sql)->skip($skip)->take($perCount)->get();
        $pagination = ($totalCount > $perCount) ? false : true;

        $colSetting = ColumnSet::make()
            ->textCol('companyName', '公司名稱', 250)
            ->textCol('name', '姓名', 250)
            ->radioButtonCol(['is_read' => '已處理'])
            ->timestampCol('updated_at', '最後更新日期')
            ->setConfig(['draggable' => true, 'selectable' => true, 'multiSortable' => true, 'pagination' => $pagination]);

        // 是否開批次
        $role = $this->basicRole(false);
        // return TableResponse::create($colSet, 'ProductConsult', $data, $this->cmsMenu, $role, '諮詢表單管理', (int) $totalPage, (int) $site_page, (int) $perCount, (int) $totalCount);
        return TableResponse::create($colSetting, 'ProductConsult', $data, $this->cmsMenu, $role, '總覽管理', (int) $totalPage, (int) $site_page, (int) $perCount, (int) $totalCount);
    }
    public function getExport(): ExportResponse
    {
        $sql = $this->basicSql(ProductConsult::class);
        $data = (clone $sql)->get();
        $colSetting = ColumnSet::make()->textCol(['textInput' => 'textInput', 'lang_textInput' => 'lang_textInput', 'textInputTarget' => 'textInputTarget', 'textInputTargetAcc' => 'textInputTargetAcc', 'textArea' => 'textArea', 'lang_textArea' => 'lang_textArea', 'radio_btn' => 'radio_btn',]);
        return ExportResponse::create($colSetting, $data);
    }

    protected function check(): bool
    {
        // dd($this->cmsMenu->use_id);
        return $this->cmsMenu->use_id == 17;
    }
}
