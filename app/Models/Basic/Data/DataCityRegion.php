<?php

namespace App\Models\Basic\Data;

use Config;

use Illuminate\Database\Eloquent\Model;

class DataCityRegion extends Model
{
    const parent_key = [ 'DataCity' => 'city_id' ];

    public function __construct()
    {
        $this->setTable("basic_data_city_region");
    }

    public function DataCity()
    {
        return $this->belongsto('App\Models\Basic\Data\DataCity',$this::parent_key['DataCity'],'id');
    }
}
