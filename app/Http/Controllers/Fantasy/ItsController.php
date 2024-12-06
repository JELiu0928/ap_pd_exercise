<?php
namespace App\Http\Controllers\Fantasy;

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

/*Model*/
use App\Models\Basic\FantasyUsers;

class ItsController extends BackendController
{

	public function __construct()
	{
		parent::__construct();
        // parent::checkRouteLang();
        // parent::checkRouteBranch();
		View::share('unitTitle', 'Its');
        View::share('unitSubTitle', 'Information Technology System');
        View::share('FantasyUser', session('fantasy_user'));
        $FantasyUsersList = (strpos(\Route::getCurrentRequest()->server('HTTP_HOST'),'.test') !== false) ? $FantasyUsersList = FantasyUsers::get()->toArray() : [];
		View::share('FantasyUsersList', $FantasyUsersList);
	}
	public function index()
	{
		return View::make('Fantasy.its.index',
		[

		]);
	}
    /*Cms選單設定*/
	public function menu(Request $request)
	{
		$modelName = 'CmsMenu';
        $page = $request->input('page');
        $search = $request->input('search');

        $page = (!empty($page)) ? $page : 1;
        $search = (!empty($search)) ? $search : [];

		$data = parent::getDataNew($modelName,'0',$page,$search,10);

        $options = parent::getOption('menu');

		return View::make('Fantasy.its.menu.index',
		[
			'modelName' => $modelName,
			'isEdit' => 1,
			'isDelete' => 1,
			'isCreate' => 1,
			'options'=>$options,
			'data'=>$data['data'],
            'count'=>$data['count'],
            'pn'=>$data['pn'],
            'viewRoute'=>'Fantasy.its.menu',
            'pageKey'=>'menu',
            'search'=>$search,
            'page'=>$page
		]);
	}
    /*網頁Key值 設定*/
	public function key(Request $request)
	{
        $modelName = 'WebKey';

        $page = $request->input('page');
        $search = $request->input('search');

        $page = (!empty($page)) ? $page : 1;
        $search = (!empty($search)) ? $search : [];

        $data = parent::getDataNew($modelName,'0',$page,$search,10);

		return View::make('Fantasy.its.key.index',
		[
            'modelName' => $modelName,
            'isEdit' => 1,
            'isDelete' => 1,
            'isCreate' => 1,
            'viewRoute'=>'Fantasy.its.key',
            'data'=>$data['data'],
            'count'=>$data['count'],
            'pn'=>$data['pn'],
            'search'=>$search,
            'page'=>$page,
            'pageKey'=>'key'
		]);
	}

	public function file(Request $request)
	{

        $options = parent::getOption('file');

        $modelName = 'FmsFirst';

        $page = $request->input('page');
        $search = $request->input('search');

        $page = (!empty($page)) ? $page : 1;
        $search = (!empty($search)) ? $search : [];

        $data = parent::getDataNew($modelName,'0',$page,$search,10);

		return View::make('Fantasy.its.file.index',
		[
            'data'=>$data['data'],
            'count'=>$data['count'],
            'pn'=>$data['pn'],
            'search'=>$search,
            'page'=>$page,
            'modelName' => $modelName,
            'isEdit' => 1,
            'isDelete' => 1,
            'isCreate' => 1,
            'options'=>$options,
            'viewRoute'=>'Fantasy.its.file',
            'pageKey'=>'file'
		]);
	}

    public function option(Request $request)
    {

        $options = parent::getOption('option');

        $modelName = 'OptionSet';

        $page = $request->input('page');
        $search = $request->input('search');

        $page = (!empty($page)) ? $page : 1;
        $search = (!empty($search)) ? $search : [];

        $data = parent::getDataNew($modelName,'0',$page,$search,10);

        return View::make('Fantasy.its.option.index',
        [
            'data'=>$data['data'],
            'count'=>$data['count'],
            'pn'=>$data['pn'],
            'search'=>$search,
            'page'=>$page,
            'modelName' => $modelName,
            'isEdit' => 1,
            'isDelete' => 1,
            'isCreate' => 1,
            'options'=>$options,
            'viewRoute'=>'Fantasy.its.option',
            'pageKey'=>'option'
        ]);
    }
}
