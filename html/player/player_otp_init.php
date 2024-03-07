<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
$mode = Replace_Check_XSS2($mode);
$TestType = Replace_Check_XSS2($TestType);

$Sql = "SELECT * FROM Study WHERE LectureCode='$LectureCode' AND Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$ServiceType = $Row['ServiceType'];
	$OpenChapter = $Row['OpenChapter'];
	$LectureTerme_idx = $Row['LectureTerme_idx'];

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META http-equiv="Expires" content="-1"> 
<META http-equiv="Pragma" content="no-cache"> 
<META http-equiv="Cache-Control" content="No-Cache"> 
<META http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
<script language='javascript'>
	window.name ="Parent_window";
	
	function fnPopup(){
		window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
		document.form_chk.target = "popupChk";
		document.form_chk.submit();
	}

	function fnPopup2(){
		window.open('', 'popupIPIN2', 'width=450, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_ipin.target = "popupIPIN2";
		document.form_ipin.action = "https://cert.vno.co.kr/ipin.cb";
		document.form_ipin.submit();
	}
</script>
</head>
<body>
<?
include "../include/login_check_pop.php";
?>
<div id="wrap">

<?
//휴대폰 인증관련 ##################################################################################
$sitecode = $CheckPlus_sitecode; // NICE로부터 부여받은 사이트 코드
$sitepasswd = $CheckPlus_sitepasswd; // NICE로부터 부여받은 사이트 패스워드

//$cb_encode_path = "/home/LMS/HRD/lib/CheckPlusSafe/CPClient";
// Brad (2021.11.24) : 오류 경로 수정
$cb_encode_path = "/home/LMS/public_html/lib/CheckPlusSafe/64bit/CPClient_64bit";

$authtype = "";      		// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드 (1가지만 사용 가능)

$popgubun 	= "N";		//Y : 취소버튼 있음 / N : 취소버튼 없음
$customize 	= "";		//없으면 기본 웹페이지 / Mobile : 모바일페이지 (default값은 빈값, 환경에 맞는 화면 제공)

$gender = "";      		// 없으면 기본 선택화면, 0: 여자, 1: 남자

//$reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
$reqseq = $LectureCode."_".date('YmdHis');
// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
//if (extension_loaded($module)) {// 동적으로 모듈 로드 했을경우
	//$reqseq = get_cprequest_no($sitecode);
//} else {
//	$reqseq = "Module get_request_no is not compiled into PHP";
//}

// CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
// 리턴url은 인증 전 인증페이지를 호출하기 전 url과 동일해야 합니다. ex) 인증 전 url : http://www.~ 리턴 url : http://www.~
$returnurl = $SiteURL."/lib/CheckPlusSafe/checkplus_success_otp.php";	// 성공시 이동될 URL
$errorurl = $SiteURL."/lib/CheckPlusSafe/checkplus_fail.php";		// 실패시 이동될 URL
	
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

//IPIN 인증관련 ##################################################################################
$sSiteCode				= $IPIN_CheckPlus_sitecode;			// NICE평가정보에서 발급한 IPIN 서비스 사이트코드
$sSitePw				= $IPIN_CheckPlus_sitepasswd;		// NICE평가정보에서 발급한 IPIN 서비스 사이트패스워드
// Brad (2021.11.24) : 오류 경로 수정
$sModulePath			= "/home/LMS/public_html/lib/NiceIPIN/64bit/IPIN2Client";			// 하단내용 참조
$sReturnURL				= $SiteURL."/lib/NiceIPIN/ipin_process_otp.php";		// 하단내용 참조
$sCPRequest				= session_id();			// 하단내용 참조

// CP요청번호 생성
// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다. 
// 예) $sCPRequest = system("$sModulePath SEQ $sSiteCode");
//$sCPRequest = `$sModulePath SEQ $sSiteCode`;
$sCPRequest = $LectureCode."_".date('YmdHis');

// CP요청번호 세션에 저장 
// 저장된 값은 ipin_result.php 페이지에서 데이타 위변조 검사에 이용됩니다.
$_SESSION['CPREQUEST'] = $sCPRequest;

$sEncData					= "";			// 암호화 된 데이타
$sRtnMsg					= "";			// 처리결과 메세지

// 암호화 데이타 생성
// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다.
// 예) $sEncData	= system("$sModulePath REQ $sSiteCode $sSitePw $sCPRequest $sReturnURL");
$sEncData	= `$sModulePath REQ $sSiteCode $sSitePw $sCPRequest $sReturnURL`;

// 리턴 결과값에 따른 처리사항
if ($sEncData == -9)
{
	$sRtnMsg = "입력값 오류 : 암호화 처리시, 필요한 파라미터값의 정보를 정확하게 입력해 주시기 바랍니다.";
} else {
	$sRtnMsg = "$sEncData 변수에 암호화 데이타가 확인되면 정상, 정상이 아닌 경우 리턴코드 확인 후 NICE평가정보 개발 담당자에게 문의해 주세요.";
}
//echo "값:".$sEncData;
//IPIN 인증관련 ##################################################################################
?>
<!-- 휴대폰 인증 파라메터 -->
<form name="form_chk" method="post">
	<input type="hidden" name="m" value="checkplusSerivce">						<!-- 필수 데이타로, 누락하시면 안됩니다. -->
	<input type="hidden" name="EncodeData" value="<?= $enc_data ?>">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->
</form>
<!-- 휴대폰 인증 파라메터 -->
<!-- IPIN 인증 파라메터 -->
<form name="form_ipin" method="post">
	<input type="hidden" name="m" value="pubmain">						<!-- 필수 데이타로, 누락하시면 안됩니다. -->
	<input type="hidden" name="enc_data" value="<?= $sEncData ?>">		<!-- 위에서 업체정보를 암호화 한 데이타입니다. -->

<!-- 업체에서 응답받기 원하는 데이타를 설정하기 위해 사용할 수 있으며, 인증결과 응답시 해당 값을 그대로 송신합니다.
해당 파라미터는 추가하실 수 없습니다. -->
	<input type="hidden" name="param_r1" value="<?=$LectureCode?>">
	<input type="hidden" name="param_r2" value="">
	<input type="hidden" name="param_r3" value="">
</form>
<!-- IPIN 인증 파라메터 -->


<!-- layer 본인인증 -->
<div class="layerArea wid570">
	<!-- close -->
	
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li><span class="fcBlue01B">본인인증을 통해 OTP를 초기화 합니다.</span></li>
				<li>&lt;휴대폰 인증&gt;과 &lt;아이핀(I-PIN)인증&gt; 중 원하는 인증방법을 클릭하여 본인인증을 진행하기 바랍니다.</li>
				<li>휴대폰 인증은 본인명의의 휴대폰만 인증이 가능합니다.</li>
			</ul>
		</div>
		
		<div class="mycheck">
			<ul>
				<li><a href="Javascript:fnPopup();"><img src="/images/sub/support_mycheck_img02.png" alt="휴대폰 인증" /></a></li>
				<li><a href="Javascript:fnPopup2();"><img src="/images/sub/support_mycheck_img03.png" class="아이핀(I-PIN) 인증" /></a></li>
			</ul>
		</div>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer 본인인증 // -->

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
					<?if($TestType) {?>
					location.href="/player/player_otp_captcha_exam.php?LectureCode=<?=$LectureCode?>&Study_Seq=<?=$Study_Seq?>&Chapter_Seq=<?=$Chapter_Seq?>&TestType=<?=$TestType?>";
					<?}else{?>
					location.href="/player/player_otp_captcha.php?Chapter_Number=<?=$Chapter_Number?>&LectureCode=<?=$LectureCode?>&Study_Seq=<?=$Study_Seq?>&Chapter_Seq=<?=$Chapter_Seq?>&Contents_idx=<?=$Contents_idx?>&mode=<?=$mode?>";
					<?}?>

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

</body>
</html>
<?
mysqli_close($connect);
?>