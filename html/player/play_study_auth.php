<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
$mode = Replace_Check_XSS2($mode);

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
<script language='javascript'>
	window.name ="Parent_window";
	
	function fnPopup(){
		if ($('#agreeCaution').is(':checked') == false) {
			alert('유의사항 숙지 및 부정훈련 금지서약에 동의하셨다면 동의함에 체크해주세요. 미동의할 경우 강의를 수강하실 수 없습니다.');
			return false;
		}
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
	function fnPopup3(){
		window.open('', 'popupIPIN2', 'width=450, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_ipin.target = "popupIPIN2";
		document.form_ipin.action = "https://cert.vno.co.kr/ipin.cb";
		document.form_ipin.submit();
	}

		function fnPopupmotp(){
			if ($('#agreeCaution').is(':checked') == false) {
				alert('유의사항 숙지 및 부정훈련 금지서약에 동의하셨다면 동의함에 체크해주세요. 미동의할 경우 강의를 수강하실 수 없습니다.');
				return false;
			}
			var COURSE_AGENT_PK = "<?=$LectureCode?>";
			var CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";
			window.open('', 'popupMotp', 'width=552, height=962, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
			document.form_motp.target = "popupMotp";
			document.form_motp.action = "/player/motp.php?class_tme=<?=$Chapter_Number?>&EvalCd=<?=$EvalCd?>&COURSE_AGENT_PK=<?=$LectureCode?>&CLASS_AGENT_PK=<?=$LectureCode?>,<?=$LectureTerme_idx?>"
			document.form_motp.submit();	
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
$sSitePw					= $IPIN_CheckPlus_sitepasswd;		// NICE평가정보에서 발급한 IPIN 서비스 사이트패스워드
$sModulePath			= $Auth_IPIN_path;			// 하단내용 참조
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

<form name="form_motp" method="post" target="popupMotp" action="">&nbsp;&nbsp;</form>


<style>
	
	/*! CSS Used from: https://winner797.kr/css/userStyle.css?v=1665615838 */
input,button{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;}
button{cursor:pointer;}
button img,img{vertical-align:middle;}
span.red{color:#c73333!important;}
ul,li{list-style:none;}
.btnArea{text-align:center;margin:10px 0;}
.btnArea button{height:46px;margin:0 2px;padding:0 30px;border-radius:3px;background:#666;border:1px solid #ccc;line-height:24px;color:#fff;font-size:15px;font-weight:bold;vertical-align:middle;}
#screenModal{overflow-x:hidden;overflow-y:auto;position:fixed;top:0;left:0;width:100%;height:100%;background:#f2f6f7;z-index:999;}
#screenModal > div{width:1260px;margin:0 auto;border:1px solid #bfc3c4;background:#fff;}
#screenModal > div + div{margin-top:15px;}
#screenModal div.titleArea{overflow:hidden;width:100%;border-top:5px solid #0780c2;border-bottom:2px solid #2665ae;background:#fff;}
#screenModal div.titleArea > div{overflow:hidden;width:1260px;margin:20px auto;text-align:right;}
#screenModal div.titleArea > div > img,#screenModal div.titleArea > div > h1,#screenModal div.titleArea > div > h2{float:left;}
#screenModal div.titleArea > div > img{margin-right:20px;}
#screenModal div.titleArea > div > h1,#screenModal div.titleArea > div > h2{width:1020px;margin:0;padding:0;text-align:left;}
#screenModal div.titleArea > div > h1{margin:26px 0 8px;font-size:30px;color:#343434;}
#screenModal div.titleArea > div > h2{font-size:20px;color:#565656;}
#screenModal div.titleArea > div button{overflow:hidden;width:70px;height:70px;margin:27px 0;padding:0;border:none;background:none;}
#screenModal > div.caution{padding:45px 0;text-align:center;}
#screenModal > div.caution h1,#screenModal > div.caution strong{color:#3B74B6;}
#screenModal > div.caution h1{font-size:26px;}
#screenModal > div.caution p{margin:0 auto;line-height:22px;font-size:15px;padding:20px 80px;color:#000000;}
#screenModal > div.caution p + p{padding-top:25px;}
#screenModal > div.btnArea{overflow:hidden;border:none;background:none;padding:20px 0;margin-bottom:40px;text-align:center;}
#screenModal > div.btnArea button{overflow:hidden;height:54px;margin:0 2px;padding:0;border:none;background:none;vertical-align:middle;}
#screenModal > div.btnArea button img{margin-top:-54px;}
#screenModal > div.btnArea button:hover img{margin-top:0;}
#screenModal div.mobileCert span.red{display:inline-block;margin-left:96px;}
div.mobileCert > form{display:none;}
div.mobileCert ul,div.mobileCert li{overflow:hidden;margin:0;padding:0;list-style:none;}
div.mobileCert li{line-height:45px;padding:10px 20px;}
div.mobileCert li h1{display:inline-block;margin:0 20px 0 0;padding:0 20px 0 0;border-right:2px solid #ccc;font-size:15px;}
div.mobileCert li form{display:inline-block;}
div.mobileCert li button{height:45px;padding:0 60px;border:none;font-size:15px;color:#fff;background:#787878;font-weight:bold;}
div.mobileCert li button{padding:0 25px 0 60px;height:48px;border:none;background-position:20px center;background-repeat:no-repeat;background-color:#666;color:#fff;font-size:15px;font-weight:bold;}
div.mobileCert li button.btnPhone{background-image:url(https://winner797.kr/images/member/icon_phone.png);}
div.mobileCert li button.btnIpin{background-image:url(https://winner797.kr/images/member/icon_ipin.png);}
#screenModal div.titleArea > div > h2{width:1020px;margin:0;padding:0;text-align:left;}
</style>


<div id="screenModal" style="">
  <div class="titleArea">
    <div>
      <img src="/images/study/img_test01.png">
      <h1>학습자 유의사항</h1>
      <h2 class="contentsName">학습자 유의사항 및 본인인증</h2>
      <button type="button" onclick="studyModalClose();">
        <img src="/images/study/btn_modalclose.png">
      </button>
    </div>
  </div>
  <div class="caution">
    <img src="/images/study/img_notice_big.png">
    <h1>주의사항</h1>
    <p>본 인터넷 통신훈련과정은 고용보험법 제 27조 및 동법 시행령 제 41조의 2 규정에 의한 <br>사업주 직업능력 개발 훈련지원을 위한 훈련과정의 승인 및 비용지원 규정에 의하여 <br>한국산업인력공단으로부터 승인받은 훈련과정입니다. <br>
      <br> 사업주지원과정이란 사업주가 재직근로자에게 직무능력향상 및 인력양성을 위한 교육훈련비를 부담하는 경우 <br>직업능력개발훈련에 소요되는 비용을 사업주에게 지원하는 제도로서, <br>기업은 소속 임직원의 교육비를 결제하고 일부를 고용노동부로부터 환급 받는 제도입니다. <br> 따라서 귀하께서는 다음 사항에 유의하여 훈련(교육)에 임해 주시기 바랍니다.
    </p>
    <table width="1260px" style="border:5px solid #000000;">
      <tbody>
        <tr>
          <td>
            <h1>[수강 유의사항]</h1>
            <p>순차학습으로 진행되며, 1일 최대 <strong>8차시</strong>까지 학습이 가능합니다. <br>평가(중간/최종)와 과제는 <strong>1회만 응시</strong> 가능하며 <strong>(재응시 불가)</strong>, 최종평가는 응시 제한시간이 있습니다. <br>진도율(중간평가 50% 이상, 최종평가/과제 80% 이상)에 따라 응시 가능 여부가 달라집니다. <br>
              <br>
              <strong>모든 과정의 수료기준은 진도율 80% 이상, 총점 60점 이상</strong>이 되어야 하며, <br>
              <br>
              <strong>수료기준에 도달한 경우에만 고용 노동부로부터 훈련비용의 지원을 받을 수 있습니다.</strong>
            </p>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <br>
    <table width="1260px" style="border:5px solid #000000;">
      <tbody>
        <tr>
          <td>
            <h1>[부정훈련 금지서약]</h1>
            <p>1. 수강생은/는 타인에게 회원정보(ID, 비밀번호 등)을 알려주지 않으며, 다른사람이 본인을 대신하여 교육을 수강하는 일이 없을 것을 서약합니다. <br>2. 수강생은/는 다른사람이 본인을 대신하여 시험을 응시하거나, 다른 사람의 시험지 또는 시험답안을 표절하여 시험답안을 작성하지 않을 것을 서약합니다. <br>
            </p>
            <p style="color:#C73333; font-weight:900;">부정훈련(학습 및 평가등의 대리, 허위 작성 기타 부정한 방법)으로 수료하여 훈련비용의 지원을 받고자 하는 경우 교육이 미수료 처리가 되며, <br>고용노동부 관련규정에 따라 행정처분 대상이 될 수 있습니다. </p>
            <p></p>
          </td>
        </tr>
      </tbody>
    </table>
    <br>
    <br>
    <p>※ 유의사항 숙지 및 부정훈련 금지서약에 동의하셨다면 동의함에 체크해주세요. <br>미동의할 경우 강의를 수강하실 수 없습니다. </p>
    <br>
    <input type="checkbox" id="agreeCaution" style="width:25px;height:25px;">
    <label for="agreeCaution" style="color:#000000; font-size:15px;">동의합니다.</label>
    <!--<input type="checkbox" id="disagreeCaution" style="width:25px;height:25px;">
    <label for="disagreeCaution" style="color:#000000; font-size:15px;">동의하지 않습니다.</label>-->
  </div>
  <div class="mobileCert">
    <form class="certForm" action="javascript:agreeCert()">
      <input type="hidden" name="lectureStart" value="2022-10-12">
      <input type="hidden" name="certPass" value="">
      <input type="hidden" name="contentsCode" id="contentsCode" value="7Q4VLG">
      <input type="hidden" name="lectureOpenSeq" id="lectureOpenSeq" value="4920">
      <input type="hidden" name="resultCode" id="resultCode" value="">
    </form>
    <ul>
      <li class='tc'>
        <h1>본인인증</h1>
          <button type="button" onclick="fnPopup();" class="btnPhone mr5">휴대폰인증하기</button>
          <button type="button" onclick="fnPopupmotp();" class="btnPhone">MOTP인증하기</button>
  		<!--<br><span class="red">※ 타인 명의 휴대폰인 경우 공공아이핀을 발급 후 아이핀 인증으로 진행해 주시기 바랍니다. (아이핀/마이핀가입)</span>
        <form name="vnoform" method="post">
          <input type="hidden" name="enc_data">
          <input type="hidden" name="param_r1" value="">
          <input type="hidden" name="param_r2" value="">
          <input type="hidden" name="param_r3" value="">
        </form>-->
      </li>
    </ul>
  </div>
  <div class="mt10">
    <!--<button onclick="agreeCert(237929,'7Q4VLG',4920)">
      <img src="/images/member/btn_ok.png">
    </button>-->
  </div>
</div>

<!-- layer 본인인증 -->
<div class="layerArea wid570" style="display:none !important">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">본인인증</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li><span class="fcBlue01B">원격훈련과정은 입과 시점에 1회 본인인증이 의무화되어 있습니다.</span></li>
				<li>&lt;휴대폰 인증&gt;과 &lt;mOTP 인증&gt; 중 원하는 인증방법을 클릭하여 본인인증을 진행하기 바랍니다.</li>
				<li>휴대폰 인증은 본인명의의 휴대폰만 인증이 가능합니다.</li>
			</ul>
		</div>
		
		<div class="mycheck">
			<ul>
				<li><a href="Javascript:fnPopup();"><img src="/images/sub/support_mycheck_img02.png" alt="휴대폰 인증" /></a></li>
				<!--<li><a href="Javascript:fnPopup2();"><img src="/images/sub/support_mycheck_img03.png" class="아이핀(I-PIN) 인증" /></a></li>-->
				<li><a href="Javascript:fnPopupmotp();" style="font-size:30px;">MOTP 인증</a></li>
			</ul>
		</div>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer 본인인증 // -->

<script type="text/javascript">

function studyModalClose(){
	$('#screenModal,#SysBg_Black').hide();
}
<!--

function CertCheckProc(m_trnDT,motp) {

	LectureCode = "<?=$LectureCode?>";
	Study_Seq = "<?=$Study_Seq?>";
	Chapter_Seq = "<?=$Chapter_Seq?>";
	AGTID = "<?=$captcha_agent_id?>";
	USRID = "<?=$LoginMemberID?>";
	COURSE_AGENT_PK = "<?=$LectureCode?>";
	CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";

	m_Ret = "T";
	m_retCD = "000000";
	m_trnID = "<?=$reqseq?>";
	//m_trnDT = "2019-12-01 13:26:31";
	
		if(motp==true){

			//인증 처리 성공시 DB작업----------------------------------------------------------------
			$.post("/player/play_study_auth_insert.php",
			{ 'LectureCode': LectureCode,
				'Study_Seq': Study_Seq,
				'Chapter_Seq': Chapter_Seq,
				'CertType': 'user',
				'AGTID': AGTID,
				'COURSE_AGENT_PK': COURSE_AGENT_PK,
				'CLASS_AGENT_PK': CLASS_AGENT_PK,
				'm_Ret': m_Ret,
				'm_retCD': m_retCD,
				'm_trnID': m_trnID,
				'm_trnDT': m_trnDT
			},function(data){
				
				if(data=="Y") {
					alert("본인 인증처리가 완료되었습니다.");
					DataResultClose();
					Play('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$mode?>');
				}else{
					alert("본인 인증처리에 실패하였습니다.\n\n다시 시도하여 주세요.");
					//top.location.reload();
				}

			});

			return false;
	}


	try {
		$.ajax({
			type : "POST",
			url  : "https://emon.hrdkorea.or.kr/EAIServer/SOURCE/ExConn/LMS/pAuthLog.jsp",
			crossDomain: true,
			data : {
				AGTID : AGTID,
				USRID : USRID,
				COURSE_AGENT_PK : COURSE_AGENT_PK,
				CLASS_AGENT_PK : CLASS_AGENT_PK,
				m_Ret : m_Ret,
				m_retCD : m_retCD,
				m_trnID : m_trnID,
				m_trnDT : m_trnDT
			},
			dataType : "xml",
			success : function(xml) { 

				if($(xml).find("RetVal").text() == "101") {

					//alert("성공");
					//인증 처리 성공시 DB작업----------------------------------------------------------------
					$.post("/player/play_study_auth_insert.php",
					{ 'LectureCode': LectureCode,
						'Study_Seq': Study_Seq,
						'Chapter_Seq': Chapter_Seq,
						'CertType': 'user',
						'AGTID': AGTID,
						'COURSE_AGENT_PK': COURSE_AGENT_PK,
						'CLASS_AGENT_PK': CLASS_AGENT_PK,
						'm_Ret': m_Ret,
						'm_retCD': m_retCD,
						'm_trnID': m_trnID,
						'm_trnDT': m_trnDT
					},function(data){

						if(data=="Y") {
							alert("본인 인증처리가 완료되었습니다.");
							DataResultClose();
							Play('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$mode?>');
						}else{
							alert("본인 인증처리에 실패하였습니다.\n\n다시 시도하여 주세요.");
							//top.location.reload();
						}

					});
					
					//인증 처리 성공시 DB작업----------------------------------------------------------------

				}else{
					//alert($(xml).find("Remark").text());
					alert("본인 인증처리중 문제가 발생했습니다.");
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

<?
mysqli_close($connect);
?>