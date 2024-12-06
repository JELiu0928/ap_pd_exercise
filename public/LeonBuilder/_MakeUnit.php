<?php
	//$db_item = $Panda_Class->_SELECT("db_item");
	
	class _MakeUnit
	{
		public function _text($data){
			$value = (!empty($data['value'])) ? $data['value'] : '';
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<input type="text" id="'.$data['name'].'" name="'.$data['name'].'" class="form-control" value="'.$value.'">
				</div>
			</div>';	
		}
		public function _date($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<div class="input-group">
						<input type="text" class="form-control" id="'.$data['name'].'" name="'.$data['name'].'" data-field="date" data-format="'.$data['format'].'" readonly>
						<span class="input-group-addon "><i class="icofont icofont-clock-time"></i></span>
					</div>
				</div>
			</div>	
			';	
		}
		public function _datetime($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<div class="input-group">
						<input type="text" class="form-control" id="'.$data['name'].'" name="'.$data['name'].'" data-field="datetime" data-format="'.$data['format'].'" readonly>
						<span class="input-group-addon "><i class="icofont icofont-clock-time"></i></span>
					</div>
				</div>
			</div>	
			';	
		}
		public function _time($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<div class="input-group">
						<input type="text" class="form-control" id="'.$data['name'].'" name="'.$data['name'].'" data-field="time" data-format="'.$data['format'].'" readonly>
						<span class="input-group-addon "><i class="icofont icofont-clock-time"></i></span>
					</div>
				</div>
			</div>	
			';	
		}
		public function _color($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<input type="text" class="form-control Leoncolorpicker" id="'.$data['name'].'" name="'.$data['name'].'" data-format="rgb" data-opacity="1" value="rgba(0, 0, 0, 1)">
				</div>
			</div>	
			';	
		}
		public function _select($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<select class="select2" id="'.$data['name'].'" name="'.$data['name'].'">';
					foreach($data['data'] as $val){
						print'<option value="'.$val['id'].'">'.$val[$data['field']].'</option>';
					}
			print'	</select>
				</div>
			</div>	
			';	
		}
		public function _selectGroup($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<select class="select2" id="'.$data['name'].'" name="'.$data['name'].'">';
					foreach($data['data'] as $val){
						print'<optgroup label="'.$val[$data['field']].'">';
							foreach($data['data2'] as $val2){
								if($val2['top_id'] == $val['id']){
									print'<option value="'.$val['id'].'">'.$val[$data['field2']].'</option>';
								}
							}
						print'</optgroup>';
					}
			print'	</select>
				</div>
			</div>	
			';	
		}
		public function _selectMultiple($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<select class="select2" id="'.$data['name'].'" name="'.$data['name'].'[]" multiple>';
					foreach($data['data'] as $val){
						print'<option value="'.$val['id'].'">'.$val[$data['field']].'</option>';
					}
			print'	</select>
				</div>
			</div>	
			';	
		}
		public function _selectMultipleGroup($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<select class="select2" id="'.$data['name'].'" name="'.$data['name'].'[]" multiple>';
					foreach($data['data'] as $val){
						print'<optgroup label="'.$val[$data['field']].'">';
							foreach($data['data2'] as $val2){
								if($val2['top_id'] == $val['id']){
									print'<option value="'.$val['id'].'">'.$val[$data['field2']].'</option>';
								}
							}
						print'</optgroup>';
					}
			print'	</select>
				</div>
			</div>	
			';	
		}
		public function _textarea($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<textarea id="'.$data['name'].'" name="'.$data['name'].'" class="form-control" style="height:300px;"> </textarea>
				</div>
			</div>	
			';	
		}
		public function _textboxio($data){
			print'
			<div class="col-md-'.$data['col'].'">
				<div class="form-group">
					<label class="col-form-label" for="'.$data['name'].'">'.$data['label'].'</label>
					<textarea id="'.$data['name'].'" name="'.$data['name'].'" class="textboxio" style="height:300px;"> </textarea>
				</div>
			</div>	
			';	
		}
		public function _sonTableHtml($data){
			print'
			<div class="accordion-panel">
				<div class="accordion-heading" role="tab" id="heading-'.$data['name'].'">
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
						<a class="accordion-msg" data-toggle="collapse" href="#collapse-'.$data['name'].'" aria-expanded="true" aria-controls="collapse-'.$data['name'].'">-</a>
					</h3>
				</div>
				<div id="collapse-'.$data['name'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'.$data['name'].'">
					<div class="accordion-content accordion-desc">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label class="col-form-label" for="inputSuccess1">文字框</label>
									<input type="text" class="form-control">
								</div>
							</div>																			
						</div>	
					</div>
				</div>
			</div>
			';	
		}
		public function _sonTable($data){
			print '
			<div class="card">
				<div class="card-header">
					<button class="btn btn-primary" data-html="">新增</button>
					<button class="btn btn-danger">刪除所選</button>
					<div class="card-header-right">
						<ul class="list-unstyled card-option">
							<li><i class="feather icon-maximize full-card"></i></li>
						</ul>
					</div>
				</div>
				<div class="card-block accordion-block">
					<ul class="nav nav-tabs md-tabs" role="tablist">';
					foreach($data['tab'] as $key=>$val){
					$active = ($key == 0) ? 'active':'';
						print'	
						<li class="nav-item">
							<a class="nav-link '.$active.'" data-toggle="tab" href="#sonTable_'.$key.'" role="tab">'.$val['label'].'</a>
							<div class="slide"></div>
						</li>';
					}						
			print'	</ul>';
					foreach($data['tab'] as $key=>$val){
			print'	<div class="tab-pane" id="#sonTable_'.$key.'" role="tabpanel">
						<div class="row">
						
							<div class="col-md-3">
								<div class="form-group">
									<label class="col-form-label" for="inputSuccess1">文字框</label>
									<input type="text" class="form-control">
								</div>
							</div>	
							<div class="tab-content card-block">
						</div>	
					</div>';
					}
			// print'	<div class="tab-pane" id="aa2" role="tabpanel">
						// <div class="sortable" role="tablist" aria-multiselectable="true">
							// <div class="accordion-panel">
								// <div class="accordion-heading" role="tab" id="heading-'.$data['name'].'">
									// <div class="checkbox-zoom zoom-default">
										// <label>
											// <input type="checkbox" name="" value="">
											// <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-default"></i></span>
										// </label>
										// <span class="sort-number">1</span>
									// </div>
									// <div class="accordion-del">
										// <button type="button" class="btn btn-danger waves-effect waves-light"><span class="icofont icofont-ui-delete"></span></button>			
									// </div>
									// <h3 class="card-title accordion-title">
										// <a class="accordion-msg" data-toggle="collapse" href="#collapse-'.$data['name'].'" aria-expanded="true" aria-controls="collapse-'.$data['name'].'">-</a>
									// </h3>
								// </div>
								// <div id="collapse-'.$data['name'].'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-'.$data['name'].'">
									// <div class="accordion-content accordion-desc">
										// <div class="row">
											// <div class="col-md-3">
												// <div class="form-group">
													// <label class="col-form-label" for="inputSuccess1">文字框</label>
													// <input type="text" class="form-control">
												// </div>
											// </div>																			
										// </div>	
									// </div>
								// </div>
							// </div>
						// </div>
					// </div>
			print'	</div>
			</div>			
			';
			

		}
	}
	$_MakeUnit = new _MakeUnit();
?>