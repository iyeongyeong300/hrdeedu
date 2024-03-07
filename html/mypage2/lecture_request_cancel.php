<?
include "../include/include_function.php";

$idx = Replace_Check_XSS2($idx);

if(empty($_SESSION['LoginMemberID'])) {
	echo "Login"; //로그인 필요
}else{

		$Sql = "DELETE FROM LectureRequest WHERE idx=$idx AND ID='$LoginMemberID'";
		$Row = mysqli_query($connect, $Sql);

		if($Row) {
			echo "Success";
		}else{
			echo "Fail";
		}

}

mysqli_close($connect);
?>