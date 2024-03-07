<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;


$mode = Replace_Check($mode); //채점여부
$Seq = Replace_Check($Seq); //수강내역 Seq
$TestType = Replace_Check($TestType); //평가 구분

$SubmitFunction = Replace_Check($SubmitFunction);

$idx = Replace_Check($idx); //답안 테이블 idx값
$LectureCode = Replace_Check($LectureCode); //강의 코드

$ExamA_Point = Replace_Check($ExamA_Point); //객관식 획득점수
$ExamB_Point = Replace_Check($ExamB_Point); //단답형 획득점수
$ExamC_Point = Replace_Check($ExamC_Point); //서술형 획득점수

$TutorRemarkA = Replace_Check($TutorRemarkA); //객관식 첨삭지도
$TutorRemarkB = Replace_Check($TutorRemarkB); //단답형 첨삭지도
$TutorRemarkC = Replace_Check($TutorRemarkC); //서술형 첨삭지도

$Mosa = Replace_Check($Mosa); //모사의심
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<HEAD>
<title>:: <?=$SiteName?> ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
</HEAD>
<BODY leftmargin="0" topmargin="0">
<?
//객관식 획득점수 계산
if($ExamA_Point) {
	$ExamA_Point_array = explode('|',$ExamA_Point);
	$ScoreA = array_sum($ExamA_Point_array);
}else{
	$ScoreA = 0;
}

//단답형 획득점수 계산
if($ExamB_Point) {
	$ExamB_Point_array = explode('|',$ExamB_Point);
	$ScoreB = array_sum($ExamB_Point_array);
}else{
	$ScoreB = 0;
}

//서술형 획득점수 계산
if($ExamC_Point) {
	$ExamC_Point_array = explode('|',$ExamC_Point);
	$ScoreC = array_sum($ExamC_Point_array);
}else{
	$ScoreC = 0;
}

$ExamTotalScore = $ScoreA + $ScoreB + $ScoreC;


if(!$Mosa) {
	$Mosa = "N";
}


if($Mosa=="N") { //모사답안 정상
	$TestCopy = "N";
	$ReportCopy = "N";
}

if($Mosa=="D") { //모사답안 의심
	$TestCopy = "D";
	$ReportCopy = "D";
}

if($Mosa=="Y") { //모사답안 확정
	$TestCopy = "Y";
	$ReportCopy = "Y";
}


//임시 저장#########################################################################################################
if($mode=="T") {

	switch($TestType) {
		case "MidTest": //중간평가
			$ExamStatus = ", MidStatus='Y'";
			$ExamScore = ", MidScore=$ExamTotalScore";
			$ExamCheckTime = ", MidCheckTime=NOW()";
			$ExamCheckIP = ", MidCheckIP='$UserIP'";
			$ExamTutorTempSave = ", MidTutorTempSave='Y'";
			$ExamMosa = "";

		break;
		case "Test": //최종평가
			$ExamStatus = ", TestStatus='Y'";
			$ExamScore = ", TestScore=$ExamTotalScore";
			$ExamCheckTime = ", TestCheckTime=NOW()";
			$ExamCheckIP = ", TestCheckIP='$UserIP'";
			$ExamTutorTempSave = ", TestTutorTempSave='Y'";
			$ExamMosa = ", TestCopy='$TestCopy'";

		break;
		case "Report": //과제
			$ExamStatus = ", ReportStatus='Y'";
			$ExamScore = ", ReportScore=$ExamTotalScore";
			$ExamCheckTime = ", ReportCheckTime=NOW()";
			$ExamCheckIP = ", ReportCheckIP='$UserIP'";
			$ExamTutorTempSave = ", ReportTutorTempSave='Y'";
			$ExamMosa = ", ReportCopy='$ReportCopy'";

		break;
		default :
			$ExamStatus = "";
			$ExamScore = "";
			$ExamCheckTime = "";
			$ExamCheckIP = "";
			$ExamTutorTempSave = "";
			$ExamMosa = "";

	}


	$SqlColume = "Mosa='$Mosa'".$ExamStatus.$ExamScore.$ExamCheckTime.$ExamCheckIP.$ExamTutorTempSave.$ExamMosa;

	//수강내역 테이블 업데이트
	$Sql = "UPDATE Study SET $SqlColume WHERE Seq=$Seq";
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$ErrorMsg01 = "[수강내역 임시저장 실패]";
	}

}
//임시 저장#########################################################################################################


//채점 완료#########################################################################################################
if($mode=="Y") {

	$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
	//echo $Sql;
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	$MidRate = $Row['MidRate']; //반영비율 중간평가
	$TestRate = $Row['TestRate']; //반영비율 최종평가
	$ReportRate = $Row['ReportRate']; //반영비율 과제
	$PassProgress = $Row['PassProgress']; //수료기준 진도율
	$PassTest = $Row['PassTest']; //수료기준 최종평가 점수
	$PassReport = $Row['PassReport']; //수료기준 과제 점수
	$PassScore = $Row['PassScore']; //반영비율을 적용한 총점

	$Sql = "SELECT * FROM Study WHERE Seq=$Seq";
	//echo $Sql;
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


	switch($TestType) {
		case "MidTest": //중간평가
			$ExamStatus = ", MidStatus='C'";
			$ExamScore = ", MidScore=$ExamTotalScore";
			$ExamCheckTime = ", MidCheckTime=NOW()";
			$ExamCheckIP = ", MidCheckIP='$UserIP'";
			$ExamTutorTempSave = ", MidTutorTempSave='N'";
			$ExamMosa = "";
			$TotalScore = ($ExamTotalScore * $MidRate / 100) + ($TestScore * $TestRate / 100) + ($ReportScore * $ReportRate / 100);

		break;
		case "Test": //최종평가
			$ExamStatus = ", TestStatus='C'";
			$ExamScore = ", TestScore=$ExamTotalScore";
			$ExamCheckTime = ", TestCheckTime=NOW()";
			$ExamCheckIP = ", TestCheckIP='$UserIP'";
			$ExamTutorTempSave = ", TestTutorTempSave='N'";
			$ExamMosa = ", TestCopy='$TestCopy'";
			$TotalScore = ($MidScore * $MidRate / 100) + ($ExamTotalScore * $TestRate / 100) + ($ReportScore * $ReportRate / 100);

		break;
		case "Report": //과제
			$ExamStatus = ", ReportStatus='C'";
			$ExamScore = ", ReportScore=$ExamTotalScore";
			$ExamCheckTime = ", ReportCheckTime=NOW()";
			$ExamCheckIP = ", ReportCheckIP='$UserIP'";
			$ExamTutorTempSave = ", ReportTutorTempSave='N'";
			$ExamMosa = ", ReportCopy='$ReportCopy'";
			$TotalScore = ($MidScore * $MidRate / 100) + ($TestScore * $TestRate / 100) + ($ExamTotalScore * $ReportRate / 100);

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
	$Sql = "UPDATE Study SET $SqlColume WHERE Seq=$Seq";
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$ErrorMsg02 = "[수강내역 채점완료 저장 실패]";
	}


}
//채점 완료#########################################################################################################


//채점 취소#########################################################################################################
if($mode=="C") {

	switch($TestType) {
		case "MidTest": //중간평가
			$ExamStatus = ", MidStatus='Y'";
			$ExamScore = ", MidScore=0";
			$ExamCheckTime = ", MidCheckTime=NOW()";
			$ExamCheckIP = ", MidCheckIP='$UserIP'";
			$ExamTutorTempSave = ", MidTutorTempSave=NULL";

		break;
		case "Test": //최종평가
			$ExamStatus = ", TestStatus='Y'";
			$ExamScore = ", TestScore=0";
			$ExamCheckTime = ", TestCheckTime=NOW()";
			$ExamCheckIP = ", TestCheckIP='$UserIP'";
			$ExamTutorTempSave = ", TestTutorTempSave=NULL";

		break;
		case "Report": //과제
			$ExamStatus = ", ReportStatus='Y'";
			$ExamScore = ", ReportScore=0";
			$ExamCheckTime = ", ReportCheckTime=NOW()";
			$ExamCheckIP = ", ReportCheckIP='$UserIP'";
			$ExamTutorTempSave = ", ReportTutorTempSave=NULL";

		break;
		default :
			$ExamStatus = "";
			$ExamScore = "";
			$ExamCheckTime = "";
			$ExamCheckIP = "";
			$ExamTutorTempSave = "";

	}

	$TotalScoreq = ", TotalScore=NULL";

	$SqlColume = "PassOK='N'".$ExamStatus.$ExamScore.$ExamCheckTime.$ExamCheckIP.$ExamTutorTempSave.$TotalScoreq;

	//수강내역 테이블 업데이트
	$Sql = "UPDATE Study SET $SqlColume WHERE Seq=$Seq";
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$ErrorMsg03 = "[수강내역 채점취소 저장 실패]";
	}


}
//채점 취소#########################################################################################################



if($mode=="T" || $mode=="Y") {

	//답안 테이블에 업데이트
	$Sql2 = "UPDATE TestAnswer SET ExamA_Point='$ExamA_Point', ExamB_Point='$ExamB_Point', ExamC_Point='$ExamC_Point', ScoreA=$ScoreA, ScoreB=$ScoreB, ScoreC=$ScoreC, TotalScore=$ExamTotalScore, TutorRemarkA='$TutorRemarkA', TutorRemarkB='$TutorRemarkB', TutorRemarkC='$TutorRemarkC' WHERE TestType='$TestType' AND Study_Seq=$Seq AND idx=$idx";
	$Row2 = mysqli_query($connect, $Sql2);

	if(!$Row2) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$ErrorMsg04 = "[답안지 저장 실패]";
	}

}




if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
?>
<script type="text/javascript">
<!--
	alert("평가결과 반영중 문제가 발생했습니다.\n\n<?=$ErrorMsg01?>\n\n<?=$ErrorMsg02?>\n\n<?=$ErrorMsg03?>\n\n<?=$ErrorMsg04?>");
	top.$("#SubmitBtn").show();
	top.$("#SubmitWait").hide();
//-->
</script>
<?
}else{
	mysqli_query($connect, "COMMIT");
?>
<script type="text/javascript">
<!--
	top.opener.<?=$SubmitFunction?>;
	top.self.close();
//-->
</script>
<?
}

mysqli_close($connect);
?>
</BODY>
</HTML>