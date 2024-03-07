<?
include "../include/include_function.php";
include "./include/include_admin_check.php";


$idx = Replace_Check2($idx2);
$Gubun = Replace_Check2($Gubun);
$ContentsTitle = Replace_Check2($ContentsTitle);
$LectureTime = Replace_Check($LectureTime);
$Expl01 = Replace_Check2($Expl01);
$Expl02 = Replace_Check2($Expl02);
$Expl03 = Replace_Check2($Expl03);


$Sql = "UPDATE ContentsExcelTemp SET Gubun='$Gubun', ContentsTitle='$ContentsTitle', LectureTime=$LectureTime, Expl01='$Expl01', Expl02='$Expl02', Expl03='$Expl03' WHERE idx=$idx";
$Row = mysqli_query($connect, $Sql);

if($Row) {
	$ProcessOk = "Y";
	$msg = "수정 되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	top.DataResultClose();
	top.ContentsExcelUploadListRoading('A');
	<?}?>
//-->
</SCRIPT>