<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Seq = Replace_Check($Seq);
$mode = Replace_Check($mode);

$Contents_idx = Replace_Check($Contents_idx);
$ContentsType = Replace_Check($ContentsType);
$ContentsPage = Replace_Check($ContentsPage);
$ContentsMobilePage = Replace_Check($ContentsMobilePage);
$ContentsURLSelect = Replace_Check($ContentsURLSelect);
$ContentsURL = Replace_Check($ContentsURL);
$ContentsURL2 = Replace_Check($ContentsURL2);
$MobileURL = Replace_Check($MobileURL);
$MobileURL2 = Replace_Check($MobileURL2);
$Question = Replace_Check2($Question);
$Example01 = Replace_Check($Example01);
$Example02 = Replace_Check($Example02);
$Example03 = Replace_Check($Example03);
$Example04 = Replace_Check($Example04);
$Example05 = Replace_Check($Example05);
$Answer = Replace_Check($Answer);
$Comment = Replace_Check2($Comment);
$UseYN = Replace_Check($UseYN);
$OrderByNum = Replace_Check($OrderByNum);
$Teacher = Replace_Check($Teacher);
$Caption = Replace_Check($Caption);

if(!$Teacher) {
	$Teacher = 0;
}

$cmd = false;

if($mode=="new") { //신규 작성---------------------------------------------------------------------------------------------------------

	$maxno = max_number("Seq","ContentsDetail");

	$Sql = "INSERT INTO ContentsDetail 
				(Seq, Contents_idx, ContentsType, ContentsPage, ContentsMobilePage, ContentsURLSelect, ContentsURL, ContentsURL2, MobileURL, MobileURL2, 
				Question, Example01, Example02, Example03, Example04, Example05, Answer, Comment, UseYN, OrderByNum, Teacher, Caption) 
				VALUES ($maxno, $Contents_idx, '$ContentsType', '$ContentsPage', '$ContentsMobilePage', '$ContentsURLSelect', '$ContentsURL', '$ContentsURL2', '$MobileURL', '$MobileURL2', 
				'$Question', '$Example01', '$Example02', '$Example03', '$Example04', '$Example05', '$Answer', '$Comment', '$UseYN', $OrderByNum, $Teacher, '$Caption')";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}//신규 작성---------------------------------------------------------------------------------------------------------


if($mode=="edit") { //수정---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE ContentsDetail SET ContentsType='$ContentsType', ContentsPage='$ContentsPage', ContentsMobilePage='$ContentsMobilePage', ContentsURLSelect='$ContentsURLSelect', ContentsURL='$ContentsURL', ContentsURL2='$ContentsURL2', MobileURL='$MobileURL', MobileURL2='$MobileURL2', Question='$Question', Example01='$Example01', Example02='$Example02', Example03='$Example03', Example04='$Example04', Example05='$Example05', Answer='$Answer', Comment='$Comment', UseYN='$UseYN', OrderByNum=$OrderByNum, Teacher=$Teacher, Caption='$Caption' WHERE Seq=$Seq";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}//수정---------------------------------------------------------------------------------------------------------


if($mode=="del") { //삭제---------------------------------------------------------------------------------------------------------

	$Sql = "DELETE FROM  ContentsDetail  WHERE Seq=$Seq";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;

}//삭제---------------------------------------------------------------------------------------------------------

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
	top.location.reload();
	<?}?>
//-->
</SCRIPT>