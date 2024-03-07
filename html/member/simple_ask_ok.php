<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의
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
$ID = Replace_Check_XSS2($ID); //아이디
$Name = Replace_Check_XSS2($Name); //이름
$Email = Replace_Check_XSS2($Email); //이메일
$Phone01 = Replace_Check_XSS2($Phone01); //휴대폰1
$Phone02 = Replace_Check_XSS2($Phone02); //휴대폰2
$Phone03 = Replace_Check_XSS2($Phone03); //휴대폰3
$SecurityCode = Replace_Check_XSS2($SecurityCode); //보안코드
$Contents = Replace_Check_XSS2($Contents); //내용


//필수 입력사항 체크
if(!$Name || !$Email || !$Phone01 || !$Phone02 || !$Phone03 || !$Contents) {
?>
<script type="text/javascript">
<!--
	alert("입력하지 않은 정보가 존재합니다.");
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
//-->
</script>
<?
exit;
}


$Phone = $Phone01."-".$Phone02."-".$Phone03;


$Phone_enc = "HEX(AES_ENCRYPT('$Phone','$DB_Enc_Key'))";
$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";

$Sql = "INSERT INTO SimpleAsk(ID, Name, Phone, Email, Contents, Status, RegDate, Del) 
			VALUES('$ID', '$Name', $Phone_enc, $Email_enc, '$Contents', 'A', NOW(), 'N')";
//echo $Sql;
$Row = mysqli_query($connect, $Sql);

if($Row) {
?>
<script type="text/javascript">
<!--
	alert("등록되었습니다.");
	top.DataResultClose();
//-->
</script>
<?
}else{
?>
<script type="text/javascript">
<!--
	alert("등록중 문제가 발생했습니다.\n\n잠시후에 다시 시도하세요.");
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