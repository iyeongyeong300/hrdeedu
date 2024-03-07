<?
include "../include/include_function.php";
include "./include/include_admin_check.php";


$idx = Replace_Check2($idx2);
$Gubun = Replace_Check2($Gubun);
$ExamType = Replace_Check2($ExamType);
$Question = Replace_Check2($Question);
$Example01 = Replace_Check2($Example01);
$Example02 = Replace_Check2($Example02);
$Example03 = Replace_Check2($Example03);
$Example04 = Replace_Check2($Example04);
$Example05 = Replace_Check2($Example05);
$Answer = Replace_Check2($Answer);
$Answer2 = Replace_Check2($Answer2);
$Comment = Replace_Check2($Comment);
$ScoreBasis = Replace_Check2($ScoreBasis);


if($Example01=="0") {
	$Example01 = "0 ";
}
if($Example02=="0") {
	$Example02 = "0 ";
}
if($Example03=="0") {
	$Example03 = "0 ";
}
if($Example04=="0") {
	$Example04 = "0 ";
}
if($Example05=="0") {
	$Example05 = "0 ";
}
if($Comment=="0") {
	$Comment = "0 ";
}
if($ScoreBasis=="0") {
	$ScoreBasis = "0 ";
}

if($Example01==="0") {
	$Example01 = "0 ";
}
if($Example02==="0") {
	$Example02 = "0 ";
}
if($Example03==="0") {
	$Example03 = "0 ";
}
if($Example04==="0") {
	$Example04 = "0 ";
}
if($Example05==="0") {
	$Example05 = "0 ";
}
if($Comment==="0") {
	$Comment = "0 ";
}
if($ScoreBasis==="0") {
	$ScoreBasis = "0 ";
}


$Sql = "UPDATE ExamBankExcelTemp SET Gubun='$Gubun', ExamType='$ExamType', Question='$Question', Example01='$Example01', Example02='$Example02', Example03='$Example03', Example04='$Example04', Example05='$Example05', Answer='$Answer', Answer2='$Answer2', Comment='$Comment', ScoreBasis='$ScoreBasis' WHERE idx=$idx";
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
	top.ExamExcelUploadListRoading('A');
	<?}?>
//-->
</SCRIPT>