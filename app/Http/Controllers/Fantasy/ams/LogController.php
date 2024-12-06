<?php

namespace App\Http\Controllers\Fantasy\ams;

use App\Http\Controllers\Fantasy\AmsController as AmsPaPa;
use App\Models\Basic\LogData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**相關Models**/

use View;

class LogController extends AmsPaPa
{
    public static $fileInformationArray = [];

    public function __construct()
    {
        parent::__construct();
        // self::$fileInformationArray = BaseFunction::getAllFilesArray();
        // View::share('fileInformationArray', self::$fileInformationArray);
    }

    public function index()
    {
        $selectDate = $_GET['date'] ?? date('Ym');
        $nowYm = date('Ym');
        $tables = DB::select("SHOW TABLES LIKE 'basic_log_data%';");
        $tableNameArr = [];
        foreach($tables as $key => $row){
            $tableNameArr[] = reset($row);
        }
        $M_list = [];
        $M_list[] = $nowYm;
        foreach($tableNameArr as $key => $row){
            if($row!='basic_log_data'){
                $M_list[] = explode('basic_log_data'.'_',$row)[1];
            }
            else continue;
        }
        rsort($M_list,);

        $selectTableName = 'basic_log_data';
        if($selectDate != $nowYm) $selectTableName .= '_'.$selectDate;

        $selectDateYm = date('Y-m',strtotime($selectDate.'01')); // 202404 -> 20240401 避免strtotime判斷錯誤
        $data = DB::table($selectTableName)->orderby('id', 'desc')->where('create_time','like',$selectDateYm.'%')->get();
        $data = json_decode(json_encode($data,true),true); //stdClass to array
        
        $tableArray = DB::select('SHOW TABLE STATUS');
        $tables = array_reduce($tableArray ?? [], function ($res, $table) {
            $res[$table->Name] = $table;
            return $res;
        }, []);
        
        return View::make(
            'Fantasy.ams.log.index',
            [
                'tables' => $tables,
                'data' => $data,
                'ShowTime' => $selectDate,
                'M_list' => $M_list,
            ]
        );
    }

    public function update(Request $request)
    {
        $data = $request->input('LogData');
        if ($data['id'] == 0) {
            $info = new LogData;

            foreach ($data as $key => $value) {
                if ($key != 'id') {
                    $info->$key = $value;
                }
            }
            $info->is_visible = 1;
            $info->branch_id = 1;
            $info->save();
            $reback =
                [
                'id' => $info->id,
                'result' => true,
                'status' => 'create',
            ];
        } else {
            $info = LogData::where('id', $data['id'])->first();
            if (!empty($info)) {
                foreach ($data as $key => $value) {
                    if ($key != 'id') {
                        $info->$key = $value;
                    }
                }
                $info->save();
                $reback =
                    [
                    'id' => $data['id'],
                    'result' => true,
                    'status' => 'update',
                ];
            } else {
                $reback =
                    [
                    'result' => false,
                ];
            }
        }
        return $reback;
    }

    public function delete(Request $request)
    {
        $kill_id = $request->input('id');
        $info = LogData::where('id', $kill_id)->first();
        if (!empty($info)) {
            $info->delete();
        }
    }

    public function reset()
    {
        $data = LogData::get()->toArray();
        return View::make(
            'Fantasy.ams.log.ajax.table',
            [
                'data' => $data,
            ]
        );
    }
}
