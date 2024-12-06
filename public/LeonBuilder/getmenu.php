<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('_Class.php');
require_once('_Model.php');
if (isset($_GET['database'])) {
    $tdatabase = $_GET['database'];
} else {
    $rs = $db->query(sprintf("show databases"));
    while ($row = $rs->fetch(PDO::FETCH_NUM)) {
        echo '<a href="getmenu.php?database=' . $row[0] . '">' . $row[0] . '</a></br>';
    }
    echo '請在網址後加上?database=資料表名稱';
    exit();
}
$basic_cms_child = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_cms_child"))->fetchAll(PDO::FETCH_ASSOC);
$basic_cms_child_son = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_cms_child_son"))->fetchAll(PDO::FETCH_ASSOC);
$basic_cms_menu = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_cms_menu"))->fetchAll(PDO::FETCH_ASSOC);
$basic_cms_parent = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_cms_parent"))->fetchAll(PDO::FETCH_ASSOC);
$basic_cms_parent_son = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_cms_parent_son"))->fetchAll(PDO::FETCH_ASSOC);
$basic_web_key = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_web_key"))->fetchAll(PDO::FETCH_ASSOC);

$leon_database = $db->query(sprintf("SELECT id,db_name FROM leon_database"))->fetchAll(PDO::FETCH_ASSOC);
$nameDataTemp = array_column($leon_database, 'db_name');


$menu = [];
foreach ($basic_cms_menu as $val) {
    //替換
    foreach ($leon_database as $v) {
        if (strtolower(str_replace("_", "", $v['db_name'])) == strtolower(str_replace("_", "", $val['model']))) {
            $val['model'] = ucfirst($v['db_name']);
        }
    }
    if ($val['parent_id'] == 0) {
        $menu[$val['id']] = ['id' => $val['model'], 'contenta' => $val['title']];
    } else {
        if (isset($menu[$val['parent_id']])) {
            $menu[$val['parent_id']]['children'][$val['id']] = ['id' => $val['model'], 'contenta' => $val['title']];
        }
    }
}

foreach ($basic_cms_child as $val) {
    foreach ($leon_database as $v) {
        if (strtolower(str_replace("_", "", $v['db_name'])) == strtolower(str_replace("_", "", $val['child_model']))) {
            $val['child_model'] = ucfirst($v['db_name']);
        }
    }

    $parent_id = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_cms_menu where id = " . $val['menu_id']))->fetch(PDO::FETCH_ASSOC)['parent_id'];
    $menu[$parent_id]['children'][$val['menu_id']]['children'][$val['id']] = ['id' => $val['child_model'], 'contenta' => $val['child_model']];
}
foreach ($basic_cms_child_son as $val) {
    $menu_id = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_cms_child where id = " . $val['child_id']))->fetch(PDO::FETCH_ASSOC)['menu_id'];
    $parent_id = $db->query(sprintf("SELECT * FROM " . $tdatabase . ".basic_cms_menu where id = " . $menu_id))->fetch(PDO::FETCH_ASSOC)['parent_id'];
    $menu[$parent_id]['children'][$menu_id]['children'][$val['child_id']]['children'][$val['id']] = ['id' => $val['model_name'], 'contenta' => $val['model_name']];
}

// foreach ($basic_cms_parent_son as $val) {
//     echo $menu[$val['menu_id']]['contenta'];
// }
$leon_menu = $db->query(sprintf("SELECT * FROM leon_menu where id = 1"))->fetch(PDO::FETCH_ASSOC);
$MenuData =  json_decode($leon_menu['db_data'], true);

// $SaveData = [];
foreach ($MenuData as $val) {
    $is_find = false;
    foreach ($menu as $v) {
        if (!isset($v['id'])) {
            print_r($menu);
            exit();
        }
        if ($val['id'] == $v['id'] && $val['contenta'] == $v['contenta']) {
            $is_find = true;
        }
    }
    if (!$is_find) {
        $menu[] = $val;
    }
}
$json_en = json_encode($menu, JSON_UNESCAPED_UNICODE);
echo $json_en;

exit();