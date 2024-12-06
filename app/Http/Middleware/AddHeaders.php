<?php

namespace App\Http\Middleware;

use Closure;
use Request;
use View;

class AddHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //忽略後台
        // if (strpos(Request::getRequestUri(), 'auth/login') !== false || strpos(Request::getRequestUri(), 'Fantasy') !== false) {
        //     return $next($request);
        // }

        //如自己專案有檔案無法載入則可以加入例外網域(以[空格]間隔[;]結尾) 如下 font-src、style-src
        // header("Content-Security-Policy: default-src 'none'; connect-src 'self' https:; base-uri 'none'; form-action 'self'; font-src 'self' https://fonts.gstatic.com data:; frame-ancestors 'none'; script-src 'self' blob: 'unsafe-eval' https://www.youtube.com 'nonce-". $this->getNonceRandomBase64() ."' 'strict-dynamic'; img-src 'self' data:; style-src 'self' https://fonts.googleapis.com 'unsafe-inline'; frame-src 'self' https://www.youtube.com;");

        //script-src 'unsafe-inline'扣分解決辦法
        //使用後專案所有<script>需要加上nonce參數，如:<script nonce="..." src="..."></script>
        //header("Content-Security-Policy: default-src 'none'; connect-src 'self' https:; base-uri 'none'; form-action 'self'; font-src 'self' data:; frame-ancestors 'none'; img-src 'self' data:; script-src 'self' blob: 'unsafe-eval' https://www.youtube.com  'nonce-". $this->getNonceRandomBase64() . "'; style-src 'self' 'unsafe-inline'; frame-src 'self' https://www.youtube.com/");

        $script['default-src'] = "'none'";
        $script['base-uri'] = "'self'";
        //設定頁面允許哪些 script 來源
        $script['script-src'] = "'self' blob: https://code.jquery.com https://cdnjs.cloudflare.com https://cdn.wdd.idv.tw/ https://www.googletagmanager.com http://www.google-analytics.com blob: 'unsafe-eval' https://www.youtube.com 'unsafe-inline' https://netdna.bootstrapcdn.com https://connect.facebook.net";
        //設定允許哪些網址內容的嵌入
        $script['child-src'] = "'self' data: blob: https://www.youtube.com/ https://www.google.com/ https://player.youku.com/ https://valc.atm.youku.com/";
        $script['frame-src'] = "'self' data: blob: https://www.youtube.com/ https://www.google.com/ https://player.youku.com/ https://valc.atm.youku.com/";
        //設定允許 XHR, Fetch, Websockets 等連接的對象
        $script['connect-src'] = "'self' https:";
        //設定允許的字型網址來源
        $script['font-src'] = "'self' data: https://fonts.gstatic.com https://netdna.bootstrapcdn.com";
        //設定允許的圖片網址來源
        $script['img-src'] = "'self' data: https://img.youtube.com https://www.facebook.com https://wddtest20231228.s3.ap-northeast-1.amazonaws.com";
        //設定允許的<audio> 和<video>使用的網址
        $script['media-src'] = '';
        //設定允許的<object>, <embed> 和<applet>使用的網址
        $script['object-src'] = '';
        //設定允許的樣式來源
        $script['style-src'] = "'self' 'unsafe-inline' https://cdn.wdd.idv.tw/ https://fonts.googleapis.com  http://netdna.bootstrapcdn.com";
        //設定頁面允許被哪些網址用 <frame>, <iframe>, <object>, <embed>嵌入
        $script['frame-ancestors'] = "'none'";
        //設定表單允許跟哪些網路服務互動
        $script['form-action'] = "'self' https://payment-stage.ecpay.com.tw https://ccore.newebpay.com";
        //強制使用 https
        $script['upgrade-insecure-requests'] = '';
        //使用 report 模式，若偵測到一些惡意攻擊會將資料回傳到某個網址
        $script['report-uri'] = '';

        $Content_Security_Policy = str_replace('=', ' ', urldecode(htmlspecialchars(http_build_query(array_filter($script), '', '; '))));

        header("Content-Security-Policy: " . $Content_Security_Policy);

        header("Referrer-Policy: no-referrer");

        header("Strict-Transport-Security: max-age=315360000; includeSubDomains");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header('X-XSS-Protection: 1; mode=block');

        // 避免$nonce報未定義的錯
        $this->getNonceRandomBase64();

        return $next($request);
    }

    private function getNonceRandomBase64()
    {
        return tap(base64_encode(rand(0, 9999999999999)), function ($base64) {
            View::Share('nonce', $base64);
        });
    }
}
