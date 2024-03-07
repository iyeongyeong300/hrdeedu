<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$idx = Replace_Check($idx);
$Status = Replace_Check($Status);
$Payment = Replace_Check($Payment);
$mode = Replace_Check($mode);


//상태 변경시
if($mode=="S") {

	$Sql = "UPDATE LectureRequest SET Status='$Status', Payment='$Payment' WHERE ID='$ID' AND idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	if($Row) {
		echo "Success";
	}else{
		echo "Fail";
	}

}

//삭제처리시
if($mode=="D") {

	$Sql = "UPDATE LectureRequest SET Del='Y' WHERE ID='$ID' AND idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	if($Row) {
		echo "Success";
	}else{
		echo "Fail";
	}

}


mysqli_close($connect);
?>