<?php

namespace App\Models\Basic\Data;

use Illuminate\Database\Eloquent\Model;

class DataGeoArea extends Model
{
    public function __construct()
    {
        $this->setTable("basic_data_geo_area");
    }

    public function DataCity()
    {
        return $this->hasmany('App\Models\Basic\Data\DataCity','geo_id','id');
    }
}
