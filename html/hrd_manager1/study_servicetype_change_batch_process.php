<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Seq = Replace_Check($Seq);
$ServiceType = Replace_Check($ServiceType);


$query = "UPDATE Study SET ServiceType='".$ServiceType."' WHERE Seq=".$Seq;
$result = mysqli_query($connect, $query);

if($result){
	$result_msg = "<font color='blue'>성공</font>";
} else {
	$result_msg = "<font color='red'>실패</font>";
}

echo $result_msg;

mysqli_close($connect);
?>