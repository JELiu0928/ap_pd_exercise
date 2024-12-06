<?php

namespace App\Http\Controllers\Fantasy;

use App;
use App\Http\Controllers\Fantasy\BackendController;
use App\Models\Basic\Cms\CmsMenu;
use App\Models\Basic\FantasyUsers;
use BaseFunction;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Route;
use Session;

/*Model*/
use View;

class AuthController extends BackendController
{

    public function __construct()
    {
        parent::__construct();
    }
	public function status()
	{
		$fantasy_user = Session::get('fantasy_user.id',0);
		return $fantasy_user > 0 ? 1 : 0;
	}
    public function getLogin($user_id = 0)
    {

        $staticPrefix = \Route::getCurrentRequest()->server('HTTP_HOST');
        return View::make('Fantasy.login', []);
    }

    public static function saveSession(Request $request, FantasyUsers $member)
    {
        $key = Str::random(16);
        $keys = json_decode($member->session_keys, true) ?? [];
        array_push($keys, $key);
        $member->session_keys = json_encode(array_slice($keys, -10, 10));
        $member->save();

        $member->load(['cmsRoles', 'amsRole']);
        $cms = [];
        $member->cmsRoles->each(function ($role) use (&$cms) {
            $unit = $role->BranchOriginUnit;
            $branch = empty($unit) ? '' : $unit->BranchOrigin;
            if (!empty($branch)) {
                $roles = json_decode($role->roles, true);
                // dump($roles);
                $models = CmsMenu::whereIn('id', array_keys($roles))->get()->reduce(function ($res, $menu) {
                    if (!empty($menu->model) && !is_numeric($menu->model)) {
                        $res[$menu->id] = $menu->model;
                    }
                    return $res;
                }, []);
                foreach ($roles as $menuId => $val) {
                    $model = $models[$menuId] ?? '';
                    if (!empty($model)) {
                        $array = explode(';', $val);
                        $cms[$branch->url_title][$unit->locale][$menuId] = $array;
                        $cms[$branch->url_title][$unit->locale][$model] = $array;
                    }
                }
            }
        });
        $member->cms = $cms;
        $member->ams = empty($member->amsRole) ? [] : $member->amsRole->toArray();
        $member = $member->toArray();

        /*為安全性或其他一些雜七雜八的考量 只存特定欄位到session*/
        session(['fantasy_user' => [
            'id' => $member['id'],
            'mail' => $member['mail'],
            'account' => $member['account'],
            'name' => $member['name'],
            'photo_image' => $member['photo_image'],
            'fms_admin' => $member['fms_admin'],
            'ams' => $member['ams'],
            'cms' => $member['cms'],
            'key' => $key,
        ]]);
        session()->save();
        BaseFunction::writeLogData('login', ['ip' => $request->ip()]);
    }
    public static function postLogin(Request $request)
    {
        // 登入可嘗試次數
        $access_time = 5;
        // 屏蔽時間（分鐘）
        $block_time = 10;

        $userData = $request->userData;
        $userData = base64_decode($userData);

        // 私鑰
		$priv_key = config('rsa.privatekey');
		$private_key_res = openssl_get_privatekey($priv_key);
		if(!$private_key_res) {
			throw new \Exception('Private Key invalid');
		}
		openssl_private_decrypt($userData, $decrypted, $private_key_res, OPENSSL_PKCS1_PADDING);
        $decrypted = json_decode($decrypted,true);

        $account = urldecode($decrypted['account']);
        $password = urldecode($decrypted['password']);

        $loginAlert = session('loginAlert')??null;
        if( isset($loginAlert) && strtotime($loginAlert['expiry_time'])<=time() ){
            session()->forget('loginAlert');
            $loginAlert = null;
        }
        if(!isset($loginAlert)){
            $loginAlert = [
                'count' => 0,
                'expiry_time' => time(),
            ];
        }

        if($loginAlert['count']>=$access_time && strtotime($loginAlert['expiry_time'])>time()){
            return [
                "an" => false,
                "message" => "錯誤嘗試次數過多，請".ceil((strtotime($loginAlert['expiry_time'])-time())/60)."分鐘後再嘗試。",
            ];
        }

        /*抓相同帳號者*/
        $member = FantasyUsers::where('is_active', 1)->where('account', $account)->first();

        if (empty($member)) {
            /*查無此帳號*/
            $loginAlert['count']++;
            $loginAlert['expiry_time']=date('Y-m-d H:i:s', time() + $block_time * 60);
            session()->put('loginAlert',$loginAlert);
            session()->save();
            return [
                "an" => false,
                "message" => "帳號或密碼錯誤(還剩".($access_time-$loginAlert['count'])."次嘗試機會)",
            ];
        }

        $lock_ip = (!empty($member->lock_ip)) ? explode(",", $member->lock_ip) : [];
        if (!empty($lock_ip) && !in_array(\Request::getClientIp(), $lock_ip)) {
            $loginAlert['count']++;
            $loginAlert['expiry_time']=date('Y-m-d H:i:s', time() + $block_time * 60);
            session()->put('loginAlert',$loginAlert);
            session()->save();
            return [
                "an" => false,
                "message" => "您目前沒有權限可以登入(還剩".($access_time-$loginAlert['count'])."次嘗試機會)",
            ];
        }

        if ( !Hash::check($password, $member->password) ) {
            /*密碼比對錯誤*/
            $loginAlert['count']++;
            $loginAlert['expiry_time']=date('Y-m-d H:i:s', time() + $block_time * 60);
            session()->put('loginAlert',$loginAlert);
            session()->save();
            return [
                "an" => false,
                "message" => "帳號或密碼錯誤(還剩".($access_time-$loginAlert['count'])."次嘗試機會)",
            ];
        }
        /*To Array是為了等等存session時方便使用*/
        session()->forget('loginAlert');
        static::saveSession($request, $member);

        return [
            "an" => true,
        ];
    }
    public function postLogout(Request $request)
    {
        Session::forget('fantasy_user');
        Session::save();
        return [
            "an" => true,
        ];
    }
    public function checkAuth()
    {
        if (Session::has('fantasy_user')) {
            $data['user'] = '1';
        } else {
            $data['user'] = '0';
        }
        return $data;
    }
}
