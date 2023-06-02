<?php
	function image_upload($image_data,$name,$size){
		$msg="";
		$result=true;
		if($_FILES[$image_data][$name]){
			$img_extensions=["jpeg","png","gif","tiff","jpg","psd","JPEG","PNG","GIF","TIFF","JPG","PSD"];
			$type=pathinfo($_FILES[$image_data][$name],PATHINFO_EXTENSION);
			$valid=false;
			$extensions="";
			foreach ($img_extensions as $key => $value) {
				if($key==sizeof($img_extensions)-1) $extensions.=$value;
				else $extensions.="$value, ";
				if($value==$type) $value=true;
			}
			if(!$valid){
				$msg.="File type of <b>".$_FILES[$image_data][$name] ."</b> must be a  <b>[ " .$extensions." ]</b><br/>";
				$result=false;
			}
			if($_FILES[$image_data][$size]>1000000){
        		$msg.="Max size of image is <b>1MB</b><br/>";
        		$$result=false;
			}
		}
		else {
			$msg.="Upload Image is required<br/>";
			$result=false;
		};
		if(!$result) return [$result,$msg];
		else return [$result];
	}
?>