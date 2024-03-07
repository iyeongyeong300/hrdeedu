<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

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
$Fax01 = Replace_Check($Fax01);
$Fax02 = Replace_Check($Fax02);
$Fax03 = Replace_Check($Fax03);
$Fax2_01 = Replace_Check($Fax2_01);
$Fax2_02 = Replace_Check($Fax2_02);
$Fax2_03 = Replace_Check($Fax2_03);
$Uptae = Replace_Check($Uptae);
$Upjong = Replace_Check($Upjong);
$Zipcode = Replace_Check($Zipcode);
$Address01 = Replace_Check($Address01);
$Address02 = Replace_Check($Address02);
$BankName = Replace_Check($BankName);
$BankNumber = Replace_Check($BankNumber);
$Email = Replace_Check($Email);
$HomePage = Replace_Check($HomePage);
$CyberURL = Replace_Check($CyberURL);
$CyberEnabled = Replace_Check($CyberEnabled);
$CSEnabled = Replace_Check($CSEnabled);
$EduManager = Replace_Check($EduManager);
$EduManagerPhone = Replace_Check($EduManagerPhone);
$EduManagerEmail = Replace_Check($EduManagerEmail);
$SalesManager = Replace_Check($SalesManager);
$Remark = Replace_Check2($Remark);
$SendSMS = Replace_Check($SendSMS);

$Tel = $Tel01."-".$Tel02."-".$Tel03;
$Tel2 = $Tel2_01."-".$Tel2_02."-".$Tel2_03;
$Fax = $Fax01."-".$Fax02."-".$Fax03;
$Fax2 = $Fax2_01."-".$Fax2_02."-".$Fax2_03;

if(!$CSEnabled) {
	$CSEnabled = "N";
}

if(!$SendSMS) {
	$SendSMS = "Y";
}

if(!$CompanyID) {
	$CompanyID = $CompanyCode;
}

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;


if($mode=="new") { //신규 등록 ---------------------------------------------------------------------------------------------------------


	//사업자번호 중복체크
	$Sql = "SELECT CompanyCode FROM Company WHERE CompanyCode='$CompanyCode'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
	?>
	<script type="text/javascript">
	<!--
		alert("동일한 사업자번호가 존재합니다.");
		top.$("#SubmitBtn").show();
		top.$("#Waiting").hide();
	//-->
	</script>
	<?
	exit;
	}

	mysqli_free_result($Result);

	//사업주아이디 중복체크
	$Sql = "SELECT CompanyID FROM Company WHERE CompanyID='$CompanyID'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
	?>
	<script type="text/javascript">
	<!--
		alert("동일한 사업주 ID가 존재합니다.");
		top.$("#SubmitBtn").show();
		top.$("#Waiting").hide();
	//-->
	</script>
	<?
	exit;
	}

	mysqli_free_result($Result);


	$maxno = max_number("idx","Company");

	$Del = "N";

	$Sql = "INSERT INTO Company 
				(idx, CompanyScale, CompanyCode, CompanyName, CompanyID, HRD, 
				Ceo, Uptae, Upjong, Zipcode, Address01, Address02, Tel, Tel2, Fax, Fax2, 
				Email, BankName, BankNumber, CSEnabled, CyberEnabled, HomePage, CyberURL, 
				EduManager, EduManagerPhone, EduManagerEmail, SalesManager, RegDate, Remark, Del, SendSMS) 
				VALUES ($maxno, '$CompanyScale', '$CompanyCode', '$CompanyName', '$CompanyID', '$HRD', 
				'$Ceo', '$Uptae', '$Upjong', '$Zipcode', '$Address01', '$Address02', '$Tel', '$Tel2', '$Fax', '$Fax2', 
				'$Email', '$BankName', '$BankNumber', '$CSEnabled', '$CyberEnabled', '$HomePage', '$CyberURL', 
				'$EduManager', '$EduManagerPhone', '$EduManagerEmail', '$SalesManager', NOW(), '$Remark','$Del', '$SendSMS')";
	$Row = mysqli_query($connect, $Sql);


	$cmd = true;
	$url = "company.php";

} //신규 등록-------------------------------------------------------------------------------------------------------------------------


if($mode=="edit") { //수정---------------------------------------------------------------------------------------------------------

	if($EduManager) { //교육담당자 설정시 회원정보에서 교육담당자로 변경
		$Sql2 = "UPDATE HRD_Member SET EduManager='Y' WHERE ID='$EduManager'";
		mysqli_query($connect, $Sql2);
	}

	$Sql = "UPDATE Company SET CompanyScale='$CompanyScale', CompanyName='$CompanyName', HRD='$HRD', Ceo='$Ceo', Uptae='$Uptae', Upjong='$Upjong', Zipcode='$Zipcode', Address01='$Address01', Address02='$Address02', Tel='$Tel', Tel2='$Tel2', Fax='$Fax', Fax2='$Fax2', Email='$Email', BankName='$BankName', BankNumber='$BankNumber', CSEnabled='$CSEnabled', CyberEnabled='$CyberEnabled', HomePage='$HomePage', CyberURL='$CyberURL', EduManager='$EduManager', EduManagerPhone='$EduManagerPhone', EduManagerEmail='$EduManagerEmail', SalesManager='$SalesManager', Remark='$Remark', SendSMS='$SendSMS' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "company_read.php?idx=".$idx;

} //수정-------------------------------------------------------------------------------------------------------------------------


if($mode=="del") { //삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Company SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "company.php?col=".$col."&sw=".$sw;

} //삭제-------------------------------------------------------------------------------------------------------------------------




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