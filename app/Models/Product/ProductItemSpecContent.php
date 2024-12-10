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
// use App\Models\Product\ProductItem;
use App\Models\Product\ProductItemKeyword;

// 產品規格表內容
class ProductItemSpecContent extends FrontBase
{
	// use getUrlName;
	public function __construct()
	{
		parent::__construct();

		$TableName = "product_item_spec_content";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}

	public function specTitle()
	{
		return $this->belongsTo(ProductItemSpecTitle::class, 'spec_id');
	}
}
