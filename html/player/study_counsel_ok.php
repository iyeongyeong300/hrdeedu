<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";
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
$Category = Replace_Check_XSS2($Category); //문의종류
$LectureCode = Replace_Check_XSS2($LectureCode); //강의코드
$Study_Seq = Replace_Check_XSS2($Study_Seq); //강의 Seq
$Contents_idx = Replace_Check_XSS2($Contents_idx); //컨텐츠 idx
$Title = Replace_Check_XSS2($Title); //제목
$Contents = Replace_Check2($Contents); //내용

//필수 입력사항 체크
if(!$Category || !$Title) {
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


$Sql = "INSERT INTO StudyCounsel(ID, LectureCode, Study_Seq, Contents_idx, Category, Title, Contents, Status, Del, RegDate, ViewCount) 
			VALUES(
			'$LoginMemberID', '$LectureCode', $Study_Seq, $Contents_idx, '$Category', '$Title', '$Contents', 'A', 'N', NOW(), 0)";
$Row = mysqli_query($connect, $Sql);


if($Row) {
?>
<script type="text/javascript">
<!--
	alert("등록되었습니다.");
	top.PlayInfoClose();
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