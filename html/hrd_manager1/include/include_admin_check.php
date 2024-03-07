<?
if(!$LoginAdminID) {
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href="./logout.php";
//-->
</SCRIPT>
<?
exit;
}

//쓰기 권한 부여
if($LoginAdminDept=="A") { //관리자
	$AdminWrite = "Y";
}
if($LoginAdminDept=="B") { //영업사원
	$AdminWrite = "N";
}
if($LoginAdminDept=="C") { //첨삭강사
	$AdminWrite = "Y";
}
?>