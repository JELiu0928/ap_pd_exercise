<?php
require_once('hide_Connections/session_start.php');
require_once('hide_Connections/Panda-class.php');
require_once('ssp.class.php');

if(isset($_POST['action'])){
	$leon_database = $db->query(sprintf("SELECT * FROM leon_database WHERE id = %s",SQLStr($_POST['id'], "int")))->fetch(PDO::FETCH_ASSOC);
	$other_data = json_decode($leon_database['other_data'], true);
	$other_data[$_POST['action']] = $_POST['state'];
	$other_data = json_encode($other_data,JSON_UNESCAPED_UNICODE);
	$SQL_data = array("other_data"=>$other_data,"id"=>$_POST['id']);
	$Panda_Class->_UPDATE("leon_database",$SQL_data);	
	exit();
}

if(isset($_GET['del'])){
	$rs = $db->exec(sprintf("DELETE FROM leon_database WHERE id=%s",SQLStr($_GET['del'], "int")));
	header("Location: ".$_SERVER['PHP_SELF']);exit();
}

$pagetitle = "元件管理";
$table = 'leon_database';
$primaryKey = 'id';
$columns = array(
	array( 'note'=>'編號','db' => 'id', 'dt' => 0 ),
	array( 'note'=>'標題','db' => 'db_note', 'dt' => 1,'search'=>true ),
	array( 'note'=>'名稱','db' => 'db_name', 'dt' => 2 ,'search'=>true),
	array( 'note'=> '功能','db' => 'other_data','dt'=> 3,'formatter' => 
		function( $d, $row ) {
			$other_data = json_decode($row['other_data'], true);
			$is_onepage = (isset($other_data['is_onepage']) && $other_data['is_onepage']) ? 'info':'secondary';
			$is_visible = (isset($other_data['is_visible']) && $other_data['is_visible']) ? 'info':'secondary';
			$is_rank 	= (isset($other_data['is_rank']) && $other_data['is_rank']) ? 'info':'secondary';
			$isDelete 	= (isset($other_data['isDelete']) && $other_data['isDelete']) ? 'info':'secondary';
			$isCreate 	= (isset($other_data['isCreate']) && $other_data['isCreate']) ? 'info':'secondary';
			$isExport 	= (isset($other_data['isExport']) && $other_data['isExport']) ? 'info':'secondary';
			$isClone 	= (isset($other_data['isClone']) && $other_data['isClone']) ? 'info':'secondary';
			return '
			<a class="btn btn-'.$is_onepage.' btn-mini" href="javascript:;" data-id="'.$row['id'].'" data-action="is_onepage" onclick="Change(this);">獨立</a>
			<a class="btn btn-'.$is_visible.' btn-mini" href="javascript:;" data-id="'.$row['id'].'" data-action="is_visible" onclick="Change(this);">顯示</a>
			<a class="btn btn-'.$is_rank.' btn-mini" href="javascript:;" data-id="'.$row['id'].'" data-action="is_rank" onclick="Change(this);">排序</a>
			<a class="btn btn-'.$isDelete.' btn-mini" href="javascript:;" data-id="'.$row['id'].'" data-action="isDelete" onclick="Change(this);">禁刪</a>
			<a class="btn btn-'.$isCreate.' btn-mini" href="javascript:;" data-id="'.$row['id'].'" data-action="isCreate" onclick="Change(this);">禁增</a>
			<a class="btn btn-'.$isExport.' btn-mini" href="javascript:;" data-id="'.$row['id'].'" data-action="isExport" onclick="Change(this);">禁匯</a>
			<a class="btn btn-'.$isClone.' btn-mini" href="javascript:;" data-id="'.$row['id'].'" data-action="isClone" onclick="Change(this);">禁複</a>';
		}
	),
	array( 'note'=> '資料表','db' => 'other_data','dt'=> 4,'formatter' => 
		function( $d, $row ) {
			$other_data = json_decode($row['other_data'], true);
			$isShareModel 	= (isset($other_data['isShareModel']) && $other_data['isShareModel']) ? 'info':'secondary';
			return '
			<a class="btn btn-'.$isShareModel.' btn-mini" href="javascript:;" data-id="'.$row['id'].'" data-action="isShareModel" onclick="Change(this);">共用</a>';
		}
	),
	array( 'note'=> '功能','db' => 'id','dt'=> 5,'formatter' => 
		function( $d, $row ) {
			$edit_url = str_replace(".php","",$_SERVER['PHP_SELF']).'-edit.php?id=';
			$action_url = str_replace(".php","",$_SERVER['PHP_SELF']).'-action.php?id=';
			$del_url = $_SERVER['PHP_SELF'].'?del=';
			return '
			<a class="btn btn-info btn-mini" href="'.$action_url.$row['id'].'">SQL</a>
			<a class="btn btn-warning btn-mini" href="'.$edit_url.$row['id'].'"><i class="fa fa-wrench"></i></a>
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
                                                    <h4>資料表管理</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
													<li class="breadcrumb-item"><a href="index-1.htm"><i class="feather icon-home"></i></a></li>
													<li class="breadcrumb-item"><a href="#!">資料表管理</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="page-body">
									<a class="btn btn-primary" onclick="Create(0);">一鍵建立資料表 + Model檔案</a>
									<a class="btn btn-primary" onclick="Create(1);">一鍵建立資料表</a>
									<a class="btn btn-primary" onclick="Create(2);">一鍵建立資料表(全部重建)</a>
									<div class="row">
										<div class="col-sm-12">
											<div class="card">
												<div class="card-header">
													<a class="btn btn-primary" href="DataBase-add.php">新增資料表</a>
													<div class="card-header-right">
														<ul class="list-unstyled card-option">
															<li><i class="feather icon-maximize full-card"></i></li>
															<li><i class="feather icon-minus minimize-card"></i></li>
														</ul>
													</div>
												</div>
												<div class="card-block">
													<div class="dt-responsive table-responsive">
<table class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
  <tr>
    <th>項目</th>
    <th colspan="3">選項</th>
    <th>是否存在</th>
    <th>備註</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td colspan="6">主要段落</td>
  </tr>
  <tr>
    <td rowspan="13">基本段落樣式</td>
    <td rowspan="3">主標題上 &gt; 圖 &gt; 內文下</td>
    <td>由上至下排列，依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>由上至下排列，依序為主標題 &gt; 影像+描述 &gt; 副標題置左 &gt; 內文＋按鈕置右。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleSL" onclick="Change(this);">有</a></td>
    <td>副標題專用</td>
  </tr>
  <tr>
    <td>由上至下排列，依序為主標題 &gt; 影像+描述 &gt; 副標題置右 &gt; 內文＋按鈕置左。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleSR" onclick="Change(this);">有</a></td>
    <td>副標題專用</td>
  </tr>
  <tr>
    <td rowspan="3">文上圖下</td>
    <td>由上至下排列，依序為主標題 &gt; 副標題 &gt; 內文＋按鈕 &gt; 影像+描述。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleU" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>由上至下排列，依序為主標題置左 &gt; 副標題 + 內文＋按鈕置右 &gt; 影像+描述。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleUL" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>由上至下排列，依序為主標題置右 &gt; 副標題 + 內文＋按鈕置左 &gt; 影像+描述。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleUR" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">圖上文下</td>
    <td>由上至下排列，依序為影像+描述 &gt; 主標題 &gt; 副標題 &gt; 內文＋按鈕。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleD" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>由上至下排列，依序為影像+描述 &gt; 主標題置左 &gt; 副標題 + 內文＋按鈕置右。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleDL" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>由上至下排列，依序為影像+描述 &gt; 主標題置右 &gt; 副標題 + 內文＋按鈕置左。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleDR" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖右文左</td>
    <td>依序為主標題 + 副標題 + 內文＋按鈕置左 &gt; 影像+描述置右。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleL" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖右文左（文繞圖）</td>
    <td>依序為主標題 + 副標題 + 內文＋按鈕置左圍繞影像+描述置右。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleLR" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖左文右</td>
    <td>依序為影像+描述置左 &gt; 主標題 + 副標題 + 內文＋按鈕置右。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleR" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖左文右（文繞圖）</td>
    <td>依序為主標題 + 副標題 + 內文＋按鈕置右圍繞影像+描述置左。</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_articleRR" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="9">TypeFull</td>
    <td rowspan="3">背景 + 純文字</td>
    <td>滿版背景，段落垂直置中，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>滿版背景，段落垂直置左，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull-L" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>滿版背景，段落垂直置右，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull-R" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">背景 + 色塊文字</td>
    <td>滿版背景，內文區域產生色塊，段落垂直置中，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull-Box" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>滿版背景，內文區域產生色塊，段落垂直置左，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull-Box-L" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>滿版背景，內文區域產生色塊，段落垂直置右，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull-Box-R" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">背景 + 色塊垂直切割文字</td>
    <td>滿版背景，內文區域產生色塊，段落置中，垂直切割區塊，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull-BoxSlice" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>滿版背景，內文區域產生色塊，段落置左，垂直切割區塊，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull-BoxSlice-L" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>滿版背景，內文區域產生色塊，段落置右，垂直切割區塊，由上至下依序為主標題 &gt; 影像+描述 &gt; 副標題 &gt; 內文＋按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeFull-BoxSlice-R" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="2">TypeSwiper</td>
    <td>圖左文右</td>
    <td>左至右，影像 &gt; 主標題+ 副標題+ 內文 + 按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeSwiper-L" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖右文左</td>
    <td>左至右，主標題+ 副標題+ 內文 + 按鈕 &gt; 影像</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="_article -typeSwiper-R" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
</tbody>
</table>

<table class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
<thead>
  <tr>
    <th colspan="6">細部零件</th>
  </tr>
</thead>
<tbody>
  <tr>
    <td rowspan="16">基本內容</td>
    <td>段落樣式</td>
    <td></td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="article_style" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">段落文字</td>
    <td>標題欄位</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>副標題欄位</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>內文欄位</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="9">段落文字對齊</td>
    <td rowspan="3">標題對齊設定</td>
    <td>靠左對齊</td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>置中</td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>靠右對齊</td>
	<td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">副標題對齊設定</td>
    <td>靠左對齊</td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>置中</td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>靠右對齊</td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">內文區塊對齊設定</td>
    <td>靠左對齊</td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>置中</td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>靠右對齊</td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">段落文字顏色</td>
    <td>標題文字顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>副標題文字顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>內文顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="15">按鈕設定</td>
    <td>按鈕文字</td>
    <td></td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="2">按鈕連結</td>
    <td>按鈕連結</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>按鈕連結開啟方式</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">按鈕文字對齊</td>
    <td>靠左對齊</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>置中</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>靠右對齊</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">按鈕位置對齊</td>
    <td>靠左對齊</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>置中</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>靠右對齊</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="2">按鈕文字顏色</td>
    <td>顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>hover顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="2">按鈕底色</td>
    <td>顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>hover顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="2">按鈕框線顏色</td>
    <td>顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>hover顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="7">圖 / 影片管理</td>
    <td rowspan="2">圖片</td>
    <td>圖片</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片描述</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">影片</td>
    <td>youtube 影片代碼</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>優庫影片代碼</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>影片截圖</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="2">typeSwiper</td>
    <td>typeSwiper 專用 - 標題</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td>Swiper 專用</td>
  </tr>
  <tr>
    <td>typeSwiper 專用 - 內文</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td>Swiper 專用</td>
  </tr>
  <tr>
    <td rowspan="15">圖片樣式設定</td>
    <td rowspan="5">圖片樣式</td>
    <td>是否為拼圖模式</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>首圖是否放大</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片每列數量設定</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片比例設定</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片垂直對齊設定</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="3">文字與圖片垂直對齊設定</td>
    <td>上</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>中</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>下</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="2">圖片描述</td>
    <td>圖片描述文字顏色</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片描述文字對齊</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="5">圖片輪播</td>
    <td>是否為輪播</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片輪播出現數量</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片輪播 是否自動撥放</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片輪播 是否使用左右箭頭</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td>圖片輪播 是否下方切換按鈕</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td></td>
  </tr>
  <tr>
    <td rowspan="5">TypeFull / Type Swiper 樣式設定</td>
    <td>內文寬度設定</td>
    <td></td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td>TypeFull 專用</td>
  </tr>
  <tr>
    <td>內文底色設定</td>
    <td></td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td>TypeFull 專用</td>
  </tr>
  <tr>
    <td>段落底色設定</td>
    <td></td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td>TypeFull&nbsp;&nbsp;/ Swiper 專用</td>
  </tr>
  <tr>
    <td rowspan="2">背景圖片</td>
    <td>電腦版圖片</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td>TypeFull 專用</td>
  </tr>
  <tr>
    <td>手機板圖片</td>
    <td></td>
    <td><a class="btn btn-secondary btn-mini" href="javascript:;" data-id="" onclick="Change(this);">有</a></td>
    <td>TypeFull 專用</td>
  </tr>
</tbody>
</table>

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
	
	<script type="text/javascript">

		$(document).ready(function() {$('#responsive-datatable').DataTable({"order": [[ 0, "desc" ]],"processing": true,"serverSide": true,"stateSave": true,"ajax": window.location.pathname + window.location.search,"language": {"url":"files/language.json"}});});
		$(document).on('click', "a.del", function() {
			var _url = $( this ).attr('href');
				Swal.fire({
					title: '刪除確認',
					text: "是否刪除此項目?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '是',
					cancelButtonText: '否',
					}).then((result) => {
						if (result.value) {
							location.replace(_url);
						}
					});		
		
			return false;
		});
		
		function Create(type){
			if(confirm("是否操作?")){
				$.ajax({
					url: '_ModelCreate.php',
					type: "POST",
					async:false,
					data: {Create:true,type:type},
					success: function(data) {
						alert("OK");
					}
				});
			}
		}
		function Change(ele){
			var id = $(ele).data('id');
			var action = $(ele).data('action');
			var state = 0;
			var new_class = '';
			var old_class = '';
			if($(ele).hasClass('btn-info')){
				state = 0;
				old_class = 'btn-info';
				new_class = 'btn-secondary';
			}else{
				state = 1;
				old_class = 'btn-secondary';
				new_class = 'btn-info';
			}
			$.ajax({
				url: window.location.pathname + window.location.search,
				type: "POST",
				async:false,
				data: {action:action,id:id,state:state},
				success: function(data) {
					$(ele).removeClass(old_class).addClass(new_class);
				}
			});
		}
	</script>
	
</body>

</html>