<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('_Model.php');
if (isset($_GET['id'])) {
    $leon_database = $db->query(sprintf("SELECT * FROM leon_database WHERE id = %s", SQLStr($_GET['id'], "int")))->fetch(PDO::FETCH_ASSOC);
    $other_data = json_decode($leon_database['other_data'], true);
    $db_data = json_decode($leon_database['db_data'], true);
    $model = ucfirst($leon_database['db_name']);
    //抓資料陣列
    $Basic_array = '$array[] = [' . PHP_EOL;
    foreach ($db_data as $val) {
        $Basic_array .= '\'' . $val['name'] . '\'=>$val->getElementByTagName(\'p\')->text(),' . PHP_EOL;
    }
    $Basic_array .= '];';
    //單筆新增
    $OneSave = '$' . $model . ' = M(\'' . $model . '\');' . PHP_EOL;
    $OneSave .= '$' . $model . ' = new $' . $model . '();' . PHP_EOL;
    foreach ($db_data as $val) {
        $OneSave .= '$' . $model . '->' . $val['name'] . ' = $val["' . $val['name'] . '"]; //' . $val['note'] . PHP_EOL;
    }
    $OneSave .= '$' . $model . '->save();';

    $MultipleSave = '$' . $model . '[] = [' . PHP_EOL;
    foreach ($db_data as $val) {
        $MultipleSave .= '	"' . $val['name'] . '" => $val["' . $val['name'] . '"], //' . $val['note'] . PHP_EOL;
    }
    $MultipleSave .= '];' . PHP_EOL;
    $MultipleSave .= 'M(\'' . $model . '\')::insert($' . $model . ');';

    //表格
    $table = '<div class="list-group-wrapper"><div class="list-group-title">' . $leon_database['db_note'] . '</div><ul class="list-group">';
    foreach ($db_data as $val) {
        $table .= '<li><span>' . $val['note'] . '</span><p>{{$' .  strtolower($model) . '[\'' . $val['name'] . '\']}}</p></li>' . PHP_EOL;
    }
    $table .= '</ul></div>';
    //
    $Basic_Code = '';
    $Basic_Code .= '//無more' . PHP_EOL;
    $Basic_Code .= '$' . $model . ' = M(\'' . $model . '\')::isVisible()->get()->toArray();' . PHP_EOL;
    $Basic_Code .= 'return View::make( $locale.\'.aaa.index\',' . PHP_EOL;
    $Basic_Code .= '[' . PHP_EOL;
    $Basic_Code .= '	\'' . $model . '\' => $' . $model . ',' . PHP_EOL;
    $Basic_Code .= ']);' . PHP_EOL;

    $Basic_Code1 = '';
    $Basic_Code1 .= '//有more\n';
    $Basic_Code1 .= '$MoreCount = 10; //每頁筆數' . PHP_EOL;
    $Basic_Code1 .= '$skip = (isset($_POST[\'skip\'])) ? $_POST[\'skip\'] : 0;' . PHP_EOL;
    $Basic_Code1 .= '$' . $model . ' = M(\'' . $model . '\')::isVisible();' . PHP_EOL;
    $Basic_Code1 .= 'if(!empty($class_main)){' . PHP_EOL;
    $Basic_Code1 .= '	$' . $model . ' = $' . $model . '->where(\'class_id\',$class_main);' . PHP_EOL;
    $Basic_Code1 .= '	//Json判斷' . PHP_EOL;
    $Basic_Code1 .= '	$' . $model . ' = $' . $model . '->whereRaw(\'json_length(class_main) > 0\');\n';
    $Basic_Code1 .= '	$' . $model . ' = $' . $model . '->whereRaw(\'json_length(class_main) > 0 and JSON_SEARCH(class_main, \'all\', ?) IS NOT NULL\',[$class_main]);' . PHP_EOL;
    $Basic_Code1 .= '}' . PHP_EOL;
    $Basic_Code1 .= '$' . $model . '_total = $' . $model . '->count();' . PHP_EOL;
    $Basic_Code1 .= '$' . $model . ' = $' . $model . '->skip($skip)->take($MoreCount)->get()->toArray();' . PHP_EOL;
    $Basic_Code1 .= '$have_next = (($' . $model . '_total - $MoreCount - $skip) > 0) ? true : false;' . PHP_EOL;
    $Basic_Code1 .= 'if($skip > 0){' . PHP_EOL;
    $Basic_Code1 .= '	$callback = View::make( $locale.\'.aaa.ajax.index\',' . PHP_EOL;
    $Basic_Code1 .= '	[' . PHP_EOL;
    $Basic_Code1 .= '		\'' . $model . '\' => $' . $model . ',' . PHP_EOL;
    $Basic_Code1 .= '	])->render();' . PHP_EOL;
    $Basic_Code1 .= '	return [\'data\'=>$callback,\'next\'=>$have_next];' . PHP_EOL;
    $Basic_Code1 .= '}else{' . PHP_EOL;
    $Basic_Code1 .= '	return View::make( $locale.\'.aaa.index\',' . PHP_EOL;
    $Basic_Code1 .= '	[' . PHP_EOL;
    $Basic_Code1 .= '		\'' . $model . '\' => $' . $model . ',' . PHP_EOL;
    $Basic_Code1 .= '	]);' . PHP_EOL;
    $Basic_Code1 .= '}' . PHP_EOL;

    $Basic_Code2 = '\n';
    $Basic_Code2 .= '//使用JOIN\n';
    $Basic_Code2 .= '$JoinDB = M_table(\'Join\');\n';
    $Basic_Code2 .= '$' . $model . 'DB = M_table(\'' . $model . '\');\n';
    $Basic_Code2 .= '$' . $model . ' = M(\'' . $model . '\')::isVisible($' . $model . 'DB)->select(DB::raw($' . $model . 'DB.\'.*,\'.$BrandDB.\'.brand_color as brand_color\'));\n';
    $Basic_Code2 .= 'if(!empty($class_main)){\n';
    $Basic_Code2 .= '	$' . $model . ' = $' . $model . '->where($' . $model . 'DB.\'.class_id\',$class_main);\n';
    $Basic_Code2 .= '	//Json判斷\n';
    $Basic_Code2 .= '	$' . $model . ' = $' . $model . '->whereRaw(\'json_length(\'.$' . $model . 'DB.\'.class_main) > 0 and JSON_SEARCH(\'.$' . $model . 'DB.\'.class_main, \'all\', ?) IS NOT NULL\',[$class_main]);			\n';
    $Basic_Code2 .= '}\n';
    $Basic_Code2 .= '$' . $model . ' = $' . $model . '->leftJoin($BrandDB, $' . $model . 'DB.\'.brand_id\', \'=\', $BrandDB.\'.id\');\n';
    $Basic_Code2 .= '$' . $model . '_total = $' . $model . '->count();\n';
    $Basic_Code2 .= '$' . $model . ' = $' . $model . '->skip($skip)->take($MoreCount)->get()->toArray();\n';
    $Basic_Code2 .= '$have_next = (($' . $model . '_total - $MoreCount - $skip) > 0) ? true : false;\n';
    $Basic_Code2 .= 'if($skip > 0){\n';
    $Basic_Code2 .= '	$callback = View::make( $locale.\'.' . $model . '.ajax.index\',\n';
    $Basic_Code2 .= '	[\n';
    $Basic_Code2 .= '		\'' . $model . '\' => $' . $model . ',\n';
    $Basic_Code2 .= '	])->render();\n';
    $Basic_Code2 .= '	return [\'data\'=>$callback,\'next\'=>$have_next];\n';
    $Basic_Code2 .= '}else{\n';
    $Basic_Code2 .= '	return View::make( $locale.\'.shopping.shopping_QA\',\n';
    $Basic_Code2 .= '	[\n';
    $Basic_Code2 .= '		\'' . $model . '\' => $' . $model . ',\n';
    $Basic_Code2 .= '	]);\n';
    $Basic_Code2 .= '}\n';
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
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="feather icon-maximize full-card"></i></li>
                                                                <li><i class="feather icon-minus minimize-card"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="OneSave">單筆新增</label>
                                                                    <textarea class="form-control" id="OneSave" style="height:350px;width:100%;"><?php echo ($OneSave) ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="MultipleSave">多筆新增</label>
                                                                    <textarea class="form-control" id="MultipleSave" style="height:350px;width:100%;"><?php echo $MultipleSave; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="Basic_array">抓資料的陣列</label>
                                                                    <textarea class="form-control" id="Basic_array" style="height:350px;width:100%;"><?php echo $Basic_array ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="Basic_Code">基本CODE</label>
                                                                    <textarea class="form-control" id="Basic_Code" style="height:350px;width:100%;"><?php echo $Basic_Code ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="Basic_Code1">基本CODE-more</label>
                                                                    <textarea class="form-control" id="Basic_Code1" style="height:350px;width:100%;"><?php echo $Basic_Code1 ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="Basic_Code2">基本CODE-join</label>
                                                                    <textarea class="form-control" id="Basic_Code2" style="height:350px;width:100%;"><?php echo $Basic_Code2 ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="jsondata">JS傳資料用</label>
                                                                    <textarea class="form-control" id="jsondata" style="height:350px;width:100%;"><?php echo $table ?></textarea>
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
    <script>
    $(".form-control").focus(function() {
        var $this = $(this);
        $this.select();
        $this.mouseup(function() {
            $this.unbind("mouseup");
            return false;
        });
    });
    </script>


</body>

</html>