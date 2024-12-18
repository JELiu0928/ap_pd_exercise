<?php
namespace App\Models\Product;
use Config;
use BaseFunction;
use Session;
use DB;
use Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as Model_Builder;
use App\Models\FrontBase;
use App\Models\Product\ProductCategoryOverview;
use App\Models\Product\ProductCategoryOverviewList;

// use App\Models\Traits\getUrlName;

class ProductConsult extends FrontBase
{
	// use getUrlName;
	protected $fillable = [
		'description',
		'name',
		'companyName',
		'mail',
		'tel',
		'service',
		'job',
		'branch_id',
		'other_require',
	];
	public function __construct()
	{
		parent::__construct(); //要使用boot(),要使用這行
		$TableName = "product_consult";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}
	public function ProductConsultList()
	{
		return $this->hasMany(ProductConsultList::class, 'consult_id')->doSort();
	}

}