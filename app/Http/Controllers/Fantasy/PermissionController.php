<?php

namespace App\Http\Controllers\Fantasy;

use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;
use App\Models\Basic\Cms\CmsRole;
use Illuminate\Support\Facades\Session;

/**相關Models**/
/*Branch*/

/*Cms*/
/*Crs*/
/*Auth*/
/*Fms*/
/*Option*/

/*Basic*/
/*AMS*/

class PermissionController extends BackendController
{

    /**
     * @return array [ edit, delete, create, need_review, can_review, is_review_edit ]
     */
    public static function getCmsAuthority($menu_id)
    {
        static $data = [];

        if (!empty($data)) {
            return $data;
        }

        $branch_id = parent::$baseBranchId;
        $locale = parent::$baseLocale;
        $user = Session::get('fantasy_user');

        $data['view'] = false;
        $data['edit'] = false;
        $data['delete'] = false;
        $data['create'] = false;
        $data['need_review'] = false;
        $data['can_review'] = false;
        $data['is_review_edit'] = false;

        $branch = BranchOrigin::where('id', $branch_id)->where('local_review_set', 'LIKE', '%"' . $locale . '"%')->first();
        // $branch = BranchOrigin::where('id', $branch_id)->whereJsonContains('local_review_set', $locale)->first();
        if ($branch_id == 0) {
            $role = CmsRole::where('type', 1)->where('user_id', $user['id'])->first();
            $role = !empty($role) ? $role->toArray() : [];
        } else {
            $branchUnit = BranchOriginUnit::where('origin_id', $branch_id)->where('locale', $locale)->first();
            $branchUnit = !empty($branchUnit) ? $branchUnit->toArray() : [];
            /*======檢查是否有 新增/刪除 審核 ======*/
            if ($branch && config('cms.reviewfunction')) {
                $data['need_review'] = true;
            }
            /*======檢查是否有 新增/刪除 審核 ======*/
            $role = CmsRole::where('type', 2)->where('user_id', $user['id'])->where('branch_unit_id', $branchUnit['id'])->first();
            $role = !empty($role) ? $role->toArray() : [];
        }
        if (!empty($role)) {
            $role_json = json_decode($role['roles'], true);
            $data['is_review_edit'] = $role['is_review_edit'];
            $value = $role_json[$menu_id] ?? '';

            $role_json_temp = explode(";", $value);
            $data['edit'] = isset($role_json_temp[3]) && intval($role_json_temp[3]) === 1;
            $data['delete'] = isset($role_json_temp[2]) && intval($role_json_temp[2]) === 1;
            $data['create'] = isset($role_json_temp[1]) && intval($role_json_temp[1]) === 1;
            $data['view'] = isset($role_json_temp[0]) && intval($role_json_temp[0]) === 1;
            $data['can_review'] = isset($role_json_temp[4]) && intval($role_json_temp[4]) === 1;

            if (empty($branch)) {
                $data['can_review'] = true;
                $data['is_review_edit'] = true;
            }
        }

        return $data;
    }
    public static function getCrsAuthority($set)
    {}
}
