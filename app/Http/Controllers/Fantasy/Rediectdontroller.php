<?php
namespace App\Http\Controllers\Fantasy;
/**原生函式**/
use Illuminate\Http\Request;
use View;
use ItemMaker;
use Cache;
use Excel;
use DateTime;
use Redirect;
use Mail;
use Session;
use Validator;
use Config;
use DB;
use Response;

use UnitMaker;
use TableMaker;
use BaseFunction;
/**相關Controller**/
use App\Http\Controllers\Controller;

/**相關repository**/

/**相關Models**/

/**相關Service**/

class Rediectdontroller extends Controller
{
    public function __construct()
    {
        
    }

    public function index($url='',$getpartment=[])
    {
        // 撈出所有目的網址的ID
        $parentidlist = DB::table('redirect_set')->select('id')->get();
        // 擷取把GET test=test 去掉的網址(因為test=test可能是自己家的)
        $cuttest = substr(str_replace("test=test","",$url),0,-1);
        // 對所有可能性的網址做搜尋
        $results0 = DB::table('three_o_one_redirect')
                                                    ->whereIn('origin_url', [
                                                    'http://'.$_SERVER['HTTP_HOST'].$url,
                                                    'http://'.$_SERVER['HTTP_HOST'].$url.'/',
                                                    'http://'.$_SERVER['HTTP_HOST'].$cuttest.'/',
                                                    'http://'.$_SERVER['HTTP_HOST'].$cuttest,
                                                    
                                                    'https://'.$_SERVER['HTTP_HOST'].$url,
                                                    'https://'.$_SERVER['HTTP_HOST'].$url.'/',
                                                    'https://'.$_SERVER['HTTP_HOST'].$cuttest.'/',
                                                    'https://'.$_SERVER['HTTP_HOST'].$cuttest,
                                                    
                                                    'http://www'.$_SERVER['HTTP_HOST'].$url,
                                                    'http://www'.$_SERVER['HTTP_HOST'].$url.'/',
                                                    'http://www'.$_SERVER['HTTP_HOST'].$cuttest.'/',
                                                    'http://www'.$_SERVER['HTTP_HOST'].$cuttest,
                                                    
                                                    'https://www'.$_SERVER['HTTP_HOST'].$url,
                                                    'https://www'.$_SERVER['HTTP_HOST'].$url.'/',
                                                    'https://www'.$_SERVER['HTTP_HOST'].$cuttest.'/',
                                                    'https://www'.$_SERVER['HTTP_HOST'].$cuttest,

                                                    ])
                                                    ->whereIn('parent_id',($parentidlist->map(function($item){ return $item->id ; } ))->toArray())
                                                    ->select('parent_id','type')
                                                    ->first();
        // 判斷有來源網址有被設定301轉址
        if(!empty($results0))
        {
            // 有被設定的話就用來搜尋目的地網址
            $results = DB::table('redirect_set')->where('id',$results0->parent_id)->select('destination_url')->first();

            // 把撈除來的絕對網址轉成鄉對網址
            $new_destination_url = str_replace([
                'http://'.$_SERVER['HTTP_HOST'],
                
                'https://'.$_SERVER['HTTP_HOST'],
                
                'http://www'.$_SERVER['HTTP_HOST'],
                
                'https://www'.$_SERVER['HTTP_HOST'],
            ],'',$results->destination_url);
        }else{
            $results = '';
        }
        
        $redirectto = '';
        // 判斷是否有設定301轉址
        if(!empty($results))
        {
            // 判斷使用者輸入的網址是否有帶GET變數test=test
            if(!empty($_GET['test'])&&$_GET['test']=="test")
            {
                // 判斷301轉址設定中的網址是否本來就有帶GET變數test
                if(preg_match("/([?]test=)/i", $new_destination_url) || preg_match("/&test=/i", $new_destination_url))
                {
                    $redirectto = $new_destination_url.$redirectto;
                }else{
                    // 判斷使設定中的網址的是否有帶GET變數，如果有的話把test放最後面沒有的話放第一個
                    if(preg_match("/[?]/i", $new_destination_url))
                    {
                        $redirectto = $new_destination_url.$redirectto.'&test=test';
                    }else{
                        $redirectto = $new_destination_url.$redirectto.'?test=test';
                    }
                }
            }else{
                $redirectto = $new_destination_url.$redirectto;
            }
        }else{
            // $redirectto = '';
            $count =0;
            // 使用者輸入的網址不戴GET變數，直接加入判斷已轉址過的判斷
            if(empty($getpartment))
            {
                $redirectto .= $url.'?bvshasredirect=1';
            // 如果有的話，把GET變數切開﹐加入判斷已轉址過的判斷，再組回去
            }else{
                $redirectto .= $_SERVER['SCRIPT_URL'];
                foreach ($getpartment as $key => $value) {
                    if($count==0)
                    {
                        $redirectto .= '?'.$key.'='.$value;
                    }else{
                        $redirectto .= '&'.$key.'='.$value;
                    }
        
                    if($count==count($getpartment)-1)
                    {
                        $redirectto .= '&bvshasredirect=1';
                    }
                    $count+= 1;
                }
            }
        }
        return ['url'=>$redirectto,'type'=>!empty($results0->type)?$results0->type:'301'];
    }

    public function error()
    {
        return Response()->view('404', array(), 404);
    }

    
}