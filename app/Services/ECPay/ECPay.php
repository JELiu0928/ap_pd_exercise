<?php

namespace App\Services\ECPay;

use App\Interface\Transaction;

use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;

class ECPay implements Transaction
{
    //測試
    private static $ecPayKey_Test = '5294y06JbISpM5x9';
    private static $ecPayIv_Test = 'v77hoKGq4kWxNNIS';
    //正式
    private static $ecPayKey_Online = '5294y06JbISpM5x9';
    private static $ecPayIv_Online = 'v77hoKGq4kWxNNIS';
    //交易網址
    private static $ecPayUrl_Test = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5'; //測試區
    private static $ecPayUrl_Online = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5'; //測試區

    public function __construct(bool $isTest = true)
    {
        self::setFactory($isTest);
        $this->ecPayUrl = $isTest ? self::$ecPayUrl_Test : self::$ecPayUrl_Online;
    }
    //建立連線
    public function connect(){
        $autoSubmitFormService = $this->factory->create('AutoSubmitFormWithCmvService');
        $action = $this->ecPayUrl;
        $this->res = $autoSubmitFormService->generate($this->params, $action);
        // echo $autoSubmitFormService->generate($input, $action);
    }

    //建立交易
    public function createPayment(){
        $this->connect();
        return $this;
    }

    //取得交易頁面
    public function getRedirectPage(){
        return $this->res;
    }

    //請款
    public function confirmPayment(){}

    //退款
    public function refundPayment(){}

    //查詢授權狀態
    public function checkPaymentStatus(){}

    //查詢訂單
    public function selectPayment(){}

    public function setPostData(array $params){
        // $input = [
        //     'MerchantID' => '2000132',
        //     'MerchantTradeNo' => 'Test' . time(),
        //     'MerchantTradeDate' => date('Y/m/d H:i:s'),
        //     'PaymentType' => 'aio',
        //     'TotalAmount' => 100,
        //     'TradeDesc' => UrlService::ecpayUrlEncode('交易描述範例'),
        //     'ItemName' => '範例商品一批 100 TWD x 1',
        //     'ChoosePayment' => 'ALL',
        //     'EncryptType' => 1,

        //     // 請參考 example/Payment/GetCheckoutResponse.php 範例開發
        //     'ReturnURL' => 'https://www.ecpay.com.tw/example/receive',
        // ];

        if(isset($params['TradeDesc'])) $params['TradeDesc'] = UrlService::ecpayUrlEncode($params['TradeDesc']);
        $this->params = $params;

        return $this;
    }

    public function setFactory($isTest){
        if($isTest){
            $this->factory = new Factory([
                'hashKey' => self::$ecPayKey_Test,
                'hashIv' => self::$ecPayIv_Test,
            ]);
        }
        else{
            $this->factory = new Factory([
                'hashKey' => self::$ecPayKey_Online,
                'hashIv' => self::$ecPayIv_Online,
            ]);
        }
    }
}
