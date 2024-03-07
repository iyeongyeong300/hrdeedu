<?
include "../include/include_function.php";

$CompanyID = Replace_Check_XSS2($CompanyID);

$Sql = "SELECT * FROM Company WHERE CompanyID='$CompanyID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
?>
<font color="red">[ 이미 등록된 사업주 아이디입니다. ]</font>
<?
}else{
?>
<font color="blue">[ 등록이 가능한 사업주 아이디입니다. ]</font>
<?
}

mysqli_close($connect);
?>