<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);

$_SESSION['CAPTCHA_'.$Study_Seq.$Chapter_Seq] = "Y";

mysqli_close($connect);
?>