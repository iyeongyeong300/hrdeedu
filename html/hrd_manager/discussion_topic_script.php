<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);
$Gubun = Replace_Check($Gubun);
$Topic = Replace_Check2($Topic);
$Example01 = Replace_Check2($Example01);
$Example02 = Replace_Check2($Example02);
$Example03 = Replace_Check2($Example03);
$Example04 = Replace_Check2($Example04);
$Example05 = Replace_Check2($Example05);
$UseYN = Replace_Check($UseYN);

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;


if($mode=="new") { //새글 작성---------------------------------------------------------------------------------------------------------

	$Sql = "INSERT INTO DiscussionTopic
				(Gubun, Topic, Example01, Example02, Example03, Example04, Example05, Comment, UseYN, Del, RegDate) 
				VALUES ( '$Gubun', '$Topic', '$Example01', '$Example02', '$Example03', '$Example04', '$Example05','$Comment',  '$UseYN', 'N', NOW())";
				
			echo $Sql;
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "discussion_topic.php";

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE DiscussionTopic SET Gubun='$Gubun', Topic='$Topic', Example01='$Example01', Example02='$Example02', Example03='$Example03', Example04='$Example04', Example05='$Example05', Comment='$Comment', UseYN='$UseYN' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "discussion_topic_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE DiscussionTopic SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "discussion_topic.php?col=".$col."&sw=".$sw;

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