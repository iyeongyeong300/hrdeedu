<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$CompanyName = Replace_Check($CompanyName);
$Ceo = Replace_Check($Ceo);
$CompanyNumber = Replace_Check($CompanyNumber);
$SalesReportNumber = Replace_Check($SalesReportNumber);
$Phone = Replace_Check($Phone);
$Fax = Replace_Check($Fax);
$Email = Replace_Check($Email);
$PersonalInformationManager = Replace_Check($PersonalInformationManager);
$Address = Replace_Check($Address);
$Copyright = Replace_Check($Copyright);



$Sql = "INSERT INTO SiteInfomation(CompanyName, Ceo, CompanyNumber, SalesReportNumber, Phone, Fax, Email, PersonalInformationManager, Address, Copyright, RegDate) VALUES('$CompanyName', '$Ceo', '$CompanyNumber', '$SalesReportNumber', '$Phone', '$Fax', '$Email', '$PersonalInformationManager', '$Address', '$Copyright', NOW())";
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