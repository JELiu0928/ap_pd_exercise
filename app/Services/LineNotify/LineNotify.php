<?php

namespace App\Services\LineNotify;
use App\Http\Controllers\BaseFunctions;
use Http;

class LineNotify
{
    private $client_id;
    private $client_secret;
    private $redirect_uri;
    private $code;
    private $state;
    
    protected $access_token;

    public function __construct(string $client_id,string $client_secret,string $redirect_uri)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->redirect_uri = $redirect_uri;
    }

    public function responseToken(string $code,string $state)
	{
		$response = Http::asForm()
		->post('https://notify-bot.line.me/oauth/token',[
			'code' => $code,
			'state' => $state,
			'grant_type' => 'authorization_code',
			'client_id' => $this->client_id,
			'client_secret' => $this->client_secret,
			'redirect_uri'=> $this->redirect_uri,
		])->json();

        if($response['status']==200)
        {
            $this->access_token = $response['access_token'];

            
            $url_send = BaseFunctions::b_url('linenotify/sendMessage');
            $url_status = $url_send.= "?access_token=".$this->access_token;
            $url_send .= "&message={要傳送的訊息}";
            
            return response()->json([
                'status'=>$response['status'],
                'SendMessage ULI'=> $url_send,
                'CheckStatus ULI'=> $url_status,
            ]);
        }else{
            return response()->json([
                'Fail : '=>$response,
            ]);
        }
	}

    public function requestLineNotify()
    {
        $csrf = csrf_token();
        $request_url = "https://notify-bot.line.me/oauth/authorize?";
        $request_url .= "&response_type=code";
        $request_url .= "&scope=notify";
        $request_url .= "&client_id=".$this->client_id;
        $request_url .= "&client_secret=".$this->client_secret;
        $request_url .= "&redirect_uri=".$this->redirect_uri;
        // $request_url .= "&response_mode=form_post";
        $request_url .= "&state=".$csrf;

        return $request_url;
    }
    public function sendLineNotifymessage($access_token,$message,$imageFullsize,$imageThumbnail)
    {

        $data = [
            'message'=>$message,
            'imageFullsize'=>$imageFullsize,
            'imageThumbnail'=>$imageThumbnail,
        ];


        $response = Http::withHeaders([
			'content-type'=>'application/x-www-form-urlencoded',
			'Authorization'=>'Bearer '.$access_token,
		])->asForm()
        ->post('https://notify-api.line.me/api/notify',$data)
        ->json();

        return $response;
    }
    
    public function checkLineNotifystatus($access_token)
    {
        $response = Http::withHeaders([
			'Authorization'=>'Bearer '.$access_token,
		])
        ->asForm()
        ->get('https://notify-api.line.me/api/status');
        
        $header = [];
        foreach($response->headers() as $key => $value)
        {
            
            if( count(explode("-",$key))>1 && explode("-",$key)[1] == "RateLimit")
            {
                $header[$key] = $value;
            }
        };

        return response()->json([
            'API Status'=>$response->json(),
            'API Limit'=>$header,
        ]);
    }
    
}