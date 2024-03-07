<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<?
$Ele = Replace_Check($Ele);
$EleArea = Replace_Check($EleArea);
$FileType = Replace_Check($FileType);

$Folder = "/Course";

include "./include/include_upload_file.php";

if(!$FileName1) {
?>
<script type="text/javascript">
<!--
	alert("첨부된 파일이 없습니다.");
	top.$("#SubmitBtn2").show();
	top.$("#Waiting2").hide();
//-->
</script>
<?
exit;
}

switch ($FileType) {
	case "text" :
		$EleAreaHTML = "<A HREF='./direct_download.php?code=Course&file=".$FileName1."'><B>".$FileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."') class='btn_inputLine01'>";
	break;
	case "img" :
		$EleAreaHTML = "<img src='../upload/Course/".$FileName1."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."') class='btn_inputLine01'>";
	break;
}

mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	top.$("#<?=$Ele?>").val("<?=$FileName1?>");
	top.$("#<?=$EleArea?>").html("<?=$EleAreaHTML?>");
	top.DataResultClose();
//-->
</SCRIPT>