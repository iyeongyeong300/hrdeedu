<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;


$mode = Replace_Check($mode); //처리 구분
$CompanyCode = Replace_Check($CompanyCode); //사업자번호
$LectureStart = Replace_Check($LectureStart); //시작일
$LectureEnd = Replace_Check($LectureEnd); //종료일

//마감테이블 등록
$Sql2 = "SELECT COUNT(*) FROM StudyEnd WHERE CompanyCode='$CompanyCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd'";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

if($TOT_NO>0) {

	if($mode=="ResultView") {

		$Sql = "UPDATE StudyEnd SET ResultViewInputID='$LoginAdminID', ResultViewInputDate=NOW() WHERE CompanyCode='$CompanyCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd'";
		$Row = mysqli_query($connect, $Sql);

	}
	if($mode=="StudyEnd") {
		$Sql = "UPDATE StudyEnd SET StudyEndInputID='$LoginAdminID', StudyEndInputDate=NOW() WHERE CompanyCode='$CompanyCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd'";
		$Row = mysqli_query($connect, $Sql);
	}

}else{

	if($mode=="ResultView") {
		$Sql = "INSERT INTO StudyEnd(CompanyCode, LectureStart, LectureEnd, ResultViewInputID, ResultViewInputDate) VALUES('$CompanyCode', '$LectureStart', '$LectureEnd', '$LoginAdminID', NOW())";
		$Row = mysqli_query($connect, $Sql);
	}
	if($mode=="StudyEnd") {
		$Sql = "INSERT INTO StudyEnd(CompanyCode, LectureStart, LectureEnd, StudyEndInputID, StudyEndInputDate) VALUES('$CompanyCode', '$LectureStart', '$LectureEnd', '$LoginAdminID', NOW())";
		$Row = mysqli_query($connect, $Sql);
	}

}

if(!$Row) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}


//수강내역 갱신
if($mode=="ResultView") {

	$Sql2 = "UPDATE Study SET ResultView='Y' WHERE CompanyCode='$CompanyCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND (ServiceType=1 OR ServiceType=3 OR ServiceType=5 OR ServiceType=9)";
	$Row2 = mysqli_query($connect, $Sql2);

}


if($mode=="StudyEnd") {

	$Sql2 = "UPDATE Study SET StudyEnd='Y' WHERE CompanyCode='$CompanyCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND (ServiceType=1 OR ServiceType=3 OR ServiceType=5 OR ServiceType=9)";
	$Row2 = mysqli_query($connect, $Sql2);

}


if(!$Row2) { //쿼리 실패시 에러카운터 증가
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