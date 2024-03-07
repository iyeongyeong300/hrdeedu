<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$TestType = Replace_Check_XSS2($TestType);

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

$NowTime = time();

$Sql = "SELECT COUNT(*) FROM TestAnswerTempSave WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq AND TestType='$TestType'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$SaveCount = $Row[0];

if($SaveCount>0) {
	$Sql = "UPDATE TestAnswerTempSave SET ATypeEA=$ATypeEA, BTypeEA=$BTypeEA, CTypeEA=$CTypeEA, ExamA_idx='$ExamA_idx', ExamB_idx='$ExamB_idx', ExamC_idx='$ExamC_idx', ExamA_answer='$ExamA_answer', ExamB_answer='$ExamB_answer', ExamC_answer='$ExamC_answer', FileName='$FileName', RegDate=NOW() WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq AND TestType='$TestType'";
}else{
	$maxno = max_number("idx","TestAnswerTempSave");
	$Sql = "INSERT INTO TestAnswerTempSave(idx, ID, LectureCode, Study_Seq, Chapter_Seq, TestType, ATypeEA, BTypeEA, CTypeEA, ExamA_idx, ExamB_idx, ExamC_idx, ExamA_answer, ExamB_answer, ExamC_answer, ProgressTime, RegDate, FileName) VALUES($maxno, '$LoginMemberID', '$LectureCode', $Study_Seq, $Chapter_Seq, '$TestType', $ATypeEA, $BTypeEA, $CTypeEA, '$ExamA_idx', '$ExamB_idx', '$ExamC_idx', '$ExamA_answer', '$ExamB_answer', '$ExamC_answer', $NowTime, NOW(), '$FileName')";
}

$Row = mysqli_query($connect, $Sql);

echo "Y";

mysqli_close($connect);
?>