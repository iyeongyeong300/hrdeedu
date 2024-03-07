<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;


$mode = Replace_Check($mode); //처리 구분
$ID = Replace_Check($ID); //아이디
$Seq = Replace_Check($Seq); //수강내역 고유번호
$CardPrice = Replace_Check($CardPrice); //카드 결제금액
$PaymentRemark = Replace_Check($PaymentRemark); //메모


if($mode=="AmountSave") { //금액 저장시------------------------------------------------------------------------------------------

	$Sql_s = "SELECT * FROM PaymentSheet2 WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	$Result_s = mysqli_query($connect, $Sql_s);
	$Row_s = mysqli_fetch_array($Result_s);
	$TOT_NO = $Row_s[0];

	if($TOT_NO > 0) {
		$Sql = "UPDATE PaymentSheet2 SET CardPrice=$CardPrice WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	}else{
		$maxno = max_number("idx","PaymentSheet2");
		$Sql = "INSERT INTO PaymentSheet2(idx, ID, Study_Seq, CardPrice, PayStatus, RegDate) VALUES($maxno, '$ID', $Seq, $CardPrice, 'N', NOW())";
	}

	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

} //금액 저장시------------------------------------------------------------------------------------------


if($mode=="PayStatusSave") { //결제 요청시------------------------------------------------------------------------------------------

	$Sql_s = "SELECT * FROM PaymentSheet2 WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	$Result_s = mysqli_query($connect, $Sql_s);
	$Row_s = mysqli_fetch_array($Result_s);
	$TOT_NO = $Row_s[0];

	if($TOT_NO > 0) {
		$Sql = "UPDATE PaymentSheet2 SET PayStatus='R' WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	}else{
		$maxno = max_number("idx","PaymentSheet2");
		$Sql = "INSERT INTO PaymentSheet2(idx, ID, Study_Seq, CardPrice, PayStatus, RegDate) VALUES($maxno, '$ID', $Seq, $CardPrice, 'R', NOW())";
	}

	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

} //결제 요청시------------------------------------------------------------------------------------------

if($mode=="PayStatusComplete") { //결제 완료 처리시------------------------------------------------------------------------------------------

	$Sql_s = "SELECT * FROM PaymentSheet2 WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	$Result_s = mysqli_query($connect, $Sql_s);
	$Row_s = mysqli_fetch_array($Result_s);
	$TOT_NO = $Row_s[0];

	$OrderNum = MakeOrderNum();

	if($TOT_NO > 0) {
		$Sql = "UPDATE PaymentSheet2 SET PayStatus='Y', PayMethod='Admin', MOID='$OrderNum', tid='', PayDate=NOW() WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	}else{
		$maxno = max_number("idx","PaymentSheet2");
		$Sql = "INSERT INTO PaymentSheet2(idx, ID, Study_Seq, CardPrice, PayStatus, RegDate, PayMethod, MOID, tid, PayDate) VALUES($maxno, '$ID', $Seq, $CardPrice, 'Y', NOW(), 'Admin', '$OrderNum', '', NOW())";
	}

	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

}//결제 완료 처리시------------------------------------------------------------------------------------------


if($mode=="PayStatusCancelSave") { //결제 요청 취소시------------------------------------------------------------------------------------------

	$Sql = "UPDATE PaymentSheet2 SET PayStatus='N' WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

}//결제 요청 취소시------------------------------------------------------------------------------------------



if($mode=="PaymentCancelSave") { //결제 취소(환불) 처리시------------------------------------------------------------------------------------------

	$Sql = "UPDATE PaymentSheet2 SET PayStatus='N', CancelDate=NOW() WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

}//결제 취소(환불) 처리시------------------------------------------------------------------------------------------

if($mode=="RemarkSave") { //메모 저장시------------------------------------------------------------------------------------------

	$Sql_s = "SELECT * FROM PaymentSheet2 WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	$Result_s = mysqli_query($connect, $Sql_s);
	$Row_s = mysqli_fetch_array($Result_s);
	$TOT_NO = $Row_s[0];

	if($TOT_NO > 0) {
		$Sql = "UPDATE PaymentSheet2 SET PaymentRemark='$PaymentRemark' WHERE ID='".$ID."' AND Study_Seq=".$Seq;
	}else{
		$maxno = max_number("idx","PaymentSheet2");
		$Sql = "INSERT INTO PaymentSheet2(idx, ID, Study_Seq, CardPrice, PayStatus, PaymentRemark, RegDate) VALUES($maxno, '$ID', $Seq, $CardPrice, 'N', '$PaymentRemark', NOW())";
	}

	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
	}

} //메모 저장시------------------------------------------------------------------------------------------


if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	echo "N";
}else{
	mysqli_query($connect, "COMMIT");
	echo "Y";
}
mysqli_close($connect);
?>