<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$CertType = Replace_Check_XSS2($CertType);
$AGTID = Replace_Check_XSS2($AGTID);
$COURSE_AGENT_PK = Replace_Check_XSS2($COURSE_AGENT_PK);
$CLASS_AGENT_PK = Replace_Check_XSS2($CLASS_AGENT_PK);
$m_Ret = Replace_Check_XSS2($m_Ret);
$m_retCD = Replace_Check_XSS2($m_retCD);
$m_trnID = Replace_Check_XSS2($m_trnID);
$m_trnDT = Replace_Check_XSS2($m_trnDT);


//인증저장내역이 있는지 확인
$Sql = "SELECT COUNT(*) FROM UserCertOTP WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$CertCount = $Row[0];

if($CertCount<1) {

	//인증성공시 인증내역에 저장
	$maxno = max_number("Seq","UserCertOTP");
	$CertDate = date("Y-m-d");

	$Sql = "INSERT INTO UserCertOTP(Seq, ID, LectureCode, Study_Seq, CertDate, CertType, AGTID, COURSE_AGENT_PK, CLASS_AGENT_PK, m_Ret, m_retCD, m_trnID, m_trnDT, RegDate) VALUES($maxno, '$LoginMemberID', '$LectureCode', $Study_Seq, '$CertDate', '$CertType', '$AGTID', '$COURSE_AGENT_PK', '$CLASS_AGENT_PK', '$m_Ret', '$m_retCD', '$m_trnID', '$m_trnDT', NOW())";
	$Row = mysqli_query($connect, $Sql);

	$Sql2 = "UPDATE Study SET certCount=certCount+1 WHERE ID='$LoginMemberID' AND LectureEnd>='$CertDate' AND StudyEnd='N'";
	$Row2 = mysqli_query($connect, $Sql2);

}

if($Row) {
	echo "Y";
}else{
	echo "N";
}

mysqli_close($connect);
?>