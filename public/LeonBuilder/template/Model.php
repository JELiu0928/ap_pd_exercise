<?php

namespace App\Models\Datalist;

use Config;
use App\Models\FrontBase;
//LeonBuilder - 程式更新不覆蓋CustomAssociation裡的設定
trait CustomAssociation
{
	public function datalist_son()
	{
		return $this->hasMany('App\Models\Datalist_son\Datalist_son', 'parent_id', 'id')->isVisible()->doSort();
	}
	public function datalist_son_many()
	{
		return $this->hasMany('App\Models\Datalist_son\Datalist_son', 'parent_id', 'id');
	}
}
class Datalist extends FrontBase
{
	use CustomAssociation;
	public function __construct()
	{
		$TableName = "datalist";
		$dataBasePrefix = Config::get('app.dataBasePrefix');
		if (!empty($dataBasePrefix)) {
			$TableName = (strpos($dataBasePrefix, 'preview') !== false) ? str_replace("preview_", "", $dataBasePrefix) . $TableName : $dataBasePrefix . $TableName;
		}
		$this->setTable($TableName);
	}
	//Leon 這給次分類選項用
	public function GetMainData()
	{
		return false;
	}
	// 排序
	public function scopedoSort($query)
	{
		return $query->orderby('w_rank', 'asc')->orderby('id', 'desc');
	}
	public function scopedoCMSSort($query)
	{
		return $query->orderby('id', 'DESC');
	}
}
