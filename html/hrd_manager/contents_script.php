<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$Gubun = Replace_Check($Gubun);
$ContentsTitle = Replace_Check($ContentsTitle);
$LectureTime = Replace_Check($LectureTime);
$Expl01 = Replace_Check2($Expl01);
$Expl02 = Replace_Check2($Expl02);
$Expl03 = Replace_Check2($Expl03);

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;


if($mode=="new") { //새글 작성---------------------------------------------------------------------------------------------------------


	$maxno = max_number("idx","Contents");

	$Sql = "INSERT INTO Contents 
				(idx, Gubun, ContentsTitle, LectureTime, Expl01, Expl02, Expl03, Del, RegDate) 
				VALUES ($maxno, '$Gubun', '$ContentsTitle', $LectureTime, '$Expl01', '$Expl02', '$Expl03', 'N', NOW())";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "contents_read.php?idx=".$maxno;

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Contents SET Gubun='$Gubun', ContentsTitle='$ContentsTitle', LectureTime=$LectureTime, Expl01='$Expl01', Expl02='$Expl02', Expl03='$Expl03' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "contents_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Contents SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "contents.php?col=".$col."&sw=".$sw;

} //글 삭제-------------------------------------------------------------------------------------------------------------------------

if($Row && $cmd) {
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
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
//-->
</SCRIPT>