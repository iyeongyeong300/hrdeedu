<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx2);

$CompanyScale = Replace_Check($CompanyScale);
$CompanyName = Replace_Check($CompanyName);
$CompanyCode = Replace_Check($CompanyCode);
$HRD = Replace_Check($HRD);
$CompanyID = Replace_Check($CompanyID);
$Ceo = Replace_Check($Ceo);
$Tel01 = Replace_Check($Tel01);
$Tel02 = Replace_Check($Tel02);
$Tel03 = Replace_Check($Tel03);
$Tel2_01 = Replace_Check($Tel2_01);
$Tel2_02 = Replace_Check($Tel2_02);
$Tel2_03 = Replace_Check($Tel2_03);

$Fax2_01 = Replace_Check($Fax2_01);
$Fax2_02 = Replace_Check($Fax2_02);
$Fax2_03 = Replace_Check($Fax2_03);

$Uptae = Replace_Check($Uptae);
$Upjong = Replace_Check($Upjong);
$Zipcode = Replace_Check($Zipcode);
$Address01 = Replace_Check($Address01);
$Address02 = Replace_Check($Address02);

$CyberEnabled = Replace_Check($CyberEnabled);
$CSEnabled = Replace_Check($CSEnabled);
$EduManager = Replace_Check($EduManager);
$EduManagerPhone = Replace_Check($EduManagerPhone);
$EduManagerEmail = Replace_Check($EduManagerEmail);
$SalesManager = Replace_Check($SalesManager);
$Remark = Replace_Check2($Remark);

$Tel = $Tel01."-".$Tel02."-".$Tel03;
$Tel2 = $Tel2_01."-".$Tel2_02."-".$Tel2_03;

$Fax2 = $Fax2_01."-".$Fax2_02."-".$Fax2_03;

if(!$CSEnabled) {
	$CSEnabled = "N";
}

if(!$CompanyID) {
	$CompanyID = $CompanyCode;
}


$Sql = "UPDATE CompanyExcelTemp SET CompanyScale='$CompanyScale', CompanyName='$CompanyName', HRD='$HRD', Ceo='$Ceo', Uptae='$Uptae', Upjong='$Upjong', Zipcode='$Zipcode', Address01='$Address01', Address02='$Address02', Tel='$Tel', Tel2='$Tel2', Fax2='$Fax2', Email='$Email', CSEnabled='$CSEnabled', CyberEnabled='$CyberEnabled', EduManager='$EduManager', EduManagerPhone='$EduManagerPhone', EduManagerEmail='$EduManagerEmail', SalesManager='$SalesManager', Remark='$Remark' WHERE idx=$idx";
//echo $Sql;
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
	top.location.reload();
	<?}?>
//-->
</SCRIPT>