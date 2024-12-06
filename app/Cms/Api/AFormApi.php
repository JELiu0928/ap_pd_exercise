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

use App\Models\Test\AForm;

class AFormApi extends CmsApi implements GetTable
{
    use BasicSql, BasicRole;

    protected $modelArray = [
        'AForm' => AForm::class,
        'AFormHead' => \App\Models\Test\AFormHead::class,
        'AFormHeadSub' => \App\Models\Test\AFormHeadSub::class,
        'AFormData' => \App\Models\Test\AFormData::class,
        'AFormMiddleSingle' => \App\Models\Test\AFormMiddleSingle::class,
        'AFormMiddleDouble' => \App\Models\Test\AFormMiddleDouble::class,
    ];
    protected $copyArray = [
        'AForm' => ['AFormData'=>'form_id','AFormHead'=>'form_id'],
        'AFormHead' => ['AFormHeadSub'=>'head_id'],
    ];
    protected $deleteArray = [
        'AForm' => ['AFormData'=>'form_id','AFormHead'=>'form_id'],
        'AFormHead' => ['AFormHeadSub'=>'head_id'],
    ];
    /** format when update, create, copy */
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {
        if ($modelClass === AForm::class) {
            $builder->with('AFormHead.AFormHeadSub');
        }
        if ($modelClass === 'editContent') {
            $builder->with('AFormHead.AFormHeadSub');
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
        $data = $this->formatBuilder(AForm::class, $this->basicSql(AForm::class))->get();

        $colSetting = ColumnSet::make()
            ->textCol('title', '表格名稱', 250)
            ->setConfig(['draggable' => true,'selectable' => true,'multiSortable' => true])
            ->setDefault('sortable', true);

        $role = $this->basicRole(true);

        return TableResponse::create($colSetting, 'AForm', $data, $this->cmsMenu, $role);
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
        return $this->cmsMenu->use_id == 2;
    }
}
