<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$CertDate = Replace_Check($CertDate);

$maxno = max_number("Seq","HRD_UserCert");
$CertType = "Admin";
$Sql = "INSERT INTO HRD_UserCert(Seq, ID, LectureCode, CertDate, CertType, RegDate) VALUES($maxno, '$ID', '', '$CertDate', '$CertType', NOW())";
$Row = mysqli_query($connect, $Sql);

$Sql2 = "UPDATE HRD_Study SET certCount=certCount+1 WHERE ID='$ID' AND LectureEnd>='$CertDate' AND StudyEnd='N'";
$Row2 = mysqli_query($connect, $Sql2);

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
	//opener.location.reload();
	<?}?>
	self.close();
//-->
</SCRIPT>