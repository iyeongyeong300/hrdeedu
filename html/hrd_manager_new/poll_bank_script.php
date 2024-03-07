<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$Gubun = Replace_Check($Gubun);
$ExamType = Replace_Check($ExamType);
$Question = Replace_Check2($Question);
$Example01 = Replace_Check($Example01);
$Example02 = Replace_Check($Example02);
$Example03 = Replace_Check($Example03);
$Example04 = Replace_Check($Example04);
$Example05 = Replace_Check($Example05);

$UseYN = Replace_Check($UseYN);

$OrderByNum = Replace_Check($OrderByNum);

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;


if($mode=="new") { //새글 작성---------------------------------------------------------------------------------------------------------


	$maxno = max_number("idx","PollBank");

	$Sql = "INSERT INTO PollBank 
				(idx, Gubun, ExamType, Question, Example01, Example02, Example03, Example04, Example05, UseYN, Del, RegDate, OrderByNum) 
				VALUES ($maxno, '$Gubun', '$ExamType', '$Question', '$Example01', '$Example02', '$Example03', '$Example04', '$Example05', '$UseYN', 'N', NOW(), $OrderByNum)";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "poll_bank.php?idx=".$maxno;

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE PollBank SET Gubun='$Gubun', ExamType='$ExamType', Question='$Question', Example01='$Example01', Example02='$Example02', Example03='$Example03', Example04='$Example04', Example05='$Example05', UseYN='$UseYN', OrderByNum=$OrderByNum WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "poll_bank_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE PollBank SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "poll_bank.php?col=".$col."&sw=".$sw;

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