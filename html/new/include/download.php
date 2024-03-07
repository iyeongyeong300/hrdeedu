<?
include "../../include/include_function.php";

$idx = Replace_Check($idx);
$code = Replace_Check($code);
$file = Replace_Check($file);

switch($file){
	case "1":
		$RealFileName = "RealFileName1";
		$FileName = "FileName1";
	break;
	case "2":
		$RealFileName = "RealFileName2";
		$FileName = "FileName2";
	break;
	case "3":
		$RealFileName = "RealFileName3";
		$FileName = "FileName3";
	break;
	case "4":
		$RealFileName = "RealFileName4";
		$FileName = "FileName4";
	break;
	case "5":
		$RealFileName = "RealFileName5";
		$FileName = "FileName5";
	break;
	case "CourseAttachFile":
		$RealFileName = "attachFile";
		$FileName = "attachFile";
	break;
	case "CoursePreviewImage":
		$RealFileName = "PreviewImage";
		$FileName = "PreviewImage";
	break;
	case "CourseBookImage":
		$RealFileName = "BookImage";
		$FileName = "BookImage";
	break;
}

$TableName = $code;

$Sql = "SELECT ".$RealFileName." AS RealFileName, ".$FileName." AS FileName FROM $TableName WHERE idx=$idx";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$FileName = $Row['FileName'];
	$RealFileName = $Row['RealFileName'];

	$filepath = $UPLOAD_DIR."/".$code."/".$FileName;
	$filepath = addslashes($filepath);	 
	//echo $FileName;
	$RealFileName = iconv("UTF-8","EUC-KR",$RealFileName);
	$RealFileName = str_replace(",","_",$RealFileName);

	header("Content-Type: application/octet-stream");
	Header("Content-Disposition: attachment; filename=".$RealFileName);
	header("Content-Transfer-Encoding: binary"); 
	Header("Content-Length: ".(string)(filesize($filepath))); 
	Header("Cache-Control: cache, must-revalidate");
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	 
	$fp = fopen($filepath,'r+b') ; 
	if (!fpassthru($fp)) {
		fclose($fp);
	}


}else{
?>
<script type="text/javascript">
<!--
	alert("파일이 존재하지 않습니다.");
	//top.location.reload();
//-->
</script>
<?
}
?>