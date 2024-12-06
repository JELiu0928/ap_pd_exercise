<?php

namespace App\Http\Controllers\Fantasy;

use Illuminate\Http\Request;
use Route;
use Config;

class SitemapController
{
    //此方法目前只適用一般情況路由
    //無分館 domain.com/{locale}
    //有分館 domain.com/{branch_url}/{locale}
    //變數位置中間不可夾雜固定節點 如 /product/{cate}/detail/{id} 必續要是 /product/{cate}/{id}

    // sitemap 變數名稱 , param 要取代的網址變數 , col 該筆資料要做網址的欄位 , model 資料來源 , pk 主鍵 , with 子資料來源 , fk 外鍵
    // ->defaults(
    //     'sitemap', 
    //     ['param'=>'{class}','col'=>'url_name','model'=>'Datalist', 'pk'=>'id','with'=>
    //         ['fk'=>'parent_id','param'=>'{two}','col'=>'img_row','model'=>'Datalist_content', 'pk'=>'id', 'with'=>
    //             ['fk'=>'second_id','param'=>'{three}','col'=>'image','model'=>'Datalist_content_img', 'pk'=>'id']
    //         ],
    //     ]);     

    private static $is_reviewed = false;
    private static $scoreArr = [
        1 => 1,
        2 => 0.8,
        3 => 0.7,
        4 => 0.6,
        5 => 0.4,
    ];

    public function __construct()
    {} 
    public function generate(Request $request)
    {        
        //找出所有路由檔案
        $all_route_file = scandir(base_path('routes'));
        foreach($all_route_file as $k => $v){
            if(stripos($v,"routes")===false) unset($all_route_file[$k]);
        }
        //加載
        foreach($all_route_file as $val){
            Route::middleware('web')->namespace('App\Http\Controllers')->group(base_path('routes/' . $val));
        }

        //以下四個陣列自定義
        //排除 uri內有包含字串
        $excludeStrArr = ['leon','_debugbar','ajax','Ajax','api','auth','sanctum','captcha','cleared','autositemapMain','autositemapSub','autositemap','download','Fantasy']; //_debugbar debug模式的路由
        //包含 uri內需有以下任意字串
        $includeStrArr = ['{locale}','{branch_url}'];
        
        //排除 路由有以下中介層
        $excludeMiddleArr = ['auth'];
        //包含 路由需有以下任意中介層
        $includeMiddleArr = ['web'];

        //本專案語系
        // $langArr = array_keys(config('cms.langArray'));
        
        //所有路由
        $routes = Route::getRoutes();
        $routesRecord = [];
        foreach($routes as $key => $route){
            //取得該路由中介層
            $_middle = $route->gatherMiddleware();
            //內容會包含字串、物件，排除非字串內容
            foreach($_middle as $km => $vm){
                if(!is_string($vm)) unset($_middle[$km]);
            }

            //該路由uri節點
            $_uriStrArr = explode('/',$route->uri());
            
            //過濾不需要的路由
            if(!empty(array_intersect($_uriStrArr,$excludeStrArr))){
                continue;
            }
            if(empty(array_intersect($_uriStrArr,$includeStrArr))){
                continue;
            }
            if(!empty(array_intersect($_middle,$excludeMiddleArr))){
                continue;
            }
            if(empty(array_intersect($_middle,$includeMiddleArr))){
                continue;
            }
            
            $routesRecord[implode('/',$_uriStrArr)] = [
                'nodeCount' => count($_uriStrArr),
                'modelSet'=>$route->defaults['sitemap'] ?? [],
                // 'pr'=>1,
                // 'paths'=>[]
            ];
        }
       
        //自定義 刪除不需要路由 C__C
        unset($routesRecord['/']);
        unset($routesRecord['{locale}/search/{keyword?}']);

        //排序
        uasort($routesRecord,function($a,$b){
            return $a['nodeCount'] <=> $b['nodeCount'];
        });
        // dump($routesRecord);

        $newRoutesRecord = [];
        //分站資料 根據各專案需求調整撈資料判斷 C__C
        $branchOrigin = M('BranchOrigin')::where('blade_template','>',0)
            ->wherehas('BranchOriginUnit',function($q){
                $q->where('is_active',1);
            })
            ->with(['BranchOriginUnit' => function($q){
                $q->where('is_active',1);
            }])
            ->get();
        
        foreach($routesRecord as $routePath => $routeData){
            $uriStrArr = explode('/',$routePath);
            $modelSet = $routeData['modelSet'];

            foreach($branchOrigin as $branch){
                //分站
                foreach($branch['BranchOriginUnit'] as $branchLocale){
                    //語系
                    $lang = $branchLocale['locale'];
                    //設定資料庫語系前字綴
                    Config::set('app.dataBasePrefix',$lang.'_');
                    //是否要審核
                    self::$is_reviewed = (config('cms.reviewfunction') && in_array($lang, json_decode($branch->local_review_set) ?: [])) ? true : false;
                    //分站 branch_url在第一個位置
                    if($uriStrArr[0] == '{branch_url}'){
                        if($branch['blade_template']==1) continue;
                        $_routePath = str_replace('{branch_url}', $branch['url_title'], $routePath);

                        if(isset($uriStrArr[1]) && $uriStrArr[1] == '{locale}'){
                            $_routePath = str_replace('{locale}', $lang, $_routePath);
                        }
                    }

                    //主站 locale 在第一個位置
                    if($uriStrArr[0] == '{locale}'){
                        if($branch['blade_template']>1) continue;
                        $_routePath = str_replace('{locale}', $lang, $routePath);
                    }
                    
                    //計算分數
                    $_tempRoutePath = preg_replace('/\{[^}]*\}/', '', $routePath);
                    $_tempRoutePath = rtrim($_tempRoutePath, '/');
                    $nodeCount = count(explode('/',$_tempRoutePath));
                    $score = self::$scoreArr[$nodeCount];
                    
                    //路由如有設定資料
                    if(!empty($modelSet)){
                        $datas = M($modelSet['model'])::where('is_visible',1)->select('id',$modelSet['col'])->get();
                        foreach($datas as $data){
                            if(empty($data[$modelSet['col']])) continue;

                            $tempRoutePath = $_routePath;
                            $tempRoutePath = str_replace($modelSet['param'], $data[$modelSet['col']], $tempRoutePath);

                            if(isset($modelSet['with']) && !empty($modelSet['with'])){
                                self::subModel($newRoutesRecord, $tempRoutePath, $data, $modelSet,$score);
                            }
                            else $newRoutesRecord[$tempRoutePath] = $score;
                        }
                    }
                    else{
                        $newRoutesRecord[$_routePath] = $score;
                    }
                }
            }
        }

        // dump($newRoutesRecord);

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

        $host = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'].'/';

        foreach ($newRoutesRecord as $url => $score) {
            $url = preg_replace('/\{[^}]*\}/', '', $url);
            $url = rtrim($url, '/');
            $uriArr = explode('?', $url);
            if(count($uriArr) == 1){
                $urlNode = $xml->addChild('url');
                $urlNode->addChild('loc', $host.$url);
                $urlNode->addChild('changefreq', 'daily');
                $urlNode->addChild('priority', $score);
            }else{
                echo $url . ' 未設定<br>';
            }
        }
        
        $xml->asXML(public_path('sitemap.xml'));

        return 'done';
    }

    public static function subModel(&$routesRecord, $routePath, $parentData, $modelSet,$score)
    {
        $score -= 0.1;
        $sonSet = $modelSet['with'];
        $datas = M($sonSet['model'])::select('id',$sonSet['col'])
            ->when(self::$is_reviewed, function($q){
                //第二第三層需於資料表預設為1
                $q->where('is_reviewed',1);
            })
            ->where('is_visible',1)
            ->where($sonSet['fk'], $parentData[$modelSet['pk']])
            ->get();
      
        foreach($datas as $data){
            $tempRoutePath = $routePath;
            //將路由設置取代為自定義資料 tw/article/{cate} -> tw/article/$cate1
            $tempRoutePath = str_replace($sonSet['param'], $data[$sonSet['col']], $tempRoutePath);
            // 將這類路由 tw/article/cate1/{articleUrl} 中的 tw/article/cate1 也加入sitemap
            $_tempRoutePath = preg_replace('/\{[^}]*\}/', '', $tempRoutePath);
            $_tempRoutePath = rtrim($_tempRoutePath, '/');
            $routesRecord[$_tempRoutePath] = $score;

            if(isset($sonSet['with']) && !empty($sonSet['with'])){
                self::subModel($routesRecord, $tempRoutePath, $data, $sonSet,$score);
            }
        }
    }
}