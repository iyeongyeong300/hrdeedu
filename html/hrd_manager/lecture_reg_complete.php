<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

require_once ('../include/KISA_SHA256.php');

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$idx = Replace_Check($Seq);

//등록된 엑셀정보 불러오기
$Sql = "SELECT * FROM StudyExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
//echo $Sql."<BR>";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$LectureCode = $Row['LectureCode']; //과정 코드
	$Tutor = $Row['Tutor']; //첨삭 강사
	$Name = $Row['Name']; //수강생 성명
	$ResNo = $Row['ResNo']; //주민번호
	$Mobile = $Row['Mobile']; //휴대폰
	$Email = $Row['Email']; //이메일
	$CompanyCode = $Row['CompanyCode']; //사업자번호
	$Depart = $Row['Depart']; //부서명
	$LectureStart = $Row['LectureStart']; //강의 시작일
	$LectureEnd = $Row['LectureEnd']; //강의 종료일
	$LectureReStudy = $Row['LectureReStudy']; //복습종료일
	$Price = $Row['Price']; //수강금액
	$rPrice = $Row['rPrice']; //환급액
	$ServiceType = $Row['ServiceType']; //서비스 구분
	$UserID = $Row['UserID']; //수강생 아이디
	$Pwd = $Row['Pwd']; //비밀번호
	$nwIno = $Row['nwIno']; //비용수급사업장
	$trneeSe = $Row['trneeSe']; //훈련생구분
	$IrglbrSe = $Row['IrglbrSe']; //비정규직구분
	$OpenChapter = $Row['OpenChapter']; //실시회차
	$SalesID = $Row['SalesID']; //영업자 아이디
	$EduManager = $Row['EduManager']; //교육담당자 여부
}

if($EduManager!="Y" && $EduManager!="N") {
	$EduManager="N";
}

if(!$Pwd) {
	$Pwd = "1111";
}

$enc_pwd = encrypt_SHA256($Pwd); //비밀번호 암호화

if(!$OpenChapter) {
	$OpenChapter = "1";
}

if(!$LectureReStudy) {
	$indate_str = strtotime($LectureEnd."2 month");
	$LectureReStudy = date("Y-m-d",$indate_str);
}

$Progress = 0;

//사업주 정보 불러오기
$Sql = "SELECT CompanyScale, CompanyID FROM Company WHERE CompanyCode='$CompanyCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyScale = $Row['CompanyScale']; //사업자 규모
	$CompanyID = $Row['CompanyID']; //사업주 아이디
}



$ResNo_array = explode("-",$ResNo);
$ResNo01 = $ResNo_array[0];
$ResNo02 = $ResNo_array[1];

$InputResNo = $ResNo01.$ResNo02;

if($ResNo02) {

	$ResNoRight1 = substr($ResNo02,0,1);

	switch($ResNoRight1) {
		//내국인 주민번호
		case "1":
			$Gender = "M";
			$BirthDay = "19".substr($ResNo01,0,2)."-".substr($ResNo01,2,2)."-".substr($ResNo01,4,2);
		break;
		case "2":
			$Gender = "F";
			$BirthDay = "19".substr($ResNo01,0,2)."-".substr($ResNo01,2,2)."-".substr($ResNo01,4,2);
		break;
		case "3":
			$Gender = "M";
			$BirthDay = "20".substr($ResNo01,0,2)."-".substr($ResNo01,2,2)."-".substr($ResNo01,4,2);
		break;
		case "4":
			$Gender = "F";
			$BirthDay = "20".substr($ResNo01,0,2)."-".substr($ResNo01,2,2)."-".substr($ResNo01,4,2);
		break;
		//외국인 등록번호
		case "5":
			$Gender = "M";
			$BirthDay = "19".substr($ResNo01,0,2)."-".substr($ResNo01,2,2)."-".substr($ResNo01,4,2);
		break;
		case "6":
			$Gender = "F";
			$BirthDay = "19".substr($ResNo01,0,2)."-".substr($ResNo01,2,2)."-".substr($ResNo01,4,2);
		break;
		case "7":
			$Gender = "M";
			$BirthDay = "20".substr($ResNo01,0,2)."-".substr($ResNo01,2,2)."-".substr($ResNo01,4,2);
		break;
		case "8":
			$Gender = "F";
			$BirthDay = "20".substr($ResNo01,0,2)."-".substr($ResNo01,2,2)."-".substr($ResNo01,4,2);
		break;
	}

}


$Sql_m = "SELECT * FROM Member WHERE ResNo=HEX(AES_ENCRYPT('$InputResNo','$DB_Enc_Key'))";
$Result_m = mysqli_query($connect, $Sql_m);
$Row_m = mysqli_fetch_array($Result_m);

if($Row_m) {
	$UserID = $Row_m['ID'];
}


if(!$UserID) { //현재 회원중에 주민번호가 일치하는 회원이 없는 경우 신규 회원으로 처리

	$UserID = $CompanyID.$ResNo01;

	//아이디가 중복된 아이디가 있는지 확인, 동일한 회사에 생년월일이 동일한 회원이 존재하는 경우
	$Sql = "SELECT COUNT(*) FROM Member WHERE ID='$UserID'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	$ID_Count = $Row[0];

	if($ID_Count>0) {

		for($i=1;$i<=50;$i++) { //회사 아이디+생년월일에서 뒤에 1부터 50까지 붙여 동일 아이디가 있는지 확인

			$UserID2 = $UserID.$i;

			$Sql = "SELECT COUNT(*) FROM Member WHERE ID='$UserID2'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$ID_Count2 = $Row[0];

			if($ID_Count2<1) { //동일한 아이디가 없으면 for문 중지
				break;
			}
		}

	$UserID = $UserID2;
	}

}




//동일한 회원여부 체크하기
$Sql = "SELECT COUNT(*) FROM Member WHERE ID='$UserID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$Member_count = $Row[0];

//회원가입 또는 정보수정 진행하기
/*
SELECT HEX(AES_ENCRYPT('비밀번호', '변환할 코드명')) 
SELECT AES_DECRYPT(UNHEX('필드명'), '변환할 코드명')
UPDATE Member SET ResNo=HEX(AES_ENCRYPT('0405050000001','el@2018!@#$')) WHERE ID='hotdog'
SELECT AES_DECRYPT(UNHEX(ResNo), 'el@2018!@#$') FROM Member
*/

$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";
$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";
$ResNo_enc = "HEX(AES_ENCRYPT('$InputResNo','$DB_Enc_Key'))";
$BirthDay_enc = "HEX(AES_ENCRYPT('$BirthDay','$DB_Enc_Key'))";
$Tel_enc = "HEX(AES_ENCRYPT('$Tel','$DB_Enc_Key'))";

if($Member_count>0)  {

	$Sql = "UPDATE Member SET 
				Name='$Name', 
				Pwd='$enc_pwd',
				ResNo=$ResNo_enc, 
				Email=$Email_enc, 
				Gender='$Gender',
				BirthDay=$BirthDay_enc,
				Mobile=$Mobile_enc, 
				CompanyCode='$CompanyCode', 
				Depart='$Depart', 
				EduManager='$EduManager', 
				Zipcode='-',
				trneeSe='$trneeSe',
				IrglbrSe='$IrglbrSe',
				PassChange='N'
				WHERE ID='$UserID'";

}else{

	$Sql = "INSERT INTO Member(ID, Pwd, Name, BirthDay, Gender, Email, Mobile, CompanyCode, Depart, Mailling, ACS, MemberOut, Sleep, UseYN, RegDate, EduManager, ResNo, Zipcode, trneeSe, IrglbrSe) 
			VALUES(
			'$UserID', '$enc_pwd', '$Name', $BirthDay_enc, '$Gender', $Email_enc, $Mobile_enc, '$CompanyCode', '$Depart', 'Y', 'Y', 'N', 'N', 'Y', NOW(), '$EduManager', $ResNo_enc, '-', '$trneeSe', '$IrglbrSe')";

}

$Row = mysqli_query($connect, $Sql);

if(!$Row) { //쿼리 실패시 에러카운터 증가
	$error_count++;
	$msg01 = "<BR>[회원]";
}



//수강등록 진행하기=========================================================================================================================

//교육과정 정보를 불러오기
$Sql = "SELECT Price, Price01, Price02, Price03, Price01View, Price02View, Price03View, PackageYN, PackageRef, PackageLectureCode, TotalPassMid, TotalPassTest, TotalPassReport FROM Course WHERE LectureCode='$LectureCode'";
//echo $Sql."<BR>";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$PriceB = $Row['Price']; //교육비용
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

	if(!$Price) {

		$Price = $PriceB;

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
				$rPrice = "0"; //환급액
				$rPrice2 = "0"; //자부담금
		}

		if($ServiceType == "3" || $ServiceType == "5" || $ServiceType == "9") { // 일반(비환급)
			$rPrice = "0";
			$rPrice2 = "0";
		}

	}else{
		$rPrice2 = $Price - $rPrice;
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
			$msg04 = "<br>[실행1]";
		}
	}

	$StudyKey = $LectureTerme_idx."_".$UserID;

	$Sql = "SELECT COUNT(*) FROM Study WHERE StudyKey='$StudyKey'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	$StudyKey_check = $Row[0];

	if($StudyKey_check>0) {
		$error_count++;
		$msg02 = "<BR>[중복]";
	}else{

		//강의 입력
		$max_Seq = max_number("Seq","Study");
		$Sql_Input = "INSERT INTO Study(Seq, LectureTerme_idx, LectureCode, ServiceType, Tutor, ID, CompanyCode, LectureStart, LectureEnd, LectureReStudy, 
							Progress, OpenChapter, StudyKey, MidStatus, TestStatus, ReportStatus, Price, rPrice, rPrice2, PackageRef, PackageLevel, InputID, InputDate, SalesID) 
							VALUES($max_Seq, $LectureTerme_idx, '$LectureCode', $ServiceType, '$Tutor', '$UserID', '$CompanyCode', '$LectureStart', '$LectureEnd', '$LectureReStudy', 
							$Progress, $OpenChapter, '$StudyKey', '$MidStatus', '$TestStatus', '$ReportStatus', $Price, $rPrice, $rPrice2, 0, 0, '$LoginAdminID', NOW(), '$SalesID')";
		$Row_Input = mysqli_query($connect, $Sql_Input);
		//echo $Sql_Input;

		if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
			$error_count++;
			$msg02 = "<BR>".$LectureCode;
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
			$Price01 = $Row_l['Price01']; ///자부담금 우선지원 환급비
			$Price02 = $Row_l['Price02']; ///자부담금 대규모 1000인 미만 환급비
			$Price03 = $Row_l['Price03']; ///자부담금 대규모 1000인 이상 환급비
			$Price01View = $Row_l['Price01View']; ///우선지원 환급비
			$Price02View = $Row_l['Price02View']; ///대규모 1000인 미만 환급비
			$Price03View = $Row_l['Price03View']; ///대규모 1000인 이상 환급비
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
				$msg04 = "<br>[실행2]";
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
				$rPrice = "0"; //환급액
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
			$msg04 = "<br>[실행3]";
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
								$Progress, $OpenChapter, '$StudyKey', '$MidStatus', '$TestStatus', '$ReportStatus', $Price, $rPrice, $rPrice2, $PackageRef, $Package_i, '$LoginAdminID', NOW(), '$SalesID', $PackageGroupNo)";
			$Row_Input = mysqli_query($connect, $Sql_Input);
			//echo $Sql_Input."<BR>";

			if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
				$error_count++;
				$msg03 = "<BR>".$LectureCode;
			}

		}

	$Package_i++;
	}
	//강의코드 루프 부분-------------------------------------------------------------------------------------------------------------------------

}
//패키지 강의인 경우 #################################################################################################


//수강등록 진행하기=========================================================================================================================

//수강등록 처리가 완료되면 엑셀 업로드 내역 삭제
if($error_count<1) {
	$Sql_d = "DELETE FROM StudyExcelTemp WHERE idx=$idx AND ID='$LoginAdminID'";
	mysqli_query($connect, $Sql_d);
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "<font color='red'>오류</font>".$msg01.$msg02.$msg03.$msg04;
	//$msg = "<font color='red'>오류</font>";
}else{
	mysqli_query($connect, "COMMIT");
	$msg = "<font color='blue'>등록</font>";
}

echo $msg;

mysqli_close($connect);
?>