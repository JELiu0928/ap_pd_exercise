<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('_Class.php');
require_once('_Model.php');

$leon_menu = $db->query(sprintf("SELECT * FROM leon_menu WHERE id = 1"))->fetch(PDO::FETCH_ASSOC);
$setting_data = json_decode($leon_menu['w_setting'], true);

if (isset($_POST['ResetBase'])) {
	$tableList = [];
	$nameData = ['migrations', 'mysession'];
	$rs = $db->query(sprintf("select TABLE_NAME as name from information_schema.tables where table_schema='$set_database';"));
	while ($row = $rs->fetch(PDO::FETCH_NUM)) {
		$name = str_replace("tw_", "", $row[0]);
		if (strpos($name, 'basic_') === false && strpos($name, 'leon_') === false && !in_array($name, $nameData)) {
			$tableList[] = $row[0];
			$db->query(sprintf("DROP TABLE " . $row[0]));
		}
	}
	exit();
}


if (isset($_POST['BasicBase'])) {
	$rs = $db->exec(sprintf("CREATE TABLE IF NOT EXISTS `mysession` (`session_key` char(32) COLLATE utf8_unicode_ci NOT NULL,`session_data` text COLLATE utf8_unicode_ci NOT NULL,`session_expiry` int(11) NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;"));
	$rs = $db->exec(sprintf("ALTER TABLE `mysession` ADD PRIMARY KEY (`session_key`);"));
	$rs = $db->exec(sprintf("CREATE TABLE IF NOT EXISTS `leon_database` (`id` INT NOT NULL AUTO_INCREMENT COMMENT '編號',`db_note` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '描述',`db_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '名稱',`db_data` text NOT NULL COMMENT '資料',`other_data` text NOT NULL COMMENT '資料',PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci COMMENT = 'leon_database'"));
	$rs = $db->exec(sprintf("CREATE TABLE IF NOT EXISTS `leon_menu` (`id` INT NOT NULL AUTO_INCREMENT COMMENT '編號',`db_data` text NOT NULL COMMENT '資料',PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_unicode_ci COMMENT = 'leon_menu'"));

	$setting_data['is_review'] = $_POST['is_review'];
	$setting_data['sub_domain'] = $_POST['sub_domain'];
	$Data_en = json_encode($setting_data, JSON_UNESCAPED_UNICODE);
	$SQL_data = array("w_setting" => $Data_en, "id" => 1);
	$Panda_Class->_UPDATE("leon_menu", $SQL_data);

	$SQL_data = array("is_cms_template_setting" => $setting_data['is_review'], "id" => 1);
	$Panda_Class->_UPDATE("basic_ams_role", $SQL_data);
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
                                                        <h4>初始化資料庫</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="page-header-breadcrumb">
                                                    <ul class="breadcrumb-title">
                                                        <li class="breadcrumb-item"><a href="index-1.htm"><i class="feather icon-home"></i></a></li>
                                                        <li class="breadcrumb-item"><a href="#!">初始化資料庫</a></li>
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
                                                        <h5>初始化資料庫</h5>
                                                        <div class="card-header-right">
                                                            <ul class="list-unstyled card-option">
                                                                <li><i class="feather icon-maximize full-card"></i></li>
                                                                <li><i class="feather icon-minus minimize-card"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="is_review">是否需要審核:需要請填1 basic_branch_origin 須設定</label>
                                                                    <input type="text" class="form-control" id="is_review" name="is_review" value="<?php echo $setting_data['is_review']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="sub_domain">子網域設定，請用逗號區分</label>
                                                                    <input type="text" class="form-control" id="sub_domain" name="sub_domain" value="<?php echo $setting_data['sub_domain']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" onclick="BasicBase();">初始化資料庫 + 更新</button>
                                                        <button class="btn btn-primary" onclick="ResetBase();">重置資料表</button>
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

    <script type="text/javascript">
    function BasicBase() {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                BasicBase: true,
                is_review: $("#is_review").val(),
                sub_domain: $("#sub_domain").val()
            },
            success: function(data) {
                alert("OK");
            }
        });
    }

    function ResetBase() {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                ResetBase: true
            },
            success: function(data) {
                alert("OK");
            }
        });
    }
    </script>

</body>

</html>
