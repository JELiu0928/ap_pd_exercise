<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;

class LogData extends Model
{
    protected $guarded = [];
    protected $table = 'basic_log_data';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public function UsersData()
    {
        return $this->belongsTo('App\Models\Basic\FantasyUsers', 'user_id')->with('_photo_image')->select('id', 'name', 'mail', 'photo_image', 'account');
    }
}
