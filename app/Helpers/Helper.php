<?php
  function NoData($model,$count = 4, $setting = [])
  {
    if(Session::has('fantasy_user')){
      $db_name = M_table($model);
      $Field = json_decode(json_encode(\DB::select('show full columns from ' . $db_name)), true);
      $emptyData = [];
      for($i = 0;$i < $count;$i++){
        $temp = [];
        foreach($Field as $val){
          $value = "";
          if (strpos($val['Type'], 'int') !== false) {
            $value = 0;
          }
          if (strpos($val['Type'], 'text') !== false) {
            if (strpos($val['Field'], '_id') !== false) {
              $value = '[]';
            }else{
              $value = "這裡請填寫[".$val['Comment']."]";
            }
          }
          if (strpos($val['Type'], 'date') !== false) {
            $value = date('Y-m-d');
          }
          if (strpos($val['Type'], 'varchar') !== false) {
            $value = "這裡請填寫[".$val['Comment']."]";
          }
          if (strpos($val['Field'], 'o_') !== false) {
            $temp[$val['Field']."_alt"] = "";
            $value = "/noimage.svg";
          }
          $temp[$val['Field']] = $value;
        }
        
        foreach($setting as $val){
          if($val['type'] == "first"){
            $temp[$val['model']] = NoData($val['model'])[0];
          }else{
            $temp[$val['model']] = NoData($val['model']);
          }
        }
        $temp['id'] = $i+1;
        $emptyData[] = $temp;
      }
    }
    
		return $emptyData ?? [];
  }
if (!function_exists('Seo')) {
  function Seo($data = [], $default = [])
  {
    $defaultSeo = [
      "seo_title" => '',
      "seo_h1" => '',
      "seo_keyword" => '',
      "seo_meta" => '',
      "seo_og_title" => '',
      "seo_description" => '',
      "seo_img" => '',
      "seo_ga" => '',
      "seo_gtm" => '',
      "seo_pixel" => '',
      "seo_structured" => '',
    ];
    $data = $data ?: $defaultSeo;
    //判斷是否為多語系SEO
    if (isset($data['tw_seo_title'])) {
      $baseLocale = view()->getshared()['baseLocale'];
      $data['seo_title'] = $data[$baseLocale . '_seo_title'];
      $data['seo_h1'] = $data[$baseLocale . '_seo_h1'];
      $data['seo_keyword'] = $data[$baseLocale . '_seo_keyword'];
      $data['seo_meta'] = $data[$baseLocale . '_seo_meta'];
      $data['seo_og_title'] = $data[$baseLocale . '_seo_og_title'];
      $data['seo_description'] = $data[$baseLocale . '_seo_description'];
      $data['seo_structured'] = $data[$baseLocale . '_seo_structured'];
    }
    $seo = [
      "seo_title" => $data['seo_title'] ?: $default['seo_title'] ?? '',
      "seo_h1" => $data['seo_h1'] ?: $default['seo_h1'] ?? '',
      "seo_keyword" => $data['seo_keyword'] ?: $default['seo_keyword'] ?? '',
      "seo_meta" => $data['seo_meta'] ?: $default['seo_meta'] ?? '',
      "seo_og_title" => $data['seo_og_title'] ?: $default['seo_og_title'] ?? '',
      "seo_description" => $data['seo_description'] ?: $default['seo_description'] ?? '',
      "seo_img" => $data['seo_img'] ?: $default['seo_img'] ?? '',
      "seo_ga" => $data['seo_ga'] ?: $default['seo_ga'] ?? '',
      "seo_gtm" => $data['seo_gtm'] ?: $default['seo_gtm'] ?? '',
      "seo_pixel" => $data['seo_pixel'] ?: $default['seo_pixel'] ?? '',
      "seo_structured" => $data['seo_structured'] ?: $default['seo_structured'] ?? '',
    ];
    $seo['seo_img'] = (!empty($seo['seo_img']) && (strpos($seo['seo_img'], 'upload') === false)) ? BaseFunction::RealFiles($seo['seo_img']) : $seo['seo_img'];
    return $seo;
  }
}
function seo_structured($data)
{
  return '<script type="application/ld+json">' . $data . '</script>';
}
function getClientIps()
{
  foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
    if (array_key_exists($key, $_SERVER) === true) {
      foreach (explode(',', $_SERVER[$key]) as $ip) {
        $ip = trim($ip); // just to be safe
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
          return $ip;
        }
      }
    }
  }
  return request()->ip(); // it will return server ip when no client ip found
}

function langArraySave($dom, $filed, $value_dom, $value)
{
  $langArray = Config::get('cms.langArray');
  foreach ($langArray as $val) {
    $dom->{$val['key'] . '_' . $filed} = $value_dom[$val['key'] . '_' . $value];
  }
  return $dom;
}
function getBcRound($number, $precision = 0)
{
  $precision = ($precision < 0)
    ? 0
    : (int) $precision;
  if (strcmp(bcadd($number, '0', $precision), bcadd($number, '0', $precision + 1)) == 0) {
    return bcadd($number, '0', $precision);
  }
  if (getBcPresion($number) - $precision > 1) {
    $number = getBcRound($number, $precision + 1);
  }
  $t = '0.' . str_repeat('0', $precision) . '5';
  return $number < 0
    ? bcsub($number, $t, $precision)
    : bcadd($number, $t, $precision);
}

function getBcPresion($number)
{
  $dotPosition = strpos($number, '.');
  if ($dotPosition === false) {
    return 0;
  }
  return strlen($number) - strpos($number, '.') - 1;
}
function pass_encode($number)
{
  $str_shuffle = str_shuffle($number);

  $array1 = str_split($number, 1);
  $array2 = str_split($str_shuffle, 1);
  foreach ($array1 as $key => $val) {
    foreach ($array2 as $k => $v) {
      if ($val == $v) {
        $array1[$key] = $k;
      }
    }
  }
  //亂數增加
  $array1[] = rand(1, 20);
  $array1[] = rand(1, 20);
  $array1[] = rand(1, 20);
  $array1 = json_encode($array1);
  $array2 = json_encode($array2);
  $pass_encode = [];
  $pass_encode[] = $array1;
  $pass_encode[] = $array2;
  return base64_encode(json_encode($pass_encode));
}
function pass_decode($number)
{
  $number = base64_decode($number);
  $data = json_decode($number);
  $pass = json_decode($data[0]);
  $passVal = json_decode($data[1]);
  $del = count($pass);
  unset($pass[$del - 1]);
  unset($pass[$del - 2]);
  unset($pass[$del - 3]);

  $passWord = [];
  foreach ($pass as $val) {
    $passWord[] = $passVal[$val];
  }
  $passWord = implode("", $passWord);
  return $passWord;
}
if (!function_exists('langkey')) {
  function langkey($data, $arr = "", $tip = "")
  {
    if (!is_array($arr)) {
      $tip = $arr;
      $arr = [];
    }
    $arr['edit'] = $arr['edit'] ?? 'textInput';
    $arr['tip'] = $arr['tip'] ?? $tip;
    if (isset($arr['value'])) {
      $arr['tip'] = '動態資料的位置請填入[value]';
    }
    $language_ui_state = Session::get('language_ui_state', "");
    if ($language_ui_state != "") {
      //編輯UI
      if (isset($arr['noedit'])) {
        if (isset($arr['value'])) {
          return str_replace("[value]", $arr['value'], BaseFunction::langkey($data));
        } else {
          return BaseFunction::langkey($data);
        }
      } else {
        if (isset($arr['hide'])) {
          return '<lang class="leon-language language-hide" langkey="' . $data . '" langtip="' . $arr['tip'] . '" langedit="' . $arr['edit'] . '">' . BaseFunction::langkey($data) . '</lang>';
        } else {
          if (isset($arr['value'])) {
            return '<lang class="leon-language" langkey="' . $data . '" langtip="' . $arr['tip'] . '" langedit="' . $arr['edit'] . '">' . str_replace("[value]", $arr['value'], BaseFunction::langkey($data)) . '</lang>';
          } else {
            return '<lang class="leon-language" langkey="' . $data . '" langtip="' . $arr['tip'] . '" langedit="' . $arr['edit'] . '">' . BaseFunction::langkey($data) . '</lang>';
          }
        }
      }
    } else {
      if (!isset($arr['hide'])) {
        if (isset($arr['value'])) {
          return str_replace("[value]", $arr['value'], BaseFunction::langkey($data));
        } else {
          return BaseFunction::langkey($data);
        }
      }
    }
  }
}
if (!function_exists('emptyy')) {
  function emptyy($data)
  {
    if (is_array($data)) {
      return empty($data);
    } else {
      if ($data == '' || $data === null) {
        return empty($data);
      } else {
        if ($data instanceof \Illuminate\Support\Collection) {
          return (count($data) == 0) ? true : false;
        } else {
          return empty($data);
        }
      }
    }
  }
}
if (!function_exists('M')) {
  function M($str, $new = false)
  {
    $str = ucfirst($str);
    $new_str = "App\\Models\\PHP\\$str";
    //判斷是否存在
    if (!class_exists($new_str)) {
      $new_str = config('models.' . $str);
      if (!class_exists($new_str)) {
        dd('model:' . $str . '找不到');
      }
    }
    if ($new) {
      $new_str = new $new_str;
    }
    return $new_str;
  }
}
if (!function_exists('M_one')) {
  function M_one($str, $key = "", $val = "")
  {
    $data = (!empty($key)) ? M($str)::where($key, $val)->first() : M($str)::first();
    return (!empty($data)) ? imgsrc($data->toArray()) : [];
  }
}
if (!function_exists('M_REGEXP')) {
  function M_REGEXP($str, $only = false)
  {
    $str = ($only) ? implode("|", $str) : '"' . implode("\"|\"", $str) . '"';
    return $str;
  }
}
if (!function_exists('M_one_rand')) {
  function M_one_rand($str, $key = "", $val = "")
  {
    $str = ucfirst($str);
    $new_str = "App\\Models\\$str\\$str";
    if (!empty($key)) {
      $arr = $new_str::isVisible()->where($key, $val)->inRandomOrder()->first();
    } else {
      $arr = $new_str::isVisible()->inRandomOrder()->first();
    }
    if (!empty($arr)) {
      $arr = imgsrc(idorname($arr->toArray()));
    } else {
      $arr = [];
    }
    return $arr;
  }
}
if (!function_exists('M_array')) {
  function M_array($str, $key = "", $val = "")
  {
    if (!empty($key)) {
      if ($key == 'parent_id') {
        $arr = imgsrc(idorname(M($str)::where(function ($q) {
          $q->where('is_visible', 1)->orwhere('is_reviewed', 1);
        })->where($key, $val)->doSort()->get()->toArray()));
      } else {
        $arr = imgsrc(idorname(M($str)::isVisible()->where($key, $val)->doSort()->get()->toArray()));
      }
    } else {
      $arr = imgsrc(idorname(M($str)::isVisible()->doSort()->get()->toArray()));
    }
    return $arr;
  }
}
if (!function_exists('M_table_Config')) {
  function M_table_Config($str)
  {
    $table = with(new $str)->getTable();
    return $table;
  }
}
if (!function_exists('M_table')) {
  function M_table($str)
  {
    $str = ucfirst($str);
    $new_str = M($str);
    $table = with(new $new_str)->getTable();
    return $table;
  }
}
if (!function_exists('M_son')) {
  function M_son($model1, $model2, $k)
  {
    $data = idorname(M($model1)::isVisible()->doSort()->get()->toArray());
    foreach ($data as $key => $val) {
      $data[$key][$k] = idorname(M($model2)::isVisible()->where('parent_id', $val['id'])->doSort()->get()->toArray());
    }
    return $data;
  }
}
if (!function_exists('M_group')) {
  function M_group($data1, $data2, $key, $col)
  {
    $is_find = false;
    foreach ($data1 as $val) {
      if (findkey($data2, 'id', $val[$key]) !== null) {
        $is_find = true;
        $data2[findkey($data2, 'id', $val[$key])][$col][] = $val;
      }
    }
    if (!$is_find) {
      foreach ($data2 as $k => $v) {
        $data2[$k][$col] = [];
      }
    }
    return $data2;
  }
}
if (!function_exists('M_content')) {
  function M_content($model, $id)
  {
    $data = M($model)::where(function ($query) {
      $query->where('is_preview', 1)->orwhere('is_visible', 1);
    })->where('parent_id', $id)->doSort()->get();
    // foreach ($data as $key => $val) {
    //   $data[$key]['contentimg'] = M($model . '_img')::where('second_id', $val['id'])->doSort()->get();
    // }
    return ['data' => $data, 'imageGroupKey' => $model . '_img'];
  }
}
if (!function_exists('M_second')) {
  function M_second($model, $second, $id)
  {
    $data = imgsrc(idorname(M($model)::isVisible()->where('parent_id', $id)->doSort()->get()->toArray()));
    foreach ($data as $key => $val) {
      $data[$key]['son'] = imgsrc(idorname(M($second)::where('second_id', $val['id'])->doSort()->get()->toArray()));
    }
    return $data;
  }
}
if (!function_exists('Mail_VerificationCode')) {
  function Mail_VerificationCode($blade, $MailInfo)
  {
    $Code = mt_rand(100000, 999999);
    if (empty(Session::get('MailCheckCode'))) {
      Session::put('MailCheckCode', $Code);
    } else {
      $Code = Session::get('MailCheckCode');
    }
    Session::put('MailCheckState', false);
    Session::save();
    $MailInfo['code'] = $Code;

    Mail::send($blade, ['data' => $MailInfo], function ($message) use ($MailInfo) {
      $message->from($MailInfo['from'], $MailInfo['from_name']);
      $message->subject($MailInfo['subject']);
      $message->to($MailInfo['to']);
    });
    return $Code;
  }
}
//取得網址名稱
if (!function_exists('idorname')) {
  function idorname($data)
  {
    if (!empty($data)) {
      foreach ($data as $col => $v) {
        if (!is_array($data[$col])) {
          $data['url_name'] = (isset($data['url_name']) && !empty($data['url_name'])) ? $data['url_name'] : $data['temp_url'];
        } else {
          $data[$col] = idorname($data[$col]);
        }
      }
    }
    return $data;
  }
}
//轉換圖片
if (!function_exists('imgsrc')) {
  function imgsrc($data)
  {
    // if (!empty($data)) {
    //   foreach ($data as $col => $v) {
    //     if (!is_array($data[$col])) {
    //       if (strpos($col, 'o_img') !== false) {
    //         $data[$col . '_mm'] = BaseFunction::RealFilesM($data[$col]);
    //         $data[$col . '_alt'] = BaseFunction::RealFilesAlt($data[$col]);
    //         $data[$col] = BaseFunction::RealFiles($data[$col]);
    //         if (empty($data[$col . '_alt'])) {
    //           $data[$col . '_alt'] = imgsrcAlt($data);
    //         }
    //       }
    //       if (strpos($col, 'o_file') !== false) {
    //         $data[$col] = BaseFunction::RealFiles($data[$col], false);
    //       }
    //     } else {
    //       $data[$col] = imgsrc($data[$col]);
    //     }
    //   }
    // }
    return $data;
  }
  function imgsrcAlt($data)
  {
    $alt = '';
    foreach ($data as $col => $v) {
      if ($col == 'w_title') {
        $alt = $data[$col];
      }
    }
    return $alt;
  }
}
//找KEY
if (!function_exists('findkey')) {
  function findkey($array, $key, $value)
  {
    $returnKey = null;
    foreach ($array as $k => $val) {
      if ((string) $val[$key] === (string) $value) {
        $returnKey = $k;
      }
    }
    return $returnKey;
  }
}
if (!function_exists('findkeyval')) {
  function findkeyval($array, $key, $value)
  {

    $returnKey = null;
    $returnNullArray = [];
    if (!empty($array)) {
      foreach ($array[0] as $k => $val) {
        $returnNullArray[$k] = '';
      }
    }

    foreach ($array as $k => $val) {
      if ((string) $val[$key] === (string) $value) {
        $returnKey = $k;
      }
    }
    $returnData = ($returnKey !== null) ? $array[$returnKey] : $returnNullArray;
    return $returnData;
  }
}
if (!function_exists('fsize')) {
  function fsize($path)
  {
    $fp = fopen($path, "r");
    $inf = stream_get_meta_data($fp);
    fclose($fp);
    foreach ($inf["wrapper_data"] as $v) {
      if (stristr($v, "content-length")) {
        $v = explode(":", $v);
        return floor(trim($v[1]) / 1024);
      }
    }
    return 0;
  }
}
if (!function_exists('Leon_article')) {
  function Leon_article($content)
  {
    return View::make(
      'article_v3',
      [
        'articles' => $content['data'],
        'imageGroupKey' => $content['imageGroupKey'],
      ]
    );
  }
}
if (!function_exists('_article')) {
  function _article($content, $imageGroupKey)
  {
    return View::make(
      'article_v3',
      [
        'articles' => $content,
        'imageGroupKey' => $imageGroupKey,
      ]
    );
  }
}
if (!function_exists('mustlogin')) {
  function mustlogin()
  {
    $UserData = Session::get('UserData');
    if (empty($UserData)) {
      header('Location: ' . BaseFunction::b_url('member'));
      exit();
    }
    return $UserData;
  }
}
if (!function_exists('CheckStorePass')) {
  function CheckStorePass()
  {
    $StorePass = Session::get('StorePass');
    if (empty($StorePass)) {
      header('Location: ' . BaseFunction::b_url('store/login'));
      exit();
    }
    //如果存在但隔天就強制再登入一次
    if ($StorePass['date'] != \Carbon\Carbon::today()->format('Y-m-d')) {
      header('Location: ' . BaseFunction::b_url('store/login'));
      exit();
    }
    return $StorePass;
  }
}
if (!function_exists('HtmlCoverUrlMail')) {
  function HtmlCoverUrlMail($text)
  {
    $regex_url = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
    $text = preg_replace($regex_url, "<a href=\"$1\">$1</a>", $text);

    $regex_mail = '/(\S+@\S+\.\S+)/';
    $text = preg_replace($regex_mail, '<a href="mailto:$1">$1</a>', $text);
    return $text;
  }
}

if (!function_exists('CoverPostInput')) {
  function CoverPostInput($requestData)
  {
    $val = [];
    if (!empty($requestData)) {
      foreach ($requestData as $v) {
        if (isset($v['name']) && isset($v['val'])) {
          $val[$v['name']] = $v['val'];
        }
      }
    }
    return $val;
  }
}

if (!function_exists('b_url')) {
  function b_url($requestData = "", $basic = false)
  {
    $requestData = str_replace("//", "/", $requestData);
    return BaseFunction::b_url($requestData, $basic);
  }
}
if (!function_exists('w_url')) {
  function w_url($requestData, $basic = false)
  {
    if (!empty($requestData)) {
      if (strpos($requestData, 'http:') !== false) { } else {
        $requestData = (strpos($requestData, 'http:') !== false) ? [] : b_url($requestData);
      }
    }
    return $requestData ?: 'javascript:;';
  }
}
if (!function_exists('href')) {
  function href($url, $target = false)
  {
    if (strpos($url, 'tel') === false && strpos($url, 'mailto') === false) {
      //同網域
      $url = (stripos($url, url('')) !== false) ? str_replace(url(''), "", $url) : $url;

      if (stripos($url, "http:") === false && stripos($url, "https:") === false && !empty($url)) {
        //如果站內網址
        $url = str_replace("./", "", str_replace("../", "", $url));
        //判斷第一節點是不是語系
        $url_path = explode('/',$url);
        if($url_path[0] == ""){
          unset($url_path[0]);
          $url_path = array_values($url_path);
        }
        $langArray = Config::get('cms.langArray');
        $parameters = Route::current()->parameters();
        $is_preview = strpos($parameters['locale'], 'preview_') !== false ? true : false;
        $is_BranchOrigin = (!empty(Config::get('branch_origin_all')->where('url_title',$url_path[0])->first())) ? true : false;
        $find_locale = ($is_BranchOrigin) ? $url_path[1] : $url_path[0];
        if(!empty(collect($langArray)->where('key',$find_locale)->first())){
          //如果在分站 - 第一節點沒指定分站網址的話
          $autoAddBranch = (isset($parameters['branch_url']) && !empty(collect($langArray)->where('key',$url_path[0])->first()));
          if($is_preview){
            if($is_BranchOrigin){
              $url_path[1] = 'preview_'.$url_path[1];
            }else{
              $url_path[0] = 'preview_'.$url_path[0];
            }
            $preview_url = implode('/',$url_path);
            $url = $preview_url;
          }
          $url = ($autoAddBranch) ? $parameters['branch_url'].'/'.$url : $url;
        }
      }
    }
    $target = ' target="' . (($target) ? '_blank' : '_self') . '"';
    $href = (!empty($url)) ? 'href="' . url($url) . '"' . $target : '';
    return $href;
  }
}
if (!function_exists('hrefAC')) {
  function hrefAC($data, $name)
  {
    $url = $data[$name];
    if (strpos($url, 'tel') === false && strpos($url, 'mailto') === false) {
      //同網域
      $url = (stripos($url, url('')) !== false) ? str_replace(url(''), "", $url) : $url;
      if (stripos($url, "http:") === false && stripos($url, "https:") === false && !empty($url)) {
        //如果站內網址
        $url = str_replace("./", "", str_replace("../", "", $url));
        //判斷第一節點是不是語系
        $url_path = explode('/',$url);
        if($url_path[0] == ""){
          unset($url_path[0]);
          $url_path = array_values($url_path);
        }
        $langArray = Config::get('cms.langArray');
        $parameters = Route::current()->parameters();
        $is_preview = strpos($parameters['locale'], 'preview_') !== false ? true : false;
        $is_BranchOrigin = (!empty(Config::get('branch_origin_all')->where('url_title',$url_path[0])->first())) ? true : false;
        $find_locale = ($is_BranchOrigin) ? $url_path[1] : $url_path[0];
        if(!empty(collect($langArray)->where('key',$find_locale)->first())){
          //如果在分站 - 第一節點沒指定分站網址的話
          $autoAddBranch = (isset($parameters['branch_url']) && !empty(collect($langArray)->where('key',$url_path[0])->first()));
          if($is_preview){
            if($is_BranchOrigin){
              $url_path[1] = 'preview_'.$url_path[1];
            }else{
              $url_path[0] = 'preview_'.$url_path[0];
            }
            $preview_url = implode('/',$url_path);
            $url = $preview_url;
          }
          $url = ($autoAddBranch) ? $parameters['branch_url'].'/'.$url : $url;
        }
      }
    }
    $href = (!empty($url)) ? 'href="' . url($url) . '"' : '';
    $href .= (!empty($url)) ? ' target="' . (($data[$name . '_target']) ? '_blank' : '_self') . '"' : '';
    $href .= ' title="' . $data[$name . '_acc'] . '"';
    return $href;
  }
}
if (!function_exists('a_target')) {
  function a_target($target)
  {
    return ($target) ? '_blank' : '_self';
  }
}
if (!function_exists('goback')) {
  function goback($url = '')
  {
    $Preview_record = Session::get('Preview_record', null);
    $referer = request()->headers->get('referer');
    if (!empty($referer)) {
      if (!empty($Preview_record)) {
        if ($referer != $Preview_record[count($Preview_record) - 1]) {
          $Preview_record[] = $referer;
        }
      } else {
        $Preview_record[] = $referer;
      }
      Session::put('Preview_record', $Preview_record);
      Session::save();
    }
    if (!empty($Preview_record)) {
      $back_page = (count($Preview_record) <= 1) ? 1 : count($Preview_record);
    } else {
      $back_page =  1;
    }
    if (strpos($referer, 'shop') !== false) {
      $back_page = 1;
    }
    $back_page = 1;
    return (!empty($referer)) ? 'href="javascript:;" onclick="history.go(-' . $back_page . ');"' : 'href="javascript:;" onclick="location.href=\'' . $url . '\';"';
  }
}
if (!function_exists('backtop')) {
  function backtop()
  {
    $NowUrl = parse_url(URL::current());
    if (isset($NowUrl['path'])) {
      $Paths = explode("/", $NowUrl['path']);
      if (count($Paths) > 0) {
        unset($Paths[count($Paths) - 1]);
      }
    }
    return $NowUrl['scheme'] . '://' . $NowUrl['host'] . implode("/", $Paths);
  }
}
if (!function_exists('download')) {
  function download($url_name, $file_id = '')
  {
    if (!empty($url_name)) {
      return url('download/' . $url_name);
    }
    return (!empty($file_id)) ? url('download/' . Crypt::encrypt($file_id)) : 'javascript:;';
  }
}
if (!function_exists('structured')) {
  function structured($SiteSeo)
  {
    return '<script type="application/ld+json">' . $SiteSeo['structured'] . '</script>';
  }
}
if (!function_exists('noimg')) {
  function noimg($file)
  {
    return ($file != '/noimage.svg') ? $file : '';
  }
}
if (!function_exists('autoimg')) {
  function autoimg($file, $basic)
  {
    return ($file != '/noimage.svg') ? $file : $basic;
  }
}
if (!function_exists('hasimg')) {
  function hasimg($file)
  {
    return ($file != '/noimage.svg') ? true : false;
  }
}
if (!function_exists('formatBytes')) {
  function formatBytes($bytes, $precision = 2)
  {
    $bytes = $bytes ?: 0;
    $base = log($bytes, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');
    return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
  }
}
if (!function_exists('GetDateWeek')) {
  function GetDateWeek($date, $type = 0)
  {
    $WeekStr[0] = [0 => "日", 1 => "一", 2 => "二", 3 => "三", 4 => "四", 5 => "五", 6 => "六",];
    $WeekStr[1] = [0 => "週日", 1 => "週一", 2 => "週二", 3 => "週三", 4 => "週四", 5 => "週五", 6 => "週六",];
    return $WeekStr[$type][\Carbon\Carbon::parse($date)->dayOfWeek];
  }
}
if (!function_exists('GetMonthTw')) {
  function GetMonthTw($m)
  {
    $GetMonthTw = [
      1 => "一",
      2 => "二",
      3 => "三",
      4 => "四",
      5 => "五",
      6 => "六",
      7 => "七",
      8 => "八",
      9 => "九",
      10 => "十",
      11 => "十一",
      12 => "十二",
    ];
    return $GetMonthTw[(int) $m];
  }
}
if (!function_exists('EmptyData')) {
  function EmptyData($date)
  {
    if ($date == '0000-00-00') {
      $date = '';
    }
    return $date;
  }
}
if (!function_exists('UserData')) {
  function UserData()
  {
    $UserData = Session::get("UserData", []);
    if (empty($UserData)) {
      return redirect()->to('tw/member')->send();
    }
    return $UserData;
  }
}
if (!function_exists('ShortURL')) {
  function ShortURL($url)
  {
    $url = str_replace("//", "/", $url);
    return $url;
  }
}
if (!function_exists('IMG')) {
  function IMG($key)
  {
    $data = BaseFunction::RealFiles($key);
    return $data;
  }
}
if (!function_exists('IMG_m')) {
  function IMG_m($key)
  {
    $data = BaseFunction::RealFilesM($key);
    return $data;
  }
}
if (!function_exists('IMG_alt')) {
  function IMG_alt($key)
  {
    $data = BaseFunction::RealFilesAlt($key);
    return $data;
  }
}
if (!function_exists('Deadline')) {
  function Deadline($setDate)
  {
    $return = '';
    $startdate = date($setDate . '23:59:59');
    $enddate = date('Y-m-d H:i:s');
    $date = round(floor((strtotime($enddate) - strtotime($startdate)) / 86400) / 365, 1);
    return $date;
  }
}
function nl2p($str)
{
  $str = str_replace(array("\r\n", "\r"), "\n", $str);
  return "<p>\n" . str_replace("\n", "\n</p>\n<p>\n", $str) . "\n</p>";
}
function extract_domain($domain)
{
  if (preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches)) {
    return $matches['domain'];
  } else {
    return $domain;
  }
}

function extract_subdomains($domain)
{
  $subdomains = $domain;
  $domain = extract_domain($subdomains);

  $subdomains = rtrim(strstr($subdomains, $domain, true), '.');

  return ($subdomains != 'www') ? $subdomains : '';
}
