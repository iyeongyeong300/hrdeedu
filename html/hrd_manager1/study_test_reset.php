<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Seq = Replace_Check($Seq);
$sType = Replace_Check($sType);

if($sType=="Mid") { //중간평가
	$str_query = " MidScore=NULL, MidStatus='N', ReTest='Y', reDate=NOW() ";
}

if($sType=="Test") { //최종평가
	$str_query = " TestScore=NULL, TestStatus='N', ReTest='Y', reDate=NOW() ";
}

if($sType=="Report") { //과제
	$str_query = " ReportScore=NULL, ReportStatus='N', ReTest='Y', reDate=NOW() ";
}

$Sql = "UPDATE Study SET $str_query WHERE Seq=$Seq";
$Row = mysqli_query($connect, $Sql);


if($Row) {
	echo "Y";
}else{
	echo "N";
}

mysqli_close($connect);
?>