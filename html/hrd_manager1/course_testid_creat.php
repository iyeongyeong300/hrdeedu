<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

require_once ('../include/KISA_SHA256.php');

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$LectureCode = Replace_Check($LectureCode);
$CreatCount = Replace_Check($CreatCount);

$error_count = 0;


for($i=0;$i<$CreatCount;$i++) {

	//기존에 eledu00001 형식으로 되어 있는 아이디가 있는지 확인
	$Sql = "SELECT MAX(RIGHT(ID,5)) FROM Member WHERE ID LIKE 'ekedu_____'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	$MAX_ID = $Row[0];

	if($MAX_ID) {
		$ID_Num = (int)$MAX_ID + 1;
		$UserID = "ekedu".str_pad($ID_Num , 5, '0', STR_PAD_LEFT);
		$MobileLast = str_pad($ID_Num , 4, '0', STR_PAD_LEFT);
	}else{
		$UserID = "ekedu00001";
		$MobileLast = "0001";
	}

	//회원가입 처리하기
	$Pwd = "1111";
	$enc_pwd = encrypt_SHA256($Pwd); //비밀번호 암호화
	$Name = "테스트";
	$BirthDay = "2000-01-01";
	$Gender = "M";
	$Email = "test@ek3434.com";
	$Tel = "1644-3434";
	$Mobile = "010-0000-".$MobileLast;
	$Zipcode = "08501";
	$Address01 = "서울시 금천구 가산디지털1로 219";
	$Address02 = "벽산디지털밸리 6차 303~6호";
	$NameEng = "";
	$CompanyCode = "1061283641";
	$Depart = "";
	$Position = "";
	$Etc01 = "";
	$Etc02 = "";
	$Mailling = "N";
	$ACS = "N";
	$MemberOut = "N";
	$Sleep = "N";
	$UseYN = "Y";
	$EduManager = "N";
	$ResNo = "0000000000000";
	$tok2ID = "";
	$TestLectureCode = $LectureCode;
	$TestID = "Y";
	$ProtectID = "N";

	$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";
	$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";
	$ResNo_enc = "HEX(AES_ENCRYPT('$ResNo','$DB_Enc_Key'))";
	$BirthDay_enc = "HEX(AES_ENCRYPT('$BirthDay','$DB_Enc_Key'))";
	$Tel_enc = "HEX(AES_ENCRYPT('$Tel','$DB_Enc_Key'))";

	$Sql_m = "INSERT INTO Member(ID, Pwd, Name, BirthDay, Gender, Email, Tel, Mobile, Zipcode, Address01, Address02, 
			NameEng, CompanyCode, Depart, Position, Etc01, Etc02, Mailling, ACS, MemberOut, Sleep, UseYN, RegDate, EduManager, ResNo, TestLectureCode, TestID, ProtectID) 
			VALUES(
			'$UserID', '$enc_pwd', '$Name', $BirthDay_enc, '$Gender', $Email_enc, $Tel_enc, $Mobile_enc, '$Zipcode', '$Address01', '$Address02', 
			'$NameEng', '$CompanyCode', '$Depart', '$Position', '$Etc01', '$Etc02', '$Mailling', '$ACS', '$MemberOut', '$Sleep', '$UseYN', NOW(), '$EduManager', $ResNo_enc, '$TestLectureCode', '$TestID', '$ProtectID')";
	$Row_m = mysqli_query($connect, $Sql_m);

	if(!$Row_m) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$msg01 = "[아이디 생성]";
	}

	//echo $Sql_m."<BR><BR>";

	//강의 넣어주기 
	$LectureStart = date("Y-m-d");
	$indate_str1 = strtotime($LectureStart."3 month");
	$indate_str2 = strtotime($LectureStart."5 month");
	$LectureEnd = date("Y-m-d",$indate_str1);
	$LectureReStudy = date("Y-m-d",$indate_str2);

	$ServiceType = 9;
	$OpenChapter = 1;

	//수강 차수 구하기
	$Sql = "SELECT idx FROM LectureTerme WHERE LectureCode='$LectureCode' AND LectureStart='$LectureStart' AND LectureEnd='$LectureEnd' AND ServiceType=$ServiceType AND OpenChapter=$OpenChapter";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {//동일한 수강차수가 있다면
		$LectureTerme_idx = $Row['idx'];
	}else{ //수강차수가 없다면 신규 등록
		$LectureTerme_idx = max_number("idx","LectureTerme");
		$Sql_L = "INSERT INTO LectureTerme(idx, LectureCode, LectureStart, LectureEnd, ServiceType, OpenChapter) VALUES($LectureTerme_idx, '$LectureCode', '$LectureStart', '$LectureEnd', $ServiceType, $OpenChapter)";
		$Row_L = mysqli_query($connect, $Sql_L);

		if(!$Row_L) { //쿼리 실패시 에러카운터 증가
			$error_count++;
			$msg02 = "[차시 생성]";
		}
	}

	$StudyKey = $LectureTerme_idx."_".$UserID;
	$Tutor = "tutor";
	$Progress = 100;
	$MidStatus = "N";
	$TestStatus = "N";
	$ReportStatus = "N";
	$Price = 0;
	$rPrice = 0;

	//강의 입력
	$max_Seq = max_number("Seq","Study");
	$Sql_Input = "INSERT INTO Study(Seq, LectureTerme_idx, LectureCode, ServiceType, Tutor, ID, CompanyCode, LectureStart, LectureEnd, LectureReStudy, 
						Progress, OpenChapter, StudyKey, MidStatus, TestStatus, ReportStatus, Price, rPrice, PackageRef, PackageLevel, InputID, InputDate, SalesID) 
						VALUES($max_Seq, $LectureTerme_idx, '$LectureCode', $ServiceType, '$Tutor', '$UserID', '$CompanyCode', '$LectureStart', '$LectureEnd', '$LectureReStudy', 
						$Progress, $OpenChapter, '$StudyKey', '$MidStatus', '$TestStatus', '$ReportStatus', $Price, $rPrice, 0, 0, '$LoginAdminID', NOW(), '$LoginAdminID')";
	$Row_Input = mysqli_query($connect, $Sql_Input);

	if(!$Row_Input) { //쿼리 실패시 에러카운터 증가
		$error_count++;
		$msg03 = "[수강 등록]";
	}

	//강의의 차시 수강률 100%로 처리#################################################################################
	$SQL_c = "SELECT a.Seq AS Chapter_Seq, a.ChapterType, a.OrderByNum, a.Sub_idx, 
					b.Gubun AS ContentGubun, b.ContentsTitle, b.idx AS Contents_idx, 
					c.Progress AS ChapterProgress, c.UserIP AS ChapterUserIP, c.RegDate AS ChapterRegDate, 
					(SELECT Seq FROM ContentsDetail WHERE Contents_idx=b.idx AND UseYN='Y' ORDER BY OrderByNum ASC, Seq ASC LIMIT 0,1) AS ContentsDetail_Seq, 
					(SELECT ContentsURL FROM ContentsDetail WHERE Contents_idx=b.idx AND UseYN='Y' ORDER BY OrderByNum ASC, Seq ASC LIMIT 0,1) AS ContentsURL
					FROM Chapter AS a 
					LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx 
					LEFT OUTER JOIN Progress AS c ON a.Seq=c.Chapter_Seq AND b.idx=c.Contents_idx AND c.ID='$UserID' AND c.LectureCode='$LectureCode' AND c.Study_Seq=$max_Seq 
					WHERE a.LectureCode='$LectureCode' AND a.ChapterType='A' ORDER BY a.OrderByNum ASC";
	//echo $SQL_c;
	$Chapter_Number = 1;
	$QUERY_c = mysqli_query($connect, $SQL_c);
	if($QUERY_c && mysqli_num_rows($QUERY_c))
	{
		while($ROW_c = mysqli_fetch_array($QUERY_c))
		{

			$Chapter_Seq = $ROW_c['Chapter_Seq'];
			$Contents_idx = $ROW_c['Contents_idx'];
			$ContentsDetail_Seq = $ROW_c['ContentsDetail_Seq'];
			$ContentsURL = $ROW_c['ContentsURL'];
			$ChapterProgress = 100;
			$ProgressTime = 1800;
			$TriggerYN = "N";

			$Sql_c2 = "INSERT INTO Progress(ID, LectureCode, Study_Seq, Chapter_Seq, Contents_idx, ContentsDetail_Seq, LastStudy, Progress, StudyTime, UserIP, RegDate, TriggerYN, Chapter_Number) VALUES('$UserID', '$LectureCode', $max_Seq, $Chapter_Seq, $Contents_idx, $ContentsDetail_Seq, '$ContentsURL', $ChapterProgress, $ProgressTime, '$UserIP', NOW(), '$TriggerYN', '$Chapter_Number')";
			$Row_c = mysqli_query($connect, $Sql_c2);

			if(!$Row_c) { //쿼리 실패시 에러카운터 증가
				$error_count++;
				$msg04 = "[수강 내역]";
			}

		$Chapter_Number++;
		}
	}
	//강의의 차시 수강률 100%로 처리#################################################################################



}



if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "처리중 ".$error_count."건의 DB에러가 발생하였습니다. 롤백 처리하였습니다. 데이터를 확인하세요.".$msg01.$msg02.$msg03.$msg04.$Sql_c2;
}else{
	mysqli_query($connect, "COMMIT");
	$msg = "테스트 아이디가 생성되었습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript">
<!--
	alert("<?=$msg?>");
	top.location.reload();
//-->
</script>