<?php
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$num = Replace_Check_XSS2($num);

$Sql = "UPDATE EmailSendLog SET Code='Y', ReciveDate=NOW() WHERE idx=$num";
//echo $Sql;
$Row = mysqli_query($connect, $Sql);

mysqli_close($connect);
?>