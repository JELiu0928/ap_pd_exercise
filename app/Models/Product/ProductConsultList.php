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

class ProductConsultList extends FrontBase
{
	protected $fillable = [
		'part_id',
		'description',
		'consult_id',
		'branch_id',
		'w_rank',
	];
	// use getUrlName;
	public function __construct()
	{
		parent::__construct(); //要使用boot(),要使用這行
		$TableName = "product_consult_list";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}

	public function ProductItemPart()
	{
		return $this->belongsTo(ProductItemPart::class, 'part_id')->orderBy('w_rank', 'asc');
	}
	public function part()
	{
		return $this->belongsTo(ProductItemPart::class, 'part_id')->isVisible();
	}



}