<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);


$MessageMode 		= Replace_Check($MessageMode);
$TemplateCode 		= Replace_Check($TemplateCode);
$Massage 			= Replace_Check($Massage);
$TemplateMessage 	= Replace_Check2($TemplateMessage);
 
 $col = Replace_Check($col);
$sw = Replace_Check($sw);


if($mode=="new") { //새글 작성---------------------------------------------------------------------------------------------------------

	//$maxno = max_number("idx","SendMessage");

	$Sql = "INSERT INTO SendMessage 
				(MessageMode, TemplateCode, Massage, TemplateMessage,Del,RegDate) 
				VALUES ('$MessageMode', '$TemplateCode', '$TemplateMessage', '$TemplateMessage','N', NOW())";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "smsdata.php";

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------
 
	$Sql = "UPDATE SendMessage SET MessageMode='$MessageMode', TemplateCode='$TemplateCode', Massage='$TemplateMessage', TemplateMessage='$TemplateMessage' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "smsdata_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "Delete From  SendMessage WHERE idx=$idx";
//	$Sql = "Update SendMessage Set Del='Y'  WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "smsdata.php?col=".$col."&sw=".$sw;

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