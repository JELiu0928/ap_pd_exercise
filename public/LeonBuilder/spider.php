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
                                                    <h4>常用程式碼</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
													<li class="breadcrumb-item"><a href="index-1.htm"><i class="feather icon-home"></i></a></li>
													<li class="breadcrumb-item"><a href="#!">常用程式碼</a></li>
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
													<h5>常用程式碼</h5>
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
																<label class="col-form-label" for="inputSuccess1">資料列表抓取</label>
																<textarea class="form-control" id="text2" style="height:150px;width:100%;">var GetSaveData = [];
$('.wraps a').each(function(){
    GetSaveData.push({
        w_title:$(this).find('.tit').text(),
        w_description:$(this).find('.list_title').text(),
        o_img:$(this).find('.csr_list_img').find('img').attr('src'),
        o_img_icon:$(this).find('.csr_list_img').find('img').attr('src'),
        post_date:$(this).find('.list_date').text(),
    });
});
console.log(JSON.stringify(GetSaveData));</textarea>
															</div>
														</div>																				
														<div class="col-md-6">
															<div class="form-group">
																<label class="col-form-label" for="inputSuccess1">Model CustomWhere</label>
																<textarea class="form-control" id="text2" style="height:150px;width:100%;">		foreach($json as $val){
			$model = M('news');
			$newdata = new $model;
			foreach($val as $key=>$v){
				$newdata->$key = ($key == 'o_img') ? FmsFile::where('title',pathinfo($val['o_img'])['filename'])->first()->id : $v;
			}
			$newdata->save();
		}</textarea>
															</div>
														</div>																				
													</div>
												</div>
												<button class="btn btn-success btn-square btn-block sweetalert2">保存</button>
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
		$(".form-control").focus(function() {
			var $this = $(this);
			$this.select();
			$this.mouseup(function() {
				$this.unbind("mouseup");
				return false;
			});
		});
		function BasicBase(){
			$.ajax({
				url: window.location.pathname + window.location.search,
				type: "POST",
				async:false,
				data: {BasicBase:true},
				success: function(data) {
					alert("OK");
				}
			});
		}
	</script>
	
</body>

</html>
