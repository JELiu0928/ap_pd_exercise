<?php

namespace App\Http\Controllers\Fantasy;

use App\Http\Controllers\BaseFunctions;
use App\Http\Controllers\Fantasy\BackendController;
use App\Http\Controllers\Fantasy\MenuController as MenuFunction;
use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;
use App\Models\Basic\Cms\CmsMenu;
use App\Services\Cms\CmsManager;
use ErrorException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class CmsController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        View::share('unitTitle', 'Cms');
        View::share('unitSubTitle', 'Content Management System');
        View::share('FantasyUser', session('fantasy_user'));
        // .test可以切換帳號
        // $FantasyUsersList = (strpos(\Route::getCurrentRequest()->server('HTTP_HOST'), '.test') !== false) ? $FantasyUsersList = FantasyUsers::get()->toArray() : [];
        // View::share('FantasyUsersList', $FantasyUsersList);
        // 禁止切換帳號
        View::share('FantasyUsersList', []);
    }
    public function refixBranch()
    {

        $isBranch = config('cms.setBranchs', false);
        /*此專案是否有分館*/
        if ($isBranch) {
            /*暫時不串權限*/
            $branchData = BranchOrigin::with('BranchOriginUnit')->get();
            $BranchCount = $branchData->count();
            $branch = $branchData->first();
            $branchWithLocale = $branch['BranchOriginUnit']->first();
            //多個分館
            if ($BranchCount) {
                $branchMenuList = MenuFunction::makeCmsBranchMenu(0, $branchWithLocale->locale, $isBranch);
                return View::make(
                    'Fantasy.cms_view.index',
                    [
                        'branchMenuList' => $branchMenuList,
                        'cmsMenuList' => [],
                    ]
                );
            }

            if (!empty($branchWithLocale)) {
                $locale = $branchWithLocale->locale;
            }
            return redirect(url('Fantasy/Cms/' . $branch['url_title'] . '/' . $locale));
        } else {
            /*暫時不串權限*/
            $branch = BranchOrigin::with('BranchOriginUnit')->first();
            $branchWithLocale = $branch['BranchOriginUnit']->first();

            if (!empty($branchWithLocale)) {
                $locale = $branchWithLocale->locale;
            } else {
            }

            return redirect(url('Fantasy/Cms/' . $branch['url_title'] . '/' . $locale));
        }
    }
    public function refixLocale($branch)
    {
        $branch = request()->branch;

        /*暫時不串權限*/
        $branchData = BranchOrigin::where('url_title', $branch)->with('BranchOriginUnit')->first();
        if (empty($branchData)) {
            return redirect(url('Fantasy/Cms'));
        }

        $branchWithLocale = $branchData['BranchOriginUnit']->first();

        if (!empty($branchWithLocale)) {
            $locale = $branchWithLocale->locale;
        } else {
            $locale = app()->getLocale();
        }

        return redirect(url('Fantasy/Cms/' . $branch . '/' . $locale));
    }
    public function index()
    {
        $branch = request()->branch;
        $locale = request()->locale;

        $isBranch = config('cms.setBranchs', false);
        $branchData = BranchOrigin::where('url_title', $branch)->first();

        if (empty($branchData)) {
            return redirect(url('Fantasy/Cms'));
        }
        $branchMenuList = MenuFunction::makeCmsBranchMenu($branchData['id'], $locale, $isBranch);
        $cmsMenuList = MenuFunction::makeCmsMenu($branchData['id'], $locale, 0);

        $firstMenu = isset(array_values($cmsMenuList)[0]) ? array_values($cmsMenuList)[0] : null;

        if ($firstMenu != null) {
            $firstUrl = BaseFunctions::cms_url('/');
            if (isset($firstMenu['list']) && !empty($firstMenu['list'])) {
                $firstID = $firstMenu['list'][array_key_first($firstMenu['list'])]['id'];
                if ($firstMenu['list'][array_key_first($firstMenu['list'])]['type'] == 4) {
                    $list = $firstMenu['list'][array_key_first($firstMenu['list'])]['list'];
                    $firstID = $list[array_key_first($list)]['id'];
                }
                $firstUrl .= "/" . $firstID;
            } else {
                $firstUrl .= "/" . $firstMenu['id'];
            }
            return redirect($firstUrl);
        }
        return view(
            'Fantasy.cms_view.index',
            [
                'branchMenuList' => $branchMenuList,
                'cmsMenuList' => $cmsMenuList,
            ]
        );
    }
    public function edit(Request $request)
    {
        list($menu, $branchOrigin) = $this->getBranchAndMenu($request->branch, $request->locale, $request->menuId);
        try {
            $view = CmsManager::singleton()->getEdit($request, $menu, $branchOrigin);
            $blade_folder = collect(config('cms.blade_template'))->where('key', $branchOrigin->blade_template)->first()['blade_folder'];
            $JsFiles = glob(resource_path('views/Fantasy/cms/' . $blade_folder . '/' . str_replace('.', '/', $menu['view_prefix']) . '/') . '*.js');
            $jscode = collect($JsFiles)->map(function ($file) {
                return fread(fopen($file, "r"), filesize($file));
            })->implode(PHP_EOL);

            $jscode = 'var dataID = ' . $request['ids'][0] . ';' . $jscode;

            return response()->json(['view' => $view, 'jscode' => $jscode]);
        } catch (Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    public function unit(Request $request)
    {
        $branch = $request->branch;
        $locale = $request->locale;
        $menuId = $request->menuId;

        $isBranch = config('cms.setBranchs', false);
        $branchData = BranchOrigin::where('url_title', $branch)->with('BranchOriginUnit')->first();

        if (empty($branchData)) {
            return redirect(url('Fantasy/Cms'));
        }

        $branchOriginUnit = $branchData['BranchOriginUnit']->where('locale', app()->getLocale())->first();
        if (empty($branchOriginUnit)) {
            return redirect(url('Fantasy/Cms'));
        }

        $cmsMenuList = MenuFunction::makeCmsMenu($branchData['id'], $locale, $menuId);
        $branchMenuList = MenuFunction::makeCmsBranchMenu($branchData['id'], $locale, $isBranch);

        return view('Fantasy.cms_view.Table.unit', [
            'branchMenuList' => $branchMenuList,
            'cmsMenuList' => $cmsMenuList,
            'nowBranchData' => $branchData,
            'nowLocale' => $branchOriginUnit,
        ]);
    }

    public function showUnit(Request $req)
    {
        $dataId = $req->dataId ?: 0;
        list($menu, $branchOrigin) = $this->getBranchAndMenu($req->branch, $req->locale, $req->menuId);
        $res = CmsManager::singleton()->getTable($req, $menu, $branchOrigin);
        $preview_url = BaseFunctions::cms_preview_url($req->menuId);
        // dd($res);
        return response()->json(['menu' => $menu, 'data' => $res->toArray(), 'dataId' => $dataId, 'preview_url' => $preview_url]);
    }
    public function updateUnit(Request $req)
    {
        DB::beginTransaction();
        try {
            list($menu, $branchOrigin) = $this->getBranchAndMenu($req->branch, $req->locale, $req->menuId);
            $response = CmsManager::singleton()->update($req, $menu, $branchOrigin);
            DB::commit();
            return $response->toArray();
        } catch (Exception $e) {
            DB::rollBack();
            // throw $e;
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }
    public function copyUnit(Request $req)
    {
        DB::beginTransaction();
        try {
            list($menu, $branchOrigin) = $this->getBranchAndMenu($req->branch, $req->locale, $req->menuId);
            $response = CmsManager::singleton()->copy($req, $menu, $branchOrigin);
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    public function deleteUnit(Request $req)
    {
        DB::beginTransaction();
        try {
            list($menu, $branchOrigin) = $this->getBranchAndMenu($req->branch, $req->locale, $req->menuId);
            $response = CmsManager::singleton()->delete($req, $menu, $branchOrigin);
            DB::commit();
            return $response;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    private function getBranchAndMenu($branch, $locale, $menuId)
    {
        static $res = [];
        if (empty($res)) {
            $branchOrigin = BranchOrigin::whereJsonContains('local_set', $locale)->where('url_title', $branch)->first();
            if (empty($branchOrigin)) {
                throw new ErrorException('No Branch Match.', 400);
            }
            $cmsMenu = CmsMenu::where('branch_id', $branchOrigin->id)->where('id', $menuId)->first();
            if (empty($cmsMenu)) {
                throw new ErrorException('No Menu Match.', 400);
            }
            $res = [$cmsMenu, $branchOrigin];
        }
        return $res;
    }
    public function article_video(Request $request)
    {
        $id = $request->id;
        return View::make(
            'video4_lightbox',
            [
                'id' => $id
            ]
        );
    }
}
