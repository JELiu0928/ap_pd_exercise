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

class ProductArticleImg extends FrontBase
{
	public function __construct()
	{
		parent::__construct();
		$TableName = "product_article_imgs";
		if (strpos($TableName, 'all_') === false) {
			$dataBasePrefix = Config::get('app.dataBasePrefix');
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}
}
