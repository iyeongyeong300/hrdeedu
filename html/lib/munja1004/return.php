<?php
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$code = Replace_Check_XSS2($code);
$msg = Replace_Check_XSS2($msg);
$nums = Replace_Check_XSS2($nums);
$cols = Replace_Check_XSS2($cols);
$etc1 = Replace_Check_XSS2($etc1);
$etc2 = Replace_Check_XSS2($etc2);

$Sql = "UPDATE SmsSendLog SET Code='$code' WHERE idx=$etc1";
//echo $Sql;
$Row = mysql_query($Sql);

mysql_close($connect);
?>