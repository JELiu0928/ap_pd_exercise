<?php

namespace App\Models\Basic;

use App\Models\Basic\Ams\AmsRole;
use App\Models\Basic\Cms\CmsRole;
use Illuminate\Database\Eloquent\Model;

class FantasyUsers extends Model
{
    public function __construct()
    {
        $this->setTable("basic_fantasy_users");
    }
    public function _photo_image()
    {
        return $this->belongsTo('App\Models\Basic\Fms\FmsFile', 'photo_image', 'file_key');
    }

    public function cmsRoles()
    {
        return $this->hasMany(CmsRole::class, 'user_id')->where('is_active', 1)->with(['BranchOriginUnit']);
    }

    public function amsRole()
    {
        return $this->hasOne(AmsRole::class, 'user_id')->where('is_active', 1);
    }

    public static function getUserArray()
    {
        static $users = '';
        if ($users === '') {
            $users = static::all()->reduce(function ($res, $user) {
                $res[$user->id] = [
                    'key' => $user->id,
                    'title' => $user->name,
                ];
                return $res;
            }, []);
        }
        return $users;
    }
}
