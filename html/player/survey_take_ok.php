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
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);

$ATypeEA = Replace_Check_XSS2($ATypeEA);
$BTypeEA = Replace_Check_XSS2($BTypeEA);

$ExamA_idx = Replace_Check_XSS2($ExamA_idx_value);
$ExamB_idx = Replace_Check_XSS2($ExamB_idx_value);
$ExamA_answer = Replace_Check_XSS2($ExamA_answer);
$ExamB_answer = Replace_Check_XSS2($ExamB_answer);


$Sql = "SELECT * FROM Study WHERE LectureCode='$LectureCode' AND Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	//$LectureStart = $Row['LectureStart'];
	//$LectureEnd = $Row['LectureEnd'];
	$ServiceType = $Row['ServiceType'];
	//$OpenChapter = $Row['OpenChapter'];
	$LectureTerme_idx = $Row['LectureTerme_idx'];
}


$maxno = max_number("idx","SurveyAnswer");

$Sql = "INSERT INTO SurveyAnswer(idx, ID, LectureCode, Study_Seq, ATypeEA, BTypeEA, ExamA_idx, ExamB_idx, ExamA_answer, ExamB_answer, RegDate) VALUES($maxno, '$LoginMemberID', '$LectureCode', $Study_Seq, $ATypeEA, $BTypeEA, '$ExamA_idx', '$ExamB_idx', '$ExamA_answer', '$ExamB_answer', NOW())";
$Row = mysqli_query($connect, $Sql);

if(!$Row) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}


//설문프로시져를 위한 데이타 넣기=======================================================================
if($ServiceType=="1" || $ServiceType=="4") {


	$ExamA_idx_Array = explode("|",$ExamA_idx);
	$ExamB_idx_Array = explode("|",$ExamB_idx);
	$ExamA_answer_Array = explode("|",$ExamA_answer);
	$ExamB_answer_Array = explode("|",$ExamB_answer);

	$i = 0;
	foreach($ExamA_idx_Array as $ExamA_idx_Array_value) {

		$Sql2 = "SELECT * FROM PollBank WHERE idx=$ExamA_idx_Array_value";
		$Result2 = mysqli_query($connect, $Sql2);
		$Row2 = mysqli_fetch_array($Result2);

		if($Row2) {
			$idx = $Row2['idx'];
			$Gubun = $Row2['Gubun'];
			$ExamType = $Row2['ExamType'];
			$Question = $Row2['Question'];
			$Example01 = $Row2['Example01'];
			$Example02 = $Row2['Example02'];
			$Example03 = $Row2['Example03'];
			$Example04 = $Row2['Example04'];
			$Example05 = $Row2['Example05'];
			$OrderByNum = $Row2['OrderByNum'];
		}

		$Answer = $ExamA_answer_Array[$i];
		$Sql3 = "INSERT INTO SurveyAnswerProcedure(Gubun, Exam_idx, OrderByNum, ID, LectureCode, LectureTerme_idx, Answer, AnswerText, RegDate) VALUES('$Gubun', $idx, $OrderByNum, '$LoginMemberID', '$LectureCode', $LectureTerme_idx, '$Answer', '', NOW())";
		$Row3 = mysqli_query($connect, $Sql3);

		if(!$Row3) { //쿼리 실패시 에러카운터 증가
			$error_count++;
		}

	$i++;
	}

	$i = 0;
	foreach($ExamB_idx_Array as $ExamB_idx_Array_value) {

		$Sql4 = "SELECT * FROM PollBank WHERE idx=$ExamB_idx_Array_value";
		$Result4 = mysqli_query($connect, $Sql4);
		$Row4 = mysqli_fetch_array($Result4);

		if($Row4) {
			$idx = $Row4['idx'];
			$Gubun = $Row4['Gubun'];
			$ExamType = $Row4['ExamType'];
			$Question = $Row4['Question'];
			$Example01 = $Row4['Example01'];
			$Example02 = $Row4['Example02'];
			$Example03 = $Row4['Example03'];
			$Example04 = $Row4['Example04'];
			$Example05 = $Row4['Example05'];
			$OrderByNum = $Row4['OrderByNum'];
		}

		$AnswerText = $ExamB_answer_Array[$i];
		$Sql5 = "INSERT INTO SurveyAnswerProcedure(Gubun, Exam_idx, OrderByNum, ID, LectureCode, LectureTerme_idx, Answer, AnswerText, RegDate) VALUES('$Gubun', $idx, $OrderByNum, '$LoginMemberID', '$LectureCode', $LectureTerme_idx, '', '$AnswerText', NOW())";
		$Row5 = mysqli_query($connect, $Sql5);

		if(!$Row5) { //쿼리 실패시 에러카운터 증가
			$error_count++;
		}

	$i++;
	}


}
//설문프로시져를 위한 데이타 넣기=======================================================================




$Sql6 = "UPDATE Study SET Survey='Y' WHERE Seq=$Study_Seq AND ID='$LoginMemberID'";
$Row6 = mysqli_query($connect, $Sql6);

if(!$Row6) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$Proc = "N";
	$msg = "설문 처리중 문제가 발생했습니다.";
}else{
	mysqli_query($connect, "COMMIT");
	$Proc = "Y";
	$msg = "설문 제출이 완료 되었습니다.";
}
?>
<script type="text/javascript">
<!--
	alert("<?=$msg?>");

	<?if($Proc=="Y") {?>
		top.location.reload();
	<?}?>
	<?if($Proc=="N") {?>
		top.$("#SurveyBtn01").show();
		top.$("#SurveyBtn02").hide();
	<?}?>

//-->
</script>
</body>
</html>
<?
mysqli_close($connect);
?>