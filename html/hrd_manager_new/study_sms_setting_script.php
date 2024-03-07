<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$MessageMode = Replace_Check($MessageMode);
$Massage = Replace_Check($Massage);

$Sql = "SELECT COUNT(*) FROM SendMessage WHERE MessageMode='$MessageMode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

if($TOT_NO<1) {
	$maxno = max_number("idx","SendMessage");
	$Sql = "INSERT INTO SendMessage(idx, MessageMode, Massage, RegDate) VALUES ($maxno, '$MessageMode', '$Massage', NOW())";
}else{
	$Sql = "UPDATE SendMessage SET Massage='$Massage' , TemplateCode='$TemplateCode' , TemplateMessage='$TemplateMessage'  WHERE MessageMode='$MessageMode'";
}

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
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	top.location.reload();
	<?}?>
//-->
</SCRIPT>