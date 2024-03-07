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



$Sql = "SELECT * FROM Member WHERE ID='$ID' AND MemberOut='N' AND UseYN='Y'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {


	//로그인 중복처리를 위한 
	$Sql4 = "DELETE FROM LoginIng WHERE ID='$ID'";
	mysqli_query($connect, $Sql4);

	$maxno = max_number("idx","LoginIng");
	$SessionID = session_id();
	$Sql5 = "INSERT INTO LoginIng(idx, ID, SessionID, IP, RegDate) VALUES($maxno, '$ID', '$SessionID', '$UserIP', NOW())";
	mysqli_query($connect, $Sql5);


	$_SESSION["LoginMemberID"] = $Row['ID'];
	$_SESSION["LoginName"] = $Row['Name'];
	$_SESSION["LoginEduManager"] = $Row['EduManager'];
	$_SESSION["LoginMemberType"] = $Row['MemberType'];
	$_SESSION["LoginTestID"] = $Row['TestID'];

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
location.href="<?=$SiteURL?>";
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