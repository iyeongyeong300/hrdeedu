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
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);

$ATypeEA = Replace_Check_XSS2($ATypeEA);
$BTypeEA = Replace_Check_XSS2($BTypeEA);
$CTypeEA = Replace_Check_XSS2($CTypeEA);

$ExamA_idx = Replace_Check_XSS2($ExamA_idx_value);
$ExamB_idx = Replace_Check_XSS2($ExamB_idx_value);
$ExamC_idx = Replace_Check_XSS2($ExamC_idx_value);
$ExamA_answer = Replace_Check_XSS2($ExamA_answer);
$ExamB_answer = Replace_Check_XSS2($ExamB_answer);
$ExamC_answer = Replace_Check_XSS2($ExamC_answer);
$FileName = Replace_Check_XSS2($FileName);

$TestType = Replace_Check_XSS2($TestType);

$maxno = max_number("idx","TestAnswer");

$Sql = "INSERT INTO TestAnswer(idx, ID, LectureCode, Study_Seq, Chapter_Seq, TestType, ATypeEA, BTypeEA, CTypeEA, ExamA_idx, ExamB_idx, ExamC_idx, ExamA_answer, ExamB_answer, ExamC_answer, RegDate, FileName) VALUES($maxno, '$LoginMemberID', '$LectureCode', $Study_Seq, $Chapter_Seq, '$TestType', $ATypeEA, $BTypeEA, $CTypeEA, '$ExamA_idx', '$ExamB_idx', '$ExamC_idx', '$ExamA_answer', '$ExamB_answer', '$ExamC_answer', NOW(), '$FileName')";
$Row = mysqli_query($connect, $Sql);

if(!$Row) { //쿼리 실패시 에러카운터 증가
	$error_count++;
	$ErrorMsg01 = "[답안지 처리불가]";
}

if($TestType=="MidTest") {
	$ExamStudy = "MidStatus='Y', MidSaveTime=NOW(), MidIP='$UserIP'";
	$CookieName = "LMS_MidTest_".$Study_Seq;
}
if($TestType=="Test") {
	$ExamStudy = "TestStatus='Y', TestEndTime=NOW(), TestSaveTime=NOW(), TestIP='$UserIP'";
	$CookieName = "LMS_Test_".$Study_Seq;
}
if($TestType=="Report") {
	$ExamStudy = "ReportStatus='Y', ReportSaveTime=NOW(), ReportIP='$UserIP'";
	$CookieName = "LMS_Report_".$Study_Seq;
}

$Sql2 = "UPDATE Study SET $ExamStudy WHERE Seq=$Study_Seq";
$Row2 = mysqli_query($connect, $Sql2);

if(!$Row2) { //쿼리 실패시 에러카운터 증가
	$error_count++;
	$ErrorMsg02 = "[수강내역 처리불가]";
}

//임시 저장된 평가 테이타 삭제
$Sql3 = "DELETE FROM TestAnswerTempSave WHERE LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND TestType='$TestType' AND ID='$LoginMemberID'";
$Row3 = mysqli_query($connect, $Sql3);

if(!$Row3) { //쿼리 실패시 에러카운터 증가
	$error_count++;
	$ErrorMsg03 = "[임시데이터 처리불가]";
}


//객관식만 있는 경우 자동 채점---------------------------------------------------------------------------------------------------
if($ATypeEA>0 && $BTypeEA==0 && $CTypeEA==0) {

	$ExamA_idx_array = explode('|',$ExamA_idx);
	$ExamA_answer_array = explode('|',$ExamA_answer);

	//객관식 문제 배점 구하기
	$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$Mid01Score = $Row['Mid01Score']; //중간평가 객관식 배점
		$Test01Score = $Row['Test01Score']; //최종평가 객관식 배점
		$Report01Score = $Row['Report01Score']; //최종평가 객관식 배점

		$MidRate = $Row['MidRate']; //반영비율 중간평가
		$TestRate = $Row['TestRate']; //반영비율 최종평가
		$ReportRate = $Row['ReportRate']; //반영비율 과제
		$PassProgress = $Row['PassProgress']; //수료기준 진도율
		$PassTest = $Row['PassTest']; //수료기준 최종평가 점수
		$PassReport = $Row['PassReport']; //수료기준 과제 점수
		$PassScore = $Row['PassScore']; //반영비율을 적용한 총점

	}

	switch($TestType) {
		case "MidTest": 
			$ExamA_Score = $Mid01Score; //객관식 배점
		break;
		case "Test":
			$ExamA_Score = $Test01Score; //객관식 배점
		break;
		case "Report":
			$ExamA_Score = $Report01Score; //객관식 배점
		break;
		default :
			$ExamA_Score = 0;
	}

	$i = 0;
	$UserAPointSUM = 0;
	$UserAPoint_Str = "";
	foreach($ExamA_idx_array as $ExamA_idx_array_value) {

		$Sql = "SELECT * FROM ExamBank WHERE ExamType='A' AND idx=$ExamA_idx_array_value";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);

		if($Row) {
			$Answer = $Row['Answer'];
		}

		$UserAnswer = $ExamA_answer_array[$i];

		if($UserAnswer==$Answer) {
			$UserAPoint = $ExamA_Score;

			if($i==0) {
				$UserAPoint_Str = $UserAPoint;
			}else{
				$UserAPoint_Str = $UserAPoint_Str."|".$UserAPoint;
			}

		}else{
			$UserAPoint = 0;

			if($i==0) {
				$UserAPoint_Str = "0";
			}else{
				$UserAPoint_Str = $UserAPoint_Str."|0";
			}

		}

		$UserAPointSUM = $UserAPointSUM + $UserAPoint;

		

	$i++;
	}

	$Sql = "SELECT * FROM Study WHERE Seq=$Study_Seq";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	$MidScore = $Row['MidScore']; //중간평가 점수
	$TestScore = $Row['TestScore']; //최종평가시험 점수
	$ReportScore = $Row['ReportScore']; //과제 점수
	$Progress = $Row['Progress']; //진도율

	if(!$MidScore) {
		$MidScore = 0;
	}
	if(!$TestScore) {
		$TestScore = 0;
	}
	if(!$ReportScore) {
		$ReportScore = 0;
	}

	$Mosa = "N";
	$TestCopy = "N";
	$ReportCopy = "N";

	switch($TestType) {
		case "MidTest": //중간평가
			$ExamStatus = ", MidStatus='C'";
			$ExamScore = ", MidScore=$UserAPointSUM";
			$ExamCheckTime = ", MidCheckTime=NOW()";
			$ExamCheckIP = ", MidCheckIP='$ServerIP'";
			$ExamTutorTempSave = ", MidTutorTempSave='N'";
			$ExamMosa = "";
			$TotalScore = ($UserAPointSUM * $MidRate / 100) + ($TestScore * $TestRate / 100) + ($ReportScore * $ReportRate / 100);

		break;
		case "Test": //최종평가
			$ExamStatus = ", TestStatus='C'";
			$ExamScore = ", TestScore=$UserAPointSUM";
			$ExamCheckTime = ", TestCheckTime=NOW()";
			$ExamCheckIP = ", TestCheckIP='$ServerIP'";
			$ExamTutorTempSave = ", TestTutorTempSave='N'";
			$ExamMosa = ", TestCopy='$TestCopy'";
			$TotalScore = ($MidScore * $MidRate / 100) + ($UserAPointSUM * $TestRate / 100) + ($ReportScore * $ReportRate / 100);

		break;
		case "Report": //과제
			$ExamStatus = ", ReportStatus='C'";
			$ExamScore = ", ReportScore=$UserAPointSUM";
			$ExamCheckTime = ", ReportCheckTime=NOW()";
			$ExamCheckIP = ", ReportCheckIP='$ServerIP'";
			$ExamTutorTempSave = ", ReportTutorTempSave='N'";
			$ExamMosa = ", ReportCopy='$ReportCopy'";
			$TotalScore = ($MidScore * $MidRate / 100) + ($TestScore * $TestRate / 100) + ($UserAPointSUM * $ReportRate / 100);

		break;
		default :
			$ExamStatus = "";
			$ExamScore = "";
			$ExamCheckTime = "";
			$ExamCheckIP = "";
			$ExamTutorTempSave = "";
			$ExamMosa = "";
			$TotalScore = 0;
	}

	//수료여부 판단
	if($Progress>=$PassProgress && $TotalScore>=$PassScore) {
		$PassOK = "Y";
	}else{
		$PassOK = "N";
		if($Progress<$PassProgress) {
			$FailReason = "진도 부족";
		}
		if($TotalScore<$PassScore) {
			if($FailReason) {
				$FailReason = $FailReason.", 평가점수 미달";
			}else{
				$FailReason = "평가점수 미달";
			}
			
		}
	}


	$PassOKq = ", PassOK='$PassOK'";
	$TotalScoreq = ", TotalScore=$TotalScore";
	$FailReasonq = ", FailReason='$FailReason'";

	$SqlColume = "Mosa='$Mosa'".$ExamStatus.$ExamScore.$ExamCheckTime.$ExamCheckIP.$ExamTutorTempSave.$ExamMosa.$PassOKq.$TotalScoreq.$FailReasonq;

	//수강내역 테이블 업데이트
	$Sql = "UPDATE Study SET $SqlColume WHERE Seq=$Study_Seq";
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$ErrorMsg04 = "[수강내역 채점완료 저장 실패]";
	}

	//답안 테이블에 업데이트
	$Sql2 = "UPDATE TestAnswer SET ExamA_Point='$UserAPoint_Str', ExamB_Point='', ExamC_Point='', ScoreA=$UserAPointSUM, ScoreB=0, ScoreC=0, TotalScore=$UserAPointSUM, TutorRemarkA='', TutorRemarkB='', TutorRemarkC='' WHERE TestType='$TestType' AND Study_Seq=$Study_Seq AND idx=$maxno";
	$Row2 = mysqli_query($connect, $Sql2);

	if(!$Row2) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$ErrorMsg05 = "[답안지 결과 저장 실패]";
	}


}
//객관식만 있는 경우 자동 채점---------------------------------------------------------------------------------------------------




if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$Proc = "N";
	$msg = "평가 처리중 문제가 발생했습니다. - 오류 원인 : ".$ErrorMsg01.$ErrorMsg02.$ErrorMsg03.$ErrorMsg04.$ErrorMsg05;
}else{
	mysqli_query($connect, "COMMIT");
	$Proc = "Y";
	$msg = "평가 제출이 완료 되었습니다.";
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