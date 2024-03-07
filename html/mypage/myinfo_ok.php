<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";

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
//필수 입력 사항
$MemberType = Replace_Check_XSS2($MemberType); //회원구분

$Pwd = Replace_Check_XSS2($Pwd); //비밀번호
$Email = Replace_Check_XSS2($Email); //이메일
$Mobile01 = Replace_Check_XSS2($Mobile01); //휴대폰1
$Mobile02 = Replace_Check_XSS2($Mobile02); //휴대폰2
$Mobile03 = Replace_Check_XSS2($Mobile03); //휴대폰3

//선택 입력 사항
$Zipcode = Replace_Check_XSS2($Zipcode); //우편번호
$Address01 = Replace_Check_XSS2($Address01); //주소
$Address02 = Replace_Check_XSS2($Address02); //나머지 주소
$Depart = Replace_Check_XSS2($Depart); //부서
$Position = Replace_Check_XSS2($Position); //직위
$CompanyCode = Replace_Check_XSS2($CompanyCode); //기업 사업자번호
$Mailling = Replace_Check_XSS2($Mailling); //메일링서비스
$Marketing = Replace_Check_XSS2($Marketing); //마케팅 수신동의


$CardName = Replace_Check_XSS2($CardName); //내일배움카드사
$CardNumber01 = Replace_Check_XSS2($CardNumber01); //내일배움카드번호
$CardNumber02 = Replace_Check_XSS2($CardNumber02);
$CardNumber03 = Replace_Check_XSS2($CardNumber03);
$CardNumber04 = Replace_Check_XSS2($CardNumber04);


$enc_pwd = encrypt_SHA256($Pwd); //비밀번호 암호화


$Mobile = $Mobile01."-".$Mobile02."-".$Mobile03;

if(!$Mailling) {
	$Mailling = "N";
}

if(!$Marketing) {
	$Marketing = "N";
}

$CardNumber = $CardNumber01."-".$CardNumber02."-".$CardNumber03."-".$CardNumber04;

$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";
$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";


$Sql = "UPDATE Member SET 
			Pwd='$enc_pwd', 
			Email=$Email_enc, 
			Mobile=$Mobile_enc, 
			Zipcode='$Zipcode', 
			Address01='$Address01', 
			Address02='$Address02', 
			CompanyCode='$CompanyCode', 
			Depart='$Depart', 
			Position='$Position', 
			CardName='$CardName', 
			CardNumber='$CardNumber', 
			Mailling='$Mailling', 
			Marketing='$Marketing', 
			PassChange = 'Y', 
			EditDate=NOW() 
			WHERE ID='$LoginMemberID'";
$Row = mysqli_query($connect, $Sql);

if($Row) {
?>
<script type="text/javascript">
<!--
	alert("회원정보가 수정되었습니다.");
	//top.location.href="/mypage/myinfo_employer.php";
	top.location.href="/new/mypage/memberinfo.html";
//-->
</script>
<?
}else{
?>
<script type="text/javascript">
<!--
	alert("회원정보 수정중 문제가 발생했습니다.\n\n잠시후에 다시 시도하세요.");
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