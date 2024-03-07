<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$Seq = Replace_Check($Seq);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$LectureReStudy = Replace_Check($LectureReStudy);

$Sql = "SELECT * FROM Study WHERE Seq=$Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$LectureCode = $Row['LectureCode'];
	$ServiceType = $Row['ServiceType'];
	$OpenChapter = $Row['OpenChapter'];
	$ID = $Row['ID'];
}

//수강 차수 구하기
$Sql2 = "SELECT idx FROM LectureTerme WHERE LectureCode='$LectureCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND ServiceType=$ServiceType AND OpenChapter=$OpenChapter";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);

if($Row2) {//동일한 수강차수가 있다면
	$LectureTerme_idx = $Row2['idx'];
}else{ //수강차수가 없다면 신규 등록
	$LectureTerme_idx = max_number("idx","LectureTerme");
	$Sql2_L = "INSERT INTO LectureTerme(idx, LectureCode, LectureStart, LectureEnd, ServiceType, OpenChapter) VALUES($LectureTerme_idx, '$LectureCode', '$LectureStart', '$LectureEnd', $ServiceType, $OpenChapter)";
	$Row2_L = mysqli_query($connect, $Sql2_L);

	if(!$Row2_L) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}
}

$StudyKey = $LectureTerme_idx."_".$ID;

$Sql_Input = "UPDATE Study SET LectureStart='$LectureStart', LectureEnd='$LectureEnd', LectureReStudy='$LectureReStudy', LectureTerme_idx=$LectureTerme_idx, StudyKey='$StudyKey' WHERE Seq=$Seq";
$Row_Input = mysqli_query($connect, $Sql_Input);

if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}
$Sql_Input = "UPDATE Study SET studyEnd='N' WHERE Seq=$Seq and LectureEnd > now() ";
$Row_Input = mysqli_query($connect, $Sql_Input);


if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$result_msg = "<font color='red'>실패</font>";
}else{
	mysqli_query($connect, "COMMIT");
	$result_msg = "<font color='blue'>성공</font>";
}


echo $result_msg;

mysqli_close($connect);
?>