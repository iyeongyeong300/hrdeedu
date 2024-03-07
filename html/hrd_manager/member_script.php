<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

require_once ('../include/KISA_SHA256.php');

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

//필수 입력 사항
$MemberType = Replace_Check($MemberType); //회원구분
$ACS = Replace_Check($ACS); //수강확인 문자발송
$Marketing = Replace_Check($Marketing); //마케팅 수신동의
$ID = Replace_Check($ID); //ID
$Pwd = Replace_Check($Pwd); //비밀번호
$Name = Replace_Check($Name); //이름
$Gender = Replace_Check($Gender); //성별
$Email = Replace_Check($Email); //이메일
$Tel01 = Replace_Check($Tel01); //전화1
$Tel02 = Replace_Check($Tel02); //전화2
$Tel03 = Replace_Check($Tel03); //전화3
$Mobile01 = Replace_Check($Mobile01); //휴대폰1
$Mobile02 = Replace_Check($Mobile02); //휴대폰2
$Mobile03 = Replace_Check($Mobile03); //휴대폰3
$Zipcode = Replace_Check($Zipcode); //우편번호
$Address01 = Replace_Check($Address01); //주소
$Address02 = Replace_Check($Address02); //나머지 주소

//선택 입력 사항
$NameEng = Replace_Check($NameEng); //영문이름
$Depart = Replace_Check($Depart); //부서
$Position = Replace_Check($Position); //직위
$CompanyCode = Replace_Check($CompanyCode); //기업 사업자번호
$Etc01 = Replace_Check($Etc01); //관심분야
$Etc02 = Replace_Check($Etc02); //가입경로
$Mailling = Replace_Check($Mailling); //메일링서비스
$EduManager = Replace_Check($EduManager); //교육담당자 여부
$UseYN = Replace_Check($UseYN); //계정 사용 여부

$ProtectID = Replace_Check($ProtectID); //대리수강 방지

$ResNo = Replace_Check($ResNo); //주민번호

$CardName = Replace_Check($CardName); //내일배움카드사
$CardNumber01 = Replace_Check($CardNumber01); //내일배움카드번호
$CardNumber02 = Replace_Check($CardNumber02);
$CardNumber03 = Replace_Check($CardNumber03);
$CardNumber04 = Replace_Check($CardNumber04);

$Tel = $Tel01."-".$Tel02."-".$Tel03;
$Mobile = $Mobile01."-".$Mobile02."-".$Mobile03;

$CardNumber = $CardNumber01."-".$CardNumber02."-".$CardNumber03."-".$CardNumber04;

if(!$Mailling) {
	$Mailling = "N";
}
if(!$ACS) {
	$ACS = "N";
}
if(!$EduManager) {
	$EduManager = "N";
}
if(!$ResNo) {
	$ResNo = "";
}
if(!$ProtectID) {
	$ProtectID = "N";
}
if(!$Marketing) {
	$Marketing = "N";
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


$col = Replace_Check($col);
$sw = Replace_Check($sw);

$cmd = false;


if($mode=="new") { //신규 등록 ---------------------------------------------------------------------------------------------------------


	//아이디 중복체크
	$Sql = "SELECT * FROM Member WHERE ID='$ID'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
	?>
	<script type="text/javascript">
	<!--
		alert("동일한 아이디가 존재합니다.");
		top.$("#SubmitBtn").show();
		top.$("#Waiting").hide();
	//-->
	</script>
	<?
	exit;
	}


	//주민번호 중복체크
	if($ResNo) {

		$Sql = "SELECT COUNT(idx) FROM Member WHERE ResNo=HEX(AES_ENCRYPT('$InputResNo','$DB_Enc_Key'))";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);
		$ResNo_count = $Row[0];

		if($ResNo_count>0) {
		?>
		<script type="text/javascript">
		<!--
			alert("동일한 주민번호가 존재합니다.");
			top.$("#SubmitBtn").show();
			top.$("#Waiting").hide();
		//-->
		</script>
		<?
		exit;
		}

	}


	$MemberOut = "N"; //탈퇴여부
	$Sleep = "N"; //휴면계정여부
	$enc_pwd = encrypt_SHA256($Pwd); //비밀번호 암호화

	$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";
	$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";
	$ResNo_enc = "HEX(AES_ENCRYPT('$InputResNo','$DB_Enc_Key'))";
	$BirthDay_enc = "HEX(AES_ENCRYPT('$BirthDay','$DB_Enc_Key'))";
	$Tel_enc = "HEX(AES_ENCRYPT('$Tel','$DB_Enc_Key'))";

	$Sql = "INSERT INTO Member(MemberType, ID, Pwd, Name, BirthDay, Gender, Email, Tel, Mobile, Zipcode, Address01, Address02, 
			NameEng, CompanyCode, Depart, Position, Etc01, Etc02, Mailling, ACS, Marketing, MemberOut, Sleep, UseYN, RegDate, EduManager, ResNo, ProtectID) 
			VALUES(
			'$MemberType', '$ID', '$enc_pwd', '$Name', $BirthDay_enc, '$Gender', $Email_enc, $Tel_enc, $Mobile_enc, '$Zipcode', '$Address01', '$Address02', 
			'$NameEng', '$CompanyCode', '$Depart', '$Position', '$Etc01', '$Etc02', '$Mailling', '$ACS', '$Marketing', '$MemberOut', '$Sleep', '$UseYN', NOW(), '$EduManager', $ResNo_enc, '$ProtectID')";
	//echo $Sql;
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "member.php";

} //신규 등록-------------------------------------------------------------------------------------------------------------------------


if($mode=="edit") { //수정---------------------------------------------------------------------------------------------------------

	//주민번호 중복체크
	if($ResNo) {

		$Sql = "SELECT COUNT(idx) FROM Member WHERE ResNo=HEX(AES_ENCRYPT('$InputResNo','$DB_Enc_Key')) AND idx != $idx";
		$Result = mysqli_query($connect, $Sql);
		$Row = mysqli_fetch_array($Result);
		$ResNo_count = $Row[0];

		if($ResNo_count>0) {
		?>
		<script type="text/javascript">
		<!--
			alert("동일한 주민번호가 존재합니다.");
			top.$("#SubmitBtn").show();
			top.$("#Waiting").hide();
		//-->
		</script>
		<?
		exit;
		}

	}

	$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";
	$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";
	$ResNo_enc = "HEX(AES_ENCRYPT('$InputResNo','$DB_Enc_Key'))";
	$BirthDay_enc = "HEX(AES_ENCRYPT('$BirthDay','$DB_Enc_Key'))";
	$Tel_enc = "HEX(AES_ENCRYPT('$Tel','$DB_Enc_Key'))";

	$Sql = "UPDATE Member SET 
			MemberType='$MemberType', 
			Name='$Name', 
			Gender='$Gender',
			BirthDay=$BirthDay_enc,
			Email=$Email_enc, 
			Tel=$Tel_enc, 
			Mobile=$Mobile_enc, 
			Zipcode='$Zipcode', 
			Address01='$Address01', 
			Address02='$Address02', 
			NameEng='$NameEng', 
			CompanyCode='$CompanyCode', 
			Depart='$Depart', 
			Position='$Position', 
			Etc01='$Etc01', 
			Etc02='$Etc02', 
			Mailling='$Mailling', 
			ACS='$ACS', 
			Marketing='$Marketing', 
			EduManager='$EduManager', 
			ResNo=$ResNo_enc, 
			ProtectID='$ProtectID', 
			CardName='$CardName', 
			CardNumber='$CardNumber', 
			UseYN='$UseYN' 
			WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "member_read.php?idx=".$idx;

} //수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="pcd") { //비밀번호 초기화 ---------------------------------------------------------------------------------------------------------

	$enc_pwd = encrypt_SHA256('1111'); //비밀번호 암호화
	$Sql = "UPDATE Member SET Pwd='$enc_pwd', PassChange='N' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "member_read.php?idx=".$idx;

} //비밀번호 초기화-------------------------------------------------------------------------------------------------------------------------


if($mode=="out") { //탈퇴처리 ---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Member SET MemberOut='Y', MemberOutDate=NOW() WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "member.php?idx=".$idx;

} //탈퇴처리-------------------------------------------------------------------------------------------------------------------------


if($mode=="useYn") { //미사용처리 ---------------------------------------------------------------------------------------------------------
	
	$NewUseYN = "N";
	if($UseYN == "N"){
		$NewUseYN = "Y";
	}
	
	$Sql = "UPDATE Member SET UseYN='$NewUseYN' WHERE idx=$idx";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "member_read.php?idx=".$idx;

} //미사용처리-------------------------------------------------------------------------------------------------------------------------



if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
//-->
</SCRIPT>