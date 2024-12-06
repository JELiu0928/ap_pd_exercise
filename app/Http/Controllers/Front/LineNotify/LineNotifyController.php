<?php

namespace App\Http\Controllers\Front\LineNotify;


use App\Http\Controllers\Front\FrontBaseController;
use App\Services\LineNotify\LineNotify;
use Http;
use Illuminate\Http\Request;
use View;
use BaseFunction;

class LineNotifyController extends FrontBaseController
{

	// line notify需要事先到官網去註冊 : https://notify-bot.line.me/zh_TW/
	// line API文件 : https://notify-bot.line.me/doc/en/
	private static $client_id = ''; // Client ID (需先在官網註冊取得)
	private static $client_secret = ''; // Client Secret (需先在官網註冊取得)
	private static $redirect_uri = 'https://laravel11.wdd.idv.tw/tw/linenotify/getToken'; // Callback URL (需先在官網綁定)
	private static $notify;

	public function __construct()
	{
		parent::__construct();
		self::$notify = new LineNotify(
			self::$client_id,
			self::$client_secret,
			self::$redirect_uri
		);
	}
	public function index()
	{	
		// 步驟一 : 跳轉去line notify頁面進行連動
		return redirect(self::$notify->requestLineNotify());
	}

	public function getToken(Request $request)
	{
		$code = $request->code;
		$state = $request->state;

		// 步驟二 : 連動完取得Token以及發訊息的API網址
		// 取得token API網址,可以參閱API文件 搜尋=> https://notify-bot.line.me/oauth/token
		
		return self::$notify->responseToken($code,$state);
	}

	public function sendMessage(Request $request)
	{
		$message = $request->message;
		$imageFullsize = $request->imageFullsize;
		$imageThumbnail = $request->imageThumbnail;
		$access_token = $request->access_token;
		
		// 步驟三 : 發送訊息或是圖片
		// 發訊息的API網址,可以參閱API文件 搜尋=> https://notify-api.line.me/api/notify

		// access_token(必須)
		// message(要發送的訊息)
		// imageFullsize & imageThumbnail(要發送的圖片,必須是網址)
		return self::$notify->sendLineNotifymessage($access_token,$message,$imageFullsize,$imageThumbnail);
	}

	public function status(Request $request)
	{	
		// 步驟四(非必要) : 查看目前API使用次數等等
		// 發訊息的API網址,可以參閱API文件 搜尋=> https://notify-api.line.me/api/status

		$access_token = $request->access_token;
		return self::$notify->checkLineNotifystatus($access_token);
	}

}
