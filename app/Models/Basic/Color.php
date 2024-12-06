<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function __construct()
    {
        $this->setTable("basic_color");
    }
}
