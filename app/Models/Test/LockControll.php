<?php

namespace App\Models\Test;

use Illuminate\Database\Eloquent\Model;

class LockControll extends Model
{
    protected $guarded = [];
    protected $table = 'a_lock_controller';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
