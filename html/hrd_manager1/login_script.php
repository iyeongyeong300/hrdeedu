<?
include "../include/include_function.php"; 

$ID = Replace_Check_XSS2($ID); //아이디
$Passwd = Replace_Check_XSS2($Passwd); //비밀번호
$IDSave = Replace_Check_XSS2($IDSave); //아이디 저장여부


/*
if(strpos($_SERVER["HTTP_HOST"],"tutor") > -1) {
	$Dept_str = " AND a.Dept='C'"; //첨삭강사로 로그인시
}else{
	$Dept_str = " AND (a.Dept='A' OR a.Dept='B')"; //일반관리자 또는 영업사원으로 로그인시
}
*/

$Sql = "SELECT a.ID, a.Name, a.Team, b.Dept, b.DeptName, b.DeptString, b.TopMenuGrant, b.SubMenuGrant FROM StaffInfo AS a LEFT OUTER JOIN DeptStructure AS b 
			ON a.Dept_idx=b.idx 
			WHERE a.ID='$ID' AND a.Pwd=password('$Passwd') AND a.UseYN='Y' AND a.Del='N' AND a.SiteCode='$SiteCode' $Dept_str";
//echo $Sql;
$Result = mysqli_query($connect,$Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {


	setCookie("LoginAdminID",$Row['ID'],0,"/"); //아이디
	setCookie("LoginAdminName",$Row['Name'],0,"/"); //이름
	setCookie("LoginAdminDepart",$Row['Team'],0,"/"); //부서
	setCookie("LoginAdminDept",$Row['Dept'],0,"/"); //관리자 구분 (A:관리자, B:영업사원, C:첨삭강사)
	setCookie("LoginAdminDeptString",$Row['DeptString'],0,"/"); //소속 부서 구성원 배열값
	setCookie("LoginAdminTopMenuGrant",$Row['TopMenuGrant'],0,"/"); //상단 메뉴 권한
	setCookie("LoginAdminSubMenuGrant",$Row['SubMenuGrant'],0,"/"); //서브메뉴 권한

	setCookie("LoginDate",date("Y-m-d H:i:s"),0);

	$_SESSION["LoginAdminID"] = $Row['ID'];

	if($IDSave=="Y") {
		setCookie("AdminSavedID",$ID,time()+15768000,"/");
	}else{
		setCookie("AdminSavedID","",0,"/");
	}

	if($Row['Dept']=="A") { //관리자 
		//$url = "study.php";
		$url = "main.php";
	}
	if($Row['Dept']=="B") { //영업사원 
		//$url = "company.php";
		$url = "main.php";
	}
	if($Row['Dept']=="C") { //첨삭강사 
		//$url = "study_correct.php";
		$url = "main.php";
	}

	//최종로그인 날짜, IP 등록
	$Sql2 = "UPDATE StaffInfo SET LastLoginDate=NOW(), LastLoginIP='$UserIP' WHERE ID='$ID'";
	mysqli_query($connect,$Sql2);

	//로그인 내역 저장
	$Sql_log = "INSERT INTO StaffLoginHistory(ID, Device, IP, SiteCode, RegDate) VALUES('$ID', 'PC', '$UserIP', '$SiteCode', NOW())";
	mysqli_query($connect,$Sql_log);

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
top.location.href="<?=$url?>";
//-->
</SCRIPT>
<?
}else{
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
alert("아이디 또는 비밀번호가 정확하지 않습니다.");
//-->
</SCRIPT>
<?
}

mysqli_close($connect);
?>