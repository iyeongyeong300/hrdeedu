<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

require_once ('../include/KISA_SHA256.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/css/style.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
</head>
<body>
<?
//로그인 여부 체크
include "../include/login_not_check.php";


//필수 입력 사항
//$ACS = Replace_Check_XSS2($ACS); //수강확인 문자발송
$Mailling = Replace_Check_XSS2($Mailling); //수강확인 문자/메일/알림톡 발송
$ACS = $Mailling;
$Marketing = Replace_Check_XSS2($Marketing); //마케팅 동의
$ID = Replace_Check_XSS2($ID); //ID
$Pwd = Replace_Check_XSS2($Pwd); //비밀번호
$Name = Replace_Check_XSS2($Name); //이름
$Email = Replace_Check_XSS2($Email); //이메일
$Mobile01 = Replace_Check_XSS2($Mobile01); //휴대폰1
$Mobile02 = Replace_Check_XSS2($Mobile02); //휴대폰2
$Mobile03 = Replace_Check_XSS2($Mobile03); //휴대폰3
$SecurityCode = Replace_Check_XSS2($SecurityCode); //보안코드
$enc_pwd = encrypt_SHA256($Pwd); //비밀번호 암호화


//필수 입력사항 체크
if(!$ID || !$Pwd || !$Name || !$Email || !$Mobile01 || !$Mobile02 || !$Mobile03) {
?>
<script type="text/javascript">
<!--
	alert("입력하지 않은 정보가 존재합니다.");
	top.$("#SubmitBtn").show();
	top.$("#WaitMag").hide();
//-->
</script>
<?
exit;
}

//보안코드 체크
if($_SESSION["make_text_image"] != $SecurityCode) {
?>
<script type="text/javascript">
<!--
	alert("보안코드가 일치하지 않습니다.");
	top.$("#SubmitBtn").show();
	top.$("#WaitMag").hide();
//-->
</script>
<?
exit;
}

//중복 아이디 체크
$Sql = "SELECT * FROM Member WHERE ID='$ID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
?>
<script type="text/javascript">
<!--
	alert("동일한 아이디가 존재합니다.");
	top.$("#SubmitBtn").show();
	top.$("#WaitMag").hide();
//-->
</script>
<?
exit;
}


//회원가입처리

$Mobile = $Mobile01."-".$Mobile02."-".$Mobile03;

if($Mailling=="on") {
	$Mailling = "Y";
}else{
	$Mailling = "N";
}

if($ACS=="on") {
	$ACS = "Y";
}else{
	$ACS = "N";
}

if($Marketing=="on") {
	$Marketing = "Y";
}else{
	$Marketing = "N";
}

if($Gender=='0'){
	$Gender = "F";
}else if($Gender=='1'){
	$Gender = "M";
}else{
	$Gender = "";
}

if($BirthDay){
	$BirthDay = substr($BirthDay,0,4)."-".substr($BirthDay,4,2)."-".substr($BirthDay,6,2);
}else{
	$BirthDay = "0000-00-00";
}

$MemberOut = "N"; //탈퇴여부
$Sleep = "N"; //휴면계정여부
$UseYN = "Y"; //계정사용여부
$ResNo = "0000000000000";
$EduManager = "N";
$PassChange = "Y";
$MemberType = "A"; //사업주훈련회원으로 가입처리

$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";
$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";
$ResNo_enc = "HEX(AES_ENCRYPT('$ResNo','$DB_Enc_Key'))";
$BirthDay_enc = "HEX(AES_ENCRYPT('$BirthDay','$DB_Enc_Key'))";

$Sql = "INSERT INTO Member(MemberType, ID, Pwd, Name, BirthDay, Gender, Email, Tel, Mobile, Zipcode, Address01, Address02, 
			NameEng, CompanyCode, Depart, Position, Etc01, Etc02, Mailling, ACS, Marketing, MemberOut, Sleep, UseYN, RegDate, ResNo, EduManager, PassChange) 
			VALUES(
			'$MemberType', '$ID', '$enc_pwd', '$Name', $BirthDay_enc, '$Gender', $Email_enc, '$Tel', $Mobile_enc, '$Zipcode', '$Address01', '$Address02', 
			'$NameEng', '$CompanyCode', '$Depart', '$Position', '$Etc01', '$Etc02', '$Mailling', '$ACS', '$Marketing', '$MemberOut', '$Sleep', '$UseYN', NOW(), $ResNo_enc, '$EduManager', '$PassChange')";
//echo $Sql;
$Row = mysqli_query($connect, $Sql);

if($Row) {
?>
<script type="text/javascript">
<!--
	//top.location.href="/member/join_step03.php";
	top.location.href="/new/member/membercomp.html";
//-->
</script>
<?
}else{
?>
<script type="text/javascript">
<!--
	alert("회원가입중 문제가 발생했습니다.\n\n잠시후에 다시 시도하세요.");
	top.$("#SubmitBtn").show();
	top.$("#WaitMag").hide();
//-->
</script>
<?
}
?>
</body>
</html>
<?
mysqli_close($connect);
?>