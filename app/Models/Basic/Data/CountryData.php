<?php

namespace App\Models\Basic\Data;

use Config;

use Illuminate\Database\Eloquent\Model;

class CountryData extends Model
{

    public function __construct()
    {
        $this->setTable("basic_country_data");
    }
}
