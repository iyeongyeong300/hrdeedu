<?
include "../include/include_function.php";

$CompanyCode = Replace_Check_XSS2($CompanyCode);

$Sql = "SELECT * FROM Company WHERE CompanyCode='$CompanyCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
?>
<font color="red">[ 이미 등록된 사업자번호입니다. ]</font>
<?
}else{
?>
<font color="blue">[ 등록이 가능한 사업자번호입니다. ]</font>
<?
}

mysqli_close($connect);
?>