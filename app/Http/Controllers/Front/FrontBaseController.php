<?php

namespace App\Http\Controllers\Front;

/**原生函式**/

use App\Http\Controllers\Controller;
use BaseFunction;
use Config;
use Redirect;
use Route;
use Session;

/**相關Controller**/

use View;

/**相關Service**/

class FrontBaseController extends Controller
{

    protected static $is_pre;
    protected static $branch;
    protected static $branch_id;
    protected static $blade_template;
    protected static $branch_origin;
    protected static $locale;
    protected static $brand_set;

    //會員資料
    protected static $memberUser = [];
    //會員ID
    protected static $memberSession = 0;
    //隨機碼 購物車用
    protected static $cartRandSession = '';

    public function __construct()
    {
        //sitemap過濾用 避免sitemap進入以下程式
        if(Route::current()->uri() == 'newSiteMap'){
            return true;
        }
        $subdomain = Route::current()->parameter('subdomain');
        $domain = explode(".", str_replace(["www."], "", Route::current()->parameter('branch')))[0];
        $subdomainORlocale = Route::current()->parameter('branch_url');
        $locale = Route::current()->parameter('locale');
        if(empty($locale)){
            $locale = $subdomainORlocale;
            $subdomainORlocale = $domain;
        }
        self::$is_pre = strpos($locale, 'preview_') !== false ? 1 : 0;
        $locale = str_replace('preview_', '', $locale);
        $subdomain = (empty($subdomain)) ? $subdomainORlocale ?: $domain : $subdomain;
        self::$branch = $subdomain;

        self::$branch_origin = M('BranchOrigin')::where(function ($q) use ($subdomain) {
            $q->where('url_title', $subdomain)->orwhere('url_title', 'www.' . $subdomain);
        })->wherehas('BranchOriginUnit', function ($q) use ($locale) {
            $q->where('locale', $locale);
        })->first();

        if (empty(self::$branch_origin)) {
            return Redirect::to('404')->send();
        }
        self::$branch_id = self::$branch_origin->id;
        //分站模板
        self::$blade_template = collect(Config::get('cms.blade_template'))->where('key', self::$branch_origin->blade_template)->first()['blade_folder'];
        //預覽站
        Config::set('custom.isPreview', self::$is_pre);
        View::share('isPreview', self::$is_pre);

        // 預覽站非會員登出
        if (!Session::has('fantasy_user') && self::$is_pre) {
            redirect(url('/'. $locale))->send();
        }
        app()->setLocale($locale);
        self::$locale = $locale;
        /*補上資料庫語系前綴*/
        if (isset($locale) and !empty($locale)) {
            Config::set('app.dataBasePrefix', '' . $locale . '_');
            Config::set('blade_template', self::$blade_template);
            Config::set('branch_origin_all', M('BranchOrigin')::all());
            View::share('baseLocale', $locale);
        }
    }

    public function randomDate($begintime, $endtime = "")
    {
        $begin = strtotime($begintime);
        $end = $endtime == "" ? mktime() : strtotime($endtime);
        $timestamp = rand($begin, $end);

        return date("Y-m-d H:i:s", $timestamp);
    }

    public static function replaceSeo($ori, $rev, $parent = [])
    {

        if (!empty($rev['web_title'])) {
            $ori['web_title'] = $rev['web_title'];
        }

        if (!empty($rev['meta_keyword'])) {
            $ori['meta_keyword'] = $rev['meta_keyword'];
        }

        if (!empty($rev['meta_description'])) {
            $ori['meta_description'] = $rev['meta_description'];
        }

        if (!empty($rev['og_title'])) {
            $ori['og_title'] = $rev['og_title'];
        }

        if (!empty($rev['og_image'])) {
            $ori['og_image'] = $rev['og_image'];
        }

        if (!empty($rev['og_description'])) {
            $ori['og_description'] = $rev['og_description'];
        }

        if (!empty($rev['ga_code'])) {
            $ori['ga_code'] = $rev['ga_code'];
        }

        if (!empty($rev['gtm_code'])) {
            $ori['gtm_code'] = $rev['gtm_code'];
        }

        if (!empty($rev['fb_code'])) {
            $ori['fb_code'] = $rev['fb_code'];
        }

        if (!empty($rev['structured'])) {
            $ori['structured'] = $rev['structured'];
        }

        return $ori;
    }
}
