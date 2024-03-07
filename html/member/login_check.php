<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

//세션이 상실되었으면
if(empty($_SESSION['LoginMemberID'])) {
	echo "O";
}else{

	$ID= $_SESSION['LoginMemberID'];
	$SessionID = session_id();

	$Sql = "SELECT COUNT(*) FROM LoginIng WHERE ID='$ID' AND SessionID='$SessionID' AND IP='$UserIP'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	$TOT_NO = $Row[0];

	if($TOT_NO < 1) {
		echo "N";
	}else{
		echo "Y";
	}

}


mysqli_close($connect);
?>