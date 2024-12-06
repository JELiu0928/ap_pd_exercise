<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use View;
use BaseFunction;
use App\Http\Controllers\OptionFunction;

class HomeController extends FrontBaseController
{
	public function __construct()
	{
		//sitemap過濾用 避免sitemap進入以下程式
		if(!parent::__construct()){
			//原本該單元需要做的事情
		}
	}
	public function index(Request $request)
	{
		return view(self::$blade_template.'.home.index', ['basic_seo' => Seo()]);
	}
	public function sub(Request $request)
	{
		return view(self::$blade_template.'.home.index', ['basic_seo' => Seo()]);
	}
}
