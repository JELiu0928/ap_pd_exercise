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

class Datalist_three extends FrontBase
{
	public function __construct()
	{
		$TableName = "datalist_three";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix,'preview') !== false) ? str_replace("preview_","",$dataBasePrefix).$TableName : $dataBasePrefix.$TableName;
		}
		$this->setTable($TableName);
	}
    //自訂區塊，不覆蓋-Star
    //自訂區塊，不覆蓋-End
}
