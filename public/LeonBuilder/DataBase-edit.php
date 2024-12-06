<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('_Class.php');
require_once('_Model.php');
if (isset($_POST['upmysql'])) {

    $leon_database = $db->query(sprintf("SELECT * FROM leon_database WHERE id = %s", SQLStr($_POST['id'], "int")))->fetch(PDO::FETCH_ASSOC);
    $basic_branch_origin_unit = $db->query(sprintf("SELECT * FROM basic_branch_origin_unit"))->fetchAll(PDO::FETCH_ASSOC);
    foreach ($basic_branch_origin_unit as $branck) {
        $other_data = json_decode($leon_database['other_data'], true);
        if (isset($other_data['isShareModel']) && $other_data['isShareModel']) {
            $db_name = $_POST['db_name'];
        } else {
            $db_name = $branck['locale'] . '_' . $_POST['db_name'];
        }
        if ($_POST['upmysql'] == "item") {
            $tableList = array();
            $rs = $db->query(sprintf("show FULL columns from $db_name"));
            while ($row = $rs->fetch(PDO::FETCH_NUM)) {
                $tableList[] = array("name" => $row[0], "type" => $row[1], "note" => $row[8]);
            }
            //判斷欄位是否存在
            $db_data = json_decode($leon_database['db_data'], true);
            echo $DB_Class->_CreateNull($db_name, $db_data, $tableList);
        }
        if ($_POST['upmysql'] == "allclear") {
            $db->exec("DROP TABLE " . $db_name);
            $db_data = json_decode($leon_database['db_data'], true);

            $Sql = $DB_Class->_Create($db_name, $db_data, $_POST['db_note']);
            $db->exec($Sql);
        }
        if ($_POST['upmysql'] == "allkeep") {
            $allkeep = $db->query(sprintf("SELECT * FROM " . $db_name))->fetchAll(PDO::FETCH_ASSOC);
            $db->exec("DROP TABLE " . $db_name);
            $db_data = json_decode($leon_database['db_data'], true);
            $Sql = $DB_Class->_Create($db_name, $db_data, $_POST['db_note']);
            $db->exec($Sql);
            //判斷
            $savelist = [];
            if (!empty($allkeep)) {
                foreach ($allkeep[0] as $key => $val) {
                    $result = $db->query(sprintf("SHOW COLUMNS FROM " . $db_name . " LIKE '" . $key . "'"))->fetch(PDO::FETCH_ASSOC);
                    if (empty($result)) {
                        foreach ($allkeep as $index => $v) {
                            unset($allkeep[$index][$key]);
                        }
                    }
                    // if (!in_array($key, ['id', 'fantasy_hide', 'w_rank', 'is_reviewed', 'is_preview', 'is_visible', 'wait_del', 'branch_id', 'parent_id', 'second_id', 'temp_url', 'updated_at', 'created_at', 'create_id'])) {
                    //     $is_have = false;
                    //     foreach ($db_data as $v) {
                    //         if ($v['name'] == $key) {
                    //             $is_have = true;
                    //         }
                    //     }
                    //     if (!$is_have) {
                    //         foreach ($allkeep as $index => $v) {
                    //             unset($allkeep[$index][$key]);
                    //         }
                    //     }
                    // }
                }
                $Panda_Class->_INSERTS($db_name, $allkeep);
            }
        }
    }
    exit();
}
if (isset($_POST['data'])) {
    $Data = $_POST['data'];
    $NewData = [];

    $new['is_onepage'] = (isset($_POST['is_onepage'])) ? $_POST['is_onepage'] : 0;
    $new['is_visible'] = (isset($_POST['is_visible'])) ? $_POST['is_visible'] : 0;
    $new['is_rank'] = (isset($_POST['is_rank'])) ? $_POST['is_rank'] : 0;
    $new['isDelete'] = (isset($_POST['isDelete'])) ? $_POST['isDelete'] : 0;
    $new['isCreate'] = (isset($_POST['isCreate'])) ? $_POST['isCreate'] : 0;
    $new['isExport'] = (isset($_POST['isExport'])) ? $_POST['isExport'] : 0;
    $new['isClone'] = (isset($_POST['isClone'])) ? $_POST['isClone'] : 0;
    $new['isSeo'] = (isset($_POST['isSeo'])) ? $_POST['isSeo'] : 0;
    $new['isSeoUrl'] = (isset($_POST['isSeoUrl'])) ? $_POST['isSeoUrl'] : 0;
    $new['isShareModel'] = (isset($_POST['isShareModel'])) ? $_POST['isShareModel'] : 0;
    $new['isAdminhide'] = (isset($_POST['isAdminhide'])) ? $_POST['isAdminhide'] : 0;
    $new['isClose'] = (isset($_POST['isClose'])) ? $_POST['isClose'] : 0;
    $new['isContent'] = (isset($_POST['isContent'])) ? $_POST['isContent'] : 0;
    $new['isHr'] = (isset($_POST['isHr'])) ? $_POST['isHr'] : 0;

    $other_data = json_encode($new, JSON_UNESCAPED_UNICODE);
    foreach ($Data as $key => $val) {
        if ($val['name'] != "") {
            $NewData[] = $val;
        }
    }
    $Data_en = json_encode($NewData, JSON_UNESCAPED_UNICODE);
    $SQL_data = array("db_note" => $_POST['db_note'], "db_name" => $_POST['db_name'], "branch_name" => $_POST['branch_name'], "db_data" => $Data_en, "other_data" => $other_data, "id" => $_POST['id']);
    $Panda_Class->_UPDATE("leon_database", $SQL_data);
    exit();
}
if (isset($_GET['id'])) {

    $leon_database = $db->query(sprintf("SELECT * FROM leon_database WHERE id = %s", SQLStr($_GET['id'], "int")))->fetch(PDO::FETCH_ASSOC);
    $other_data = json_decode($leon_database['other_data'], true);

    $db_data = json_decode($leon_database['db_data']);
    $NewArray = $db_data;
    // echo json_encode($NewArray);
    // exit();
    // $NewArray = [];
    // foreach ($db_data as $key => $val) {
    //     $NewArray2 = [];
    //     foreach ($val as $vv) {
    //         $NewArray2[] = $vv;
    //     }
    //     $NewArray[] = $NewArray2;
    // }
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
                                                        <h4><?php echo $leon_database['db_note'] ?></h4>
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
                                                        <a class="btn btn-primary" onclick="Create('keep');">重建整個資料表(保留資料)</a>
                                                        <a class="btn btn-primary" onclick="CreateItem();">只建立不存在欄位</a>
                                                        <a class="btn btn-primary" onclick="Create('clear');">重建整個資料表(清空資料)</a>
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="feather icon-maximize full-card"></i></li>
                                                                <li><i class="feather icon-minus minimize-card"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="db_note">資料表描述</label>
                                                                    <input type="text" class="form-control" id="db_note" name="db_note" value="<?php echo $leon_database['db_note'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="db_name">資料表名稱</label>
                                                                    <input type="text" class="form-control" id="db_name" name="db_name" value="<?php echo $leon_database['db_name'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="branch_name">Cms分館資料夾</label>
                                                                    <input type="text" class="form-control" id="branch_name" name="branch_name" value="<?php echo $leon_database['branch_name'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="is_onepage">獨立</label>
                                                                        <input type="checkbox" id="is_onepage" name="is_onepage" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="is_visible">顯示</label>
                                                                        <input type="checkbox" id="is_visible" name="is_visible" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="is_rank">排序</label>
                                                                        <input type="checkbox" id="is_rank" name="is_rank" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isDelete">禁刪</label>
                                                                        <input type="checkbox" id="isDelete" name="isDelete" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isCreate">禁增</label>
                                                                        <input type="checkbox" id="isCreate" name="isCreate" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isExport">禁匯</label>
                                                                        <input type="checkbox" id="isExport" name="isExport" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isClone">禁複</label>
                                                                        <input type="checkbox" id="isClone" name="isClone" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isSeo">isSeo</label>
                                                                        <input type="checkbox" id="isSeo" name="isSeo" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isSeoUrl">isSeoUrl</label>
                                                                        <input type="checkbox" id="isSeoUrl" name="isSeoUrl" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isShareModel">共用</label>
                                                                        <input type="checkbox" id="isShareModel" name="isShareModel" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isAdminhide">免管理者</label>
                                                                        <input type="checkbox" id="isAdminhide" name="isAdminhide" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isClose">isClose</label>
                                                                        <input type="checkbox" id="isClose" name="isClose" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isContent">編輯器</label>
                                                                        <input type="checkbox" id="isContent" name="isContent" value="1">
                                                                    </span>
                                                                    <span class="ck_p">
                                                                        <label class="col-form-label" for="isHr">hr</label>
                                                                        <input type="checkbox" id="isHr" name="isHr" value="1">
                                                                    </span>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="spreadsheet"></div>
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
    <?php if ($other_data['is_visible']) { ?>$("#is_visible").prop("checked", true);
    <?php } ?>
    <?php if ($other_data['isDelete']) { ?>$("#isDelete").prop("checked", true);
    <?php } ?>
    <?php if ($other_data['is_onepage']) { ?>$("#is_onepage").prop("checked", true);
    <?php } ?>
    <?php if ($other_data['is_rank']) { ?>$("#is_rank").prop("checked", true);
    <?php } ?>

    <?php if (isset($other_data['isCreate']) && $other_data['isCreate']) { ?>$("#isCreate").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isExport']) && $other_data['isExport']) { ?>$("#isExport").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isClone']) && $other_data['isClone']) { ?>$("#isClone").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isSeo']) && $other_data['isSeo']) { ?>$("#isSeo").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isSeoUrl']) && $other_data['isSeoUrl']) { ?>$("#isSeoUrl").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isShareModel']) && $other_data['isShareModel']) { ?>$("#isShareModel").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isAdminhide']) && $other_data['isAdminhide']) { ?>$("#isAdminhide").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isClose']) && $other_data['isClose']) { ?>$("#isClose").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isContent']) && $other_data['isContent']) { ?>$("#isContent").prop("checked", true);
    <?php } ?>
    <?php if (isset($other_data['isHr']) && $other_data['isHr']) { ?>$("#isHr").prop("checked", true);
    <?php } ?>

    let columns = [{
            width: 50,
            key: 'show',
            type: 'checkbox',
            title: '表格'
        },
        {
            width: 50,
            key: 'show_rank',
            type: 'text',
            title: '表排'
        },
        {
            width: 50,
            key: 'excel',
            type: 'checkbox',
            title: '匯出'
        },
        {
            width: 50,
            key: 'batch',
            type: 'checkbox',
            title: '批次'
        },
        {
            width: 50,
            key: 'search',
            type: 'checkbox',
            title: '搜尋'
        },
        {
            width: 50,
            key: 'son',
            type: 'checkbox',
            title: '次分類'
        },
        {
            width: 50,
            key: 'disable',
            type: 'checkbox',
            title: '禁改'
        },
        {
            width: 50,
            key: 'lang',
            type: 'checkbox',
            title: '多語'
        },
        {
            width: 130,
            key: 'note',
            type: 'text',
            title: '欄位描述'
        },
        {
            width: 130,
            key: 'name',
            type: 'text',
            title: '欄位名稱'
        },
        {
            width: 130,
            key: 'type',
            type: 'autocomplete',
            title: '欄位類型',
            source: ['int', 'text', 'varchar', 'date', 'datetime', 'double', 'float', 'json', '內容', '內容圖片',
                'SEO', 'SEO無網址',
                'tinyint',
                'smallint',
                'mediumint',
                'bigint',
                'decimal',
                'real',
                'bit',
                'boolean',
                'serial',
                'timestamp',
                'time',
                'year',
                'char',
                'varchar',
                'tinytext',
                'mediumtext',
                'longtext',
                'binary',
                'varbinary',
                'tinyblob',
                'mediumblob',
                'blob',
                'longblob',
                'enum',
                'set',
                'geometry',
                'point',
                'linestring',
                'polygon',
                'multipoint',
                'multilinestring',
                'multipolygon',
                'geometrycollection'
            ]
        },
        {
            width: 130,
            key: 'formtype',
            type: 'autocomplete',
            title: '表單類型',
            source: [
                'textInput',
                'lang_textInput',
                'textInputTarget',
                'textInputTargetAcc',
                'textArea',
                'lang_textArea',
                'radio_btn',
                'radio_area',
                'select2',
                'select2Multi',
                'imageGroup',
                'imageGroup_all',
                'imageGroup_3size',
                'imageGroup_array',
                'colorPicker',
                'datePicker',
                'filePicker',
                'inputHidden',
                'sn_textArea',
                'numberInput',
                'reviewed_radio_btn',
                'select',
                'selectBydata',
                'selectMulti',
                'selectMultiBydata',
                'selectGroup',
                'selectGroupDownward',
                'selectGroupUpward',
                'dateRange',
            ]
        },
        {
            width: 120,
            key: 'model',
            type: 'text',
            title: '選單資料來源'
        },
        {
            width: 80,
            key: 'tip',
            type: 'text',
            title: 'Tip提示'
        },
        {
            width: 80,
            key: 'tab',
            type: 'text',
            title: '換頁標籤'
        },
        {
            width: 80,
            key: 'img',
            type: 'text',
            title: '圖片來源'
        },
        {
            width: 80,
            key: 'other',
            type: 'text',
            title: '其他'
        },
    ]
    var data = '<?php echo json_encode($NewArray) ?>';
    data = JSON.parse(data);
    let newData = [];
    data.map(function(item, index) {
        let temparr = [];
        for (const key in columns) {
            let val = item[columns[key]['key']] || '';
            temparr.push(val);
        }
        newData.push(temparr);
    });
    let colWidths = columns.map((function(value, index) {
        return value['width'];
    }));

    var spreadsheet = jexcel(document.getElementById('spreadsheet'), {
        data: newData,
        colWidths: colWidths,
        minDimensions: [5, 10],
        columns: columns
    });

    function Create(action) {
        if (action == 'clear') {
            if (confirm("重建資料會不見喔!")) {
                $.ajax({
                    url: window.location.pathname + window.location.search,
                    type: "POST",
                    async: false,
                    data: {
                        id: <?php echo $_GET['id'] ?>,
                        upmysql: 'allclear',
                        db_name: $("#db_name").val(),
                        db_note: $("#db_note").val(),
                        branch_name: $("#branch_name").val(),
                    },
                    success: function(data) {
                        alert("OK");
                    }
                });
            }
        } else {
            $.ajax({
                url: window.location.pathname + window.location.search,
                type: "POST",
                async: false,
                data: {
                    id: <?php echo $_GET['id'] ?>,
                    upmysql: 'allkeep',
                    db_name: $("#db_name").val(),
                    db_note: $("#db_note").val(),
                    branch_name: $("#branch_name").val()
                },
                success: function(data) {
                    alert("OK");
                }
            });
        }

    }

    function CreateItem() {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                id: <?php echo $_GET['id'] ?>,
                upmysql: 'item',
                db_name: $("#db_name").val()
            },
            success: function(data) {
                $("#sql").html(data);
            }
        });
    }

    function SendData() {
        var is_onepage = 0;
        var is_rank = 0;
        var is_visible = 0;
        var isDelete = 0;
        var isCreate = 0;
        var isExport = 0;
        var isClone = 0;
        var isSeo = 0;
        var isSeoUrl = 0;
        var isShareModel = 0;
        var isAdminhide = 0;
        var isClose = 0;
        var isContent = 0;
        var isHr = 0;
        if ($("#is_onepage").is(':checked')) {
            is_onepage = 1;
        }
        if ($("#is_rank").is(':checked')) {
            is_rank = 1;
        }
        if ($("#is_visible").is(':checked')) {
            is_visible = 1;
        }
        if ($("#isDelete").is(':checked')) {
            isDelete = 1;
        }
        if ($("#isCreate").is(':checked')) {
            isCreate = 1;
        }
        if ($("#isExport").is(':checked')) {
            isExport = 1;
        }
        if ($("#isClone").is(':checked')) {
            isClone = 1;
        }
        if ($("#isSeo").is(':checked')) {
            isSeo = 1;
        }
        if ($("#isSeoUrl").is(':checked')) {
            isSeoUrl = 1;
        }
        if ($("#isShareModel").is(':checked')) {
            isShareModel = 1;
        }
        if ($("#isAdminhide").is(':checked')) {
            isAdminhide = 1;
        }
        if ($("#isClose").is(':checked')) {
            isClose = 1;
        }
        if ($("#isContent").is(':checked')) {
            isContent = 1;
        }
        if ($("#isHr").is(':checked')) {
            isHr = 1;
        }
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                id: <?php echo $_GET['id'] ?>,
                db_note: $("#db_note").val(),
                db_name: $("#db_name").val(),
                branch_name: $("#branch_name").val(),
                is_onepage: is_onepage,
                is_rank: is_rank,
                is_visible: is_visible,
                isDelete: isDelete,
                isCreate: isCreate,
                isExport: isExport,
                isClone: isClone,
                isSeo: isSeo,
                isSeoUrl: isSeoUrl,
                isShareModel: isShareModel,
                isAdminhide: isAdminhide,
                isClose: isClose,
                isContent: isContent,
                isHr: isHr,
                data: spreadsheet.getData()
            },
            success: function(data) {
                alert("OK");
            }
        });
    }
    </script>

</body>

</html>