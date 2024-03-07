<?
include "../include/include_function.php";

$code = Replace_Check($code);
$file = Replace_Check($file);

if($file) {

	$filepath = $UPLOAD_DIR."/".$code."/".$file;
	$filepath = addslashes($filepath);	 
	//echo $filepath;

	header("Content-Type: application/octet-stream");
	Header("Content-Disposition: attachment;; filename=$file");
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
	history.back();
//-->
</script>
<?
}
?>