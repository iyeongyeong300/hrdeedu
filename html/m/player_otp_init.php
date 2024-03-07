<script language='javascript'>
	window.name ="Parent_window";
	
	function fnPopup(){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk.target = "popupChk";
		document.form_chk.submit();
	}

</script>
<?
//휴대폰 인증관련 ##################################################################################
$sitecode = $CheckPlus_sitecode; // NICE로부터 부여받은 사이트 코드
$sitepasswd = $CheckPlus_sitepasswd; // NICE로부터 부여받은 사이트 패스워드

$cb_encode_path = $Auth_Mobile_path;

$authtype = "";      		// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드 (1가지만 사용 가능)

$popgubun 	= "N";		//Y : 취소버튼 있음 / N : 취소버튼 없음
$customize 	= "Mobile"; // 없으면 기본 웹페이지 / Mobile : 모바일페이지

$gender = "";      		// 없으면 기본 선택화면, 0: 여자, 1: 남자

$reqseq = $LectureCode."_".date('YmdHis');     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.

// CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
// 리턴url은 인증 전 인증페이지를 호출하기 전 url과 동일해야 합니다. ex) 인증 전 url : http://www.~ 리턴 url : http://www.~
$returnurl = $MobileSiteURL."/checkplus_success.php";	// 성공시 이동될 URL
$errorurl = $MobileSiteURL."/checkplus_fail.php";		// 실패시 이동될 URL
	
// reqseq값은 성공페이지로 갈 경우 검증을 위하여 세션에 담아둔다.

$_SESSION["REQ_SEQ"] = $reqseq;

// 입력될 plain 데이타를 만든다.
$plaindata = "7:REQ_SEQ" . strlen($reqseq) . ":" . $reqseq .
				 "8:SITECODE" . strlen($sitecode) . ":" . $sitecode .
				 "9:AUTH_TYPE" . strlen($authtype) . ":". $authtype .
				 "7:RTN_URL" . strlen($returnurl) . ":" . $returnurl .
				 "7:ERR_URL" . strlen($errorurl) . ":" . $errorurl .
				 "11:POPUP_GUBUN" . strlen($popgubun) . ":" . $popgubun .
				 "9:CUSTOMIZE" . strlen($customize) . ":" . $customize .
				 "6:GENDER" . strlen($gender) . ":" . $gender ;


$enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;

if( $enc_data == -1 )
{
	$returnMsg = "암/복호화 시스템 오류입니다.";
	$enc_data = "";
}
else if( $enc_data== -2 )
{
	$returnMsg = "암호화 처리 오류입니다.";
        $enc_data = "";
}
	else if( $enc_data== -3 )
	{
		$returnMsg = "암호화 데이터 오류 입니다.";
		$enc_data = "";
	}
	else if( $enc_data== -9 )
	{
		$returnMsg = "입력값 오류 입니다.";
		$enc_data = "";
	}

//echo $returnMsg;
//echo $enc_data; //업체정보 암호화 데이타
//휴대폰 인증관련 ##################################################################################
?>
<!-- 휴대폰 인증 파라메터 -->
<form name="form_chk" method="post">
	<input type="hidden" name="m" value="checkplusSerivce">						<!-- 필수 데이타로, 누락하시면 안됩니다. -->
	<input type="hidden" name="EncodeData" value="<?= $enc_data ?>">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
</form>
<div id="captcha_div" align="center">
	<table border="0">
		<tr align="center">
			<td colspan="2" class="fs24b fc999B pt30">OPT 초기화</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp</td>
		</tr>
		<tr>
			<td colspan="2" class="info" align="center">OPT 초기화를 위한 본인인증을 합니다.</td>
		</tr>
		<tr>
			<td colspan="2"><br><br><br></td>
		</tr>
		<tr>
			<td align="center">이름</td> 
			<td><?=$Name?></td>
		</tr>
		<tr>
			<td align="center">휴대폰</td> 
			<td><?=$Mobile?></td>
		</tr>
		<tr>
			<td colspan="2"><br><br>
		</tr>
		<tr>
			<td colspan="2" align="center"><button id="btnAuth" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:16px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:140px; height:55px; cursor:pointer" onclick="fnPopup();">인증 하기</button></td>
		</tr>
	</table>
</div>

<script type="text/javascript">
<!--
function CertCheckProc(m_trnDT) {

	var LectureCode = "<?=$LectureCode?>";
	var Study_Seq = "<?=$Study_Seq?>";

	var AGTID = "<?=$captcha_agent_id?>";
	var USRID = "<?=$LoginMemberID?>";
	var COURSE_AGENT_PK = "<?=$LectureCode?>";
	var CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";

	var m_Ret = "";       // 본인인증 결과 : T/F  (T:성공, F:실패). T에 해당하는 경우만 호출.
	var m_retCD = "";     // 인증서비스 공급자(나이스 등)의 인증결과 코드 값
	var m_trnID = "";     // 인증서비스 공급자가 부여한 인증거래 고유 아이디(일련번호)
	//var m_trnDT = "";     // 인증처리 일시 (YYYY-MM-DD HH24:MI:SS)

	m_Ret = "T";
	m_retCD = "000000";
	m_trnID = "<?=$reqseq?>";

	
	try {
		$.ajax({
			type : "POST",
			url  : "https://fds.hrdkorea.or.kr/fdsService/hrdOTP/JSP/clientService/regiPhoneAuthLog.jsp",
			crossDomain: true,
			data : {
				AGTID : AGTID,
				USRID : USRID,
				m_Ret : m_Ret,
				m_retCD : m_retCD,
				m_trnID : m_trnID,
				m_trnDT : m_trnDT
			},
			dataType : "xml",
			success : function(xml) {					
				if($(xml).find("RetVal").text() == "101") {
					alert("OTP 초기화가 성공적으로 이루어졌습니다.");
					location.href="lecture_view.php?Chapter_Number=<?=$Chapter_Number?>&LectureCode=<?=$LectureCode?>&Study_Seq=<?=$Study_Seq?>&Chapter_Seq=<?=$Chapter_Seq?>&Contents_idx=<?=$Contents_idx?>&mode=<?=$mode?>";
				} else {
					alert("OTP 초기화에 실패하였습니다.\r\n" + $(xml).find("RetMsg").text() + "\r\n" + $(xml).find("Remark").text());
				}					
			},
			error : function(xhr, textStatus, error) {
				alert("오류발생 : " + error);
			}
		});
	} catch(e) {
		alert("오류발생 : " + e.message);
	}

}


//-->
</script>