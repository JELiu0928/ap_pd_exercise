<?php
require_once('hide_Connections/session_start.php');
require_once('ssp.class.php');
if(isset($_POST['Create'])){
	$leon_database_data = $db->query(sprintf("SELECT * FROM basic_cms_menu"))->fetchAll(PDO::FETCH_ASSOC);
	$Cmsrole = [];
	foreach($leon_database_data as $val){
		$Cmsrole[$val['id']] = ";1;1;1";
	}
	$Cmsrole = json_encode($Cmsrole,JSON_UNESCAPED_UNICODE);
	$rs = $db->exec(sprintf("UPDATE basic_cms_role SET roles = %s",
	SQLStr($Cmsrole, "text")));
	exit();
}
$pagetitle = "元件管理";
$table = 'basic_cms_role';
$primaryKey = 'id';
$columns = array(
	array( 'note'=>'編號','db' => 'id', 'dt' => 0 ),
	array( 'note'=>'標題','db' => 'user_id', 'dt' => 1 ),
	array( 'note'=> '功能','db' => 'id','dt'=> 2,'formatter' => 
		function( $d, $row ) {
			$edit_url = str_replace(".php","",$_SERVER['PHP_SELF']).'-edit.php?id=';
			$del_url = $_SERVER['PHP_SELF'].'?del=';
			return '<a class="btn btn-warning btn-mini" href="'.$edit_url.$row['id'].'"><i class="fa fa-wrench"></i></a>
			<a class="btn btn-danger btn-mini del" href="'.$del_url.$row['id'].'"><i class="fa fa-remove"></i></a>';
		}
	)
);
if(isset($_GET['draw'])){echo json_encode(SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns));exit();}
?>
<!DOCTYPE html>
<html>
<?php require_once('_require-head.php');?>
<body>
<div class="theme-loader"><div class="ball-scale"><div class='contain'><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div><div class="ring"><div class="frame"></div></div></div></div></div>
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <?php require_once('_require-navbar.php');?>
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
				<?php require_once('_require-nav.php');?>
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
													<div class="card-header-right">
														<ul class="list-unstyled card-option">
															<li><i class="feather icon-maximize full-card"></i></li>
															<li><i class="feather icon-minus minimize-card"></i></li>
														</ul>
													</div>
												</div>
												<div class="card-block">
													
													<div class="dt-responsive table-responsive">
														<table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
															<thead>
															<tr>
															 <?php foreach($columns as $val){if($val['dt'] != -1){echo "<th>".$val['note']."</th>";}}?>
															</tr>
															</thead>
															<tbody></tbody>
														</table>
													</div>
												</div>
												<button class="btn btn-success btn-square btn-block" onclick="Create();">啟用所有權限</button>
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
		$(document).ready(function() {$('#responsive-datatable').DataTable({"order": [[ 0, "desc" ]],"processing": true,"serverSide": true,"stateSave": true,"ajax": window.location.pathname + window.location.search,"language": {"url":"files/language.json"}});});
		function Create(){
			$.ajax({
				url: 'Cmsrole.php',
				type: "POST",
				async:false,
				data: {Create:true},
				success: function(data) {
					alert("OK");
				}
			});
		}
	</script>
	
</body>

</html>
