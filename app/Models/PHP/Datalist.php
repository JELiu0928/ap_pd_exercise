<?php
namespace App\Models\PHP;
use Config;
use BaseFunction;
use Session;
use DB;
use Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as Model_Builder;
use App\Models\FrontBase;

class Datalist extends FrontBase
{
	public function __construct()
	{
		$TableName = "datalist";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix,'preview') !== false) ? str_replace("preview_","",$dataBasePrefix).$TableName : $dataBasePrefix.$TableName;
		}
		$this->setTable($TableName);
	}
	public function Datalist_content()
	{
	return $this->hasMany('App\Models\PHP\Datalist_content', 'parent_id', 'id')->isVisible()->doSort();
	}
	public function Datalist_son()
	{
	return $this->hasMany('App\Models\PHP\Datalist_son', 'parent_id', 'id')->isVisible()->doSort();
	}
	public function dataoption()
	{
	return $this->belongsTo('App\Models\PHP\Dataoption', 'select2', 'id')->isVisible();
	}
    //自訂區塊，不覆蓋-Star
    //自訂區塊，不覆蓋-End
}
