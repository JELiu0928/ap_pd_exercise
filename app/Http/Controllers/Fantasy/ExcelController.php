<?php

namespace App\Http\Controllers\Fantasy;

/**原生函式**/

use App\Http\Controllers\Fantasy\BackendController;
use App\Models\Basic\Branch\BranchOrigin;

/**相關Controller**/

use App\Models\Basic\Cms\CmsMenu;
use App\Services\Cms\CmsManager;
use Illuminate\Http\Request;
use PhpParser\Error;

class ExcelController extends BackendController
{
    const perPage = 1000;
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $req)
    {
        // default
        return view('exports.default', [
            'page' => $req->page ?? 1,
        ]);
    }

    public function output(Request $req)
    {
        list($menu, $branchOrigin) = $this->getBranchAndMenu($req->branch, $req->locale, $req->menuId);

        $res = CmsManager::singleton()->getExport($req, $menu, $branchOrigin);

        return response()->json($res->toArray());
    }

    private function getBranchAndMenu($branch, $locale, $menuId)
    {
        $branchOrigin = BranchOrigin::whereJsonContains('local_set', $locale)->where('url_title', $branch)->first();
        if (empty($branchOrigin)) {
            throw new Error('No Branch Match.', 400);
        }
        $cmsMenu = CmsMenu::where('branch_id', $branchOrigin->id)->where('id', $menuId)->first();
        if (empty($cmsMenu)) {
            throw new Error('No Menu Match.', 400);
        }
        config(['app.dataBasePrefix' => $locale . '_']);
        return [$cmsMenu, $branchOrigin];
    }
}
