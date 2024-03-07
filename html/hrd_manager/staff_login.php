<?
include "../include/include_function.php"; 

$ID = Replace_Check_XSS2($ID); //아이디
$Login_token_value = Replace_Check2($Login_token_value); //검증용 토큰


if($Login_token_value != $_SESSION["Login_token"]) {
?>
<script type="text/javascript">
<!--
	alert("정상적인 로그인 접근이 아닙니다.");
	self.close();
//-->
</script>
<?
exit;
}



$Sql = "SELECT a.ID, a.Name, a.Team, b.Dept, b.DeptName, b.DeptString, b.TopMenuGrant, b.SubMenuGrant FROM StaffInfo AS a LEFT OUTER JOIN DeptStructure AS b 
			ON a.Dept_idx=b.idx 
			WHERE a.ID='$ID' AND a.UseYN='Y' AND a.Del='N'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {


	setCookie("LoginAdminID",$Row['ID'],0);
	setCookie("LoginAdminName",$Row['Name'],0);
	setCookie("LoginAdminDepart",$Row['Team'],0);
	setCookie("LoginAdminDept",$Row['Dept'],0);
	setCookie("LoginAdminDeptString",$Row['DeptString'],0);
	setCookie("LoginAdminTopMenuGrant",$Row['TopMenuGrant'],0);
	setCookie("LoginAdminSubMenuGrant",$Row['SubMenuGrant'],0);

	setCookie("LoginDate",date("Y-m-d H:i:s"),0);

	$_SESSION["LoginAdminID"] = $Row['ID'];

	if($IDSave=="Y") {
		setCookie("AdminSavedID",$ID,time()+15768000);
	}else{
		setCookie("AdminSavedID","",0);
	}

	//로그인 내역 저장
	$Sql_log = "INSERT INTO StaffLoginHistory(ID,Device,IP,RegDate, SiteCode) VALUES('$ID','PC','$UserIP',NOW(), '$SiteCode')";
	//mysqli_query($connect, $Sql_log);

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href="main.php";
//-->
</SCRIPT>
<?
}else{
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("로그인이 불가능한 아이디입니다.[미사용 전환 아이디]");
	self.close();
//-->
</SCRIPT>
<?
}

mysqli_close($connect);
?>