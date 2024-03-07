<?
include "../include/include_function.php";
?>
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<?
$Expl = Replace_Check($Expl);
$File = Replace_Check($File);

$Folder = "/Report";

$file = $_FILES['file']['tmp_name']; 
$file_name = $_FILES['file']['name']; 
$file_size = $_FILES['file']['size'];

//첫번째 파일 업로드------------------------------------------------------------------------------------------------
if($file_size>0){

	if($file_size>52428800) {
?>
	<SCRIPT LANGUAGE="JavaScript">
	<!--
	alert("파일크기는 50M이하만 가능합니다.");
	top.UploadFileClose();
	//-->
	</SCRIPT>
<?
	exit;
	}


	$ext = substr(strrchr($file_name,"."),1); //확장자앞 .을 제거하기 위하여 substr()함수를 이용
	$ext = strtolower($ext); //확장자를 소문자로 변환
	$str_name = str_replace($ext,"",$file_name); //확장자를 제외한 파일명

	$filename = $LoginMemberID."_".date('YmdHis').".".$ext;

	//파일 경로를 제외한 파일명 검출
	$file_name_arrary = explode("\\",$file_name);
	$file_name_arrary_count = count($file_name_arrary);
	$file_name2 = $file_name_arrary[$file_name_arrary_count-1];

	copy($file,$UPLOAD_DIR.$Folder."/".$filename); 

	$FileName1 = $filename;
	$RealFileName1 = $file_name2;

}else{

	$FileName1 = "";
	$RealFileName1 = "";

}
//첫번째 파일 업로드 끝=====================================================

if(!$FileName1) {
?>
<script type="text/javascript">
<!--
	alert("첨부된 파일이 없습니다.");
	top.UploadFileClose();
//-->
</script>
<?
exit;
}


$EleAreaHTML = $FileName1."&nbsp;&nbsp;<a href=Javascript:UploadFileDelete('".$Expl."','".$File."'); style='background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px;'>&nbsp;&nbsp;파일 삭제하기&nbsp;&nbsp;</a>";


mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	top.$("#<?=$File?>").val("<?=$FileName1?>");
	top.$("#<?=$Expl?>").html("<?=$EleAreaHTML?>");

	setTimeout(function(){
		top.UploadFileClose();
		top.ExamTempSave();
	},1000);
//-->
</SCRIPT>