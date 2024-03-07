<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check_pop.php";
//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
</head>

<body>
<?

/*
<input type="hidden" name="LectureCode" 	id="LectureCode" value="<?=$LectureCode?>">
			<input type="hidden" name="Study_Seq" 		id="Study_Seq" value="<?=$Study_Seq?>">
			<input type="hidden" name="Chapter_Seq" 	id="Chapter_Seq" value="<?=$Chapter_Seq?>">
			<input type="hidden" name="User_Id" 		id="User_Id" value="<?=$User_Id?>">
			UserAnswer
			
			*/
	$LectureCode = Replace_Check_XSS2($LectureCode);
	$Study_Seq = Replace_Check_XSS2($Study_Seq);
	$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
	$UserAnswer = Replace_Check_XSS2($UserAnswer);
 
 
$Sql = "INSERT INTO DiscussionAnswer( ID, LectureCode, Study_Seq, Chapter_Seq, UserAnswer, TutorRemark,RegDate) VALUES('$LoginMemberID', '$LectureCode', $Study_Seq, $Chapter_Seq, '$UserAnswer','', NOW())";
$Row = mysqli_query($connect, $Sql);

if(!$Row) { //쿼리 실패시 에러카운터 증가
	$error_count++;
	$ErrorMsg01 = "[토론 내용 처리불가]";
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$Proc = "N";
	$msg = " 처리중 문제가 발생했습니다. - 오류 원인 : ".$ErrorMsg01.$ErrorMsg02.$ErrorMsg03.$ErrorMsg04.$ErrorMsg05;
	
}else{
	
	mysqli_query($connect, "COMMIT");
	$Proc = "Y";
	$msg = "토론참여가 완료 되었습니다.";
}
?>
<script type="text/javascript">
<!--
	alert("<?=$msg?>");

	//저장된 쿠키 삭제
	var sName = "<?=$CookieName?>";
	document.cookie = sName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

	<?if($Proc=="Y") {?>
		top.location.reload();
	<?}?>
	<?if($Proc=="N") {?>
		top.$("#ExamBtn01").show();
		top.$("#ExamBtn02").hide();
		top.$("div[id='ResultConfirm']").hide();
	<?}?>

//-->
</script>
</body>
</html>
<?
mysqli_close($connect);
?>