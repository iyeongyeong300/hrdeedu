<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$LectureCode = Replace_Check($LectureCode); //과정코드
$PackageLectureCode = Replace_Check($PackageLectureCode); //패키지강의 코드

$Sql = "UPDATE Course SET PackageLectureCode='$PackageLectureCode' WHERE idx=$idx AND LectureCode='$LectureCode'";
$Row = mysqli_query($connect, $Sql);

if($Row) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
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
	top.location.reload();
	<?}?>
//-->
</SCRIPT>