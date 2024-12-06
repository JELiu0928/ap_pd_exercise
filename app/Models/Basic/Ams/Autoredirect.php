<?php
namespace App\Models\Basic\Ams;
use Config;
use Illuminate\Database\Eloquent\Builder AS Model_Builder;
use Illuminate\Database\Eloquent\Model;

class Autoredirect extends Model
{
	public function __construct()
	{
		$TableName = "basic_autoredirect";
		$this->setTable($TableName);
	}
}
