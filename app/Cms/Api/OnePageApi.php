<?php

namespace App\Cms\Api;

use App\Http\Controllers\OptionFunction;
use App\Models\PHP\One_page;
use App\Services\Cms\agGrid\ColumnSet;
use App\Services\Cms\api\method\GetExport;
use App\Services\Cms\api\method\GetTable;
use App\Services\Cms\api\response\ExportResponse;
use App\Services\Cms\api\response\TableResponse;
use App\Services\Cms\api\traits\BasicRole;
use App\Services\Cms\api\traits\BasicSql;
use App\Services\Cms\classes\CmsApi;
use Illuminate\Database\Eloquent\Builder;

class OnePageApi extends CmsApi implements GetTable
{
    use BasicSql, BasicRole;

    protected $modelArray = [
        'One_page' => One_page::class,
    ];
    protected $copyArray = [

    ];
    protected $deleteArray = [

    ];
    /** format when update, create, copy */
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {
        if ($modelClass === 'editContent') {

        }
        return $builder;
    }
    protected function getRoles(): array
    {
        $roles = parent::getRoles();
        // $roles['maxLines'] = 2;
        // $roles['delete'] = false;
        return $roles;
    }
    public function getTable(): TableResponse
    {
        $data = $this->formatBuilder(One_page::class, $this->basicSql(One_page::class))->get();

        $colSetting = ColumnSet::make()
            ->textCol('title', '產品名稱', 250)
            ->setConfig(['draggable' => true,'selectable' => true,'multiSortable' => true])
            ->setDefault('sortable', true);

        $role = $this->basicRole(true);

        return TableResponse::create($colSetting, 'One_page', $data, $this->cmsMenu, $role);
    }
    // public function getExport(): ExportResponse
    // {
    //     $sql = $this->basicSql(Datalist::class);
    //     $data = (clone $sql)->get();
    //     $colSetting = ColumnSet::make()->textCol(['textInput' => 'textInput','lang_textInput' => 'lang_textInput','textInputTarget' => 'textInputTarget','textInputTargetAcc' => 'textInputTargetAcc','textArea' => 'textArea','lang_textArea' => 'lang_textArea','radio_btn' => 'radio_btn',]);
    //     return ExportResponse::create($colSetting, $data);
    // }

    protected function check(): bool
    {   
        return $this->cmsMenu->use_id == 9;
    }
}
