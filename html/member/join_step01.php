<?
$HTML_TITLE = "이용약관 > 회원가입 > ";
include "../include/include_top.php";

//로그인 여부 체크
include "../include/login_not_check.php";
?>
        
        <!-- Container -->
        <div id="container">
        
        	<!-- page Title -->
        	<div class="titleZoneFull">
            	<!-- title -->
                <div class="titleZone">
                	<h2>회원가입</h2>
        		</div>
                <!-- title // -->
        	</div>
        	<!-- page Title // -->
<script language='javascript'>
	window.name ="Parent_window";
	
	function fnPopup(){

		if(JoinStep01()==true) {

			window.open('', 'popupChk', 'width=500, height=550, top=100, left=400, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
			document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
			document.form_chk.target = "popupChk";
			document.form_chk.submit();

		}

	}

	function fnPopup2(){

		JoinStep01();

		window.open('', 'popupIPIN2', 'width=450, height=550, top=100, left=400, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_ipin.target = "popupIPIN2";
		document.form_ipin.action = "https://cert.vno.co.kr/ipin.cb";
		document.form_ipin.submit();

	}
</script>
<?
//휴대폰 인증관련 ##################################################################################
$sitecode = $CheckPlus_sitecode; // NICE로부터 부여받은 사이트 코드
$sitepasswd = $CheckPlus_sitepasswd; // NICE로부터 부여받은 사이트 패스워드

$cb_encode_path = $Auth_Mobile_path;

$authtype = "";      		// 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드 (1가지만 사용 가능)

$popgubun 	= "N";		//Y : 취소버튼 있음 / N : 취소버튼 없음
$customize 	= "";		//없으면 기본 웹페이지 / Mobile : 모바일페이지 (default값은 빈값, 환경에 맞는 화면 제공)

$gender = "";      		// 없으면 기본 선택화면, 0: 여자, 1: 남자

//$reqseq = "REQ_0123456789";     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
$reqseq = session_id();
// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
//if (extension_loaded($module)) {// 동적으로 모듈 로드 했을경우
	//$reqseq = get_cprequest_no($sitecode);
//} else {
//	$reqseq = "Module get_request_no is not compiled into PHP";
//}

// CheckPlus(본인인증) 처리 후, 결과 데이타를 리턴 받기위해 다음예제와 같이 http부터 입력합니다.
// 리턴url은 인증 전 인증페이지를 호출하기 전 url과 동일해야 합니다. ex) 인증 전 url : http://www.~ 리턴 url : http://www.~
$returnurl = $SiteURL."/lib/CheckPlusSafe/checkplus_success_join.php";	// 성공시 이동될 URL
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
$sSitePw					= $IPIN_CheckPlus_sitepasswd;		// NICE평가정보에서 발급한 IPIN 서비스 사이트패스워드
$sModulePath			= $Auth_IPIN_path;			// 하단내용 참조
$sReturnURL				= $SiteURL."/lib/NiceIPIN/ipin_process_join.php";		// 하단내용 참조
$sCPRequest				= session_id();;			// 하단내용 참조

// CP요청번호 생성
// 실행방법은 싱글쿼터(`) 외에도, 'exec(), system(), shell_exec()' 등등 귀사 정책에 맞게 처리하시기 바랍니다. 
// 예) $sCPRequest = system("$sModulePath SEQ $sSiteCode");
$sCPRequest = `$sModulePath SEQ $sSiteCode`;
//$sCPRequest = shell_exec("$sModulePath SEQ $sSiteCode");
//echo "CP:".$sCPRequest."<BR><BR>";
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
	<input type="hidden" name="param_r1" value="">
	<input type="hidden" name="param_r2" value="">
	<input type="hidden" name="param_r3" value="">
</form>
<!-- IPIN 인증 파라메터 -->
			<!-- Content -->
            <div class="Content">
                
                <!-- content area -->
                <div class="contentMax">
                    
                    <!-- info area -->
					<form name="AgreeForm" method="POST" action="/member/join_step02.php">
					<input type="hidden" name="Name" id="Name" value="">
					<input type="hidden" name="BirthDay" id="BirthDay" value="">
					<input type="hidden" name="Gender" id="Gender" value="">
					<input type="hidden" name="Mobile" id="Mobile" value="">
                    <div class="conInfoMax">
                    	<!-- area -->
                        
                        <h3>약관동의 안내</h3>
                        <div class="join_policy">
                        	<p class="txt">
							<?=$SiteName?>에서는 원할한 교육 운영 및 한국산업인력공단 모니터링, 수강, 증명서 발급 등과 관련하여 귀하의 개인정보를 아래와 같이 수집 · 이용을 하고자 합니다.<br />
                        다음 사항에 대해 충분히 읽어보신 후, 동의 여부를 체크하여 주시기 바랍니다.</p>
                        	<p class="agree"><span class="inpCheck">
                        		<input type="checkbox" name="AllCheck" id="AllCheck" value="Y" onclick="JoinAgreeAllCheck();" />
                        		<label for="AllCheck">모든 이용약관 및 개인정보 수집·이용 내용에 동의합니다.</label>
                        		</span>
                        	</p>
                        </div>
                        
                        <h3 class="mt50">이용약관</h3>
                  		<div class="join_policy">
                        	<p><iframe src="agreement_i.php" scrolling="yes" width="100%" height="300px" frameborder="0"></iframe></p>
                      		<p class="agree">
								<span class="inpCheck">
                        		<input type="checkbox" name="Agree01_01" id="Agree01_01" value="Y" onclick="JoinAgree01Check('A');" />
                        		<label for="Agree01_01">동의합니다</label>
                        		</span>&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="inpCheck">
                        		<input type="checkbox" name="Agree01_02" id="Agree01_02" value="N" onclick="JoinAgree01Check('B');" />
                        		<label for="Agree01_02">동의하지 않습니다</label>
                        		</span>
                        	</p>
                    	</div>
                        
                        <h3 class="mt50">개인정보 수집 및 이용 동의</h3>
                        <div class="join_policy">
                        	<p><iframe src="privacy_i.php" scrolling="yes" width="100%" height="300px" frameborder="0"></iframe></p>
                            <p class="agree">
								<span class="inpCheck">
                        		<input type="checkbox" name="Agree03_01" id="Agree03_01" value="Y" onclick="JoinAgree03Check('A');" />
                  	    		<label for="Agree03_01">동의합니다</label>
                        		</span>&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="inpCheck">
                        		<input type="checkbox" name="Agree03_02" id="Agree03_02" value="N" onclick="JoinAgree03Check('B');" />
                  	    		<label for="Agree03_02">동의하지 않습니다</label>
                        		</span>
                        	</p>
                        </div>
                        
                        <h3 class="mt50">개인정보의 제3자 제공 동의</h3>
                        <div class="join_policy">
                        	<p><iframe src="privacy_i2.php" scrolling="yes" width="100%" height="240px" frameborder="0"></iframe></p>
                            <p class="agree">
								<span class="inpCheck">
                        		<input type="checkbox" name="Agree04_01" id="Agree04_01" value="Y" onclick="JoinAgree04Check('A');" />
                  	    		<label for="Agree04_01">동의합니다</label>
                        		</span>&nbsp;&nbsp;&nbsp;&nbsp;
								<span class="inpCheck">
                        		<input type="checkbox" name="Agree04_02" id="Agree04_02" value="N" onclick="JoinAgree04Check('B');" />
                  	    		<label for="Agree04_02">동의하지 않습니다</label>
                        		</span>
                        	</p>
                        </div>
                        
                        <h3 class="mt50">수강확인 문자발송</h3>
                        <div class="join_policy">
                        	<p class="txt">훈련생에게 SMS(문자) 등을 발송하여 훈련수강과 관련된 사실관계 확인을 통해 부정수급을 방지하고 설문조사를 진행하여 훈련품질을 향상하기 위한 한국산업인력공단의 모니터링 기능입니다.</p>
                            <p class="agree">
								<span class="inpCheck">
                        		<input type="checkbox" name="ACS" id="ACS" value="Y" />
                  				<label for="ACS">수강확인 문자발송 동의합니다.</label>
                        		</span>
                        	</p>
                        </div>
                        
                        <h3 class="mt50">마케팅 동의안내</h3>
                        <div class="join_policy">
                        	<p class="txt"><?=$SiteName?> 내 홍보 등 광고성 정보의 수신에 동의합니다.<br>(단, 교육과 관련된 필수 과정 정보, 주요 공지사항, 안내 등은 수신 동의 여부에 관계없이 자동 발송됩니다.)</p>
                            <p class="agree">
								<span class="inpCheck">
                        		<input type="checkbox" name="Marketing" id="Marketing" value="Y" />
                  				<label for="Marketing">마케팅 수신에 동의합니다.</label>
                        		</span>
                        	</p>
                        </div>
                        
                        <!-- btn -->
                        <div class="btnAreaTc04">
                        	<span class="btnSky01"><a href="Javascript:fnPopup();" class="wid180">휴대폰 인증</a></span>
                            <!--<span class="btnGray01"><a href="Javascript:fnPopup2();" class="wid180">아이핀 인증</a></span>-->
                        </div>
                        
                        <!-- area // -->
                    </div>
					</form>
                    <!-- info area // -->
                
                </div>
                <!-- content area -->
            
            </div>
            <!-- Content // -->
            
        </div>
        <!-- Container // -->
         
<?
include "../include/include_bottom.php";
?>
