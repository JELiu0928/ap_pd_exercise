<?php

namespace App\Cms\Api;

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

use App\Models\PHP\Dataoption;

class DataoptionApi extends CmsApi implements GetTable, GetExport
{
    use BasicSql, BasicRole;
    protected $FilterField = '{FilterField}';

    protected $modelArray = [
        'Dataoption' => \App\Models\PHP\Dataoption::class,
        
    ];
    protected $copyArray = [
        
    ];
    protected $deleteArray = [
        
    ];
    /** format when update, create, copy */
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {
        if ($modelClass === Dataoption::class) {
            
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
        
        return $roles;
    }
    public function getTable(): TableResponse
    {
        $sql = $this->formatBuilder(Dataoption::class, $this->basicSql(Dataoption::class, $this->req->search));
        $totalCount = (clone $sql)->count();
        $perCount = 100; //每頁筆數
        $site_page = (!empty($this->req->page)) ? $this->req->page : 1;
        $skip = ($site_page - 1) * $perCount;
        $totalPage = ceil($totalCount / $perCount);
        $data = (clone $sql)->skip($skip)->take($perCount)->get();
        $pagination = ($totalCount > $perCount) ? false : true;

        $colSetting = ColumnSet::make()
        ->textCol('title', '標題', 250)
->rankInputCol('w_rank', '排序')->radioButtonCol(['is_preview' => '預覽','is_visible' => '顯示狀態',])
->timestampCol('updated_at', '最後更新日期')
->setConfig(['draggable' => true,'selectable' => true,'multiSortable' => true,'pagination' => $pagination])
->setDefault('sortable', true);

        $role = $this->getRoles();

        return TableResponse::create($colSetting, 'Dataoption', $data, $this->cmsMenu, $role, '選項資料', (int) $totalPage, (int) $site_page, (int) $perCount, (int) $totalCount);
    }
    public function getExport(): ExportResponse
    {
        $sql = $this->basicSql(Dataoption::class);
        $data = (clone $sql)->get();
        $colSetting = ColumnSet::make()->textCol(['title' => '標題',]);
        return ExportResponse::create($colSetting, $data);
    }

    protected function check(): bool
    {
        return $this->cmsMenu->use_id === 2;
    }
}
