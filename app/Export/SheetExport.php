<?php

namespace App\Export;


use BaseFunction;
use App\Export\SearchFunction;
use Illuminate\Contracts\View\View;
//方法一
use App\Services\Search\SearchManager;
use Illuminate\Support\Facades\Config;


use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
//方法二
use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;  //調整寬度

//方法二
class SheetExport implements FromView, ShouldAutoSize
{
    use Exportable;
    public function __construct($branch, $model, $menu_id, $search = '', $check = "")
    {
        $this->branch = $branch;
        $this->model = $model;
        $this->menu_id = $menu_id;
        $this->search = json_decode($search, true);
        $this->check = json_decode($check, true);
    }

    public function view(): View
    {
        $CmsMenu = Config::get('models.CmsMenu')::where('id', $this->menu_id)->first();
        $has_auth = $CmsMenu ? $CmsMenu->has_auth : 0;
        $branch = Config::get('models.BranchOrigin')::where('url_title', $this->branch)->first();

        $branch_id = $branch ? $branch->id : 0;

        $data = Config::get('models.' . $this->model)::where('branch_id', $branch_id);

        // 新增權限篩選
        if (intval($has_auth) != 0) {
            $data->CheckAuth($has_auth, $branch_id);
        }

        /*===搜尋條件Start====*/
        if (!empty($this->search)) {
            $searchManager = new SearchManager($this->search, $data, $this->model);
            $data = $searchManager->search();
        }

        /*===選取方式篩選====*/
        if (!empty($this->check)){
            $data->whereIn('id',$this->check);
        }

        /*===排序====*/
		if (Config::get('cms.CMSSort', false) === true) $data->doCMSSort();

        return view('exports.excel', [
            'data' => $data->get()
        ]);
    }
    // public function bindValue(Cell $cell, $value)
    // {
    //     $cell->setValueExplicit($value, DataType::TYPE_STRING);
    //     return true;
    // }

}
