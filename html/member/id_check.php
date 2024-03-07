<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$ID = Replace_Check_XSS2($ID);

$Sql = "SELECT * FROM Member WHERE ID='$ID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
?>
<input type="hidden" name="ID_Check" id="ID_Check" value="N">
<?
}else{
?>
<input type="hidden" name="ID_Check" id="ID_Check" value="Y">
<?
}

mysqli_close($connect);
?>