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

use App\Models\PHP\{$Model};

class {$Model}Api extends CmsApi implements GetTable{$hasExport}
{
    use BasicSql, BasicRole;

    protected $modelArray = [
        {$modelArray}
        {$modelArraySon}
    ];
    protected $copyArray = [
        {$copyArray}
    ];
    protected $deleteArray = [
        {$deleteArray}
    ];
    /** format when update, create, copy */
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {
        if ($modelClass === {$Model}::class) {
            {$imageCol}
        }
        if ($modelClass === 'editContent') {
            {$editContent}
        }
        return $builder;
    }
    protected function getRoles(): array
    {
        $roles = parent::getRoles();
        $roles['maxLines'] = 2;
        return $roles;
    }
    public function getTable(): TableResponse
    {
        $sql = $this->formatBuilder({$Model}::class, $this->basicSql({$Model}::class, $this->req->search));
        $totalCount = (clone $sql)->count();
        $perCount = 100; //每頁筆數
        $site_page = (!empty($this->req->page)) ? $this->req->page : 1;
        $skip = ($site_page - 1) * $perCount;
        $totalPage = ceil($totalCount / $perCount);
        $data = (clone $sql)->skip($skip)->take($perCount)->get();
        $pagination = ($totalCount > $perCount) ? false : true;

        $colSetting = ColumnSet::make()
        {$getDataList}

        $role = $this->basicRole(true);

        return TableResponse::create($colSetting, '{$Model}', $data, $this->cmsMenu, $role, '{$Title}', (int) $totalPage, (int) $site_page, (int) $perCount, (int) $totalCount);
    }
    {$getExport}

    protected function check(): bool
    {
        return $this->cmsMenu->use_id === 0;
    }
}
