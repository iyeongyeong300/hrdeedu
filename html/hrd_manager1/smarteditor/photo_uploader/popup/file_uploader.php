<?
$url = $_REQUEST["callback"].'?callback_func='.$_REQUEST["callback_func"];
//$url = $_REQUEST["callback"].'?callback_func=tmpFrame_13123_func';
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

$timeinfo = getdate(time());

$YMDHIS = $timeinfo["year"];

$ROOT_PATH = $_SERVER['DOCUMENT_ROOT'];

if(strlen($timeinfo["mon"]) < 2) {
	$YMDHIS = $YMDHIS."0".$timeinfo["mon"];
}else{
	$YMDHIS = $YMDHIS.$timeinfo["mon"];
}


$ROOT_HTTP = "/upload/webedit/".$YMDHIS;

// SUCCESSFUL
if($bSuccessUpload) {
	$tmp_name = $_FILES['Filedata']['tmp_name'];
	$name = $_FILES['Filedata']['name'];
	
	$filename_ext = strtolower(array_pop(explode('.',$name)));
	$allow_file = array("jpg", "png", "bmp", "gif");
	
	if(!in_array($filename_ext, $allow_file)) {
		$url .= '&errstr='.$name;
	} else {
		//$uploadDir = '../../upload/';
		//$uploadDir = "../upload/webedit/".$YMDHIS."/";
		$uploadDir = $ROOT_PATH."/upload/webedit/".$YMDHIS."/";
		if(!is_dir($uploadDir)){
			umask(0);
			mkdir($uploadDir, 0777);
		}

		//파일명 변경
		$ext = strtolower(substr($name,strlen($name)-4)); //파일 확장자
		$str_name = str_replace($ext,"",$name); //확장자를 제외한 파일명

		if(strlen($timeinfo["mday"]) < 2) {
			$YMDHIS = $YMDHIS."0".$timeinfo["mday"];
		}else{
			$YMDHIS = $YMDHIS.$timeinfo["mday"];
		}

		if(strlen($timeinfo["hours"]) < 2) {
			$YMDHIS = $YMDHIS."0".$timeinfo["hours"];
		}else{
			$YMDHIS = $YMDHIS.$timeinfo["hours"];
		}

		if(strlen($timeinfo["minutes"]) < 2) {
			$YMDHIS = $YMDHIS."0".$timeinfo["minutes"];
		}else{
			$YMDHIS = $YMDHIS.$timeinfo["minutes"];
		}

		if(strlen($timeinfo["seconds"]) < 2) {
			$YMDHIS = $YMDHIS."0".$timeinfo["seconds"];
		}else{
			$YMDHIS = $YMDHIS.$timeinfo["seconds"];
		}

		$FileName = $YMDHIS.$ext;
		
		//$newPath = $uploadDir.urlencode($_FILES['Filedata']['name']);
		$newPath = $uploadDir.$FileName;
		
		@move_uploaded_file($tmp_name, $newPath);
		
		$url .= "&bNewLine=true";
		$url .= "&sFileName=".urlencode(urlencode($FileName));
		//$url .= "&sFileURL=upload/".urlencode(urlencode($name));
		$url .= "&sFileURL=".$ROOT_HTTP."/".urlencode(urlencode($FileName));
		
	}
}
// FAILED
else {
	$url .= '&errstr=error';
}

header('Location: '. $url);
?>