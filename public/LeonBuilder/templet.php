<?php
require_once('hide_Connections/session_start.php');
require_once('ssp.class.php');
require_once('_MakeUnit.php');
$pagetitle = "元件管理";

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
                                                    <h4>頁面標題</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
													<li class="breadcrumb-item"><a href="index-1.htm"><i class="feather icon-home"></i></a></li>
													<li class="breadcrumb-item"><a href="#!">頁面標題</a></li>
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
													<h5>基本資料</h5>
													<div class="card-header-right">
														<ul class="list-unstyled card-option">
															<li><i class="feather icon-maximize full-card"></i></li>
															<li><i class="feather icon-minus minimize-card"></i></li>
														</ul>
													</div>
												</div>
												<div class="card-block">
													<div class="row">
														<div class="col-lg-12">
														<?php
														// $_MakeUnit->_text([
															// "col"=>3,
															// "name"=>"aaa",
															// "label"=>"測試看看"
														// ]);
														// $_MakeUnit->_date([
															// "col"=>3,
															// "name"=>"aaa",
															// "label"=>"測試看看",
															// "format"=>"yyyy-MM-dd"
														// ]);
														$_MakeUnit->_sonTable([
															"table"=>"db_class",
															"key"=>"top_id",
															"label"=>"第二層",
															"tab"=>[
																[
																	"label"=>"基本資料",
																	"ui"=>[
																		[
																			"MakeUnit"=>"_text",
																			"col"=>3,
																			"name"=>"aaa",
																			"label"=>"第三層",
																		]
																	]
																],
																[
																	"label"=>"圖片相關",
																	"ui"=>[
																		[
																			"MakeUnit"=>"_text",
																			"col"=>3,
																			"name"=>"aaa",
																			"label"=>"第三層",
																		]
																	]
																]
															]
														]);
														?>
														</div>
														<div class="col-lg-12">
															<div class="alert alert-danger icons-alert">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti-close"></i></button>
																<p><strong>注意事項</strong></p>
																<p>1.這是中文字這是中</p>
															</div>
															<ul class="nav nav-tabs md-tabs " role="tablist">
																<li class="nav-item">
																	<a class="nav-link active" data-toggle="tab" href="#home7" role="tab">基本設定</a>
																	<div class="slide"></div>
																</li>
																<li class="nav-item">
																	<a class="nav-link" data-toggle="tab" href="#profile7" role="tab">資料管理</a>
																	<div class="slide"></div>
																</li>
																<li class="nav-item">
																	<a class="nav-link" data-toggle="tab" href="#messages7" role="tab">檔案管理</a>
																	<div class="slide"></div>
																</li>
																<li class="nav-item">
																	<a class="nav-link" data-toggle="tab" href="#settings7" role="tab">SEO設定</a>
																	<div class="slide"></div>
																</li>
															</ul>
															<!-- Tab panes -->
															<div class="tab-content card-block">
																<div class="tab-pane active" id="home7" role="tabpanel">
																	<div class="row">
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">文字框</label>
																				<input type="text" class="form-control">
																			</div>
																		</div>																			
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">日期</label>
																				<div class="input-group">
																					<input type="text" class="form-control" data-field="date" data-format="yyyy-MM" readonly>
																					<span class="input-group-addon "><i class="icofont icofont-clock-time"></i></span>
																				</div>
																			</div>
																		</div>													
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">日期+時間</label>
																				<div class="input-group">
																					<input type="text" class="form-control" data-field="datetime" data-format="yyyy-MM-dd HH:mm:ss" readonly>
																					<span class="input-group-addon "><i class="icofont icofont-clock-time"></i></span>
																				</div>
																			</div>
																		</div>													
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">時間</label>
																				<div class="input-group">
																					<input type="text" class="form-control" data-field="time" data-format="HH:mm:ss" readonly>
																					<span class="input-group-addon "><i class="icofont icofont-clock-time"></i></span>
																				</div>
																			</div>
																		</div>													
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">顏色選擇</label>
																				<input type="text" class="form-control Leoncolorpicker" data-format="rgb" data-opacity="1" value="rgba(0, 0, 0, 1)">
																			</div>
																		</div>																	
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">單選</label>
																				<select class="select2" name="state">
																				  <option value="AL">Alabama</option>
																				  <option value="WY">Wyoming</option>
																				</select>
																			</div>
																		</div>																	
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">群組選單</label>
																				<select class="select2" name="state">
																					<optgroup label="Alaskan/Hawaiian Time Zone">
																						<option value="AK" data-select2-id="60">Alaska</option>
																						<option value="HI">Hawaii</option>
																					</optgroup>
																					<optgroup label="Alaskan/Hawaiian Time Zone">
																						<option value="AK" data-select2-id="60">Alaska</option>
																						<option value="HI">Hawaii</option>
																					</optgroup>
																				</select>
																			</div>
																		</div>	
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">多選</label>
																				<select class="select2" name="state" multiple>
																				  <option value="AL">Alabama</option>
																				  <option value="WY">Wyoming</option>
																				</select>
																			</div>
																		</div>	
																		<div class="col-md-3">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">群組多選</label>
																				<select class="select2" name="state" multiple>
																					<optgroup label="Alaskan/Hawaiian Time Zone">
																						<option value="AK" data-select2-id="60">Alaska</option>
																						<option value="HI">Hawaii</option>
																					</optgroup>
																					<optgroup label="Alaskan/Hawaiian Time Zone">
																						<option value="AK" data-select2-id="60">Alaska</option>
																						<option value="HI">Hawaii</option>
																					</optgroup>
																				</select>
																			</div>
																		</div>	
																		<div class="col-md-12">
																			<div class="form-group">
																				<label class="col-form-label" for="inputSuccess1">內容編輯器</label>
																				<textarea id="w_text" name="w_text" class="textboxio" style="height:300px;"> </textarea>
																			</div>
																		</div>																	
																	</div>
																</div>
																<div class="tab-pane " id="profile7" role="tabpanelaa">
																	<div class="card">
																		<div class="card-header">
																			<button class="btn btn-primary">新增</button>
																			<button class="btn btn-danger">刪除所選</button>
																			<div class="card-header-right">
																				<ul class="list-unstyled card-option">
																					<li><i class="feather icon-maximize full-card"></i></li>
																				</ul>
																			</div>
																		</div>
																		<div class="card-block accordion-block">
																			<div class="sortable" role="tablist" aria-multiselectable="true">
																				<div class="accordion-panel">
																					<div class="accordion-heading" role="tab" id="headingOne">
																						<div class="checkbox-zoom zoom-default">
																							<label>
																								<input type="checkbox" name="" value="">
																								<span class="cr"><i class="cr-icon icofont icofont-ui-check txt-default"></i></span>
																							</label>
																							<span class="sort-number">1</span>
																						</div>
																						<div class="accordion-del">
																							<button type="button" class="btn btn-danger waves-effect waves-light"><span class="icofont icofont-ui-delete"></span></button>			
																						</div>
																						<h3 class="card-title accordion-title">
																							<a class="accordion-msg" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																								標題
																							</a>
																						</h3>
																					</div>
																					<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
																						<ul class="nav nav-tabs md-tabs " role="tablist">
																							<li class="nav-item">
																								<a class="nav-link active" data-toggle="tab" href="#aa1" role="tab">基本設定</a>
																								<div class="slide"></div>
																							</li>
																							<li class="nav-item">
																								<a class="nav-link" data-toggle="tab" href="#aa2" role="tab">資料管理</a>
																								<div class="slide"></div>
																							</li>
																						</ul>
																						<div class="tab-content card-block">
																							<div class="tab-pane" id="aa1" role="tabpanel">
																								<div class="row">
																									<div class="col-md-3">
																										<div class="form-group">
																											<label class="col-form-label" for="inputSuccess1">文字框</label>
																											<input type="text" class="form-control">
																										</div>
																									</div>	
																								</div>	
																							</div>
																							<div class="tab-pane" id="aa2" role="tabpanel">
																								<div class="sortable" role="tablist" aria-multiselectable="true">
																									<div class="accordion-panel">
																										<div class="accordion-heading" role="tab" id="headingOne">
																											<div class="checkbox-zoom zoom-default">
																												<label>
																													<input type="checkbox" name="" value="">
																													<span class="cr"><i class="cr-icon icofont icofont-ui-check txt-default"></i></span>
																												</label>
																												<span class="sort-number">1</span>
																											</div>
																											<div class="accordion-del">
																												<button type="button" class="btn btn-danger waves-effect waves-light"><span class="icofont icofont-ui-delete"></span></button>			
																											</div>
																											<h3 class="card-title accordion-title">
																												<a class="accordion-msg" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																													標題
																												</a>
																											</h3>
																										</div>
																										<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
																											<div class="accordion-content accordion-desc">
																												<div class="row">
																													<div class="col-md-3">
																														<div class="form-group">
																															<label class="col-form-label" for="inputSuccess1">文字框</label>
																															<input type="text" class="form-control">
																														</div>
																													</div>																			
																													<div class="col-md-3">
																														<div class="form-group">
																															<label class="col-form-label" for="inputSuccess1">日期</label>
																															<div class="input-group">
																																<input type="text" class="form-control" data-field="date" data-format="yyyy-MM-dd" readonly>
																																<span class="input-group-addon "><i class="icofont icofont-clock-time"></i></span>
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
																<div class="tab-pane " id="messages7" role="tabpanel">
																	<div class="card">
																		<div class="card-header">
																			<h5></h5>
																			<div class="card-header-right">
																				<ul class="list-unstyled card-option">
																					<li><i class="feather icon-maximize full-card"></i></li>
																				</ul>
																			</div>
																		</div>
																		<div class="card-block">
																			<div class="sub-title">Example 1</div>
																			<input type="file" name="files[]" class="Leon_OneImage" multiple="multiple">
																		</div>
																	</div>
																</div>
																<div class="tab-pane" id="settings7" role="tabpanel">
																	<div class="card">
																		<div class="card-header">
																			<button class="btn btn-primary">新增</button>
																			<button class="btn btn-danger">刪除所選</button>
																			<div class="card-header-right">
																				<ul class="list-unstyled card-option">
																					<li><i class="feather icon-maximize full-card"></i></li>
																				</ul>
																			</div>
																		</div>
																		<div class="card-block accordion-block">
																			<div class="sortable" role="tablist" aria-multiselectable="true">
																				<div class="accordion-panel">
																					<div class="accordion-heading" role="tab" id="headingOne">
																						<div class="checkbox-zoom zoom-default">
																							<label>
																								<input type="checkbox" name="" value="">
																								<span class="cr"><i class="cr-icon icofont icofont-ui-check txt-default"></i></span>
																							</label>
																							<span class="sort-number">1</span>
																						</div>
																						<div class="accordion-del">
																							<button type="button" class="btn btn-danger waves-effect waves-light"><span class="icofont icofont-ui-delete"></span></button>			
																						</div>
																						<h3 class="card-title accordion-title">
																							<a class="accordion-msg" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
																								標題
																							</a>
																						</h3>
																					</div>
																					<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
																						<div class="accordion-content accordion-desc">
																							<div class="row">
																								<div class="col-md-3">
																									<div class="form-group">
																										<label class="col-form-label" for="inputSuccess1">文字框</label>
																										<input type="text" class="form-control">
																									</div>
																								</div>																			
																								<div class="col-md-3">
																									<div class="form-group">
																										<label class="col-form-label" for="inputSuccess1">日期</label>
																										<div class="input-group">
																											<input type="text" class="form-control" data-field="date" data-format="yyyy-MM-dd" readonly>
																											<span class="input-group-addon "><i class="icofont icofont-clock-time"></i></span>
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
												<button class="btn btn-success btn-square btn-block sweetalert2">新增資料</button>
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
<?php require_once('_require-footer.php');?>	
</body>

</html>
