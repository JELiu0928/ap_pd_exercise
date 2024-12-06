<?php
namespace App\Http\Controllers\Fantasy\ams;

use App\Http\Controllers\Fantasy\AmsController as AmsPaPa;
use App\Http\Controllers\Fantasy\MenuController as MenuFunction;
use Illuminate\Http\Request;

use View;
use Redirect;
use Auth;
use Debugbar;
use Route;
use App;
use Config;
use Session;

use UnitMaker;
use TableMaker;
use BaseFunction;

/**相關Models**/
use App\Models\Basic\Ams\AmsRole;
use App\Models\Basic\Fms\FmsZero;

class FmsManagerController extends AmsPaPa
{
	public static $fileInformationArray = [];

	public function __construct()
	{
		parent::__construct();
		// self::$fileInformationArray = BaseFunction::getAllFilesArray();
		// View::share('fileInformationArray', self::$fileInformationArray);

	}

	public function index(){
        $data = FmsZero::get()->toArray();
		return View::make('Fantasy.ams.fms_folder.index',
		[
			'data' => $data
		]);
    }

    public function update(Request $request)
	{
		$data = $request->input('FmsZero');
		if($data['id'] == 0)
		{
            $info = new FmsZero;

			foreach ($data as $key => $value)
			{
				if($key != 'id')
				{
					$info->$key = $value;
				}
			}
			$info->is_active = 1;
			$info->key_id = 1;
			$info->branch_id = 1;
			$info->type = 1;
			$info->save();
            $reback =
				[
					'id' => $info->id,
					'result' => true,
					'status' => 'create'
				];
        }else{
            $info = FmsZero::where('id',$data['id'])->first();
			if(!empty($info))
			{
				foreach ($data as $key => $value)
				{
					if($key != 'id')
					{
						$info->$key = $value;
					}
				}
				$info->save();
                $reback =
                    [
                        'id' => $data['id'],
                        'result' => true,
                        'status' => 'update'
                    ];
            }else{
                $reback =
				[
					'result' => false
				];
            }
        }
        return $reback;
    }

	public function delete(Request $request)
	{
		$kill_id = $request->input('id');
		$info = FmsZero::where('id',$kill_id)->first();
		if(!empty($info))
		{
			$info->delete();
		}
    }

	public function reset()
	{
        $data = FmsZero::get()->toArray();
		return View::make('Fantasy.ams.fms_folder.ajax.table',
		[
			'data' => $data
		]);
    }
}
