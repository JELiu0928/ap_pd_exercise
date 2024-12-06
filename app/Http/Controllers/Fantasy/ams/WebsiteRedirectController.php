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
use App\Models\Basic\Ams\Autoredirect;

class WebsiteRedirectController extends AmsPaPa
{
	public static $fileInformationArray = [];

	public function __construct()
	{
		parent::__construct();
		// self::$fileInformationArray = BaseFunction::getAllFilesArray();
		// View::share('fileInformationArray', self::$fileInformationArray);
	}

	public function index(){
		$data = Autoredirect::get()->toArray();
		return View::make('Fantasy.ams.website_redirect.index',
		[
			'data' => $data
		]);
    }

    public function update(Request $request)
	{
		$data = $request->input('Autoredirect');
		if($data['id'] == 0)
		{
            $info = new Autoredirect;

			foreach ($data as $key => $value)
			{
				if($key != 'id')
				{
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
					'status' => 'create'
				];
        }else{
            $info = Autoredirect::where('id',$data['id'])->first();
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
		$info = Autoredirect::where('id',$kill_id)->first();
		if(!empty($info))
		{
			$info->delete();
		}
    }

	public function reset()
	{
		$data = Autoredirect::get()->toArray();
		return View::make('Fantasy.ams.website_redirect.ajax.table',
		[
			'data' => $data
		]);
    }
}
