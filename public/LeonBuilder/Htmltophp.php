<?php
require_once('hide_Connections/session_start.php');
require_once('_Model.php');
function dir_path($path)
{
	$path = str_replace('\\', '/', $path);
	if (substr($path, -1) != '/') $path = $path . '/';
	return $path;
}
function dir_list($path, $exts = '', $list = array())
{
	$path = dir_path($path);
	$files = glob($path . '*');
	foreach ($files as $v) {
		if (!$exts || preg_match('/\.($exts)/i', $v)) {
			$list[] = $v;
			if (is_dir($v)) {
				$list = dir_list($v, $exts, $list);
			}
		}
	}
	return $list;
}
$folderList = [];
# 指定目錄路徑
$directory = '../';

# 列出所有檔案或目錄，去除「.」與「..」目錄
$items = array_diff(scandir($directory), array('..', '.'));

# 輸出檔案或目錄
foreach ($items as $item) {
    if (is_dir($directory . $item)) {
        $folderList[] = $item;
    }
}

if (isset($_POST['BasicBase'])) {
	$r = dir_list($_POST['BasicBase']);
	if ($_POST['List'] == 'gettw') {
		$data_arr = [];
		$tw_list = [];

		$index = 0;
		if ($_POST['type'] != 'set') {
			echo '<table>';
		}
		foreach ($r as $val) {
			$filename = str_replace(".blade", "", pathinfo($val, PATHINFO_FILENAME));
			$NowbladeData = [];
			if (strpos($val, '.php') !== false) {
				$TempData = [];
				$file = fopen($val, "r+");
				$fileindex = 0;

				while (!feof($file)) {
					$str = fgets($file);
					//檢查是否還有中文字
					if ($_POST['type'] == 'reget') {
						if (preg_match('/[\x{4e00}-\x{9fff}]+/u', $str, $matches) && !preg_match('/{{/u', $str, $matches)  && !preg_match('/<!(.*?)>/u', $str, $matches)  && !preg_match('/\/\//u', $str, $matches)) {
							if ($fileindex == 0) {
								echo pathinfo($val, PATHINFO_FILENAME) . '</br>';
							}
							echo $str . "</br>";
							$fileindex++;
						}
					} else {
						preg_match_all('/>(.*?)<|".*?"|\'.*?\'/u', $str, $content);
						foreach ($content[0] as $v) {
							$string = substr($v, 1, -1);
							if (preg_match('/[\x{4e00}-\x{9fff}]+/u', $string, $matches) && !preg_match('/{{/u', $string, $matches)) {
								// if (in_array($string, $NowbladeData)) {
								// $key = array_search($string, $NowbladeData);
								// $str = str_replace($v, substr($v, 0, 1) . "{{trans('setting.".$filename."_" . $key . "')}}" . substr($v, -1, 1), $str);
								// } else {

								// }
								$str = str_replace($v, substr($v, 0, 1) . "{{trans('setting." . $filename . "_" . $fileindex . "')}}" . substr($v, -1, 1), $str);
								//if (!in_array($string, $NowbladeData)) {
								$NowbladeData[] = $string;
								//$tw_list[$index] = $string;
								if ($fileindex == 0 && $_POST['type'] != 'set') {
									//echo '//' . pathinfo($val, PATHINFO_FILENAME) . '</br>';
									echo '<tr><td style="background-color: #ffc107;">' . pathinfo($val, PATHINFO_FILENAME) . '</td><td></td></tr>';
								}
								if ($_POST['type'] == 'set') {
									echo "'" . $filename . "_" . $fileindex . "'=>'" . $string . "',</br>";
									//echo '<tr><td>'.$filename.'_'.$fileindex.'</td><td>'.$string.'</td></tr>';
								} else {
									//echo $filename."_" . $fileindex . "\t\t\t\t\t" . $string . "</br>";
									echo '<tr><td>' . $filename . '_' . $fileindex . '</td><td>' . $string . '</td></tr>';
								}
								$index++;
								$fileindex++;
								//}
							}
						}
						//要替換的
						$TempData[] = $str;
					}
				}
				fclose($file);

				//在寫回去
				if ($_POST['type'] == 'set') {
					$file = fopen($val, "w");
					foreach ($TempData as $TempDataval) {
						fwrite($file, $TempDataval);
					}
					fclose($file);
				}
			}
		}
		if ($_POST['type'] != 'set') {
			echo '</table>';
		}
		//print_r($NowbladeData);
		// foreach($tw_list as $key=>$val){
		// echo "'txt_" . $key . "'=>'" . $val . "',</br>";
		// }
	}
	if ($_POST['List'] == 'Controller') {
		$is_group = true;
		foreach ($r as $key => $val) {
			if (strpos($val, '.html') !== false) {
				if ($is_group) {
					echo '資料夾:' . str_replace($_POST['BasicBase'], "", dirname($r[$key]));
					echo '</br>';
					$is_group = false;
				}
				echo 'public function ' . basename($val, ".html") . '($branch,$locale,Request $request)</br>';
				echo '{</br>';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;return View::make( $locale.\'.' . str_replace($_POST['BasicBase'], "", dirname($r[$key])) . '.' . basename($val, ".html") . '\',</br>';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;[</br></br>';
				echo '&nbsp;&nbsp;&nbsp;&nbsp;]);</br>';
				echo '}</br>';
				//echo '<div>	Route::get(\'/'.basename($val, ".html").'\',\'Front\\'.ucfirst(str_replace($_POST['BasicBase'].'/',"",dirname($r[$key]))).'Controller@'.basename($val, ".html").'\')->name("'.ucfirst(str_replace($_POST['BasicBase'].'/',"",dirname($r[$key])).'-'.basename($val, ".html")).'");</div>';
				if (isset($r[$key + 1])) {
					if (dirname($r[$key]) != dirname($r[$key + 1])) {
						echo '</br></br>';
						$is_group = true;
					}
				}
			}
		}
		echo '}</br>';
		exit();
	}
	if ($_POST['List'] == 'Route') {
		$is_group = true;
		foreach ($r as $key => $val) {
			if (strpos($val, '.html') !== false) {
				if ($is_group) {
					echo 'Route::group([\'prefix\'=>\'' . str_replace($_POST['BasicBase'], "", dirname($r[$key])) . '\'],function()</br>';
					echo '{</br>';
					$is_group = false;
				}
				//echo "<div> Route::match(['get', 'post'],'/{class?}','Front\ProductController@index')->name(\"Product-index\");</div>";
				echo '<div>	Route::match([\'get\', \'post\'],\'/' . basename($val, ".html") . '\',\'Front\\' . ucfirst(str_replace($_POST['BasicBase'] . '/', "", dirname($r[$key]))) . 'Controller@' . basename($val, ".html") . '\')->name("' . ucfirst(str_replace($_POST['BasicBase'] . '/', "", dirname($r[$key])) . '-' . basename($val, ".html")) . '");</div>';
				if (isset($r[$key + 1])) {
					if (dirname($r[$key]) != dirname($r[$key + 1])) {
						echo '});</br></br>';
						$is_group = true;
					}
				}
			}
		}
		echo '});</br>';
		exit();
	}
	if ($_POST['List'] == 'cover') {
        $site_name = $_POST['site_name'];
        $Controllers = (!empty($site_name)) ? '_' . $site_name : '';
        $resources = (!empty($site_name)) ? '/resources/' . $site_name : '';
		foreach ($r as $val) {
			if (strpos($val, '.html') !== false) {
				if (!is_file(str_replace(".html", ".blade.php", $val))) {

					copy($val, str_replace(".html", ".blade.php", $val));
					//
					$file = fopen(str_replace(".html", ".blade.php", $val), "r+");
					$i = 10;
					$content = $contentAll = array();
					$is_add = false;
					$is_ajax = true;
                    $shareClass_state = false;
                    $shareScript_state = false;
                    $mainClass_state = false;
                    $mainScript_state = false;
					$bodyClass = $bodyDataPage = "";
                    $shareClass = [];
                    $shareScript = [];
                    $mainClass = [];
                    $mainScript = [];
					while (!feof($file)) {
						$str = fgets($file);
						//前面先加基本程式
						if (strpos($str, '<body') !== false) {
							$dom = new DomDocument;
							libxml_use_internal_errors(true);
							$dom->loadHTML($str);
							libxml_clear_errors();

							$el = $dom->getElementsByTagName("body");
							foreach ($el as $vv) {
								$bodyClass = $vv->getAttribute("class");
								$bodyDataPage = $vv->getAttribute("data-page");
							}
						}
						if (strpos($str, '<main') !== false) {
							$is_add = true;
							$is_ajax = false;
						}
						if (strpos($str, '<footer') !== false) {
							$is_add = false;
						}
                        if (strpos($str, '個別頁面 CSS') !== false) {
                            $shareClass_state = true;
                        }
                        if ($shareClass_state) {
                            if (strpos($str, '<link') !== false) {
                                $str = str_replace("\"./", "\"/resources/" . $site_name . "/", $str);
                                $str = str_replace(".css", ".css?v={{BaseFunction::getV()}}", $str);
                                $shareClass[] = $str;
                            }
                        }
                        if (strpos($str, '主頁面 CSS') !== false) {
                            $shareClass_state = false;
                            $mainClass_state = true;
                        }
                        if ($mainClass_state) {
                            if (strpos($str, '<link') !== false) {
                                $str = str_replace("\"./", "\"/resources/" . $site_name . "/", $str);
                                $str = str_replace(".css", ".css?v={{BaseFunction::getV()}}", $str);
                                $mainClass[] = $str;
                            }
                            if (strpos($str, '</head>') !== false) {
                                $mainClass_state = false;
                            }
                        }
                        if (strpos($str, '個別頁面引用 JS') !== false) {
                            $shareScript_state = true;
                        }
                        if ($shareScript_state) {
                            if (strpos($str, '<script') !== false) {
                                $str = str_replace("\"./", "\"/resources/" . $site_name . "/", $str);
                                $str = str_replace(".css", ".js?v={{BaseFunction::getV()}}", $str);
                                $str = str_replace("<script", "<script nonce=\"{{\$nonce}}\"", $str);
                                $shareScript[] = $str;
                            }
                        }
                        if (strpos($str, '主頁面 JS') !== false) {
                            $shareScript_state = false;
                            $mainScript_state = true;
                        }
                        if ($mainScript_state) {
                            if (strpos($str, '<script') !== false) {
                                $str = str_replace("\"./", "\"/resources/" . $site_name . "/", $str);
                                $str = str_replace(".css", ".js?v={{BaseFunction::getV()}}", $str);
                                $str = str_replace("<script", "<script nonce=\"{{\$nonce}}\"", $str);
                                $mainScript[] = $str;
                            }
                            if (strpos($str, '</body>') !== false) {
                                $mainScript_state = false;
                            }
                        }

						if ($is_add) {
                            $str = str_replace("\"./assets", "\"/resources/" . $site_name . "/assets", $str);
							$content[$i] = $str;
							//print_r($i . " = " . $str.PHP_EOL);
							$i++;
						}
						$contentAll[] = $str;
					}
					fclose($file);
                    $pageClass = implode("", $shareClass) . implode("", $mainClass);
                    $pageScript = implode("", $shareScript) . implode("", $mainScript);
					if (!$is_ajax) {
                        $content[0] = "@extends('Front" . $Controllers . ".template')" . PHP_EOL;
						$content[1] = "  @section('css')" . PHP_EOL;
                        $content[2] = $pageClass;
                        // $content[2] = "  	<link rel=\"stylesheet\" href=\"{{url('" . $resources . "/css/pages/" . basename(str_replace(".html", "", $val)) . ".css?v='.BaseFunction::getV())}}\"/>" . PHP_EOL;
						$content[3] = "  @stop" . PHP_EOL;
						$content[6] = "@section('bodyClass', '" . $bodyClass . "')" . PHP_EOL;
						$content[7] = "@section('bodyDataPage', '" . $bodyDataPage . "')" . PHP_EOL;
						$content[8] = "@section('content')" . PHP_EOL;
                        $content[9] = "	@include('Front" . $Controllers . ".include.header')" . PHP_EOL;

                        $content[$i] = "	@include('Front" . $Controllers . ".include.footer')" . PHP_EOL;
						$content[$i + 1] = "	@section('script')" . PHP_EOL;
                        $content[$i + 2] = $pageScript;
                        // $content[$i + 2] = "	<script nonce=\"{{" . "$" . "nonce}}\" defer src=\"{{url('" . $resources . "/js/pages/" . basename(str_replace(".html", "", $val)) . ".min.js?v='.BaseFunction::getV())}}\"></script>" . PHP_EOL;
						$content[$i + 3] = "	<script>" . PHP_EOL;
						$content[$i + 4] = "	</script>" . PHP_EOL;
						$content[$i + 5] = "	@stop" . PHP_EOL;
						$content[$i + 6] = "@stop" . PHP_EOL;
						//在寫回去
						ksort($content);
						$file = fopen(str_replace(".html", ".blade.php", $val), "w");
						foreach ($content as $key => $val) {
							fwrite($file, $val);
						}
						fclose($file);
					} else {
						ksort($contentAll);
						$file = fopen(str_replace(".html", ".blade.php", $val), "w");
						foreach ($contentAll as $key => $val) {
							fwrite($file, $val);
						}
						fclose($file);
					}
				}
			}
		}
	}

	exit();
}

if (isset($_POST['List']) && $_POST['List'] == true) {
	$r = dir_list($_POST['BasicBase']);
} else { }

$leon_menu = $db->query(sprintf("SELECT * FROM leon_menu WHERE id = 1"))->fetch(PDO::FETCH_ASSOC);

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
                                                        <h4>Html轉php</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="page-header-breadcrumb">
                                                    <ul class="breadcrumb-title">
                                                        <li class="breadcrumb-item"><a href="index-1.htm"><i class="feather icon-home"></i></a></li>
                                                        <li class="breadcrumb-item"><a href="#!">Html轉php</a></li>
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
                                                        <h5>轉換會讓view裡面的html複製一份然後改成blade.php的檔名，存在就不會複製</h5>
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
                                                                    <label class="col-form-label" for="viewpath">View的路徑</label>
                                                                    <input type="text" class="form-control" id="viewpath" name="viewpath" value="">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label" for="site_name">網站路徑名稱</label>
                                                                    <input type="text" class="form-control" id="site_name" name="site_name" value="<?php echo $leon_menu['site_name'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <?php foreach ($folderList as $val) { ?>
                                                                <div onclick='$("#viewpath").val("<?php echo '../../public/' . $val ?>")'><?php echo '../../public/' . $val ?></div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary" onclick="BasicBase();">轉換吧</button>
                                                        <!--<button class="btn btn-primary" onclick="Route();">轉成Route路徑</button>
														<button class="btn btn-primary" onclick="Controller();">轉成Controller路徑</button>-->
                                                        <button class="btn btn-primary" onclick="gettw('');">取得中文字</button>
                                                        <button class="btn btn-primary" onclick="gettw('set');">取得setting格式並替換</button>
                                                        <button class="btn btn-primary" onclick="gettw('reget');">檢查是否還有中文字</button>
                                                        <button class="btn btn-primary" onclick="geten();">取得英文字</button>
                                                        <div class="row">
                                                            <div class="col-md-12" id="Route_list">

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

    <script type="text/javascript">
    function BasicBase() {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                List: 'cover',
                BasicBase: $("#viewpath").val(),
                site_name: $("#site_name").val()
            },
            success: function(data) {
                alert("OK");
            }
        });
    }

    function Route() {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                List: 'Route',
                BasicBase: $("#viewpath").val()
            },
            success: function(data) {
                //$("#Route").html('');
                $("#Route_list").html(data);
            }
        });
    }

    function Controller() {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                List: 'Controller',
                BasicBase: $("#viewpath").val()
            },
            success: function(data) {
                //$("#Route").html('');
                $("#Route_list").html(data);
            }
        });
    }

    function gettw(type) {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                List: 'gettw',
                type: type,
                BasicBase: $("#viewpath").val()
            },
            success: function(data) {
                //$("#Route").html('');
                $("#Route_list").html(data);
            }
        });
    }

    function geten() {
        $.ajax({
            url: window.location.pathname + window.location.search,
            type: "POST",
            async: false,
            data: {
                List: 'geten',
                BasicBase: $("#viewpath").val()
            },
            success: function(data) {
                //$("#Route").html('');
                $("#Route_list").html(data);
            }
        });
    }
    </script>

</body>

</html>