<?
include "../include/include_function.php";
include "./include/include_admin_check.php";


$MosaCheck01_value = Replace_Check($MosaCheck01_value);
$MosaCheck02_value = Replace_Check($MosaCheck02_value);


$MosaCheck01_value_len = mb_strlen($MosaCheck01_value,"UTF-8");
$MosaCheck02_value_len = mb_strlen($MosaCheck02_value,"UTF-8");

if($MosaCheck01_value_len>$MosaCheck02_value_len) {

	$MosaRatio = $MosaCheck02_value_len / $MosaCheck01_value_len * 100;

}else{

	$MosaRatio = $MosaCheck01_value_len / $MosaCheck02_value_len * 100;

}


echo number_format($MosaRatio,2);

mysqli_close($connect);
?>