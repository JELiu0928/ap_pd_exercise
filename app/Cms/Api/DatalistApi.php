<?php

namespace App\Cms\Api;

use App\Http\Controllers\OptionFunction;
use App\Models\PHP\Datalist_content;
use App\Models\PHP\Datalist_content_img;
use App\Models\PHP\Datalist_son;
use App\Models\PHP\Datalist_three;
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

class DatalistApi extends CmsApi implements GetTable, GetExport
{
    use BasicSql, BasicRole;
    protected $FilterField = '{FilterField}';

    protected $modelArray = [
        'Datalist' => Datalist::class,
        'Datalist_content' => Datalist_content::class,
'Datalist_content_img' => Datalist_content_img::class,
'Datalist_son' => Datalist_son::class,
'Datalist_three' => Datalist_three::class,

    ];
    protected $copyArray = [
        'Datalist_content' => ['Datalist_content_img'=>'second_id'],
'Datalist_son' => ['Datalist_three'=>'second_id'],
'Datalist' => ['Datalist_content'=>'parent_id','Datalist_son'=>'parent_id'],
    ];
    protected $deleteArray = [
        'Datalist_content' => ['Datalist_content_img'=>'second_id'],
'Datalist_son' => ['Datalist_three'=>'second_id'],
'Datalist' => ['Datalist_content'=>'parent_id','Datalist_son'=>'parent_id'],
    ];
    /** format when update, create, copy */
    protected function formatBuilder(string $modelClass, Builder $builder): Builder
    {
        
        if ($modelClass === Datalist::class) {
            $builder->imageCol(['o_img','o_img_m']);
        }
        if ($modelClass === 'editContent') {
            $builder->with(['Datalist_content' => function ($q) {$q->with(['Datalist_content_img' => function ($q2) {$q2->orderBy('w_rank');},])->orderBy('w_rank');}])
->with(['Datalist_son' => function ($q) {$q->with(['Datalist_three' => function ($q2) {$q2->orderBy('w_rank');},])->orderBy('w_rank');}]);
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
        $sql = $this->formatBuilder(Datalist::class, $this->basicSql(Datalist::class, $this->req->search));
        $totalCount = (clone $sql)->count();
        $perCount = 100; //每頁筆數
        $site_page = (!empty($this->req->page)) ? $this->req->page : 1;
        $skip = ($site_page - 1) * $perCount;
        $totalPage = ceil($totalCount / $perCount);
        $data = (clone $sql)->skip($skip)->take($perCount)->get();
        $pagination = ($totalCount > $perCount) ? false : true;
        $getList = [
            1=>['key'=>'1','title'=>'分類1'],
            2=>['key'=>'2','title'=>'分類2'],
            3=>['key'=>'3','title'=>'分類3'],
            4=>['key'=>'4','title'=>'分類4'],
            5=>['key'=>'5','title'=>'分類5'],
            6=>['key'=>'6','title'=>'分類6'],
            7=>['key'=>'7','title'=>'分類7'],
            8=>['key'=>'8','title'=>'分類8'],
            9=>['key'=>'9','title'=>'分類9'],
            10=>['key'=>'10','title'=>'分類10'],
            11=>['key'=>'11','title'=>'分類11'],
            12=>['key'=>'12','title'=>'分類12'],
            13=>['key'=>'13','title'=>'分類13'],
            14=>['key'=>'14','title'=>'分類14'],
        ];
        $getListMuti = [
            1=>['key'=>'1','title'=>'多筆分類1'],
            2=>['key'=>'2','title'=>'多筆分類2'],
            3=>['key'=>'3','title'=>'多筆分類3'],
            4=>['key'=>'4','title'=>'多筆分類4'],
        ];
        $colSetting = ColumnSet::make()
        ->imageCol('o_img', 'imageGroup')
->textCol('textInput', 'textInput', 250)
->textCol('textArea', 'textArea', 250)
->radioButtonCol('radio_btn', 'radio_btn')
->selectCol('radio_area', 'radio_area', OptionFunction::Datalist_radio_area())
->selectCol('select2', 'select2',$getList)
->selectMultiCol('select2Multi', 'select2Multi', $getListMuti)
->colorCol('colorPicker', 'colorPicker')
->dateCol('datePicker', 'datePicker')
->rankInputCol('w_rank', '排序')->radioButtonCol(['is_preview' => '預覽','is_visible' => '顯示狀態',])
->timestampCol('updated_at', '最後更新日期')
->setConfig(['draggable' => true,'selectable' => true,'multiSortable' => true,'pagination' => $pagination])
->setDefault('sortable', true);

        $role = $this->getRoles();

        return TableResponse::create($colSetting, 'Datalist', $data, $this->cmsMenu, $role, '資料集', (int) $totalPage, (int) $site_page, (int) $perCount, (int) $totalCount);
    }
    public function getExport(): ExportResponse
    {
        $sql = $this->basicSql(Datalist::class);
        $data = (clone $sql)->get();
        $colSetting = ColumnSet::make()->textCol(['textInput' => 'textInput','lang_textInput' => 'lang_textInput','textInputTarget' => 'textInputTarget','textInputTargetAcc' => 'textInputTargetAcc','textArea' => 'textArea','lang_textArea' => 'lang_textArea','radio_btn' => 'radio_btn',]);
        return ExportResponse::create($colSetting, $data);
    }

    protected function check(): bool
    {
        return $this->cmsMenu->use_id == 1;
    }
}
