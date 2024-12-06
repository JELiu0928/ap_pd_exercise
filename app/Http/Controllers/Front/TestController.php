<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Basic\FantasyUsers;
use Exception;
use Illuminate\Http\Request;
use App\Models\Test\LockControll;
use App\Models\Test\ATest;
use DB;
use View;
use Illuminate\Support\Str;
use App\Services\LinePay\LinePay;
use App\Services\ECPay\ECPay;
use App\Models\Test\AForm;

class TestController
{
	public function __construct()
	{

    }
    public function test(Request $request)
	{
        dd(123);
    }
	public function lock(Request $request)
	{
        DB::transaction(function () {
            //被 lock 的資料會被鎖住，其他人無法讀取
            $lock = LockControll::lockForUpdate()->where('unit','cart')->first();
            $lock->is_lock = 1;
            $lock->save();

            sleep(5);

            $lock->is_lock = 0;
            $lock->save();
        });
        return "ok";
	}
    //測試 lock
    public function plus(Request $request)
	{
        $data = DB::transaction(function () {

            //等待上面釋放才會執行
            $lock = LockControll::lockForUpdate()->where('unit','cart')->first();
            if($lock->is_lock==0){
                $lock->is_lock = 1;
                $lock->save();
                sleep(2);
                $data = ATest::first();
                $data->num = $data->num + 1;
                $data->save();
                dump($data->num);
                $lock->is_lock = 0;
                $lock->save();
            }
            return $data;
        });
        dd($data);
        return "ok";
    }
    public function ECPay(Request $request)
	{

        $input = [
            'MerchantID' => '2000132',
            'MerchantTradeNo' => 'Test' . time(),
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType' => 'aio',
            'TotalAmount' => 100,
            'TradeDesc' => '交易描述範例',
            'ItemName' => '範例商品一批 100 TWD x 1',
            'ChoosePayment' => 'ALL',
            'EncryptType' => 1,

            // 請參考 example/Payment/GetCheckoutResponse.php 範例開發
            'ReturnURL' => 'https://www.ecpay.com.tw/example/receive',
        ];

        $pay = new ECPay();
        $pay->setPostData($input)
            ->createPayment();
        // echo $pay->res;
        dd($pay);
    }
    public function linePay(Request $request)
	{
        //訂單資料
        $data = [];
        $data['amount'] = 100;
        $data['currency'] = 'TWD';
        $data['orderId'] = 'wdd'.date('His');
        $data['packages'] = [];

        $packages = [];
        $packages['id'] = 1;
        $packages['amount'] = 100;
        $product = [];
        $product['name'] = '測試商品';
        $product['quantity'] = 1;
        $product['price'] = 100;
        $packages['products'][] = $product;
        $data['packages'][] = $packages;

        $data['redirectUrls'] = [];
        //同意授權後的導向畫面
        $data['redirectUrls']['confirmUrl'] = 'https://laravel919.wdd.idv.tw/tw/linePayCallBackConfirm';
        $data['redirectUrls']['cancelUrl'] = 'https://laravel919.wdd.idv.tw/tw/linePayCallBackCancel';
        //交易回傳若為 SERVER 無導向頁面，需回傳line 200
        // $data['redirectUrls']['confirmUrlType'] = 'SERVER';


        $json = json_encode($data);

        $line = new LinePay();
        $line->setPostData($json)
            ->createPayment();
        $data = $line->getRedirectPage();
        dd($data);

        return $response;
    }

    //使用者在Line介面付款成功後回傳 已授權 需再請款
    public function linePayCallBackConfirm(Request $request)
	{
        dd($request->all());
    }
    //使用者在Line介面付款失敗後回傳
    public function linePayCallBackCancel(Request $request)
	{
        dd($request->all());
    }

    //成立交易後 需請款
    public function linePayConfirm(Request $request)
	{
        //line訂單編號
        $transID = '2023110802036393010';
        //請款資料
        $data = [];
        $data['amount'] = 100;
        $data['currency'] = 'TWD';
        $json = json_encode($data);

        $line = new LinePay();
        $line->setPostData($json)
            ->setTransactionId($transID)
            ->confirmPayment();
        $data = $line->getRes();
        dd($data);
    }
    //查看請款狀態
    public function linePayCheck(Request $request)
	{
        //line訂單編號
        $transID = '2023102702032895010';

        $line = new LinePay();
        $line->setTransactionId($transID)
            ->checkPaymentStatus();
        $data = $line->getRes();
        dd($data);
    }
    //查看訂單內容
    public function linePayDetail(Request $request)
	{
        $queryStr = 'transactionId=2023102502032063510&transactionId=2023102502032061710&transactionId=2023102702032895010';

        $line = new LinePay();
        $line->setGetData($queryStr)
            ->selectPayment();
        $data = $line->getRes();
        dd($data);
    }
    //退款
    public function linePayRefund(Request $request)
	{
        //部分退款
        $data = [];
        $data['refundAmount'] = 10;
        $json = json_encode($data);

        $transID = '2023102702032708710';

        $line = new LinePay();
        $line
            // ->setPostData($json)
            ->setTransactionId($transID)
            ->refundPayment();
        $data = $line->getRes();
        dd($data);
    }

    public function testTable(Request $request)
	{
        $formID = $request['formID'];
        //AFormHead 第1層表頭  AFormHeadSub 第2層表頭
        //AFormData 表格列資料 AFormMiddleSingle 儲存格資料(1層表頭) AFormMiddleDouble 儲存格資料(2層表頭)
        $formData = AForm::where('id',$formID)->with('AFormHead.AFormHeadSub','AData.AFormMiddleSingle','AData.AFormMiddleDouble')->first();

        $colDef = [];
        $rowData = [];

        $colDef[] = [
            'headerName' => 'id',
            'field' => 'dataID',
            'hide' => true,
            'pinned' => 'left',
            'editable' => false,
            'width' => 200
        ];

        switch ($formData['head_type']) {
            case AForm::HeadSingle:
                $colDef[] = [
                    'headerName' => $formData['first_col'],
                    'headerTooltip' => $formData['first_col'],
                    'field' => 'first_col',
                    'pinned' => 'left',
                    'editable' => false,
                    'width' => 200,
                ];
                //單層表頭
                foreach($formData['AFormHead'] as $key => $head){
                    $colDef[$key + 2] = [
                        'headerName' => $head['title'],
                        'headerTooltip' => $head['title'],
                        'field' => $head['id'].'.val',
                    ];
                    if($formData['cell_type'] == AForm::CellCheckBox){
                        $colDef[$key + 2]['field'] = $head['id'].'.checked';
                        $colDef[$key + 2]['cellRenderer'] = 'checkboxRenderer'; //Checkbox的自定義事件
                        $colDef[$key + 2]['cellClass'] = 'checkbox-css'; //自訂義class
                    }
                }

                foreach($formData['AData'] as $key => $val){
                    $temp = [
                        'dataID' => $val['id'],
                        'first_col' => $val['title']
                    ];
                    foreach($formData['AFormHead'] as $key2 => $head){
                        $temp[$head['id']] = [
                            'head_id' => $head['id'],
                            'data_id' => $val['id'],
                        ];
                        if($formData['cell_type'] == AForm::CellCheckBox){
                            $temp[$head['id']]['checked'] = 0;
                        }
                        else{
                            $temp[$head['id']]['val'] = '';
                        }
                    }
                    foreach($val['AFormMiddleSingle'] as $key2 => $formVal){
                        if(isset($temp[$formVal['head_id']])){

                            $temp[$formVal['head_id']] = [
                                'val' => $formVal['title'],
                                'head_id' => $formVal['head_id'],
                                'data_id' => $val['id']
                            ];

                            if($formData['cell_type'] == AForm::CellCheckBox){
                                $temp[$formVal['head_id']] = [
                                    'checked' => $formVal['title']==1 ? 1 : 0,
                                    'head_id' => $formVal['head_id'],
                                    'data_id' => $val['id']
                                ];
                            }
                        }
                    }
                    $rowData[] = $temp;
                }
                break;
            case AForm::HeadDouble:
                $colDef[] = [
                    'headerName' => $formData['first_col'],
                    'headerTooltip' => $formData['first_col'],
                    'children' => [
                        [
                            'headerName' => '',
                            'field' => 'first_col',
                            'pinned' => 'left',
                            'editable' => false,
                            'width' => 200,
                        ]
                    ],
                ];
                //雙層表頭
                foreach($formData['AFormHead'] as $key => $head){
                    $colDef[$key + 2] = [
                        'headerName' => $head['title'],
                        'headerTooltip' => $head['title'],
                        'children' => [],
                    ];
                    foreach($head['AFormHeadSub'] as $key2 => $headSub){
                        $colDef[$key + 2]['children'][$key2] = [
                            'headerName' => $headSub['title'],
                            'headerTooltip' => $headSub['title'],
                            'field' => $headSub['id'].'.val',
                            'columnGroupShow' => 'open',
                        ];
                        if($formData['cell_type'] == AForm::CellCheckBox ){
                            $colDef[$key + 2]['children'][$key2]['field'] = $headSub['id'].'.checked';
                            $colDef[$key + 2]['children'][$key2]['cellRenderer'] = 'checkboxRenderer';
                            $colDef[$key + 2]['children'][$key2]['cellClass'] = 'checkbox-css';
                        }
                    }
                }

                foreach($formData['AData'] as $key => $val){
                    $temp = [
                        'dataID' => $val['id'],
                        'first_col' => $val['title']
                    ];
                    foreach($formData['AFormHead'] as $key2 => $head){
                        foreach($head['AFormHeadSub'] as $key3 => $headSub){
                            $temp[$headSub['id']] = [
                                'head_id' => $headSub['id'],
                                'data_id' => $val['id'],
                            ];
                            if($formData['cell_type'] == AForm::CellCheckBox){
                                $temp[$headSub['id']]['checked'] = 0;
                            }
                            else{
                                $temp[$headSub['id']]['val'] = '';
                            }
                        }
                    }
                    foreach($val['AFormMiddleDouble'] as $key2 => $formVal){
                        if(isset($temp[$formVal['head_sub_id']])){

                            $temp[$formVal['head_sub_id']] = [
                                'val' => $formVal['title'],
                                'head_id' => $formVal['head_sub_id'],
                                'data_id' => $val['id']
                            ];

                            if($formData['cell_type'] == AForm::CellCheckBox ){
                                $temp[$formVal['head_sub_id']] = [
                                    'checked' => $formVal['title']==1 ? 1 : 0,
                                    'head_id' => $formVal['head_sub_id'],
                                    'data_id' => $val['id']
                                ];
                            }
                        }
                    }
                    $rowData[] = $temp;
                }

                break;

            default:
                # code...
                break;
        }

        $colDef = json_encode($colDef, JSON_UNESCAPED_UNICODE);
        $rowData = json_encode($rowData, JSON_UNESCAPED_UNICODE);

        $res = [];
        $res['view'] = view('aggridBase', [
            'colDef' => $colDef,
            'rowData' => $rowData,
            'cell_type' => $formData['cell_type'],
            'modelName' => 'AForm',
            'formID' => $formID,
        ])->render();
        return $res;
    }
    public function testTableSave(Request $request)
	{
        $req = $request->all();

        $model = config('models.'.$req['model']);
        $form = $model::where('id',$req['formID'])->first();

        $headType = $form['head_type'];

        $updata = [];
        foreach($req['data'] as $rowNode){
            unset($rowNode['dataID']);
            unset($rowNode['first_col']);
            foreach($rowNode as $colNode){
                if($headType == AForm::HeadSingle){
                    $updata[] =[
                        'head_id' => $colNode['head_id'],
                        'data_id' => $colNode['data_id'],
                        'title' => $form['cell_type'] == AForm::CellCheckBox ? $colNode['checked'] : $colNode['val'],
                    ];
                }
                if($headType == AForm::HeadDouble){
                    $updata[] =[
                        'head_sub_id' => $colNode['head_id'],
                        'data_id' => $colNode['data_id'],
                        'title' => $form['cell_type'] == AForm::CellCheckBox ? $colNode['checked'] : $colNode['val'],
                    ];
                }
            }
        }

        $table = $headType == AForm::HeadSingle ? 'a_form_middle_single' : 'a_form_middle_double';


        DB::table($table)->upsert($updata,null);
        return '';

        // DB::transaction(function ()use($table,$updata) {

                // DB::table($table)->delete();
                // DB::table($table)->upsert($updata,null);
                // DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1");
                // DB::table($table)->insert(['id'=>1,'data_id'=>1,'head_sub_id'=>1,'title'=>2]);
                // DB::table($table)->insert(['id'=>1,'data_id'=>1,'head_sub_id'=>1,'title'=>2]);


            // DB::table($table)->upsert($updata,null);
        // });
        // return '';
    }
}
