<?php

namespace App\Models\Basic;

use App\Models\Basic\Branch\branchOriginUnit;
use Illuminate\Database\Eloquent\Model;

class WebKey extends Model
{
    public function __construct()
    {
        $this->setTable("basic_web_key");
    }

    public function CmsMenu()
    {
        return $this->hasMany('App\Models\Basic\Cms\CmsMenu', 'key_id', 'id');
    }
    public function CmsMenuBranch()
    {
        return $this->hasMany('App\Models\Basic\Cms\CmsMenu', 'key_id', 'id')->where('use_type', 2)->where('parent_id', 0);
    }
    public function CmsMenuBranchUse()
    {
        return $this->hasMany('App\Models\Basic\Cms\CmsMenuUse', 'key_id', 'id')->where('use_type', 2)->where('parent_id', 0);
    }
    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('w_rank', 'asc')->orderby('id', 'asc');
    }

    /**
     * @param BranchOriginUnit|array|null $branchOriginUnit
     * @return array
     */
    public static function getCmsRoleList($branchOriginUnit)
    {
        if (empty($branchOriginUnit)) {
            return [];
        }

        $unit_set = json_decode($branchOriginUnit['unit_set'], true);
        $lang = $branchOriginUnit->locale;
        config(['app.dataBasePrefix' => $lang . '_']);
        return static::with([
            'CmsMenu' => function ($query) use ($branchOriginUnit) {
                $query->orderBy('w_rank')
                    ->where('parent_id', 0)
                    ->where('is_active', 1)
                    ->where('branch_id', $branchOriginUnit['origin_id'])
                    ->with(['CmsMenu' => function ($q) {
                        $q->orderBy('w_rank')->with(['CmsMenu' => function ($q2) {
                            $q2->orderBy('w_rank');
                        },
                        ]);
                    },
                    ]);
            },
        ])
        ->get()
        ->sortBy(function($q){
            if(count($q['CmsMenu'])>0) return $q['CmsMenu'][0]->w_rank;
            else return 99999;
        })
        ->reduce(function ($res, $item) use ($unit_set) {
            if ($unit_set[$item->id] ?? 0) {
                $item->CmsMenu = $item->CmsMenu->reduce(function ($res2, $menu) {
                    $res2->push(array_merge($menu->getAttributes(), ['cmsOptions' => $menu->getCmsOptions()]));
                    foreach ($menu->CmsMenu as $child) {
                        $res2->push(array_merge($child->getAttributes(), ['cmsOptions' => $child->getCmsOptions()]));
                        foreach ($child->CmsMenu as $son) {
                            $res2->push(array_merge($son->getAttributes(), ['cmsOptions' => $son->getCmsOptions()]));
                        }
                    }
                    return $res2;
                }, collect([]));
                $res[$item->id] = $item->toArray();
            }
            return $res;
        }, []);
    }
}
