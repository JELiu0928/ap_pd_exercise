<?php

namespace App\Services\LinePay;

use App\Interface\Transaction;

class LinePay implements Transaction
{
    //https://pay.line.me/portal/tw/auth/login  test_202310254646   Y5)662c49N
    private static $linePayID = '2001317344';
    private static $linePaySecret = '5a9cbd3f836fd596dd2f9dd96cf6d792';
    private static $linePayUrl_Test = 'https://sandbox-api-pay.line.me'; //測試區
    private static $linePayUrl_Online = 'https://api-pay.line.me';  //正式區

    public function __construct(bool $isTest = true)
    {
        $this->linePayUrl = $isTest ? self::$linePayUrl_Test : self::$linePayUrl_Online;
        // init 由postman產生 大部分都需要，否則會被linepay擋
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_ENCODING, '');
        curl_setopt($this->curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

        //一次性戳 必要
        $this->nonce = strtotime('now');
        //get query
        $this->query = '';
        //post params
        $this->json = '';
    }

    //建立連線
    public function connect(){
        $this->encrypt();

        $response = curl_exec($this->curl);
        curl_close($this->curl);

        $this->res = $response;
        return $this;
    }

    //建立交易 linePay中為授權 需再進行請款
    public function createPayment(){
        $this->setUri('/v3/payments/request')
            ->setMethod('POST')
            ->connect();
        return $this;
    }

    //取得交易頁面 line有分電腦版手機版
    public function getRedirectPage(){
        $res = json_decode($this->res,true);
        $data = [];
        if($res['returnCode']=='0000'){
            $data['status'] = true;
            $data['pageUrl'] = $res['info']['paymentUrl'];
        }
        else{
            $data['status'] = false;
            $data['returnCode'] = $res['returnCode'];
            $data['returnMessage'] = $res['returnMessage'];
        }
        return $data;
    }
    //請款
    public function confirmPayment(){
        $this->setUri('/v3/payments/'.$this->transactionId.'/confirm')
            ->setMethod('POST')
            ->connect();
        return $this;
    }

    //退款
    public function refundPayment(){
        $this->setUri('/v3/payments/'.$this->transactionId.'/refund')
            ->setMethod('POST')
            ->connect();
        return $this;
    }

    //查詢授權狀態
    public function checkPaymentStatus(){
        $this->setUri('/v3/payments/requests/'.$this->transactionId.'/check')
            ->setMethod('GET')
            ->connect();
        return $this;
    }

    //查詢查詢訂單
    public function selectPayment(){
        $this->setUri('/v3/payments')
            ->setMethod('GET')
            ->connect();
        return $this;
    }


    public function setUri(string $uri=''){
        $this->uri = $uri;
        curl_setopt($this->curl, CURLOPT_URL, $this->linePayUrl.$uri );
        return $this;
    }

    public function setMethod(string $method='get'){
        $this->method = $method;
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);
        return $this;
    }

    public function setHeaders(array $headers){
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers );
        return $this;
    }

    public function setPostData(string $json){
        $this->json = $json;
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $json);
        return $this;
    }

    public function setGetData(string $query){
        $this->query = $query;
        return $this;
    }

    public function setTransactionId(string $transactionId){
        $this->transactionId = $transactionId;
        return $this;
    }

    public function getRes(){
        return json_decode($this->res,true);
    }

    //字串加密以符合linepay的需求
    public function encrypt(){
        $bodyStr = '';
        if( strtolower($this->method) == 'get' ){
            $bodyStr = $this->query;
            curl_setopt($this->curl, CURLOPT_URL, $this->linePayUrl.$this->uri.'?'.$this->query);
        }
        if( strtolower($this->method) == 'post' ) $bodyStr = $this->json;

        $encryptStr = self::$linePaySecret.$this->uri.$bodyStr.$this->nonce;
        //hash_hmac第四個參數必須加上true才會通過linepay檢查
        $this->encrypt = base64_encode(hash_hmac('sha256', $encryptStr , self::$linePaySecret,true));

        $headers = [];
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'X-LINE-ChannelId: '.self::$linePayID;
        $headers[] = 'X-LINE-Authorization-Nonce: '.$this->nonce;
        $headers[] = 'X-LINE-Authorization: '.$this->encrypt;

        $this->setHeaders($headers);
    }
}
