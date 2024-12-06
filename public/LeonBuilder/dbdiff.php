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
        echo '<a href="getdatabase.php?database=' . $row[0] . '">' . $row[0] . '</a></br>';
    }
    echo '請在網址後加上?database=資料表名稱';
    exit();
}

if (isset($_POST['db_name'])) {
    $db_name = $_POST['db_name'];
    $tableList = array();
    $rs = $db->query(sprintf("show FULL columns from $db_name"));
    while ($row = $rs->fetch(PDO::FETCH_NUM)) {
        if (!in_array($row[0], ['id', 'rank', 'is_reviewed', 'is_preview', 'is_visible', 'branch_id', 'create_id', 'created_at', 'updated_at', 'temp_url'])) {
            $note = $row[8] ?: str_replace("tw_", "", $row[0]);
            $tableListTemp = array("show" => "false", "search" => "false", "son" => "false", "disable" => "false", "note" => $note, "name" => str_replace("tw_", "", $row[0]), "type" => $row[1], "formtype" => "textInput", "model" => "", "tip" => "", "tab" => "", "img" => "");
            $NewArray2 = [];
            foreach ($tableListTemp as $key => $vv) {
                $NewArray2[$key] = $vv;
            }
            $tableList[] = $NewArray2;
        }
    }
    $other_data = ["is_onepage" => "0", "is_rank" => "0", "is_visible" => "0", "isDelete" => "0", "isCreate" => "0", "isExport" => "0", "isClone" => "0", "isShareModel" => "0"];
    $db_name = str_replace("tw_", "", $db_name);
    $Save_DB = ["db_note" => $db_name, "db_name" => $db_name, "db_data" => json_encode($tableList, JSON_UNESCAPED_UNICODE), 'other_data' => json_encode($other_data, JSON_UNESCAPED_UNICODE)];
    $Panda_Class->_INSERT("leon_database", $Save_DB);
    exit();
}
$tableListA = array();
$tableListB = array();
$rs = $db->query(sprintf("select TABLE_NAME as name from information_schema.tables where table_schema='$set_database';"));
while ($row = $rs->fetch(PDO::FETCH_NUM)) {
    $tableListA[] = $row[0];
}
$rs = $db->query(sprintf("select TABLE_NAME as name from information_schema.tables where table_schema='$tdatabase';"));
while ($row = $rs->fetch(PDO::FETCH_NUM)) {
    $tableListB[] = $row[0];
}
$diff = [];
//比對兩邊欄位
foreach ($tableListA as $val) {
    $columnsA = $db->query(sprintf("show FULL columns from " . $set_database . "." . $val))->fetchAll(PDO::FETCH_NUM);
    $columnsB = $db->query(sprintf("show FULL columns from " . $tdatabase . "." . $val))->fetchAll(PDO::FETCH_NUM);

    $columnsA_Field = array_column($columnsA, 0);
    $columnsA_Type = array_column($columnsA, 1);
    $columnsB_Field = array_column($columnsB, 0);
    $columnsB_Type = array_column($columnsB, 1);

    $result = array_diff($columnsA_Field, $columnsB_Field);
    if (!empty($result)) {
        print_r($result);
        exit();
    }
}

echo 'ok';
exit();

$leon_database = $db->query(sprintf("SELECT id,db_name FROM leon_database"))->fetchAll(PDO::FETCH_ASSOC);

$nameDataTemp = array_column($leon_database, 'db_name');
$nameData = [];
foreach ($nameDataTemp as $val) {
    $nameData[str_replace("tw_", "", $val)] = str_replace("tw_", "", $val);
}

$nameData[] = "migrations";
$nameData[] = "mysession";
while ($row = $rs->fetch(PDO::FETCH_NUM)) {
    $name = str_replace("tw_", "", $row[0]);
    if (strpos($name, 'basic_') === false && strpos($name, 'leon_') === false && !in_array($name, $nameData)) {
        $tableList[] = $row[0];
    }
}

if (isset($_GET['all'])) {
    $leon_database = $db->query(sprintf("SELECT * FROM `$tdatabase`.`basic_cms_menu`"))->fetchAll(PDO::FETCH_ASSOC);
    foreach ($tableList as $val) {
        $db_name = $val;
        $isShareModel = '1';
        if (strpos($db_name, 'tw_') !== false) {
            $isShareModel = '0';
        }
        $tableListArr = array();
        $rs = $db->query(sprintf("show FULL columns from " . $tdatabase . "." . $db_name));
        while ($row = $rs->fetch(PDO::FETCH_NUM)) {
            if (!in_array($row[0], ['web_title', 'meta_keyword', 'meta_description', 'ga_code', 'gtm_code', 'fb_code', 'og_title', 'og_image', 'og_description', 'structured', 'seo_h1', 'url_name', 'seo_title', 'seo_keyword', 'seo_meta', 'seo_ga', 'seo_gtm', 'seo_img', 'seo_og_title', 'seo_pixel', 'seo_description', 'seo_json', 'id', 'rank', 'is_reviewed', 'is_preview', 'is_visible', 'branch_id', 'create_id', 'created_at', 'updated_at', 'temp_url', 'fantasy_hide', 'w_rank', 'wait_del', 'parent_id', 'second_id'])) {
                $note = $row[8] ?: str_replace("tw_", "", $row[0]);
                // $tableListTemp = array("show" => "false", "search" => "false", "son" => "false", "disable" => "false", "note" => $note, "name" => str_replace("tw_", "", $row[0]), "type" => explode("(", "$row[1]")[0], "formtype" => "textInput", "model" => "", "tip" => "", "tab" => "", "img" => "");
                $tableListTemp = array("show" => "false", "search" => "false", "son" => "false", "disable" => "false", "note" => $note, "name" => $row[0], "type" => explode("(", "$row[1]")[0], "formtype" => "textInput", "model" => "", "tip" => "", "tab" => "", "img" => "");
                $NewArray2 = [];
                foreach ($tableListTemp as $key => $vv) {
                    $NewArray2[$key] = $vv;
                }
                $tableListArr[] = $NewArray2;
            }
        }
        $other_data = ["is_onepage" => "0", "is_rank" => "1", "is_visible" => "1", "isDelete" => "0", "isCreate" => "0", "isExport" => "1", "isClone" => "0", "isShareModel" => $isShareModel];
        $db_name = str_replace("tw_", "", $db_name);

        $db_note = $db_name;
        foreach ($leon_database as $Baseval) {
            if (strtolower(str_replace("_", "", $db_name)) == strtolower(str_replace("_", "", $Baseval['model']))) {
                $db_note = $Baseval['title'];
                break;
            }
        }
        $Save_DB = ["db_note" => $db_note, "db_name" => $db_name, "db_data" => json_encode($tableListArr, JSON_UNESCAPED_UNICODE), 'other_data' => json_encode($other_data, JSON_UNESCAPED_UNICODE)];
        $Panda_Class->_INSERT("`leon_database`", $Save_DB);
    }
    $tableList = [];
}
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
                                                        <h4>編輯資料表</h4>
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
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <a class="btn btn-primary" onclick="Create();">全部擷取</a>
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="feather icon-maximize full-card"></i></li>
                                                                <li><i class="feather icon-minus minimize-card"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="">
                                                            <?php foreach ($tableList as $val) { ?>
                                                            <div><?php echo $val ?><a style="padding-left: 15px;" class="CreateData" data-name="<?php echo $val ?>">擷取</a></div>
                                                            <?php } ?>
                                                        </div>
                                                        <div id="spreadsheet"></div>
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
    </div>
    <div id="dtBox"></div>
    <script type="text/javascript" src="files\bower_components\jquery\js\jquery.min.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-ui\js\jquery-ui.min.js"></script>
    <script type="text/javascript" src="files\bower_components\popper.js\js\popper.min.js"></script>
    <script type="text/javascript" src="files\bower_components\bootstrap\js\bootstrap.min.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-slimscroll\js\jquery.slimscroll.js"></script>
    <script type="text/javascript" src="files\bower_components\modernizr\js\modernizr.js"></script>
    <script type="text/javascript" src="files\bower_components\modernizr\js\css-scrollbars.js"></script>
    <script type="text/javascript" src="files\bower_components\nehakadam-DateTimePicker\dist\DateTimePicker.min.js">
    </script>
    <script type="text/javascript" src="files\assets\pages\jquery.filer\js\jquery.filer.min.js"></script>
    <script type="text/javascript" src="files\bower_components\spectrum\js\spectrum.js"></script>
    <script type="text/javascript" src="files\bower_components\jscolor\js\jscolor.js"></script>
    <script type="text/javascript" src="files\bower_components\jquery-minicolors\js\jquery.minicolors.min.js"></script>
    <script type="text/javascript" src="files\bower_components\i18next\js\i18next.min.js"></script>
    <script type="text/javascript" src="files\bower_components\i18next-xhr-backend\js\i18nextXHRBackend.min.js">
    </script>
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

    <script type="text/javascript">
    <?php if (isset($_GET['db_name'])) { ?>
    var data = <?php echo json_encode($tableList, JSON_UNESCAPED_UNICODE) ?>;
    var spreadsheet = jexcel(document.getElementById('spreadsheet'), {
        data: data,
        colWidths: [60, 60, 60, 60, 150, 150, 100, 150, 150, 300, 100, 80],
        minDimensions: [5, 10],
        columns: [{
                key: 'show',
                type: 'checkbox',
                title: '表格'
            },
            {
                key: 'search',
                type: 'checkbox',
                title: '搜尋'
            },
            {
                key: 'son',
                type: 'checkbox',
                title: '次分類'
            },
            {
                key: 'disable',
                type: 'checkbox',
                title: '禁改'
            },
            {
                key: 'note',
                type: 'text',
                title: '欄位描述'
            },
            {
                key: 'name',
                type: 'text',
                title: '欄位名稱'
            },
            {
                key: 'type',
                type: 'autocomplete',
                title: '欄位類型',
                source: ['int', 'text', 'varchar', 'date', 'datetime', 'double', 'json', '內容', '內容圖片',
                    'SEO', 'SEO無網址'
                ]
            },
            {
                key: 'formtype',
                type: 'autocomplete',
                title: '表單類型',
                source: [
                    'checkbox',
                    'multiData',
                    'multiFile',
                    'multiImage',
                    'multiImageGroup',
                    'radio',
                    'select',
                    'selectmulti',
                    'switch',
                    'textArea',
                    'textAreaDrag',
                    'textInput',
                    'textInputDrag',
                    'textInputDrop',
                ]
            },
            {
                key: 'model',
                type: 'text',
                title: '選單資料來源'
            },
            {
                key: 'tip',
                type: 'text',
                title: 'Tip提示'
            },
            {
                key: 'tab',
                type: 'text',
                title: '換頁標籤'
            },
            {
                key: 'img',
                type: 'text',
                title: '圖片來源'
            },
        ]
    });
    <?php } ?>

    function Create() {
        location.href = window.location.pathname + '?database=<?php echo $tdatabase; ?>&all=true'
    }

    $(".CreateData").click(function() {
        var db_name = $(this).attr('data-name');
        $(this).closest('div').remove();
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                db_name: db_name,
            },
            success: function(data) {

            }
        });
    });
    </script>

</body>

</html>