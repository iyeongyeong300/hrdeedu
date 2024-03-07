<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$OrderByNum = Replace_Check($OrderByNum);
$Category = Replace_Check($Category);
$Title = Replace_Check($Title);
$UseYN = Replace_Check($UseYN);
$Content = Replace_Check2($Content);

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;


if($mode=="new") { //새글 작성---------------------------------------------------------------------------------------------------------

	if(!$OrderByNum) {
		$OrderByNum = max_number("OrderByNum","Faq");
	}

	$maxno = max_number("idx","Faq");

	$Sql = "INSERT INTO Faq 
				(idx, OrderByNum, UseYN, Category, Title, Content, Del, RegDate) 
				VALUES ($maxno, $OrderByNum, '$UseYN', '$Category', '$Title', '$Content', 'N', NOW())";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "faq_read.php?idx=".$maxno;

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------

	if(!$OrderByNum) {
		$OrderByNum = max_number("OrderByNum","Faq");
	}

	$Sql = "UPDATE Faq SET OrderByNum=$OrderByNum, UseYN='$UseYN', Category='$Category', Title='$Title', Content='$Content' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "faq_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Faq SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "faq.php?col=".$col."&sw=".$sw;

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