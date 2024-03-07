<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$TB = Replace_Check($TB);
$Field = Replace_Check($Field);
$ele = Replace_Check($ele);
$ID = Replace_Check($ID);


if($TB=="Member") {
$Sql = "SELECT AES_DECRYPT(UNHEX($Field),'$DB_Enc_Key') FROM $TB WHERE ID='$ID'";
}
if($TB=="SimpleAsk" || $TB=="Counsel") {
$Sql = "SELECT AES_DECRYPT(UNHEX($Field),'$DB_Enc_Key') FROM $TB WHERE idx='$ID'";
}

//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

echo $Row[0];

mysqli_close($connect);
?>