<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$mode         = Replace_Check($mode);        //처리 구분
$CompanyCode  = Replace_Check($CompanyCode); //사업자번호
$LectureStart = Replace_Check($LectureStart);//시작일
$LectureEnd   = Replace_Check($LectureEnd);  //종료일
$ServiceType  = Replace_Check($ServiceType); //환급여
$LectureCode  = Replace_Check($LectureCode); //과정코드

$StudyEndWhere = "CompanyCode='$CompanyCode' AND ServiceType='$ServiceType' AND LectureCode='$LectureCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd'";

//수강마감테이블 조회
$Sql2 = "SELECT COUNT(*) FROM StudyEnd WHERE $StudyEndWhere";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

if($TOT_NO>0) {
	if($mode=="StudyEnd") {
		$Sql = "UPDATE StudyEnd SET StudyEndInputID='$LoginAdminID', StudyEndInputDate=NOW(),ResultViewInputID='$LoginAdminID', ResultViewInputDate=NOW() WHERE $StudyEndWhere";
		$Row = mysqli_query($connect, $Sql);
	}
}else{
	if($mode=="StudyEnd") {
		$Sql = "INSERT INTO StudyEnd(CompanyCode, ServiceType, LectureCode, LectureStart, LectureEnd, StudyEndInputID, StudyEndInputDate, ResultViewInputID, ResultViewInputDate) VALUES('$CompanyCode', '$ServiceType','$LectureCode','$LectureStart', '$LectureEnd', '$LoginAdminID', NOW(), '$LoginAdminID', NOW())";
		$Row = mysqli_query($connect, $Sql);
	}
}

//쿼리 실패시 에러카운터 증가
if(!$Row) {
	$error_count++;
}

//수강내역 갱신
if($mode=="StudyEnd") {
	$Sql2 = "UPDATE Study SET StudyEnd='Y', ResultView='Y' WHERE $StudyEndWhere";
	$Row2 = mysqli_query($connect, $Sql2);
}

//쿼리 실패시 에러카운터 증가
if(!$Row2) {
	$error_count++;
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	echo "N";
}else{
	mysqli_query($connect, "COMMIT");
	echo "Y";
}
mysqli_close($connect);
?>