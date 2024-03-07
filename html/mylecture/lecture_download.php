<?
include "../include/include_function.php";

$LectureCode = Replace_Check($LectureCode);

$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$FileName = $Row['attachFile'];
	$ContentsName = $Row['ContentsName'];

	$ContentsName = str_replace(",","",$ContentsName);
	$ContentsName = str_replace(" ","_",$ContentsName);
	$ContentsName = str_replace(".","_",$ContentsName);

	$ext = substr(strrchr($FileName,"."),1);
	$RealFileName = "학습자료_".$ContentsName.".".$ext;
	$RealFileName = iconv("UTF-8","EUC-KR",$RealFileName);

	$filepath = $UPLOAD_DIR."/Course/".$FileName;
	$filepath = addslashes($filepath);
	//echo $RealFileName;

	header("Content-Type: application/octet-stream");
	Header("Content-Disposition: attachment;; filename=$RealFileName");
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