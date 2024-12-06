<?php

namespace App\Models\Basic;

use Illuminate\Database\Eloquent\Model;

class ReviewNotify extends Model
{
    public function __construct()
    {
        $this->setTable("basic_review_notify");
    }
}