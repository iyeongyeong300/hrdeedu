<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

require_once ('../include/KISA_SHA256.php');

$MemberType = Replace_Check_XSS2($MemberType);
$ID = Replace_Check_XSS2($ID);
$Name = Replace_Check_XSS2($Name);
$Mobile01 = Replace_Check_XSS2($Mobile01);
$Mobile02 = Replace_Check_XSS2($Mobile02);
$Mobile03 = Replace_Check_XSS2($Mobile03);

$Mobile = $Mobile01."-".$Mobile02."-".$Mobile03;

$Mobile_enc = "HEX(AES_ENCRYPT('$Mobile','$DB_Enc_Key'))";

$Sql = "SELECT * FROM Member WHERE MemberType='$MemberType' AND ID='$ID' AND Name='$Name' AND Mobile=$Mobile_enc AND MemberOut='N' AND UseYN='Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	if($Row['Sleep']=="Y") {
		$msg = "현재 휴면계정 상태입니다.[휴면계정 복구] 메뉴를 통해 계정을 복구하세요.";
	}else{
		//임시 비밀번호 생성 및 변경
		$Temp_Pwd = Pwd_makeRand();
		$enc_pwd = encrypt_SHA256($Temp_Pwd); //비밀번호 암호화
		$Sql2 = "UPDATE Member SET Pwd='$enc_pwd', PassChange = 'N' WHERE ID='$ID' AND Name='$Name' AND Mobile=$Mobile_enc AND MemberOut='N' AND UseYN='Y'";
		mysqli_query($connect, $Sql2);

		//비밀번호 휴대폰으로 문자 발송 처리
		$msg_type = 'new_password';
		$msg_mobile = str_replace("-","",$Mobile);
		$StrTmpPwd = (string)$Temp_Pwd;
		$msg_var = $Name."|".$StrTmpPwd;
		$user_id = $ID;
		$input_id = $ID;

		$kakaotalk_result = kakaotalk_send3($msg_type,$msg_mobile,$msg_var,$user_id,$input_id);

		if($kakaotalk_result=="Y"){
			$msg = "등록된 휴대폰번호로 임시비밀번호를 전송하였습니다.";
		}else{
			$msg = "시스템 오류가 발생했습니다. 관리자에게 문의하세요.";
		}
		
	}

}else{
	$msg = "입력하신 정보로 일치하는 회원정보가 없습니다.";
}
?>
<!-- layer - PW -->
<div class="layerArea wid450">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">비밀번호 찾기</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<p class="fc777"><?=$msg?></p>
		<p class="btnAreaTc02"><span class="btnSmSky01"><a href="Javascript:DataResultClose();">확인</a></span></p>
	  <!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer - PW // -->
<?
mysqli_close($connect);
?>