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
 
$Sql_Input = "UPDATE Study SET LectureStart='$LectureStart', LectureEnd='$LectureEnd'  WHERE Seq=$Seq";
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