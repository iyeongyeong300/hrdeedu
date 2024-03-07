<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$LectureStart = Replace_Check($LectureStart); //수강기간 시작일
$LectureEnd = Replace_Check($LectureEnd); //수강기간 종료일
$LectureReStudyMonth = Replace_Check($LectureReStudyMonth); //복습기간
$LectureCode = Replace_Check($LectureCode); //강의 코드
$UserID = Replace_Check($UserID); //수강생 아이디
$Tutor = Replace_Check($Tutor); //첨삭강사 아이디
$ServiceType = Replace_Check($ServiceType); //개설용도
$Progress = Replace_Check($Progress); //진도율
$OpenChapter = Replace_Check($OpenChapter); //실시 회차
$SalesManagerTemp = Replace_Check($SalesManagerTemp); //영업담당자
$nwIno = Replace_Check($nwIno); //비용수급사업장

//$LectureStart2 = $LectureStart." 00:01:05";
//$LectureEnd2 = $LectureEnd." 23:59:55";

$indate_str = strtotime($LectureEnd."$LectureReStudyMonth month");
$LectureReStudy = date("Y-m-d",$indate_str);

//회원정보에서 소속 사업주 사업자번호와 이름 조회
$Sql = "SELECT CompanyCode, Name FROM Member WHERE ID='$UserID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyCode = $Row['CompanyCode'];
	$Name = $Row['Name'];
}

//사업자 번호가 있다면 교육비 산정을 위해 회사규모를 구한다.
if($CompanyCode) {

	$Sql = "SELECT CompanyScale FROM Company WHERE CompanyCode='$CompanyCode'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$CompanyScale = $Row['CompanyScale'];
	}else{
		$CompanyScale = "C";
	}

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

	$PackageYN = $Row['PackageYN']; //패키지 강의 여부
	$PackageRef = $Row['PackageRef']; //패키지 고유번호
	$PackageLectureCode = $Row['PackageLectureCode']; //패키지에 포함된 강의코드 코드1|코드2|코드3
	$TotalPassMid = $Row['TotalPassMid']; //중간평가 총점
	$TotalPassTest = $Row['TotalPassTest']; //최종평가 총점
	$TotalPassReport = $Row['TotalPassReport']; //과제 총점
}

//일반 단과 강의인 경우 #################################################################################################
if($PackageYN=="N") {

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

	if($ServiceType == "3" || $ServiceType == "5" || $ServiceType == "9") { // 일반(비환급)
		$rPrice = "0";
		$rPrice2 = "0";
	}

	if($TotalPassMid > 0 ) {
		$MidStatus = "N";
	}else{
		$MidStatus = "N";
	}
	if($TotalPassTest > 0 ) {
		$TestStatus = "N";
	}else{
		$TestStatus = "N";
	}
	if($TotalPassReport > 0 ) {
		$ReportStatus = "N";
	}else{
		$ReportStatus = "N";
	}

	//수강 차수 구하기
	$Sql2 = "SELECT idx FROM LectureTerme WHERE LectureCode='$LectureCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND ServiceType=$ServiceType AND OpenChapter=$OpenChapter";
	$Result2 = mysqli_query($connect, $Sql2);
	$Row2 = mysqli_fetch_array($Result2);

	if($Row2) {//동일한 수강차수가 있다면
		$LectureTerme_idx = $Row2['idx'];
	}else{ //수강차수가 없다면 신규 등록
		$LectureTerme_idx = max_number("idx","LectureTerme");
		$Sql2_L = "INSERT INTO LectureTerme(idx, LectureCode, LectureStart, LectureEnd, ServiceType, OpenChapter) VALUES($LectureTerme_idx, '$LectureCode', '$LectureStart', '$LectureEnd', $ServiceType, $OpenChapter)";
		$Row2_L = mysqli_query($connect, $Sql2_L);

		if(!$Row2_L) { //쿼리 실패시 에러카운터 증가
			$error_count++;
		}
	}

	$StudyKey = $LectureTerme_idx."_".$UserID;

	$Sql = "SELECT COUNT(*) FROM Study WHERE StudyKey='$StudyKey'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	$StudyKey_check = $Row[0];

	if($StudyKey_check>0) {
		$error_count++;
		$msg = "\\n------------------------------------------\\n\\n[동일한 과정·수간기간·서비스 구분]";
	}else{

		//강의 입력
		$max_Seq = max_number("Seq","Study");
		$Sql_Input = "INSERT INTO Study(Seq, LectureTerme_idx, LectureCode, ServiceType, Tutor, ID, CompanyCode, LectureStart, LectureEnd, LectureReStudy, 
							Progress, OpenChapter, StudyKey, MidStatus, TestStatus, ReportStatus, Price, rPrice, rPrice2, PackageRef, PackageLevel, InputID, InputDate, SalesID) 
							VALUES($max_Seq, $LectureTerme_idx, '$LectureCode', $ServiceType, '$Tutor', '$UserID', '$CompanyCode', '$LectureStart', '$LectureEnd', '$LectureReStudy', 
							$Progress, $OpenChapter, '$StudyKey', '$MidStatus', '$TestStatus', '$ReportStatus', $Price, $rPrice, $rPrice2, 0, 0, '$LoginAdminID', NOW(), '$SalesManagerTemp')";
		$Row_Input = mysqli_query($connect, $Sql_Input);
		echo $Sql_Input;

		if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
			$error_count++;
			$msg = "[DB입력 오류]";
		}else{
			$msg = "등록 되었습니다.";
		}


	}


}
//일반 단과 강의인 경우 #################################################################################################


//패키지 강의인 경우 #################################################################################################
if($PackageYN=="Y") {

	$PackageLectureCode_Array = explode("|",$PackageLectureCode);

	//강의코드 루프 부분-------------------------------------------------------------------------------------------------------------------------
	$Package_i = 1;
	foreach($PackageLectureCode_Array as $PackageLectureCode_Array_value) {

		//교육과정 정보를 불러오기
		$Sql_l = "SELECT LectureCode, Price, Price01, Price02, Price03, TotalPassMid, TotalPassTest, TotalPassReport, ServiceType FROM Course WHERE LectureCode='$PackageLectureCode_Array_value'";
		$Result_l = mysqli_query($connect, $Sql_l);
		$Row_l = mysqli_fetch_array($Result_l);

		if($Row_l) {
			$LectureCode = $Row_l['LectureCode']; //과정코드
			$Price = $Row_l['Price']; //교육비용
			$Price01 = $Row_l['Price01']; ///우선지원 환급비
			$Price02 = $Row_l['Price02']; ///대규모 1000인 미만 환급비
			$Price03 = $Row_l['Price03']; ///대규모 1000인 이상 환급비
			$TotalPassMid = $Row_l['TotalPassMid']; //중간평가 총점
			$TotalPassTest = $Row_l['TotalPassTest']; //최종평가 총점
			$TotalPassReport = $Row_l['TotalPassReport']; //과제 총점
			$ServiceTypeP = $Row_l['ServiceType']; //서비스 구분
		}

		if($ServiceType=="9") {
			$ServiceTypeP = "9";
		}

		//수강 차수 구하기
		$Sql2 = "SELECT idx FROM LectureTerme WHERE LectureCode='$LectureCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND ServiceType=$ServiceTypeP AND OpenChapter=$OpenChapter";
		$Result2 = mysqli_query($connect, $Sql2);
		$Row2 = mysqli_fetch_array($Result2);

		if($Row2) {//동일한 수강차수가 있다면
			$LectureTerme_idx = $Row2['idx'];
		}else{ //수강차수가 없다면 신규 등록
			$LectureTerme_idx = max_number("idx","LectureTerme");
			$Sql2_L = "INSERT INTO LectureTerme(idx, LectureCode, LectureStart, LectureEnd, ServiceType, OpenChapter) VALUES($LectureTerme_idx, '$LectureCode', '$LectureStart', '$LectureEnd', $ServiceTypeP, $OpenChapter)";
			$Row2_L = mysqli_query($connect, $Sql2_L);

			if(!$Row2_L) { //쿼리 실패시 에러카운터 증가
				$error_count++;
			}
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

		if($ServiceTypeP == "3" || $ServiceTypeP == "5" || $ServiceTypeP == "9") { // 일반(비환급)
			$rPrice = "0";
			$rPrice2 = "0";
		}

		if($TotalPassMid > 0 ) {
			$MidStatus = "N";
		}else{
			$MidStatus = "N";
		}
		if($TotalPassTest > 0 ) {
			$TestStatus = "N";
		}else{
			$TestStatus = "N";
		}
		if($TotalPassReport > 0 ) {
			$ReportStatus = "N";
		}else{
			$ReportStatus = "N";
		}

		$StudyKey = $LectureTerme_idx."_".$UserID;

		$Sql = "SELECT COUNT(*) FROM Study WHERE StudyKey='$StudyKey'";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);

		$StudyKey_check = $Row[0];

		if($StudyKey_check>0) {
			$error_count++;
			$msg = "\\n------------------------------------------\\n\\n[동일한 과정·수간기간·서비스 구분]\\n\\n[강의코드:".$LectureCode."]";
		}else{

			//강의 입력
			$max_Seq = max_number("Seq","Study");

			if($Package_i==1) {
				$PackageGroupNo = $max_Seq;
			}

			$Sql_Input = "INSERT INTO Study(Seq, LectureTerme_idx, LectureCode, ServiceType, Tutor, ID, CompanyCode, LectureStart, LectureEnd, LectureReStudy, 
								Progress, OpenChapter, StudyKey, MidStatus, TestStatus, ReportStatus, Price, rPrice, rPrice2, PackageRef, PackageLevel, InputID, InputDate, SalesID, PackageGroupNo) 
								VALUES($max_Seq, $LectureTerme_idx, '$LectureCode', $ServiceTypeP, '$Tutor', '$UserID', '$CompanyCode', '$LectureStart', '$LectureEnd', '$LectureReStudy', 
								$Progress, $OpenChapter, '$StudyKey', '$MidStatus', '$TestStatus', '$ReportStatus', $Price, $rPrice, $rPrice2, $PackageRef, $Package_i, '$LoginAdminID', NOW(), '$SalesManagerTemp', $PackageGroupNo)";
			$Row_Input = mysqli_query($connect, $Sql_Input);


			if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
				$error_count++;
				$msg = "[DB입력 오류]";
			}else{
				if($error_count<1) {
					$msg = "등록 되었습니다.";
				}
			}

		}

	$Package_i++;
	}
	//강의코드 루프 부분-------------------------------------------------------------------------------------------------------------------------

}
//패키지 강의인 경우 #################################################################################################

//비용수급사업장이 등록된 경우 회원정보 수정
if($nwIno) {

	$Sql = "UPDATE Member SET nwIno='$nwIno' WHERE ID='$UserID'";
	$Row = mysqli_query($connect, $Sql);

	if(!$Row) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$msg = "[회원정보(비용수급사업장) 오류]";
	}

}


if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "처리중 ".$error_count."건의 에러가 발생하였습니다.\\n\\n롤백 처리하였습니다.\\n\\n입력한 자료를 확인하세요.\\n\\n".$msg;
	$ProcessOk = "N";
}else{
	mysqli_query($connect, "COMMIT");
	$ProcessOk = "Y";
}


mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	<?if($ProcessOk=="Y") {?>
	top.location.reload();
	<?}else{?>
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?}?>
//-->
</SCRIPT>