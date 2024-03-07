<?
include "../include/include_function.php";

$ID = Replace_Check_XSS2($ID);

$Sql = "SELECT * FROM StaffInfo WHERE ID='$ID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
?>
<font color="red">[ 이미 등록된 아이디입니다. ]</font>
<?
}else{
?>
<font color="blue">[ 등록이 가능한 아이디입니다. ]</font>
<?
}

mysqli_close($connect);
?>