<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$seq_value = Replace_Check($seq_value);

$seq_array = explode('|',$seq_value);


foreach($seq_array as $seq) {
//foreach ====================================================================================================================================================

	//기존 삭제되는 자료 백업
	$Sql = "INSERT INTO StudyDeleteLog SELECT * FROM Study WHERE Seq=".$seq;
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

	//수강내역이 없는 훈련기간 삭제를 위해 삭제하려는 수강내역에서 훈련기간 검색에 필요한 조건을 조회
	$Sql_t = "SELECT LectureCode, ServiceType, OpenChapter, LectureStart, LectureEnd FROM Study WHERE Seq=".$seq;
	$Result_t = mysqli_query($connect, $Sql_t);
	$Row_t = mysqli_fetch_array($Result_t);

	if($Row_t) {
		$LectureCode = $Row_t['LectureCode'];
		$ServiceType = $Row_t['ServiceType'];
		$OpenChapter = $Row_t['OpenChapter'];
		$LectureStart = $Row_t['LectureStart'];
		$LectureEnd = $Row_t['LectureEnd'];
	}

	//해당 수강내역 삭제
	$Sql2 = "DELETE FROM Study WHERE Seq=".$seq;
	$Row2 = mysqli_query($connect, $Sql2);

	if(!$Row2) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

	//진도 내역 삭제
	$Sql3 = "DELETE FROM Progress WHERE Study_Seq=".$seq;
	$Row3 = mysqli_query($connect, $Sql3);

	if(!$Row3) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

	//조건에 해당하는 훈련기간에 수강내역이 존재하는지 확인
	$Sql2 = "SELECT COUNT(*) FROM Study WHERE LectureCode='$LectureCode' AND ServiceType=$ServiceType AND OpenChapter=$OpenChapter AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd'";
	$Result2 = mysqli_query($connect, $Sql2);
	$Row2 = mysqli_fetch_array($Result2);
	$StudyCount = $Row2[0];


	if($StudyCount<1) { //조건에 해당하는 훈련기간에 수강내역이 없다면 훈련기간 삭제처리
		$Sql_t2 = "DELETE FROM LectureTerme WHERE LectureCode='$LectureCode' AND ServiceType=$ServiceType AND OpenChapter=$OpenChapter AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd'";
		$Row_t2 = mysqli_query($connect, $Sql_t2);

		if(!$Row_t2) { //쿼리 실패시 에러카운터 증가
			$error_count++;
		}
	}


//foreach ====================================================================================================================================================
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