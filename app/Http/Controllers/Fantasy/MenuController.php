<?php

namespace App\Http\Controllers\Fantasy;

use BaseFunction;
use Session;
use App\Models\Basic\Branch\BranchOrigin;
use App\Models\Basic\Branch\BranchOriginUnit;
use App\Models\Basic\Cms\CmsMenu;

class MenuController extends BackendController
{

    public static function getFmsFolderMenu($type, $branch_id = "", $zero_id = '')
    {
        $member = Session::get('fantasy_user');
        if ($type == '1') {
            /*第零層*/
            $zero = parent::$ModelsArray['FmsZero']::where('is_active', 1)
                ->where('type', 1)
                ->orderBy('w_rank', 'asc')
                ->get()
                ->toArray();
            if (empty($zero)) {
                echo "請先至Account帳號管理，建立FMS基本目錄";
                die;
            }
            /*第一層*/
            $list = [];
            $firstList = parent::$ModelsArray['FmsFirst']::where('is_active', 1);
            if ($zero_id != '') {
                $firstList = $firstList->where('zero_id', $zero_id);
            } else {
                // $firstList = $firstList->where('zero_id',$zero[0]['id']);
            }
            $firstList = $firstList->where('type', $type)
                ->orderBy('w_rank', 'asc')
                ->get()
                ->toArray();

            foreach ($firstList as $key => $value) {
                array_push($list, $value);
            }
            /*第二層*/
            foreach ($list as $key => $value) {
                $temp_model = parent::$ModelsArray['FmsSecond'];
                $list[$key]['list'] = $temp_model::where('first_id', $value['id'])
                    ->get()
                    ->toArray();
            }
            /*第三層*/
            foreach ($list as $key => $value) {
                if (!empty($value['list'])) {
                    foreach ($value['list'] as $key2 => $value2) {
                        $temp_model = parent::$ModelsArray['FmsThird'];
                        $list[$key]['list'][$key2]['list'] = $temp_model::where('second_id', $value2['id'])
                            ->get()
                            ->toArray();
                    }
                }
            }
        } elseif ($type == '2') {} elseif ($type == '3') {
            $temp_model = parent::$ModelsArray['CmsRole'];
            $cmsRoles = $temp_model::where('is_active', 1)
                ->where('user_id', $member['id'])
                ->where('branch_unit_id', $branch_id)
                ->where('type', 2)
                ->with('CmsPermissionWithMenu')
                ->first();
            $cmsRoles = (!empty($cmsRoles)) ? $cmsRoles->toArray() : [];
            if (empty($cmsRoles)) {
                echo "No Permission.";
                die;
            } else {
                /*Web Key*/
                $key_group = [];
                foreach ($cmsRoles['cms_permission_with_menu'] as $value2) {
                    array_push($key_group, $value2['cms_menu']['key_id']);
                }
                /*第一層*/
                $list = [];
                if ($cmsRoles['branch_manage'] == 1) {
                    $temp_model = parent::$ModelsArray['FmsFirst'];
                    $list = $temp_model::where('is_active', 1)
                        ->where('type', 4)
                        ->orderBy('w_rank', 'asc')
                        ->get()
                        ->toArray();
                }
                $temp_model = parent::$ModelsArray['FmsFirst'];
                $firstList = $temp_model::where('is_active', 1)
                    ->whereIn('key_id', $key_group)
                    ->where('type', $type)
                    ->orderBy('w_rank', 'asc')
                    ->get()
                    ->toArray();
                foreach ($firstList as $key => $value) {
                    array_push($list, $value);
                }
                /*第二層*/
                foreach ($list as $key => $value) {
                    $temp_model = parent::$ModelsArray['FmsSecond'];
                    $list[$key]['list'] = $temp_model::where('first_id', $value['id'])
                        ->where('branch_id', $branch_id)
                        ->get()
                        ->toArray();
                }
                /*第三層*/
                foreach ($list as $key => $value) {
                    if (!empty($value['list'])) {
                        foreach ($value['list'] as $key2 => $value2) {
                            $temp_model = parent::$ModelsArray['FmsThird'];
                            $list[$key]['list'][$key2]['list'] = $temp_model::where('second_id', $value['id'])
                                ->where('branch_id', $branch_id)
                                ->get()
                                ->toArray();
                        }
                    }
                }
                /*檢查是否有私有資料夾*/
                /*2*/
                /*3*/
            }
        }
        return [
            'list' => $list,
            'zero' => $zero,
        ];
    }
    public static function makeCmsBranchMenu($branch_id, $locale, $isBranch)
    {
        $member = Session::get('fantasy_user');
        //使用者可管理的語系
        $branch_unit_list = M('CmsRole')::where('is_active', 1)->where('user_id', $member['id'])->get()->pluck('branch_unit_id');
        $data = [];
        if ($isBranch) {
            if($branch_id==0){
                $nowBranch = [];
                $nowBranch['title'] = '品牌總覽';
            }
            else{
                $nowBranch = M('BranchOrigin')::where('is_active', 1)->where('id', $branch_id)->first();
                if (empty($nowBranch)) return [];
            }
            $nowBranch = M('BranchOrigin')::where('is_active', 1)->where('id', $branch_id)->first();
            
            if ($branch_id == 0) {
                $nowBranch['title'] = '品牌總覽';
            } else {
                $nowBranch = $nowBranch->toArray();
            }
            $branchData = M('BranchOrigin')::where('is_active', 1)->with('BranchOriginUnit')->get();
            $firstList = [];
            $overviewList = [];
            $chkOvList = [];
            $count_ov = 0;

            foreach ($branchData as $key => $row) {
                $branchWithLocale = $row['BranchOriginUnit']->whereIn('id', $branch_unit_list);
                if(count($branchWithLocale)==0){
                    unset($branchData[$key]);
                    continue;
                }
                $firstList[$key]['title'] = $row['title'];
                $firstList[$key]['link'] = 'javascript:;';
                // $firstList[$key]['locale'] = $row['locale'];
                $firstList[$key]['locale'] = $branchWithLocale[0]['locale'];

                $secondList = [];
                foreach ($branchWithLocale as $key2 => $row2) {
                    $secondList[$key2]['title'] = parent::$langArray[$row2['locale']]['title'];
                    $secondList[$key2]['link'] = url('Fantasy/Cms/' . $row['url_title'] . '/' . $row2['locale']);

                    //品牌總覽語系
                    if (!in_array($row2['locale'], $chkOvList)) {
                        array_push($chkOvList, $row2['locale']);
                        $overviewList[$count_ov]['title'] = parent::$langArray[$row2['locale']]['title'];
                        $overviewList[$count_ov]['link'] = url('/Fantasy/Cms/overview/' . $row2['locale']);
                        $count_ov++;
                    }
                }
                $firstList[$key]['list'] = $secondList;
            }
            
            $data['list'] = $firstList;
            if ($branch_id == 0) {
                $data['now'] = $nowBranch['title'];
            } else {
                $data['now'] = $nowBranch['title'] . ' - ' . parent::$langArray[$locale]['title'];
            }
        } else {
            /*暫不權限 無交叉比對*/
            $nowBranch = BranchOrigin::where('is_active', 1)->where('id', $branch_id)->with('BranchOriginUnit')->first();

            if (empty($nowBranch)) return '';
            
            $branchWithLocale = $nowBranch['BranchOriginUnit']->where('origin_id', $branch_id);

            if (count($branchWithLocale)==0) return '';

            $firstList = [];
            foreach ($branchWithLocale as $key => $row) {
                if (isset(parent::$langArray[$row['locale']])) {
                    $firstList[$key]['title'] = parent::$langArray[$row['locale']]['title'];
                    $firstList[$key]['link'] = url('Fantasy/Cms/' . $nowBranch->url_title . '/' . $row['locale']);
                    $firstList[$key]['list'] = [];
                    $firstList[$key]['locale'] = $row['locale'];
                }
            }
            $data['list'] = $firstList;
            $data['now'] = $nowBranch->title . ' - ' . parent::$langArray[$locale]['title'];
        }
        $data['now_locale'] = parent::$langArray[$locale]['abb_title'];
        $data['now_locale_prefix'] = $locale;
        return $data;
    }
    public static function makeCmsMenu($branch_id, $locale, $now_id)
    {
        $member = Session::get('fantasy_user');
        /*暫不權限 無交叉比對*/
        $nowBranch = BranchOrigin::where('is_active', 1)->where('id', $branch_id)->with('BranchOriginUnit')->first();
        $BranchOriginUnit = $nowBranch['BranchOriginUnit']->where('origin_id', $branch_id)->where('locale', $locale)->first();
        //提前判斷  $BranchOriginUnit 是否 null (總覽 id = 0)
        $unit_set = $BranchOriginUnit ? array_keys(collect(json_decode($BranchOriginUnit['unit_set'], true))->filter(function ($item) {
            return $item == 1;
        })->toArray()) : [];

        $temp_role = (!empty($BranchOriginUnit)) ? M('CmsRole')::where('branch_unit_id', $BranchOriginUnit->id)->where('user_id', $member['id'])->first() : [];
        if (empty($temp_role)) {
            return [];
        }
        $role = collect(json_decode($temp_role->roles, true))
            ->map(function ($value) {
                return array_map('intval', explode(';', $value));
            });

        if (empty($nowBranch) and $branch_id != 0) {
            return [];
        } else {
            if ($branch_id == 0) {
                $use_type = 1;
                $nowBranchUrlTitle = 'overview';
            } else {
                $use_type = 2;
                $nowBranchUrlTitle = $nowBranch->url_title;
            }

            $type_can = ['1', '2'];
            /*無串權限*/
            $firstList = CmsMenu::where('is_active', 1)
                ->whereIn('key_id', $unit_set)
                ->where('use_type', $use_type)
                ->whereIn('type', $type_can)
                ->orderBy('w_rank', 'asc')
                ->orderby('id', 'asc')
                ->get()
                ->filter(function ($item) use ($role, $use_type) {
                    if ($use_type == 1) {
                        return true;
                    } else {
                        return isset($role[$item['id']]) && array_sum($role[$item['id']]) > 0;
                    }
                })
                ->values()
                ->toArray();
        }
        foreach ($firstList as $key => $row) {
            if ($row['type'] == 1) {
                $firstList[$key]['list'] = CmsMenu::where('is_active', 1)
                    ->where('use_type', $use_type)
                    ->whereIn('type', ['3', '4'])
                    ->where('parent_id', $row['id'])
                    ->orderBy('w_rank', 'asc')
                    ->orderby('id', 'asc')
                    ->get()
                    ->filter(function ($item) use ($role) {
                        return isset($role[$item['id']]) && array_sum($role[$item['id']]) > 0;
                    })
                    ->map(function ($item, $key) use ($use_type, $role) {
                        $item['list'] = CmsMenu::where('is_active', 1)
                            ->where('use_type', $use_type)
                            ->where('type', '5')
                            ->where('parent_id', $item['id'])
                            ->orderBy('w_rank', 'asc')
                            ->get()
                            ->filter(function ($item) use ($role) {
                                return isset($role[$item['id']]) && array_sum($role[$item['id']]) > 0;
                            })
                            ->toArray();
                        return $item;
                    })->toArray();
                    foreach ($firstList[$key]['list'] as $key1=>$row1) {
                        if($row1['type']==4){
                            if(count($row1['list'])==0){
                                unset($firstList[$key]['list'][$key1]);
                            }
                        }
                   }
                if (empty($firstList[$key]['list'])) {
                    unset($firstList[$key]);
                }
            }
        }

        /*串連結*/
        foreach ($firstList as $key => $row) {
            $ModelDataCountTotal = 0;
            if ($row['type'] == 2) {
                $firstList[$key]['link'] = url('/Fantasy/Cms/' . $nowBranchUrlTitle . '/' . $locale . '/unit/' . $row['id']);
            } else {
                $firstList[$key]['link'] = 'javascript:;';
            }

            if (!empty($row['list'])) {
                foreach ($row['list'] as $key2 => $row2) {
                    if($row2['type'] == 4 && empty($row2['list'])){
                        unset($firstList[$key]['list'][$key2]);
                        continue;
                    }

                    if ($row2['type'] == 3) {
                        $firstList[$key]['list'][$key2]['link'] = url('/Fantasy/Cms/' . $nowBranchUrlTitle . '/' . $locale . '/unit/' . $row2['id']);
                    } elseif ($row2['type'] == 4) {
                        $firstList[$key]['list'][$key2]['link'] = 'javascript:;';
                    }
                    if (!empty($row2['list'])) {
                        foreach ($row2['list'] as $key3 => $row3) {
                            $firstList[$key]['list'][$key2]['list'][$key3]['link'] = url('/Fantasy/Cms/' . $nowBranchUrlTitle . '/' . $locale . '/unit/' . $row3['id']);
                            //Leon 取得未核准數量
                            if (!empty($row3['model'])) {
                                //$ModelDataCount = ($row2['is_content'] == 0) ? Config('models.'.$row3['model'])::where('is_reviewed',0)->count() : 0;
                                $firstList[$key]['list'][$key2]['list'][$key3]['DataCount'] = 0;
                                $ModelDataCountTotal += 0;
                            }
                        }
                    }
                    //Leon 取得未核准數量
                    if (!empty($row2['model'])) {
                        //$ModelDataCount = ($row2['is_content'] == 0) ? Config('models.'.$row2['model'])::where('is_reviewed',0)->count() : 0;
                        $firstList[$key]['list'][$key2]['DataCount'] = 0;
                        $ModelDataCountTotal += 0;
                    }
                }
                if(empty($firstList[$key]['list'])){
                    unset($firstList[$key]);
                    continue;
                }
            }
            $firstList[$key]['DataCount'] = $ModelDataCountTotal;
        }

        /*如果有要串父親DB*/
        /*找當前單元*/
        foreach ($firstList as $key => $row) {
            if ($row['id'] == $now_id) {
                $firstList[$key]['active'] = 'open active';
            } else {
                $firstList[$key]['active'] = '';
            }
            $firstList[$key]['is_hr'] = $firstList[$key]['is_hr'] ?? 0;
            if (!empty($row['list'])) {
                foreach ($row['list'] as $key2 => $row2) {
                    if ($row2['id'] == $now_id) {
                        $firstList[$key]['list'][$key2]['active'] = 'open active';
                        $firstList[$key]['active'] = 'open active';
                    } else {
                        if (!empty($row2['list'])) {
                            $firstList[$key]['list'][$key2]['active'] = '';
                            foreach ($row2['list'] as $key3 => $row3) {
                                if ($row3['id'] == $now_id) {
                                    $firstList[$key]['list'][$key2]['list'][$key3]['active'] = 'open active';
                                    $firstList[$key]['list'][$key2]['active'] = 'open active';
                                    $firstList[$key]['active'] = 'open active';
                                } else {
                                    $firstList[$key]['list'][$key2]['list'][$key3]['active'] = '';
                                }
                            }
                        } else {
                            $firstList[$key]['list'][$key2]['active'] = '';
                        }
                    }
                }
            }
        }
        return $firstList;
    }
}
