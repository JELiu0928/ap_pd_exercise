<?php

namespace App\Models\Basic\Ams;

use Config;

use Illuminate\Database\Eloquent\Model;

class AmsRole extends Model
{
    public function __construct()
    {
        $this->setTable("basic_ams_role");
    }

    public function UsersData()
    {
        return $this->belongsTo('App\Models\Basic\FantasyUsers', 'user_id')->with('_photo_image')->select('id', 'name', 'mail', 'photo_image', 'account');
    }
}
