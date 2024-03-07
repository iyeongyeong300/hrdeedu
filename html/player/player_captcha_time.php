<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$Study_Seq = Replace_Check_XSS2($Study_Seq);
$StepType = Replace_Check_XSS2($StepType);

$Sql2 = "UPDATE Study SET ".$StepType."=NOW() WHERE Seq=$Study_Seq AND ID='$LoginMemberID'";
$Row2 = mysqli_query($connect, $Sql2);

mysqli_close($connect);
?>