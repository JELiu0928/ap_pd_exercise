<?php

namespace App\Services\Cms;

use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Cms\CmsMenu;
use App\Services\Cms\api\InitApi;
use App\Services\Cms\classes\CmsApi;
use App\Services\Cms\classes\CmsApiResponse;
use Illuminate\Http\Request;

class CmsManager
{
    private static $API = [];
    /** @var CmsManager */
    private static $instance;
    /** @var CmsApi */
    private $init;
    private function __construct()
    {
        $this->boot();
    }
    /** @return CmsApiResponse */
    public function getTable(Request $req, CmsMenu $cmsMenu, BranchOrigin $branchOrigin)
    {
        return $this->init->handle('getTable', $req, $cmsMenu, $branchOrigin);
    }
    /** @return CmsApiResponse */
    public function getExport(Request $req, CmsMenu $cmsMenu, BranchOrigin $branchOrigin)
    {
        return $this->init->handle('getExport', $req, $cmsMenu, $branchOrigin);
    }
    public function getEdit(Request $req, CmsMenu $cmsMenu, BranchOrigin $branchOrigin)
    {
        return $this->init->handle('getEdit', $req, $cmsMenu, $branchOrigin);
    }
    public function update(Request $req, CmsMenu $cmsMenu, BranchOrigin $branchOrigin)
    {
        return $this->init->handle('update', $req, $cmsMenu, $branchOrigin);
    }
    public function delete(Request $req, CmsMenu $cmsMenu, BranchOrigin $branchOrigin)
    {
        return $this->init->handle('delete', $req, $cmsMenu, $branchOrigin);
    }
    public function copy(Request $req, CmsMenu $cmsMenu, BranchOrigin $branchOrigin)
    {
        return $this->init->handle('copy', $req, $cmsMenu, $branchOrigin);
    }
    private function boot()
    {
        $this->init = new InitApi();
        foreach (static::$API as $api) {
            if (is_subclass_of($api, CmsApi::class)) {
                $nextApi = new $api();
                if (empty($current)) {
                    $current = $this->init->setNext($nextApi);
                } else {
                    $current = $current->setNext($nextApi);
                }
            }
        }
    }

    public static function registerApi($api)
    {
        static::$API[$api] = $api;
    }

    /** @return CmsManager */
    public static function singleton()
    {
        if (empty(static::$instance)) {
            static::$instance = new static();
        }
        return static::$instance;
    }
}
