<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('_MakeUnit.php');
if (isset($_POST['data'])) {
    $Save_DB = [];
    $Data = $_POST['data'];
    $temp_key = 0;

    $other_data = [
        "is_onepage" => $_POST['is_onepage'], "is_rank" => $_POST['is_rank'], "is_visible" => $_POST['is_visible'], "isDelete" => $_POST['isDelete'], "isCreate" => $_POST['isCreate'], "isExport" => $_POST['isExport'], "isClone" => $_POST['isClone']
    ];
    foreach ($Data as $key => $val) {
        //當類型沒填，視為表格名稱
        if ($val['note'] != "" && $val['name'] != "" && $val['type'] == "") {
            $Save_DB[$key] = ["db_note" => $val['note'], "db_name" => $val['name'], "db_data" => [], 'other_data' => json_encode($other_data, JSON_UNESCAPED_UNICODE)];
            $temp_key = $key;
        }
        if ($val['name'] != "" && $val['type'] != "") {
            // $val['show'] = ($val['name'] == 'w_title') ? 'true' : 'false';
            $Save_DB[$temp_key]['db_data'][] = $val;
        }
    }
    foreach ($Save_DB as $key => $val) {
        $Save_DB[$key]['db_data'] = json_encode($val['db_data'], JSON_UNESCAPED_UNICODE);
    }
    $Panda_Class->_INSERTS("leon_database", $Save_DB);

    exit();
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
                                                        <h4>建立資料表</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="page-header-breadcrumb">
                                                    <ul class="breadcrumb-title">
                                                        <li class="breadcrumb-item"><a href="index-1.htm"><i class="feather icon-home"></i></a></li>
                                                        <li class="breadcrumb-item"><a href="#!">建立資料表</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div>第一列為資料表描述及名稱</div>
                                                        <div>若是文章編輯器，欄位類型選內容，其他隨便打</div>
                                                        <div class="row">
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
    <?php require_once('_require-footer.php'); ?>

    <script type="text/javascript">
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

    let colWidths = columns.map((function(value, index) {
        return value['width'];
    }));

    var spreadsheet = jexcel(document.getElementById('spreadsheet'), {
        data: [],
        colWidths: colWidths,
        minDimensions: [5, 10],
        columns: columns
    });

    function SendData() {
        var is_onepage = 0;
        var is_rank = 0;
        var is_visible = 0;
        var isDelete = 0;
        var isCreate = 0;
        var isExport = 0;
        var isClone = 0;
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
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                db_note: $("#db_note").val(),
                db_name: $("#db_name").val(),
                is_onepage: is_onepage,
                is_rank: is_rank,
                is_visible: is_visible,
                isDelete: isDelete,
                isCreate: isCreate,
                isExport: isExport,
                isClone: isClone,
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