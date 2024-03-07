<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$seq_value = Replace_Check($seq_value);

$seq_array = explode('|',$seq_value);


foreach($seq_array as $idx) {
//foreach ====================================================================================================================================================

	$Sql = "UPDATE ExamBank SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
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