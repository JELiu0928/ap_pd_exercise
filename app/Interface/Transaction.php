<?php

namespace App\Interface;

interface Transaction
{
    //建立連線
    public function connect();

    //建立交易
    public function createPayment();

    //取得交易頁面
    public function getRedirectPage();

    //請款
    public function confirmPayment();

    //退款
    public function refundPayment();

    //查詢授權狀態
    public function checkPaymentStatus();

    //查詢訂單
    public function selectPayment();
}
