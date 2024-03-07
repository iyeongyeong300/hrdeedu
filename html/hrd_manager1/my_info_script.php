<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Team = Replace_Check($Team);
$Mobile01 = Replace_Check($Mobile01);
$Mobile02 = Replace_Check($Mobile02);
$Mobile03 = Replace_Check($Mobile03);
$Phone01 = Replace_Check($Phone01);
$Phone02 = Replace_Check($Phone02);
$Phone03 = Replace_Check($Phone03);
$Email = Replace_Check($Email);
$BankName = Replace_Check($BankName);
$BankNumber = Replace_Check($BankNumber);

$Mobile = $Mobile01."-".$Mobile02."-".$Mobile03;
$Phone = $Phone01."-".$Phone02."-".$Phone03;

$Passwd = Replace_Check($Passwd);
$PwdChange = Replace_Check($PwdChange);


if($PwdChange=="Y") {
	$Sql = "UPDATE StaffInfo SET Team='$Team', Mobile='$Mobile', Phone='$Phone', Email='$Email', BankName='$BankName', BankNumber='$BankNumber', Pwd=password('$Passwd') WHERE ID='$LoginAdminID'";
}else{
	$Sql = "UPDATE StaffInfo SET Team='$Team', Mobile='$Mobile', Phone='$Phone', Email='$Email', BankName='$BankName', BankNumber='$BankNumber' WHERE ID='$LoginAdminID'";
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