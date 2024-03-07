<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$Seq = Replace_Check($Seq);
$ServiceTypeApply = Replace_Check($ServiceTypeApply);



$Sql = "SELECT * FROM Study WHERE Seq=$Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyCode = $Row['CompanyCode'];
	$LectureCode = $Row['LectureCode'];
	$ServiceType = $Row['ServiceType'];
}

//교육비 산정을 위해 회사규모를 구한다.
$Sql = "SELECT CompanyScale FROM Company WHERE CompanyCode='$CompanyCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyScale = $Row['CompanyScale'];
}


//교육과정 정보를 불러오기
$Sql = "SELECT Price, Price01, Price02, Price03, Price01View, Price02View, Price03View, PackageYN, PackageRef, PackageLectureCode, TotalPassMid, TotalPassTest, TotalPassReport FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Price = $Row['Price']; //교육비용

	$Price01 = $Row['Price01']; ///자부담 우선지원 환급비
	$Price02 = $Row['Price02']; ///자부담 대규모 1000인 미만 환급비
	$Price03 = $Row['Price03']; ///자부담 대규모 1000인 이상 환급비

	$Price01View = $Row['Price01View']; ///우선지원 환급비
	$Price02View = $Row['Price02View']; ///대규모 1000인 미만 환급비
	$Price03View = $Row['Price03View']; ///대규모 1000인 이상 환급비
}

//사업장 규모별 환급비용을 선정
switch($CompanyScale) {
	case "A": //대규모 1000인 이상
		$rPrice = $Price03View;
		$rPrice2 = $Price03;
	break;
	case "B": //대규모 1000인 미만
		$rPrice = $Price02View;
		$rPrice2 = $Price02;
	break;
	case "C": //우선지원대상
		$rPrice = $Price01View;
		$rPrice2 = $Price01;
	break;
	default:
		$rPrice = "0"; //환급금
		$rPrice2 = "0"; //자부담금
}

if($ServiceTypeApply=="N") {

	if($ServiceType == "3" || $ServiceType == "5") { // 일반(비환급)
		$rPrice = "0";
		$rPrice2 = "0";
	}

}

if($ServiceType == "9") { // 테스트일 경우
		$rPrice = "0";
		$rPrice2 = "0";
	}


$Sql_Input = "UPDATE Study SET Price=$Price, rPrice=$rPrice, rPrice2=$rPrice2 WHERE Seq=$Seq";
$Row_Input = mysqli_query($connect, $Sql_Input);

if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}


if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$result_msg = "<font color='red'>실패</font>";
}else{
	mysqli_query($connect, "COMMIT");
	$result_msg = "<font color='blue'>성공</font>";
}

echo $result_msg;

mysqli_close($connect);
?>