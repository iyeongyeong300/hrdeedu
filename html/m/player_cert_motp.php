<?php
//error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );
//ini_set("display_errors", 1);

//본인 인증한 휴대폰 번호가 회원정보와 일치하는지 확인
$Sql = "SELECT Name, BirthDay, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Member WHERE ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

$UserMobile = $Row["Mobile"];
$UserName = $Row["Name"];
$UserBirthDay = $Row["BirthDay"];

$UserMobile = str_replace("-","",$UserMobile); //회원정보의 휴대폰 번호

$arrEvalType = array("00" => "입과", "01" => "진도", "02" => "시험", "03" => "과제", "04" => "진행평가", "00" => "입과", "99" => "기타");
$evalCd = "01";
$evalType = $arrEvalType[$evalCd];

$Chapter_NumberZero = strlen($Chapter_Number) == 1 ? "0".$Chapter_Number:$Chapter_Number;


//현재 과정 본인 인증 횟수
$MobileAuth_Arr= mysqli_fetch_array(mysqli_query($connect, "SELECT COUNT(*) as cnt FROM UserCertOTP WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq"));
$MobileAuth_count = $MobileAuth_Arr[cnt];

if($MobileAuth_count<1 && ($ServiceType==1 || $ServiceType==4)) { //과정 인증내역이 없으면 본인인증 필요 (과정당 1회만 인증)
	$evalCd = "00";
	$evalType = $arrEvalType[$evalCd];
}
?>
<script type="text/javascript" src="https://fds.hrdkorea.or.kr/fdsService/hrdAPI/hrdFrameLoader.js"></script>
<script>
function fn_otpAccredit() {
	var name= "<?php echo $UserName; ?>";
	var tel = "<?php echo $UserMobile; ?>";
	var otp = $("#otpNo").val();

	var LectureCode = "<?=$LectureCode?>";
	var Study_Seq = "<?=$Study_Seq?>";

	var AGTID = "<?=$captcha_agent_id?>";
	var USRID = "<?=$LoginMemberID?>";
	var COURSE_AGENT_PK = "<?=$LectureCode?>";
	var CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";
	var EVAL_CD = "<?php echo $evalCd; ?>";

	var USRDT = hrdFrame.getUT();

	if (otp == ""){
		alert("mOTP 인증번호를 입력하세요.");
		return false;
	}


	$.ajax({
		url:"https://emonotp.hrdkorea.or.kr/api/v2/otp_accredit",
		type:"POST",
		timeout:10000,
		contentType:"application/x-www-form-urlencoded",
		data:{
			USER_NM    : name,
			USER_TEL   : tel,
			OTPNO      : otp,
			AGTID      : AGTID,
			USRID      : USRID,
			SESSIONID  : "<?php echo session_id();?>",
			EXIP       : "<?php echo $UserIP;?>",
			COURSE_AGENT_PK  : COURSE_AGENT_PK,
			CLASS_AGENT_PK  : CLASS_AGENT_PK,
			EVAL_CD    : EVAL_CD, //평가 구분 코드 : 00 입과, 01 진도, 02 시험, 03 과제, 04 진행평가, 99 기타
			EVAL_TYPE  : "<?php echo $evalType; ?>", //EVAL_TYPE 평가 방법 (진도, 시험, 과제, 진행평가, 기타)
			CLASS_TME  : "<?php echo $evalCd == '00' ? '00':$Chapter_NumberZero; ?>", //진도 차시 또는 평가 회수 ( 01~999 )
			USRDT      : USRDT,
			UT         : USRDT
		},success:function(data){
			//console.log("data==="+JSON.stringify(data));
			//$("#display").prepend(JSON.stringify(data)+"</br>");
			if(data.code == 200) {
				$.ajaxSetup({ async:false }); //-- 순차처리
				//console.log(data.status);
				if(EVAL_CD == '00'){
					//-- 본인인증 값 저장
					var m_Ret = "T";
					var m_retCD = "000000";
					var m_trnID = "<?php echo $LectureCode."_".date('YmdHis');?>";
					var m_trnDT = USRDT;
					$.post("./player_cert_insert.php",
					{ 'LectureCode': LectureCode,
							'Study_Seq': Study_Seq,
							'CertType': 'user',
							'AGTID': AGTID,
							'COURSE_AGENT_PK': COURSE_AGENT_PK,
							'CLASS_AGENT_PK': CLASS_AGENT_PK,
							'm_Ret': m_Ret,
							'm_retCD': m_retCD,
							'm_trnID': m_trnID,
							'm_trnDT': m_trnDT
					},function(data){
							//if(data=="Y") {
							//	alert("인증처리가 완료되었습니다.");
							//}
					});
					alert("입과시 mOTP 인증처리가 완료되었습니다.\n 한번 더 mOTP인증처리가 필요합니다.");
					//alert("입과시 mOTP 인증처리가 완료되었습니다.");
				}
				else{
					$.post("./player_captcha_session.php",
					{
						'Chapter_Number': "<?php echo $Chapter_Number; ?>",
						'LectureCode': "<?php echo $LectureCode; ?>",
						'Study_Seq': "<?php echo $Study_Seq; ?>",
						'Chapter_Seq': "<?php echo $Chapter_Seq; ?>"
					},function(data,status){
					});
					alert("인증처리가 완료되었습니다.");
				}
				TopPageMove();
				//self.close();
			} else if (data.code == "AP001") {
				alert('인증번호가 일치하지 않습니다. 다시 입력 하세요.');
				location.replace(); //-- 화면을 갱신해 준다.
			} else if (data.code == "AP001") {
				alert('인증번호가 일치하지 않습니다. 다시 입력 하세요.');
				location.replace(); //-- 화면을 갱신해 준다.
			} else if (data.code == "AP009") {
				//-- 5회 오류시
				alert('5회 오류가 발생하였습니다.\nmOTP인증이 잠겼습니다.\n본인확인을 하여 잠금을 해제 하세요.');
				resetOpt();
			} else {
				//console.log(data.status)
				alert("mOTP시스템 장애가 발생하였습니다. 대체인증 화면으로 이동합니다. - 1");
				changeCert();
				//self.close();
			}
		},error:function(e){
			alert("mOTP시스템 장애가 발생하였습니다. 대체인증 화면으로 이동합니다. - 2");
			changeCert();
			//self.close();
		}
	});

}
//-- 무조건 처리 해 주어야 하나?
function fn_userReset(M_RET) {
	var name= "<?php echo $UserName; ?>";
	var tel = "<?php echo $UserMobile; ?>";

	var LectureCode = "<?=$LectureCode?>";
	var Study_Seq = "<?=$Study_Seq?>";

	var AGTID = "<?=$captcha_agent_id?>";
	var USRID = "<?=$LoginMemberID?>";
	var COURSE_AGENT_PK = "<?=$LectureCode?>";
	var CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";

	var USRDT = hrdFrame.getUT();
	var M_RETCD = "000000";
	var M_TRNID = "<?php echo $LectureCode."_".date('YmdHis');?>";

	$.ajax({
		url:"https://emonotp.hrdkorea.or.kr/api/v2/user_reset",
		type:"POST",
		contentType:"application/x-www-form-urlencoded",
		timeout:10000,
		data:{
			USER_NM   : name,
			USER_TEL  : tel,
			AGTID     : AGTID,
			USRID     : USRID,
			M_RET     : M_RET,
			M_RETCD   : M_RETCD,
			M_TRNID   : M_TRNID,
			M_TRNDT   : USRDT
		},
		success:function(data){
			//$("#display").prepend(JSON.stringify(data)+"</br>");
			if(data.code == 200) {
				//console.log(data.status);
				$("#otpNo").val('');
				$("#motp_div").show();
				$("#captcha_div").hide();
			} else if (data.code == "AP010") {
				alert("초기화에 실패 했습니다.");
			} else {
				//console.log(data.status)
				alert("시스템 장애가 발생했습니다. - 1");
			}
			//self.close();
		},error:function(e){
			//$("#display").prepend("ERROR==="+JSON.stringify(e));
			alert("시스템 장애가 발생했습니다. - 2");
			//self.close();
		}

	});

}


</script>

<div id="motp_div" align="center">
	<table border="0">
		<tr align="center">
			<td colspan="2" class="fs24b pt30">mOTP 인증</td>
		</tr>
		<!--
		<tr>
			<td colspan="2">&nbsp</td>
		</tr>
		-->
		<tr>
			<td colspan="2" class="info" align="center" style="padding: 10px 0 10px 0">
				<h3>mOTP앱에서 조회되는 인증번호를 입력하세요.</h3>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="info" align="center">
				<div class="input-div">
					<span><input type="text" id="otpNo" placeholder="인증번호" maxlength="6" autocomplete="off" numberOnly="true" style="font-size:14px; font-weight:bold; padding:0 10px; width: 100px; height:30px; vertical-align:top; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px;" /></span>
					<span class="btnSmSky01"><a href="javascript:void(0);" onclick="fn_otpAccredit();">인증하기</a></span>
					<span class="btnSmGray01"><a href="javascript:void(0);" onclick="changeCert();">휴대폰 인증</a></span>					
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="info" align="center" style="padding: 10px 0 10px 0">
				1. 휴대폰에 앱이 없으신분은 스토어나 마켓에서 <br>한국산업인력공단 mOTP를<br> 검색하셔서 먼저 설치 하시기 바랍니다.
				<br>2. mOTP 사용이 불가한 경우<br>휴대폰 인증을 사용하시기 바랍니다.<br>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="info" align="center" style="padding: 10px 0 10px 0">
				<img src="./motp_sample_img.png" alt="sample_motp_img"/>
			</td>
		</tr>
	</table>
</div>
<?
/////////////////////////////////////////////////////////////////////////////////////////////////////
// 아래는 휴대폰인증
/////////////////////////////////////////////////////////////////////////////////////////////////////
$Sql = "SELECT *, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Member WHERE ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Name = $Row['Name'];
	$Mobile = $Row['Mobile'];
}
?>
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

$authtype = ""; // 없으면 기본 선택화면, X: 공인인증서, M: 핸드폰, C: 카드

$popgubun 	= "N"; // Y : 취소버튼 있음 / N : 취소버튼 없음
$customize 	= "Mobile"; // 없으면 기본 웹페이지 / Mobile : 모바일페이지

$gender = ""; // 없으면 기본 선택화면, 0: 여자, 1: 남자

$reqseq = $LectureCode."_".date('YmdHis');     // 요청 번호, 이는 성공/실패후에 같은 값으로 되돌려주게 되므로
// 업체에서 적절하게 변경하여 쓰거나, 아래와 같이 생성한다.
//if (extension_loaded($module)) {// 동적으로 모듈 로드 했을경우
	//$reqseq = get_cprequest_no($sitecode);
//} else {
//	$reqseq = "Module get_request_no is not compiled into PHP";
//}



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


//if (extension_loaded($module)) {// 동적으로 모듈 로드 했을경우
//	$enc_data = get_encode_data($sitecode, $sitepasswd, $plaindata);
    $enc_data = `$cb_encode_path ENC $sitecode $sitepasswd $plaindata`;

//} else {
	//	$enc_data = "Module get_request_data is not compiled into PHP";
//}

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
<div id="captcha_div" align="center" style="display:none">
	<table border="0">
		<tr align="center">
			<td colspan="2" class="fs24b fc999B pt30">휴대폰 인증</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp</td>
		</tr>
		<tr>
			<td colspan="2" class="info" align="center">[인증하기]버튼을 클릭하여<br>본인인증을 진행하시기 바립니다.<br><br>휴대폰 인증은 본인명의 휴대폰만<br>인증이 가능하오니 유의하시기 바립니다.</td>
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
			<td colspan="2" align="center"><button id="btnAuth" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:16px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:140px; height:55px; cursor:pointer" onclick="fnPopup();">인증하기</button></td>
		</tr>
	</table>
</div>


<input type="hidden" name="Chapter_Number" id="Chapter_Number" value="<?=$Chapter_Number?>">
<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
<input type="hidden" name="Study_Seq" id="Study_Seq" value="<?=$Study_Seq?>">
<input type="hidden" name="Chapter_Seq" id="Chapter_Seq" value="<?=$Chapter_Seq?>">

<div id="SysBg_White" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #FFFFFF;display:none;"></div>
<script type="text/javascript">
<!--
$(function(){
	$("input:text[numberOnly]").on("keyup", function() {$(this).val( $(this).val().replace(/[^0-9]/gi,"") );});
});
var isReset = false;
function resetOpt() {
	isReset = true;
	changeCert();
}
function resetOptProc() {
	isReset = false;
	fn_userReset('F');
}

function changeCert() {
	$("#motp_div").hide();
	$("#captcha_div").show();
}

function TopPageMove() {
	top.location.href="./lecture_view.php?Chapter_Number=<?=$Chapter_Number?>&LectureCode=<?=$LectureCode?>&Study_Seq=<?=$Study_Seq?>&Chapter_Seq=<?=$Chapter_Seq?>&Contents_idx=<?=$Contents_idx?>&mode=<?=$mode?>";
}


function CertCheckProc(m_trnDT) {
	if(isReset){
		resetOptProc();
		return;
	}
	var LectureCode = "<?=$LectureCode?>";
	var Study_Seq = "<?=$Study_Seq?>";

	var AGTID = "<?=$captcha_agent_id?>";
	var USRID = "<?=$LoginMemberID?>";
	var COURSE_AGENT_PK = "<?=$LectureCode?>";
	var CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";
	EVAL_CD = "<?php echo $evalCd; ?>";

	var m_Ret = "T";
	var m_retCD = "000000";
	var m_trnID = "<?=$reqseq?>";
	//m_trnDT = "2019-12-01 13:26:31";

	try {
		$.ajax({
			type : "POST",
			//url : "https://emon.hrdkorea.or.kr/EAIServer/SOURCE/ExConn/LMS/pAuthLog.jsp",
			url : "https://emon.hrdkorea.or.kr/EAIServer/SOURCE/ExConn/LMS/pSubOtpLog.jsp",
			crossDomain: true,
			data : {
				AGTID : AGTID,
				USRID : USRID,
				COURSE_AGENT_PK : COURSE_AGENT_PK,
				CLASS_AGENT_PK : CLASS_AGENT_PK,
				EVAL_CD    : EVAL_CD, //평가 구분 코드 : 00 입과, 01 진도, 02 시험, 03 과제, 04 진행평가, 99 기타
				EVAL_TYPE  : "<?php echo $evalType; ?>", //EVAL_TYPE 평가 방법 (진도, 시험, 과제, 진행평가, 기타)
				CLASS_TME  : "<?php echo $evalCd == '00' ? '00':$Chapter_NumberZero; ?>", //진도 차시 또는 평가 회수 ( 01~999 )
				m_Ret : m_Ret,
				m_retCD : m_retCD,
				m_trnID : m_trnID,
				m_trnDT : m_trnDT
			},
			dataType : "xml",
			success : function(xml) {

				if($(xml).find("RetVal").text() == "101") {

					//인증 처리 성공시 DB작업----------------------------------------------------------------
					$.ajaxSetup({ async:false }); //-- 순차처리
					//console.log(data.status);
					if(EVAL_CD == '00'){
						$.post("./player_cert_insert.php",
						{ 'LectureCode': LectureCode,
								'Study_Seq': Study_Seq,
								'CertType': 'user',
								'AGTID': AGTID,
								'COURSE_AGENT_PK': COURSE_AGENT_PK,
								'CLASS_AGENT_PK': CLASS_AGENT_PK,
								'm_Ret': m_Ret,
								'm_retCD': m_retCD,
								'm_trnID': m_trnID,
								'm_trnDT': m_trnDT
						},function(data){
								//if(data=="Y") {
								//	alert("인증처리가 완료되었습니다.");
								//}
						});
						alert("입과시 인증처리가 완료되었습니다.\n 한번 더 인증처리가 필요합니다.");
						resetOtpStatus(m_retCD);
						//alert("입과시 인증처리가 완료되었습니다.");
					}
					else{
						$.post("./player_captcha_session.php",
						{
							'Chapter_Number': "<?php echo $Chapter_Number; ?>",
							'LectureCode': "<?php echo $LectureCode; ?>",
							'Study_Seq': "<?php echo $Study_Seq; ?>",
							'Chapter_Seq': "<?php echo $Chapter_Seq; ?>"
						},function(data,status){
						});
						alert("인증처리가 완료되었습니다.");
						
					}

					TopPageMove();

					//인증 처리 성공시 DB작업----------------------------------------------------------------

				}else{
					//alert($(xml).find("Remark").text());
					alert("본인 인증처리중 문제가 발생했습니다.");
				}

			},
			error : function(xhr, textStatus, error) {
				alert("오류발생1 : " + error);
			}
		});
	} catch(e) {
		alert("오류발생2 : " + e.message);
	}

}


// OTP 비밀번호 연속오류로 인한 정지 시 본인인증을 통한 초기화 예시.
		function resetOtpStatus(p_retCD) {
			<?
			date_default_timezone_set('Asia/Seoul');

			// 현재 날짜와 시간 가져오기
				$currentDateTime = date('Y-m-d H:i:s');

			?>
			var m_Ret = "";       // 본인인증 결과 : T/F  (T:성공, F:실패). T에 해당하는 경우만 호출.
			var m_retCD = "";     // 인증서비스 공급자(나이스 등)의 인증결과 코드 값
			var m_trnID = "";     // 인증서비스 공급자가 부여한 인증거래 고유 아이디(일련번호)
			var m_trnDT = "";     // 인증처리 일시 (YYYY-MM-DD HH24:MI:SS)
			var AGTID = "<?=$captcha_agent_id?>";
			var USRID = "<?=$LoginMemberID?>";
	
			m_Ret = "T";
			m_retCD = p_retCD;//"000000";
			m_trnID = "<?=$reqseq?>";
			m_trnDT = "<?=$currentDateTime?>";
		
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
<?php if(false) { //-- 이전소스 사요안함 나중에 지음 ?>
<script type="text/javascript">
<!--
function CertCheckProc(m_trnDT) {

	LectureCode = "<?=$LectureCode?>";
	Study_Seq = "<?=$Study_Seq?>";

	AGTID = "<?=$captcha_agent_id?>";
	USRID = "<?=$LoginMemberID?>";
	COURSE_AGENT_PK = "<?=$LectureCode?>";
	CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";

	m_Ret = "T";
	m_retCD = "000000";
	m_trnID = "<?=$reqseq?>";
	//m_trnDT = "2019-12-01 13:26:31";

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

					$.post("./player_cert_insert.php",
					{ 'LectureCode': LectureCode,
						'Study_Seq': Study_Seq,
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
							location.href="lecture.php";
						}else{
							alert("본인 인증처리에 실패하였습니다.");
							location.href="lecture.php";
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
<?php } ?>
