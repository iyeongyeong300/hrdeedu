<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$idx = Replace_Check($Seq);

//등록된 엑셀정보 불러오기
$Sql = "SELECT * FROM ExamBankExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
//echo $Sql."<BR>";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Gubun = $Row['Gubun']; //차시구분
	$ExamType = $Row['ExamType']; //평가 유형
	$Question = $Row['Question']; //질문
	$Example01 = $Row['Example01']; //예문1
	$Example02 = $Row['Example02']; //예문2
	$Example03 = $Row['Example03']; //예문3
	$Example04 = $Row['Example04']; //예문4
	$Example05 = $Row['Example05']; //예문5
	$Answer = $Row['Answer']; //객관식 정답
	$Answer2 = $Row['Answer2']; //단답형, 서술형 정답
	$Comment = $Row['Comment']; //해답설명
	$ScoreBasis = $Row['ScoreBasis']; //채점기준
}

$Gubun = addslashes($Gubun);
$ExamType = addslashes($ExamType);
$Question = addslashes($Question);
$Example01 = addslashes($Example01);
$Example02 = addslashes($Example02);
$Example03 = addslashes($Example03);
$Example04 = addslashes($Example04);
$Example05 = addslashes($Example05);
$Answer = addslashes($Answer);
$Answer2 = addslashes($Answer2);
$Comment = addslashes($Comment);
$ScoreBasis = addslashes($ScoreBasis);


$maxno = max_number("idx","ExamBank");

$Sql2 = "INSERT INTO ExamBank 
				(idx, Gubun, ExamType, Question, Example01, Example02, Example03, Example04, Example05, Answer, Answer2, Comment, ScoreBasis, UseYN, Del, RegDate) 
				VALUES ($maxno, '$Gubun', '$ExamType', '$Question', '$Example01', '$Example02', '$Example03', '$Example04', '$Example05', '$Answer', '$Answer2', '$Comment', '$ScoreBasis', 'Y', 'N', NOW())";
$Row2 = mysqli_query($connect, $Sql2);

if(!$Row2) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}


//등록 처리가 완료되면 엑셀 업로드 내역 삭제
if($error_count<1) {
	$Sql_d = "DELETE FROM ExamBankExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
	mysqli_query($connect, $Sql_d);
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "<font color='red'>오류</font>";
}else{
	mysqli_query($connect, "COMMIT");
	$msg = "<font color='blue'>등록</font>";
}

echo $msg;

mysqli_close($connect);
?>