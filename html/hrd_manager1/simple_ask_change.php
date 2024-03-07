<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$Status = Replace_Check($Status);
$mode = Replace_Check($mode);


//상태 변경시
if($mode=="S") {

	$Sql = "UPDATE SimpleAsk SET Status='$Status' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	if($Row) {
		echo "Success";
	}else{
		echo "Fail";
	}

}

//삭제처리시
if($mode=="D") {

	$Sql = "UPDATE SimpleAsk SET Del='Y' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	if($Row) {
		echo "Success";
	}else{
		echo "Fail";
	}

}


mysqli_close($connect);
?>