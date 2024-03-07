<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

$ID = Replace_Check($ID);
$Dept_idx = Replace_Check($Dept_idx);
$Dept = Replace_Check($Dept);
$Name = Replace_Check($Name);
$Pwd = Replace_Check($Pwd);
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
$UseYN = Replace_Check($UseYN);

$Mobile = $Mobile01."-".$Mobile02."-".$Mobile03;
$Phone = $Phone01."-".$Phone02."-".$Phone03;

$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;


if($mode=="new") { //새글 작성---------------------------------------------------------------------------------------------------------

	//아이디 중복체크
	$Sql = "SELECT ID FROM StaffInfo WHERE ID='$ID'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
	?>
	<script type="text/javascript">
	<!--
		alert("동일한 ID가 존재하거나 삭제된 ID입니다.");
		top.$("#SubmitBtn").show();
		top.$("#Waiting").hide();
	//-->
	</script>
	<?
	exit;
	}

	$maxno = max_number("idx","StaffInfo");

	$Dept = "A";
	$Del = "N";

	$Sql = "INSERT INTO StaffInfo 
				(idx, ID, Dept_idx, Dept, Name, Pwd, Team, Mobile, Phone, Email, BankName, BankNumber, UseYN, Del, RegDate, SiteCode) 
				VALUES ($maxno, '$ID', $Dept_idx, '$Dept', '$Name', password('$Pwd'), '$Team', '$Mobile', '$Phone', '$Email', '$BankName', '$BankNumber', '$UseYN', '$Del', NOW(), '$SiteCode')";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "staff01.php";

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE StaffInfo SET Dept_idx=$Dept_idx, Name='$Name', Team='$Team', Mobile='$Mobile', Phone='$Phone', Email='$Email', BankName='$BankName', BankNumber='$BankNumber', UseYN='$UseYN' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "staff01_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE StaffInfo SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "staff01.php?col=".$col."&sw=".$sw;

} //글 삭제-------------------------------------------------------------------------------------------------------------------------


if($mode=="pcd") { //비밀번호 초기화 ---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE StaffInfo SET Pwd=password('1111') WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "staff01_read.php?idx=".$idx;

} //비밀번호 초기화-------------------------------------------------------------------------------------------------------------------------

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