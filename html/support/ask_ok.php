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
$Name = Replace_Check_XSS2($Name); //이름
$Category = Replace_Check_XSS2($Category); //문의종류
$Mobile01 = Replace_Check_XSS2($Mobile01); //연락처1
$Mobile02 = Replace_Check_XSS2($Mobile02); //연락처2
$Mobile03 = Replace_Check_XSS2($Mobile03); //연락처3
$Email01 = Replace_Check_XSS2($Email01); //이메일1
$Email02 = Replace_Check_XSS2($Email02); //이메일2
$Title = Replace_Check_XSS2($Title); //제목
$Contents = Replace_Check2($Contents); //내용
$SecurityCode = Replace_Check_XSS2($SecurityCode); //보안코드

//필수 입력사항 체크
if(!$Name || !$Category || !$Title) {
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


$Mobile = $Mobile01."-".$Mobile02."-".$Mobile03;
$Email = $Email01."@".$Email02;

$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";
$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";

$Sql = "INSERT INTO Counsel(ID, Name, Category, Mobile, Email, Title, Contents, Status, Del, RegDate, ViewCount) 
			VALUES(
			'$LoginMemberID', '$Name', '$Category', $Mobile_enc, $Email_enc, '$Title', '$Contents', 'A', 'N', NOW(), 0)";
$Row = mysqli_query($connect, $Sql);

$url = "/new/support/ask.html";


if($Row) {
?>
<script type="text/javascript">
<!--
	alert("등록되었습니다.");
	top.location.href="<?=$url?>";
//-->
</script>
<?
}else{
?>
<script type="text/javascript">
<!--
	alert("등록중 문제가 발생했습니다.\n\n잠시후에 다시 시도하세요.");
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