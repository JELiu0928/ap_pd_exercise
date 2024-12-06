<?php
function dir_list($path, $exts = '', $list = array())
{
    $path = dir_path($path);
    $files = glob($path . '*');
    foreach ($files as $v) {
        if (!$exts || preg_match('/\.($exts)/i', $v)) {
            $list[] = $v;
            if (is_dir($v)) {
                $list = dir_list($v.'/', $exts, $list);
            }
        }
    }
    return $list;
}
function dir_path($path)
{
    $path = str_replace('\\', '/', $path);
    if (substr($path, -1) != '/') {
        $path = $path . '/';
    }
    return $path;
}
function dblink()
{
    $servername = "127.0.0.1";
    $file = fopen('../.env', "r+");
    $_DATABASE = ['DB_DATABASE'=>'','DB_USERNAME'=>'','DB_PASSWORD'=>''];
    while (!feof($file)){
        $str = fgets($file);
        if(strpos($str,'DB_DATABASE') !== false){
            $_DATABASE['DB_DATABASE'] = trim(str_replace("DB_DATABASE=","",$str));
        }
        if(strpos($str,'DB_USERNAME') !== false){
            $_DATABASE['DB_USERNAME'] = trim(str_replace("DB_USERNAME=","",$str));
        }
        if(strpos($str,'DB_PASSWORD') !== false){
            $_DATABASE['DB_PASSWORD'] = trim(str_replace("DB_PASSWORD=","",$str));
        }
    }
    fclose($file);
    if (strpos($_DATABASE['DB_PASSWORD'], '"') !== false) {
        echo '密碼有雙引號,確認沒問題把我註解';
        exit();
    }
    $conn = new PDO("mysql:host=$servername;dbname=".$_DATABASE['DB_DATABASE'], $_DATABASE['DB_USERNAME'], $_DATABASE['DB_PASSWORD']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
}
function hastable($tableName)
{
    $conn = dblink();
    $stmt = $conn->query("SHOW TABLES LIKE '$tableName'");
    $result = $stmt->fetchAll();
    
    if (count($result) > 0) {
        return true;
    } else {
        return false;
    }
}


$modeldataPath = '../config/model';
$modeldataPaths = dir_list($modeldataPath);
$modeldataPaths[] = '../config/models.php';
function findModel($modeldataPaths,$name)
{
    $re = '/\''.$name.'\'\s?=>\s?(.*?)::/';
    foreach($modeldataPaths as $file){
        if(is_file($file)){
            $tempdata = fopen($file, "r",0777);
            $tempdata_html = fread($tempdata, filesize($file));
            preg_match($re, $tempdata_html, $matches);
            if(!empty($matches)){
                return '..\\'.$matches[1].'.php';
            }
        }
    }
    return '';
}

function getindex()
{
    $conn = dblink();
    // 取得所有資料表的索引
    $stmt = $conn->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $getindex = [];
    foreach ($tables as $table) {
        
        // 取得資料表的索引
        $stmt = $conn->query("SHOW INDEXES FROM $table");
        $indexes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($indexes as $index) {
            $getindex[] = ['table'=>$table,'index'=>$index['Column_name'],'name'=>$index['Key_name']];
        }
    }
    return $getindex;
}
$oldindex = getindex();
echo '原本index數量：'.count($oldindex).'<br>';

        $path = '../app/Models/';
        $path = dir_path($path);
        $r = dir_list($path);

        $re = '/hasMany\s?\((.*?)\)/';
        
        foreach($r as $file){
            if(is_file($file)){
                $tempdata = fopen($file, "r",0777);
                $tempdata_html = fread($tempdata, filesize($file));
                preg_match_all($re, $tempdata_html, $matches, PREG_SET_ORDER, 0);
                if(!empty($matches)){
                    foreach($matches as $v){
                        $string = preg_replace('/\s+/', '', $v[1]);
                        $string = str_replace(['\'', '"'], '', $string);
                        $datas = explode(',',$string);
                        if (strpos($datas[0], '::class') !== false) {
                            $temp_model = str_replace("::class", "", $datas[0]);
                            $remodel = '/use\s(.*?)'.$temp_model.';/';
                            preg_match($remodel, $tempdata_html, $modelmatch);
                            $model = (isset($modelmatch[1])) ? '..\\'.$modelmatch[1].$temp_model.'.php' : findModel($modeldataPaths,$temp_model);
                        } else {
                            $model = '..\\'.$datas[0].'.php';
                        }
                        
                        if(!empty($model)){
                            $model = str_replace("\\", "/", $model);
                            //echo $model .'<br>';
                            $model = str_replace(['../App'], '../app', $model);

                            if(file_exists($model)){
                                $tempdata1 = fopen($model, "r",0777);
                                $tempdata_html1 = fread($tempdata1, filesize($model));
                                //取得資料表名稱
                                $reTable = '/setTable\s?\(.*[\'|"](.*?)[\'|"]\);|protected \s?\$table\s=\s?[\'|"](.*?)[\'|"]/';
                                preg_match($reTable, $tempdata_html1, $reTableMatch);
                                if(count($reTableMatch) < 2){
                                    $reTable = '/setTable\s?\((.*?)\);/';
                                    preg_match($reTable, $tempdata_html1, $reTableMatch);
                                }

                                if(count($reTableMatch) >= 2){
                                    $tableName = str_replace(['\'', '"'], '', $reTableMatch[2] ?? $reTableMatch[1]);
                                    if (strpos($tableName, '$') !== false) {
                                        $tableName = str_replace(['$'], '', $tableName);
                                        $reTable = '/\$'.$tableName.'\s=\s?[\'|"](.*?)[\'|"];/s';
                                        preg_match($reTable, $tempdata_html1, $reTableMatch);
                                        $tableName = str_replace(['\'', '"'], '', $reTableMatch[2] ?? $reTableMatch[1]);
                                    }
                                    $conn = dblink();
                                    //echo $model . '>' . $tableName .'>' . $datas[1].'<br>';
                                    $stmt = $conn->prepare("SHOW TABLES LIKE ?");
                                    $stmt->execute(['%'.$tableName]);
                                    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                    foreach($tables as $tableName){
                                        if(hastable($tableName)){
                                            //echo $model . '>' . $tableName .'>' . $datas[1].'<br>';
                                            $stmt = $conn->query("SHOW INDEX FROM ".$tableName." WHERE Key_name = '" . $datas[1]."'");
                                            $indexExists = $stmt->fetch();

                                            $stmt = $conn->query("SHOW COLUMNS FROM $tableName LIKE '$datas[1]'");
                                            $column = $stmt->fetch(PDO::FETCH_ASSOC);
                                            if(!empty($column)){
                                                if (strpos($column['Type'], 'int') !== false || strpos($column['Type'], 'varchar') !== false) {
                                                    $stmt = $conn->query("SHOW COLUMNS FROM $tableName");
                                                    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                                    $hasColumn = in_array($datas[1], $columns);
                            
                                                    if (empty($indexExists) && $hasColumn) {
                                                        $indexName = $datas[1];
                                                        $columnName = $datas[1];
                                                        $stmt = $conn->prepare("ALTER TABLE $tableName ADD INDEX $indexName ($columnName)");
                                                        $stmt->execute();
                                                    }
                                                }
                                            }
                             



                                        }else{
                                            echo $model . '>' . $tableName .'>' . $datas[1].'<br>';
                                        }
                                    }
                                }else{
                                    print_r($model);
                                    exit();
                                    echo $model .'xxxxx<br>';
                                }
                               
                            }
                        }
                       
                    }
                }
            }
        }
        $re = '/belongsTo\s?\((.*?)\)/';
        foreach($r as $file){
            if(is_file($file)){
                $tempdata = fopen($file, "r",0777);
                $tempdata_html = fread($tempdata, filesize($file));
                preg_match_all($re, $tempdata_html, $matches, PREG_SET_ORDER, 0);
                if(!empty($matches)){
                    foreach($matches as $v){
                        $string = preg_replace('/\s+/', '', $v[1]);
                        $string = str_replace(['\'', '"'], '', $string);
                        $datas = explode(',',$string);
                        if (strpos($datas[0], '::class') !== false) {
                            $temp_model = str_replace("::class", "", $datas[0]);
                            $remodel = '/use\s(.*?)'.$temp_model.';/';
                            preg_match($remodel, $tempdata_html, $modelmatch);
                            $model = (isset($modelmatch[1])) ? '..\\'.$modelmatch[1].$temp_model.'.php' : findModel($modeldataPaths,$temp_model);
                        } else {
                            $model = '..\\'.$datas[0].'.php';
                        }
                        if(!empty($model)){
                            $model = str_replace("\\", "/", $model);
                            $model = str_replace(['../App'], '../app', $model);
                            if(file_exists($model)){
                                if(count($datas) == 2){
                                    //取得資料表名稱
                                    $reTable = '/setTable\s?\(.*[\'|"](.*?)[\'|"]\);|protected \s?\$table\s=\s?[\'|"](.*?)[\'|"]/';
                                    preg_match($reTable, $tempdata_html, $reTableMatch);
                                    if(count($reTableMatch) < 2){
                                        $reTable = '/setTable\s?\((.*?)\);/';
                                        preg_match($reTable, $tempdata_html, $reTableMatch);
                                    }
                                    if(count($reTableMatch) >= 2){
                                        $tableName = str_replace(['\'', '"'], '', $reTableMatch[2] ?? $reTableMatch[1]);
                                        if (strpos($tableName, '$') !== false) {
                                            $tableName = str_replace(['$'], '', $tableName);
                                            $reTable = '/\$'.$tableName.'\s=\s?[\'|"](.*?)[\'|"];/s';
                                            preg_match($reTable, $tempdata_html, $reTableMatch);
                                            $tableName = str_replace(['\'', '"'], '', $reTableMatch[2] ?? $reTableMatch[1]);
                                        }
                                        $conn = dblink();
                                        $stmt = $conn->prepare("SHOW TABLES LIKE ?");
                                        $stmt->execute(['%'.$tableName]);
                                        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                        foreach($tables as $tableName){
                                            if(hastable($tableName)){
                                                $stmt = $conn->query("SHOW INDEX FROM ".$tableName." WHERE Key_name = '" . $datas[1]."'");
                                                $indexExists = $stmt->fetch();
                                    
                                                $stmt = $conn->query("SHOW COLUMNS FROM $tableName LIKE '$datas[1]'");
                                                $column = $stmt->fetch(PDO::FETCH_ASSOC);
                                                if(!empty($column)){
                                                    if (strpos($column['Type'], 'int') !== false || strpos($column['Type'], 'varchar') !== false) {
                                                        $stmt = $conn->query("SHOW COLUMNS FROM $tableName");
                                                        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                                        $hasColumn = in_array($datas[1], $columns);
                                
                                                        if (empty($indexExists) && $hasColumn) {
                                                            $indexName = $datas[1];
                                                            $columnName = $datas[1];
                                                            $stmt = $conn->prepare("ALTER TABLE $tableName ADD INDEX $indexName ($columnName)");
                                                            $stmt->execute();
                                                        }
                                                    }
                                                }


                                            }
                                        }
                                    }else{
                                        echo $model .'<br>';
                                    }
                                } 
                                if(count($datas) == 3){
                                    $tempdata1 = fopen($model, "r",0777);
                                    $tempdata_html1 = fread($tempdata1, filesize($model));
                                    //取得資料表名稱
                                    $reTable = '/setTable\s?\(.*[\'|"](.*?)[\'|"]\);|protected \s?\$table\s=\s?[\'|"](.*?)[\'|"]/';
                                    preg_match($reTable, $tempdata_html1, $reTableMatch);
                                    if(count($reTableMatch) < 2){
                                        $reTable = '/setTable\s?\((.*?)\);/';
                                        preg_match($reTable, $tempdata_html, $reTableMatch);
                                    }
                                    if(count($reTableMatch) >= 2){
                                        $tableName = str_replace(['\'', '"'], '', $reTableMatch[2] ?? $reTableMatch[1]);
                                        if (strpos($tableName, '$') !== false) {
                                            $tableName = str_replace(['$'], '', $tableName);
                                            $reTable = '/\$'.$tableName.'\s=\s?[\'|"](.*?)[\'|"];/s';
                                            preg_match($reTable, $tempdata_html1, $reTableMatch);
                                            $tableName = str_replace(['\'', '"'], '', $reTableMatch[2] ?? $reTableMatch[1]);
                                        }
                                        $conn = dblink();
                                        $stmt = $conn->prepare("SHOW TABLES LIKE ?");
                                        $stmt->execute(['%'.$tableName]);
                                        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                        foreach($tables as $tableName){
                                            if(hastable($tableName)){
                                                $stmt = $conn->query("SHOW INDEX FROM ".$tableName." WHERE Key_name = '" . $datas[2]."'");
                                                $indexExists = $stmt->fetch();
                                                $stmt = $conn->query("SHOW COLUMNS FROM $tableName LIKE '$datas[1]'");
                                                $column = $stmt->fetch(PDO::FETCH_ASSOC);
                                                if(!empty($column)){
                                                    if (strpos($column['Type'], 'int') !== false || strpos($column['Type'], 'varchar') !== false) {
                                                        $stmt = $conn->query("SHOW COLUMNS FROM $tableName");
                                                        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
                                                        $hasColumn = in_array($datas[2], $columns);
                                
                                                        if (empty($indexExists) && $hasColumn) {
                                                            $indexName = $datas[2];
                                                            $columnName = $datas[2];
                                                            $stmt = $conn->prepare("ALTER TABLE $tableName ADD INDEX $indexName ($columnName)");
                                                            $stmt->execute();
                                                        }
                                                    }
                                                }

                                            }
                                        }
                                    }else{
                                        echo $model .'<br>';
                                    }
                                }
                               
                            }
                        }
                       
                    }
                }
            }
        }
        $newindex = getindex();
        echo '新的index數量：'.count($newindex).'<br>';