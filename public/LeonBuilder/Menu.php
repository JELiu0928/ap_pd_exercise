<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');

if (isset($_GET['merge'])) {
    $basic_cms_child = $db->query(sprintf("SELECT * FROM basic_cms_child"))->fetchAll(PDO::FETCH_ASSOC);
    $basic_cms_child_son = $db->query(sprintf("SELECT * FROM basic_cms_child_son"))->fetchAll(PDO::FETCH_ASSOC);
    $basic_cms_menu = $db->query(sprintf("SELECT * FROM wddidv_franzshoponline.basic_cms_menu"))->fetchAll(PDO::FETCH_ASSOC);
    $basic_cms_parent = $db->query(sprintf("SELECT * FROM basic_cms_parent"))->fetchAll(PDO::FETCH_ASSOC);
    $basic_cms_parent_son = $db->query(sprintf("SELECT * FROM basic_cms_parent_son"))->fetchAll(PDO::FETCH_ASSOC);
    $basic_web_key = $db->query(sprintf("SELECT * FROM basic_web_key"))->fetchAll(PDO::FETCH_ASSOC);
    $menu = [];
    foreach ($basic_cms_menu as $val) {
        if ($val['parent_id'] == 0) {
            $menu[$val['id']] = ['id' => $val['model'], 'contenta' => $val['title']];
        } else {
            if (isset($menu[$val['parent_id']])) {
                $menu[$val['parent_id']]['children'][$val['id']] = ['id' => $val['model'], 'contenta' => $val['title']];
            }
        }
    }
    foreach ($basic_cms_child as $val) {
        $parent_id = $db->query(sprintf("SELECT * FROM basic_cms_menu where id = " . $val['menu_id']))->fetch(PDO::FETCH_ASSOC)['parent_id'];
        $menu[$parent_id]['children'][$val['menu_id']]['children'][$val['id']] = ['id' => $val['child_model'], 'contenta' => $val['child_model']];
    }
    foreach ($basic_cms_child_son as $val) {
        $menu_id = $db->query(sprintf("SELECT * FROM basic_cms_child where id = " . $val['child_id']))->fetch(PDO::FETCH_ASSOC)['menu_id'];
        $parent_id = $db->query(sprintf("SELECT * FROM basic_cms_menu where id = " . $menu_id))->fetch(PDO::FETCH_ASSOC)['parent_id'];
        $menu[$parent_id]['children'][$menu_id]['children'][$val['child_id']]['children'][$val['id']] = ['id' => $val['model_name'], 'contenta' => $val['model_name']];
    }
    $json_en = json_encode($menu, JSON_UNESCAPED_UNICODE);
    echo $json_en;
    // foreach ($basic_cms_parent_son as $val) {
    //     echo $menu[$val['menu_id']]['contenta'];
    // }
    // $leon_menu = $db->query(sprintf("SELECT * FROM leon_menu where id = 1"))->fetch(PDO::FETCH_ASSOC);
    // $MenuData =  json_decode($leon_menu['db_data'], true);

    // $SaveData = [];
    // foreach ($MenuData as $val) { }


    exit();
}



if (isset($_POST['data'])) {
    $Data = $_POST['data'];
    $leon_menu = $db->query(sprintf("SELECT * FROM leon_menu where id = 1"))->fetch(PDO::FETCH_ASSOC);
    if (!empty($leon_menu)) {
        $SQL_data = array("db_data" => $Data, "id" => $_POST['id']);
        $Panda_Class->_UPDATE("leon_menu", $SQL_data);
    } else {
        $SQL_data = array("db_data" => $Data);
        $Panda_Class->_INSERT("leon_menu", $SQL_data);
    }
    exit();
}
$MenuData = array();
$MenuState = 0;
$leon_menu = $db->query(sprintf("SELECT * FROM leon_menu where id = 1"))->fetch(PDO::FETCH_ASSOC);
$leon_database = $db->query(sprintf("SELECT * FROM leon_database"))->fetchAll(PDO::FETCH_ASSOC);
$TheModels = [];
if (!empty($leon_menu)) {
    $MenuData = json_decode($leon_menu['db_data'], true);
    foreach ($MenuData as $key1 => $v1) {
        //同步名稱
        //$db_key = array_search(strtolower($v1['id']),array_column($leon_database,'db_name'));
        $db_key = '';
        $MenuData[$key1]['content'] = empty($db_key) ? $v1['contenta'] : $leon_database[$db_key]['db_note'];
        $MenuData[$key1]['contenta'] = empty($db_key) ? $v1['contenta'] : $leon_database[$db_key]['db_note'];
        $TheModels[] = $v1['id'];
        if (isset($v1['children'])) {
            foreach ($v1['children'] as $key2 => $v2) {
                $db_key = array_search(strtolower($v2['id']), array_column($leon_database, 'db_name'));
                $db_key = '';
                $MenuData[$key1]['children'][$key2]['content'] = empty($db_key) ? $v2['contenta'] : $leon_database[$db_key]['db_note'];
                $MenuData[$key1]['children'][$key2]['contenta'] = empty($db_key) ? $v2['contenta'] : $leon_database[$db_key]['db_note'];
                $TheModels[] = $v2['id'];
                if (isset($v2['children'])) {
                    foreach ($v2['children'] as $key3 => $v3) {
                        $db_key = array_search(strtolower($v3['id']), array_column($leon_database, 'db_name'));
                        $db_key = '';
                        $MenuData[$key1]['children'][$key2]['children'][$key3]['content'] = empty($db_key) ? $v3['contenta'] : $leon_database[$db_key]['db_note'];
                        $MenuData[$key1]['children'][$key2]['children'][$key3]['contenta'] = empty($db_key) ? $v3['contenta'] : $leon_database[$db_key]['db_note'];
                        $TheModels[] = $v3['id'];
                        if (isset($v3['children'])) {
                            foreach ($v3['children'] as $key4 => $v4) {
                                $db_key = array_search(strtolower($v4['id']), array_column($leon_database, 'db_name'));
                                $db_key = '';
                                $MenuData[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['content'] = empty($db_key) ? $v4['contenta'] : $leon_database[$db_key]['db_note'];
                                $MenuData[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['contenta'] = empty($db_key) ? $v4['contenta'] : $leon_database[$db_key]['db_note'];
                                $TheModels[] = $v4['id'];
                                if (isset($v4['children'])) {
                                    foreach ($v4['children'] as $key5 => $v5) {
                                        $db_key = array_search(strtolower($v5['id']), array_column($leon_database, 'db_name'));
                                        $db_key = '';
                                        $MenuData[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['children'][$key5]['content'] = empty($db_key) ? $v5['contenta'] : $leon_database[$db_key]['db_note'];
                                        $MenuData[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['children'][$key5]['contenta'] = empty($db_key) ? $v5['contenta'] : $leon_database[$db_key]['db_note'];
                                        $TheModels[] = $v5['id'];
                                        if (isset($v5['children'])) {
                                            foreach ($v5['children'] as $key6 => $v6) {
                                                $db_key = array_search(strtolower($v6['id']), array_column($leon_database, 'db_name'));
                                                $db_key = '';
                                                $MenuData[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['children'][$key5]['children'][$key6]['content'] = empty($db_key) ? $v6['contenta'] : $leon_database[$db_key]['db_note'];
                                                $MenuData[$key1]['children'][$key2]['children'][$key3]['children'][$key4]['children'][$key5]['children'][$key6]['contenta'] = empty($db_key) ? $v6['contenta'] : $leon_database[$db_key]['db_note'];

                                                $TheModels[] = $v6['id'];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    $MenuState = 1;
}

$NewMenuData = [];
foreach ($leon_database as $val) {
    // $Blade = json_decode($val['db_data'],true);
    // foreach($Blade as $vv){
    // echo $val['id']." / ".$vv[8]."</br>";
    // }

    $is_inarray = false;
    if (in_array(ucfirst($val['db_name']), $TheModels)) {
        $is_inarray = true;
    }
    if ($is_inarray == false) {
        $NewMenuData[] = ["id" => ucfirst($val['db_name']), "content" => $val['db_note'], "contenta" => $val['db_note']];
    }
}

if (empty($MenuData)) {
    $MenuData[] = ["id" => "Leon", "content" => "佔位置而已", "contenta" => "佔位置而已"];
}
if (empty($NewMenuData)) {
    $NewMenuData[] = ["id" => "Leon", "content" => "佔位置而已", "contenta" => "佔位置而已"];
}
$MenuData_en = json_encode($MenuData, JSON_UNESCAPED_UNICODE);
$NewMenuData_en = json_encode($NewMenuData, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html>
<?php require_once('_require-head.php'); ?>

<body>
    <div class="theme-loader">
        <div class="ball-scale">
            <div class='contain'>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
                <div class="ring">
                    <div class="frame"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            <?php require_once('_require-navbar.php'); ?>
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <?php require_once('_require-nav.php'); ?>
                    <div class="pcoded-content">
                        <div class="pcoded-inner-content">
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <div class="page-header">
                                        <div class="row align-items-end">
                                            <div class="col-lg-8">
                                                <div class="page-header-title">
                                                    <div class="d-inline">
                                                        <h4>選單管理</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="page-header-breadcrumb">
                                                    <ul class="breadcrumb-title">
                                                        <li class="breadcrumb-item"><a href="index-1.htm"><i class="feather icon-home"></i></a></li>
                                                        <li class="breadcrumb-item"><a href="#!">編輯資料表</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page-body">
                                        <a class="btn btn-primary" onclick="blade();">一鍵佈局blade + 選單資料表</a>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div>
                                                            <a class="btn btn-primary" onclick="addgo();">建立主分類</a>
                                                            <a class="btn btn-primary" onclick="cssd();">縮起全部</a>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label" for="db_note">名稱</label>
                                                                        <input type="text" class="form-control" id="db_note" name="db_note">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label" for="db_note">Model (用於後台需要直接篩選的頁面)</label>
                                                                        <input type="text" class="form-control" id="db_model" name="db_model">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label class="col-form-label" for="db_class">Class (次分類)</label>
                                                                        <input type="text" class="form-control" id="db_class" name="db_class">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="feather icon-maximize full-card"></i></li>
                                                                <li><i class="feather icon-minus minimize-card"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="cf nestable-lists">
                                                            <div class="dd" id="nestable"></div>
                                                            <div class="dd" id="nestable2"></div>
                                                            <div class="dd" id="nestable3"></div>
                                                        </div>
                                                        <textarea id="nestable-output" style="width:100%"></textarea>
                                                        <textarea id="nestable2-output" style="width:100%"></textarea>
                                                    </div>
                                                    <button class="btn btn-success btn-square btn-block sweetalert2" onclick="SendData();">保存</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="dtBox"></div>
    <script type="text/javascript" src="files\bower_components\jquery\js\jquery.min.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
    <script type="text/javascript" src="files\bower_components\popper.js\js\popper.min.js"></script>
    <script type="text/javascript" src="files\bower_components\bootstrap\js\bootstrap.min.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js"></script>
    <script type="text/javascript" src="files\bower_components\modernizr\js\modernizr.js"></script>
    <script type="text/javascript" src="files\bower_components\modernizr\js\css-scrollbars.js"></script>
    <script type="text/javascript" src="files\bower_components\nehakadam-DateTimePicker\dist\DateTimePicker.min.js"></script>
    <script type="text/javascript" src="files\assets\pages\jquery.filer\js\jquery.filer.min.js"></script>
    <script type="text/javascript" src="files\bower_components\spectrum\js\spectrum.js"></script>
    <script type="text/javascript" src="files\bower_components\jscolor\js\jscolor.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-minicolors\js\jquery.minicolors.min.js"></script>
    <script type="text/javascript" src="files\bower_components\i18next\js\i18next.min.js"></script>
    <script type="text/javascript" src="files\bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js"></script>
    <script type="text/javascript" src="files\bower_components\i18next-browser-languagedetector\js\i18nextBrowserLanguageDetector.min.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-i18next\js\jquery-i18next.min.js"></script>
    <script type="text/javascript" src="files\assets\pages\advance-elements\custom-picker.js"></script>
    <script type="text/javascript" src="files\assets\js\pcoded.min.js"></script>
    <script type="text/javascript" src="files\assets\js\vartical-layout.min.js"></script>
    <script type="text/javascript" src="files\assets\js\jquery.mCustomScrollbar.concat.min.js"></script>
    <script type="text/javascript" src="files\assets\js\script.js"></script>
    <script type="text/javascript" src="files\bower_components\nehakadam-DateTimePicker\dist\i18n\DateTimePicker-i18n-zh-TW.js"></script>
    <script type="text/javascript" src="textboxio\textboxio\textboxio.js"></script>
    <script type="text/javascript" src="files\bower_components\select2\js\select2.full.min.js"></script>
    <script type="text/javascript" src="files\bower_components\Sortable\js\Sortable.js"></script>
    <script type="text/javascript" src="files\bower_components\sweetalert\js\sweetalert.min.js"></script>
    <!-- data-table js -->
    <script src="files\bower_components\datatables.net\js\jquery.dataTables.min.js"></script>
    <script src="files\bower_components\datatables.net-buttons\js\dataTables.buttons.min.js"></script>
    <script src="files\assets\pages\data-table\js\jszip.min.js"></script>
    <script src="files\assets\pages\data-table\js\pdfmake.min.js"></script>
    <script src="files\assets\pages\data-table\js\vfs_fonts.js"></script>
    <script src="files\assets\pages\data-table\extensions\buttons\js\dataTables.buttons.min.js"></script>
    <script src="files\assets\pages\data-table\extensions\buttons\js\buttons.flash.min.js"></script>
    <script src="files\assets\pages\data-table\extensions\buttons\js\jszip.min.js"></script>
    <script src="files\assets\pages\data-table\extensions\buttons\js\pdfmake.min.js"></script>
    <script src="files\assets\pages\data-table\extensions\buttons\js\vfs_fonts.js"></script>
    <script src="files\assets\pages\data-table\extensions\buttons\js\buttons.colVis.min.js"></script>
    <script src="files\bower_components\datatables.net-buttons\js\buttons.print.min.js"></script>
    <script src="files\bower_components\datatables.net-buttons\js\buttons.html5.min.js"></script>
    <script src="files\bower_components\datatables.net-bs4\js\dataTables.bootstrap4.min.js"></script>
    <script src="files\bower_components\datatables.net-responsive\js\dataTables.responsive.min.js"></script>
    <script src="files\bower_components\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js"></script>
    <script src="excel-v3\dist\jexcel.js"></script>
    <script src="excel-v3\dist\jsuites.js"></script>
    <script type="text/javascript" src="files\assets\js\jquery.nestable.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));
                //, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        var json = [{
                "id": 1,
                "content": "First item",
                "classes": ["dd-nochildren"]
            },
            {
                "id": 2,
                "content": "Second item",
                "children": [{
                        "id": 3,
                        "content": "Item 3"
                    },
                    {
                        "id": 4,
                        "content": "Item 4"
                    },
                    {
                        "id": 5,
                        "content": "Item 5",
                        "value": "Item 5 value",
                        "foo": "Bar",
                        "children": [{
                                "id": 6,
                                "content": "Item 6"
                            },
                            {
                                "id": 7,
                                "content": "Item 7"
                            },
                            {
                                "id": 8,
                                "content": "Item 8"
                            }
                        ]
                    }
                ]
            },
            {
                "id": 9,
                "content": "Item 9"
            },
            {
                "id": 10,
                "content": "Item 10",
                "children": [{
                    "id": 11,
                    "content": "Item 11",
                    "children": [{
                        "id": 12,
                        "content": "Item 12"
                    }]
                }]
            }
        ];
        var lastId = 12;
        var json = <?php echo $MenuData_en; ?>;
        var json1 = <?php echo $NewMenuData_en; ?>;
        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1,
            json: json,
            contentCallback: function(item) {
                var content = item.content || '' ? item.content : item.id;
                content += ' <i>(id = ' + item.id + ')</i><input name="' + item.id + '" type="checkbox" value="">' + item.contentx;
                return content;
            }
        }).on('change', updateOutput);
        $('#nestable3').nestable({
            group: 1,
            json: json,
            contentCallback: function(item) {
                var content = item.content || '' ? item.content : item.id;
                content += ' <i>(id = ' + item.id + ')</i><input name="' + item.id + '" type="checkbox" value="">' + item.contentx;
                return content;
            }
        }).on('change', updateOutput);
        // activate Nestable for list 2
        $('#nestable2').nestable({
            group: 1,
            json: json1,
            contentCallback: function(item) {
                var content = item.content || '' ? item.content : item.id;
                content += ' <i>(id = ' + item.id + ')</i>';
                return content;
            }
        }).on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        updateOutput($('#nestable2').data('output', $('#nestable2-output')));
        updateOutput($('#nestable3').data('output', $('#nestable2-output')));

        $('#nestable-menu').on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
            if (action === 'add-item') {
                var newItem = {
                    "id": lastId,
                    "content": "Item " + lastId
                };
                $('#nestable').nestable('add', newItem);
            }
            if (action === 'replace-item') {
                var replacedItem = {
                    "id": 10,
                    "content": "New item 10",
                    "children": [{
                        "id": ++lastId,
                        "content": "Item " + lastId,
                        "children": [{
                            "id": ++lastId,
                            "content": "Item " + lastId
                        }]
                    }]
                };
                $('#nestable').nestable('replace', replacedItem);
            }
        });


    });

    function cssd() {
        $('.dd').nestable('collapseAll');
    }

    function addgo() {
        var newItem = {
            "id": $("#db_model").val(),
            "content": $("#db_note").val(),
            "contenta": $("#db_note").val(),
            "contentx": $("#db_class").val()
        };
        $('#nestable').nestable('add', newItem);
    }

    function SendData() {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                MenuState: <?php echo $MenuState; ?>,
                id: <?php echo (!empty($leon_menu)) ? 1 : 0; ?>,
                data: $('#nestable-output').val()
            },
            success: function(data) {
                alert("OK");
            }
        });
    }

    function blade() {
        $.ajax({
            url: 'Layout.php',
            type: "POST",
            async: false,
            data: {
                Layout: true
            },
            success: function(data) {
                alert(data);
            }
        });
    }
    </script>

</body>

</html>