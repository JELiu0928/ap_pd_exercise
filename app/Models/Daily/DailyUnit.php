<?php
namespace App\Models\Daily;
use Config;
use BaseFunction;
use Session;
use DB;
use Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as Model_Builder;
use App\Models\FrontBase;
use Exception;

class DailyUnit extends FrontBase
{
	public function __construct()
	{
        parent::__construct();

		$TableName = "daily_unit";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix,'preview') !== false) ? str_replace("preview_","",$dataBasePrefix).$TableName : $dataBasePrefix.$TableName;
		}
		$this->setTable($TableName);
	}
    protected static function boot()
    {
        parent::boot();

        // static::saving(function ($model) {
        //     throw new Exception("Your text message goes here");
        // });
    }
}
