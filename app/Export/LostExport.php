<?php
namespace App\Export;

use Config;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;  //調整寬度
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
//方法一
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
//方法二
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use BaseFunction;
use App\Export\SearchFunction;

//方法二
class LostExport extends SearchFunction implements WithMultipleSheets
{
    use Exportable;
    public function __construct($branch, array $CoverData)
    {
        $this->branch = BaseFunction::getBranchByTitle($branch);
        $this->CoverData = $CoverData;
        $this->BackArray = [];
    }
    public function sheets(): array
    {
        $sheets = [];
        //主表
        $CoverData = $this->CoverData;
        $sheets[] = new SheetExport($CoverData);
        //次表
        self::GetCoverData($CoverData);
        foreach($this->BackArray as $val){
            $sheets[] = new SheetExport($val);
        }

        return $sheets;
    }

    public function GetCoverData($Data){
        if(isset($Data['son']) && !empty($Data['son'])){
            foreach($Data['son'] as $key=>$val){
                if(isset($val['son'])){
                    unset($val['son']);
                }
                $this->BackArray[] = $val;
                self::GetCoverData($Data['son'][$key]);
            }
        }
    }
//    public function view(): View
//     {
//         //這邊內容自己寫
//         // $data = Config::get('models.Lost')::select('number','date','title','type','location','content','note','created_at','updated_at');
//         // if(!empty($this->get_data['search'])){
//         //     $search = json_decode($this->get_data['search'], true);
//         //     $query = SearchFunction::search($search);
//         //     $data = $data->where('branch_id', $this->branch['id'])->where($query)->get()->toArray();
//         // }else{
//         //     $data = $data->where('branch_id', $this->branch['id'])->get();
//         // }
//         return view('test', [
//             //'data' => $this->get_data
//         ]);
//     }
}

/*//方法一
class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Config::get('models.Lost')::select('number','date','title','type','location','content','note','created_at','updated_at')->get();
    }
    public function headings(): array
    {
        return [
            '登錄單號',
            '拾獲日期',
            '品項 / 數量',
            '狀態',
            '拾獲樓層',
            '拾獲地點',
            '備註',
            '資料建立日期',
            '最後修改日期'
        ];
    }
}*/

