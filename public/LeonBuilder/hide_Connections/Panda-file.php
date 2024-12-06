<?php
	//單檔上傳 $upload_file->_file($path,$_FILES["w_file"],大小限制,舊檔案資料);
	//多檔上傳 $upload_file->_multi_file($path,$_FILES["w_file"],大小限制,舊檔案資料);
	//單圖上傳 $upload_file->_img($path,$_FILES["w_img"],大小限制,array("state"=>true,"type"=>"auto","width"=>800,"hieght"=>600,"watermark"=>false,"watermark_img"=>""),舊檔案資料);
	//多圖上傳 $upload_file->_multi_img($path,$_FILES["w_img"],大小限制,array("state"=>true,"type"=>"auto","width"=>800,"hieght"=>600,"watermark"=>false,"watermark_img"=>""),舊檔案資料);
	
	class Upload_file
	{
		public $max_imgs_size = 5;
		public $max_file_size = 10;
		public function _rename($name)
		{
			$rename = strtoupper(dechex(date('m'))).date('d').substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
			$ext = strtolower(str_replace(".", "", strrchr($name, ".")));
			$rename = $rename.".".$ext;
			return $rename;
		}
		public function _DEL($path,$files)
		{
			foreach($files as $val){
				@unlink($path.$val);
			}
			return true;
		}
		public function _file($path,$file,$size,$old_file = array("name"=>"","file"=>""))
		{
			$file_arr = array();
			if($file["error"] > 0){
				$new_file_name = $old_file['file'];
				$file_arr = $old_file;
			}else{
				if(($file["size"] / 1024) > ($size * 1024)){
					$new_file_name = $old_file['file'];
					$file_arr = $old_file;
				}else{
					$new_file_name = $this->_rename($file["name"]);
					move_uploaded_file($file["tmp_name"],$path.$new_file_name);
					//刪除舊檔案
					if($old_file['file'] != ""){$this->_DEL($path,array($old_file['file']));}
					$file_arr = array("name"=>$file["name"],"file"=>$new_file_name);
				}
			}
			if($file_arr['file'] == ""){$file_arr = array();}
			$file_arr_en = json_encode($file_arr,JSON_UNESCAPED_UNICODE);
			return $file_arr_en;
		}
		public function _multi_file($path,$file,$size,$old_file = "")
		{
			$file_arr = array();
			if($old_file != ""){
				$old_arr = json_decode($old_file, true);
				$file_arr = array_merge($file_arr, $old_arr);
			}
			for($i = 0;$i < count($file['tmp_name']);$i++){
				if($file["error"][$i] > 0){
				}else{
					if(($file["size"][$i] / 1024) > ($size * 1024)){
						
					}else{
						$new_file_name = $this->_rename($file["name"][$i]);
						move_uploaded_file($file["tmp_name"][$i],$path.$new_file_name);
						$file_arr[] = array("name"=>$file["name"][$i],"file"=>$new_file_name);
					}
				}
			}
			$file_arr_en = json_encode($file_arr,JSON_UNESCAPED_UNICODE);
			return $file_arr_en;
		}
		public function _img($path,$file,$size,$setting = array(),$old_file = "")
		{
			$thumb_state 	= (isset($setting['state'])) ? $setting['state'] : false;
			$thumb_type 	= (isset($setting['type'])) ? $setting['type'] : "";
			$thumb_width 	= (isset($setting['width'])) ? $setting['width'] : 0;
			$thumb_hieght 	= (isset($setting['hieght'])) ? $setting['hieght'] : 0;
			$watermark 		= (isset($setting['watermark'])) ? $setting['watermark'] : false;
			$watermark_img 	= (isset($setting['watermark_img'])) ? $setting['watermark_img'] : "";
			$allowedExts 	= array("gif", "jpeg", "jpg", "png");
			
			if($file["error"] > 0){
				$new_file_name = $old_file;
			}else{
				if(($file["size"] / 1024) > ($size * 1024)){
					$new_file_name = $old_file;
				}else{
					$tmp = explode('.', $file["name"]);
					if(in_array(strtolower(end($tmp)), $allowedExts)){
						$new_file_name = $this->_rename($file["name"]);
						move_uploaded_file($file["tmp_name"],$path.$new_file_name);
						//啟用縮圖
						if($thumb_state == true){
							$this->make_thumb($path.$new_file_name,$thumb_width,$thumb_hieght,$thumb_type);
						}
						//啟用浮水印
						if($watermark == true){
							$this->watermark($path.$new_file_name, $watermark_img);
						}
						//高清壓縮
						$this->pictumb($path.$new_file_name,1,80);
						//刪除舊檔案
						if($old_file != ""){$this->_DEL($path,array($old_file));}
					}else{
						$new_file_name = $old_file;
					}
				}
			}
			return $new_file_name;
		}
		public function _multi_img($path,$file,$size,$setting = array(),$old_file = "")
		{
			$thumb_state 	= (isset($setting['state'])) ? $setting['state'] : false;
			$thumb_type 	= (isset($setting['type'])) ? $setting['type'] : "";
			$thumb_width 	= (isset($setting['width'])) ? $setting['width'] : 0;
			$thumb_hieght 	= (isset($setting['hieght'])) ? $setting['hieght'] : 0;
			$watermark 		= (isset($setting['watermark'])) ? $setting['watermark'] : false;
			$watermark_img 	= (isset($setting['watermark_img'])) ? $setting['watermark_img'] : "";
			$allowedExts 	= array("gif", "jpeg", "jpg", "png");
			$file_arr = array();
			if($old_file != ""){
				$file_arr = array_merge($file_arr, $old_file);
			}
			for($i = 0;$i < count($file['tmp_name']);$i++){
				if($file["error"][$i] > 0){
					
				}else{
					if(($file["size"][$i] / 1024) > ($size * 1024)){
						
					}else{
						$tmp = explode('.', $file["name"][$i]);
						if(in_array(strtolower(end($tmp)), $allowedExts)){
							$new_file_name = $this->_rename($file["name"][$i]);
							echo $path.$new_file_name." / ";
							move_uploaded_file($file["tmp_name"][$i],$path.$new_file_name);
							//啟用縮圖
							if($thumb_state == true){
								$this->make_thumb($path.$new_file_name,$thumb_width,$thumb_hieght,$thumb_type);
							}
							//啟用浮水印
							if($watermark == true){
								$this->watermark($path.$new_file_name, $watermark_img);
							}
							//高清壓縮
							$this->pictumb($path.$new_file_name,1,80);
							$file_arr[] = $new_file_name;
						}
					}
				}
			}
			$file_arr_en = json_encode($file_arr,JSON_UNESCAPED_UNICODE);
			return $file_arr_en;
		}
		public function make_thumb($img_name,$new_w,$new_h,$type)
		{	
			$ext=$this->getExtension($img_name);
			if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext) || !strcmp("JPG",$ext) || !strcmp("JPEG",$ext))
			$src_img=imagecreatefromjpeg($img_name);
			if(!strcmp("png",$ext) || !strcmp("PNG",$ext))
			$src_img=imagecreatefrompng($img_name);
			$old_x=imageSX($src_img);
			$old_y=imageSY($src_img);
			$ratio1=$old_x/$new_w;
			$ratio2=$old_y/$new_h;
			$center_draw = 0;
			$old_size = 0;
			//如果圖片都
			if($old_x > $new_w && $old_y > $new_h){
				if($ratio1>$ratio2) {
				$thumb_w=$new_w;
				$thumb_h=$old_y/$ratio1;
					if($type == "fix"){
						$draw_x = ($old_x / 2) - ($old_y / 2);
						$draw_y = 0;
						$old_size = $old_y;
					}
				}
				else    
				{
				$thumb_h=$new_h;
				$thumb_w=$old_x/$ratio2;
					if($type == "fix"){
						$draw_x = 0;
						$draw_y = ($old_y / 2) - ($old_x / 2);
						$old_size = $old_x;
					}
				}
			}else{
				$thumb_w=$old_x;
				$thumb_h=$old_y;
			}
			if($type == "auto"){$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);}
			if($type == "fix"){$dst_img=ImageCreateTrueColor($new_w,$new_h);}
			if($type == ""){$dst_img=ImageCreateTrueColor($new_w,$new_h);}
			imagesavealpha($dst_img, true); 
			$trans_colour = imagecolorallocatealpha($dst_img, 255, 255, 255, 127); 
			imagefill($dst_img, 0, 0, $trans_colour);
			$x = round(($new_w - $thumb_w) / 2);
			$y = round(($new_h - $thumb_h) / 2);
			if($type == "auto"){imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);}
			if($type == "fix"){imagecopyresampled($dst_img,$src_img,0,0,$draw_x,$draw_y,$new_w,$new_h,$old_size,$old_size);}
			if($type == ""){imagecopyresampled($dst_img,$src_img,$x,$y,0,0,$thumb_w,$thumb_h,$old_x,$old_y);}

			if(!strcmp("png",strtolower($ext))){
			header("Content-type: image/png");
			imagepng($dst_img,$img_name,9/100);
			}else{
			imagejpeg($dst_img,$img_name,100);
			}
			imagedestroy($dst_img);
			imagedestroy($src_img);
			return true;
		}
		public function getExtension($str) {$i = strrpos($str,".");if (!$i) { return "";}$l = strlen($str) - $i;$ext = substr($str,$i+1,$l);return $ext;}
		public function watermark($from_filename, $watermark_filename){
			$allow_format = array('jpeg', 'png', 'gif');
			$sub_name = $t = '';
			$img_info = getimagesize($from_filename);
			$width = $img_info['0'] / 2;
			$height = $img_info['1'] / 2;
			$mime = $img_info['mime'];
			list($t, $sub_name) = explode('/', $mime);
			if ($sub_name == 'jpg'){$sub_name = 'jpeg';}
			if (!in_array($sub_name, $allow_format)){return false;}
			$function_name = 'imagecreatefrom' . $sub_name;
			$image = $function_name($from_filename);
			$img_info = getimagesize($watermark_filename);
			$w_width  = $img_info['0'];
			$w_height = $img_info['1'];
			$w_mime   = $img_info['mime'];
			list($t, $sub_name) = explode('/', $w_mime);
			if (!in_array($sub_name, $allow_format)){return false;}
			$function_name = 'imagecreatefrom' . $sub_name;
			$watermark = $function_name($watermark_filename);
			imagesetbrush($image, $watermark);
			imageline($image, $width, $height, $width, $height, IMG_COLOR_BRUSHED);
			return imagejpeg($image, $from_filename);
		}

		public function pictumb($srcFile,$percent = 1,$quality = 100){
			$dstFile = $srcFile;
			
			list($width, $height) = getimagesize($srcFile);
			if ($width>600){
				$new_width = $width / $percent;
				$new_height = $height / $percent;
			}else{
				$new_width =$width;
				$new_height = $height;
			}
			$image_p = imagecreatetruecolor($new_width, $new_height);
			$color=imagecolorallocate($image_p,255,255,255); 
			imagecolortransparent($image_p,$color); 
			imagefill($image_p,0,0,$color); 
			$format=substr($srcFile,strrpos($srcFile, '.'));
			switch ($format) {
				case '.png':
					$image=imagecreatefrompng($srcFile);
					break;
				case '.jpg':
					$image=imagecreatefromjpeg($srcFile);
					break;
				case '.jpeg':
					$image=imagecreatefromjpeg($srcFile);
					break;
				case '.bmp':
					$image=imagecreatefromwbmp($srcFile);
					break;
				case '.gif':
					$image=imagecreatefromgif($srcFile);
					break;
				default:
					 $image=imagecreatefromjpeg($srcFile);
					break;
			}
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			chmod($srcFile,0777);
			unlink($srcFile);
			switch ($format) {
				case '.png':
					imagepng($image_p,$dstFile);
					break;
				case '.jpg':
					imagejpeg($image_p,$dstFile, $quality);
					break;
				case '.jpeg':
					imagejpeg($image_p,$dstFile, $quality);
					break;
				case '.bmp':
					imagewbmp($image_p,$dstFile);
					break;
				case '.gif':
					imagegif( $image_p,$dstFile);
					break;
				default:
					 imagejpeg($image_p,$dstFile,$quality);
					break;
			}
		}
	}
	$upload_file = new Upload_file();
?>