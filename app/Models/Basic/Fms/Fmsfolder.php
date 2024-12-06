<?php

namespace App\Models\Basic\Fms;

use Illuminate\Database\Eloquent\Model;
use Session;

class Fmsfolder extends Model
{
    private static $role;
    public function __construct()
    {
        $this->setTable("basic_fms_folder");
    }
    public function create_user()
    {
        return $this->belongsTo('App\Models\Basic\FantasyUsers', 'create_id')->with('_photo_image');
    }
    // CMS排序
    public function scopedoCMSSort($query)
    {
        return $query->orderby('id', 'desc');
    }
    public function childCategory()
    {
        return $this->hasMany('App\Models\Basic\Fms\Fmsfolder', 'parent_id', 'id')->with('create_user');
    }
    public function son_folder()
    {
        return $this->childCategory()->with(['son_folder']);
    }
    public function son_folder_withSession()
    {
        if (static::$role === 'all') {
            return $this->childCategory()->with('son_folder_withSession');
        } else {
            return $this->childCategory()
                ->checkValid()
                ->with('son_folder_withSession');
        }

    }
    public function topchildCategory()
    {
        return $this->belongsTo('App\Models\Basic\Fms\Fmsfolder', 'parent_id', 'id')->with('create_user');
    }
    public function top_folder()
    {
        return $this->topchildCategory()->with('top_folder');
    }

    public function scopecheckValid($query)
    {
        $user = session('fantasy_user');
        $query->when((empty($user['ams']) || empty($user['ams']['is_folder'])), function ($q2) use ($user) {
            $q2->where('is_private', 0)
                ->orWhere('create_id', $user['id'])
                ->orWhereJsonContains('can_use', (string) $user['id']);
        });
    }

    public static function setRole($role)
    {
        if ($role === 'all') {
            static::$role = 'all';
        } else {
            static::$role = 'me';
        }
    }
}
