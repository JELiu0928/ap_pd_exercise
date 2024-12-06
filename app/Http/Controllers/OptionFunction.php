<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

use View;
use Redirect;
use Auth;
use Debugbar;
use Route;
use App;
use Config;
use Session;
use Carbon\Carbon;

class OptionFunction extends BaseController
{

	public function __construct()
	{
		parent::__construct();
	}
	public static function article_style()
	{
		$array = [
			'typeBasic',
			'typeSL',
			'typeSR',

			'typeU',
			'typeUL',
			'typeUR',

			'typeD',
			'typeDL',
			'typeDR',

			'typeL',
			'typeR',

			'typeLR',
			'typeRR',

			'typeF',
			'typeFL',
			'typeFR',

			'typeFBox',
			'typeFBoxL',
			'typeFBoxR'
		];
		return $array;
	}
	public static function City_List()
	{
		$array = [
			//["key" => 0, "title" => "選擇縣市"],
			["key" => 1, "title" => "基隆市"],
			["key" => 2, "title" => "臺北市"],
			["key" => 3, "title" => "新北市"],
			["key" => 4, "title" => "桃園市"],
			["key" => 5, "title" => "新竹市"],
			["key" => 6, "title" => "新竹縣"],
			["key" => 7, "title" => "苗栗縣"],
			["key" => 8, "title" => "臺中市"],
			["key" => 9, "title" => "彰化縣"],
			["key" => 10, "title" => "南投縣"],
			["key" => 11, "title" => "雲林縣"],
			["key" => 12, "title" => "嘉義市"],
			["key" => 13, "title" => "嘉義縣"],
			["key" => 14, "title" => "臺南市"],
			["key" => 15, "title" => "高雄市"],
			["key" => 16, "title" => "屏東縣"],
			["key" => 17, "title" => "宜蘭縣"],
			["key" => 18, "title" => "花蓮縣"],
			["key" => 19, "title" => "臺東縣"],
			["key" => 20, "title" => "澎湖縣"],
			["key" => 21, "title" => "金門縣"],
			["key" => 22, "title" => "連江縣"],
		];
		return $array;
	}
	//連結開啟模式
	public static function targeturl($key = null)
	{
		$array = [
			["key" => 0, "title" => "直接開啟", "target" => '_self'],
			["key" => 1, "title" => "開新視窗", "target" => '_blank'],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}
	//是否
	public static function yesno($key = null)
	{
		$array = [
			["key" => 0, "title" => "否"],
			["key" => 1, "title" => "是"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//列表模式
	public static function Article_w_type($key = null)
	{
		$array = [
			["key" => 0, "title" => "橫式", "val" => "hori"],
			["key" => 1, "title" => "直式", "val" => "vert"],
			["key" => 2, "title" => "無圖模式", "val" => "default"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//表單狀態
	public static function from_state($key = null)
	{
		$array = [
			["key" => 0, "title" => ""],
			["key" => 1, "title" => "COMPLETE 測驗已完成"],
			["key" => 2, "title" => "UNDER REVIEW 重測審核中"],
			["key" => 3, "title" => "RETEST 重新測驗"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//學分申請狀態
	public static function credit_state($key = null)
	{
		$array = [
			["key" => 0, "title" => ""],
			["key" => 1, "title" => "未提交"],
			["key" => 2, "title" => "審核中"],
			["key" => 3, "title" => "審核通過"],
			["key" => 4, "title" => "審核未通過"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//帳號狀態
	public static function account_state($key = null)
	{
		$array = [
			["key" => 0, "title" => "正常"],
			["key" => 1, "title" => "停用"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//報名狀態
	public static function signup_state($key = null)
	{
		$array = [
			["key" => 0, "title" => "審核中"],
			["key" => 1, "title" => "報名成功"],
			["key" => 2, "title" => "審核未成功"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//活動編號
	public static function Seminar_signup_seminar_id($key = null)
	{
		$array = [
			["key" => 0, "title" => "選項1"],
			["key" => 1, "title" => "選項2"],
			["key" => 2, "title" => "選項2"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//報名狀態
	public static function Seminar_signup_w_state($key = null)
	{
		$array = [
			["key" => 0, "title" => "選項1"],
			["key" => 1, "title" => "選項2"],
			["key" => 2, "title" => "選項2"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//稱謂
	public static function sex($key = null)
	{
		$array = [
			["key" => 0, "title" => "男性"],
			["key" => 1, "title" => "女性"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}


	//飲食禁忌
	public static function food($key = null)
	{
		$array = [
			["key" => '葷食', "title" => "葷食"],
			["key" => '素食', "title" => "素食"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//文字位置
	public static function algin($key = null)
	{
		$array = [
			["key" => 0, "title" => "置左", "value" => "left"],
			["key" => 1, "title" => "置中", "value" => "center"],
			["key" => 2, "title" => "置右", "value" => "right"],
		];
		return ($key !== null) ? findkeyval($array, 'key', $key) : $array;
	}

	//radio_area
	public static function One_page_radio_area($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//select2
	public static function One_page_select2($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//select2Multi
	public static function One_page_select2Multi($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//radio_area
	public static function Datalist_radio_area($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//select2
	public static function Datalist_select2($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//select2Multi
	public static function Datalist_select2Multi($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項3"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//radio_area
	public static function Datalist_son_radio_area($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//select2
	public static function Datalist_son_select2($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//select2Multi
	public static function Datalist_son_select2Multi($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//radio_area
	public static function Datalist_three_radio_area($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//select2
	public static function Datalist_three_select2($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}

	//select2Multi
	public static function Datalist_three_select2Multi($key = null)
	{
		$array = [
			["key"=>0,"title"=>"選項1"],
			["key"=>1,"title"=>"選項2"],
			["key"=>2,"title"=>"選項2"],
		];
		return ($key !== null) ? findkeyval($array,'key',$key) : $array;
	}
	//table
    public static function One_page_table($key = null)
    {
        $setting = [
            "label"=>["標題"],
            "field"=>["a1"],
            "count"=>5,
        ];		
        return $setting;
    }
	//AddModelUp
}
