/*
  ++++ 한국산업인력공단 통합 API 로딩 +++++++++++++++++++++++++++++++++++++++++++++++++++
  ** 페이지 로딩 시 호출.
  ** 통합 API는 용량이 있으므로 최초 페이지 로딩이 완료된 후 바로 함수호출하여 로딩 시작하여 주십시오.
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
window.onload = function() {
	// isDebug가 true로 설정되어 있을 경우 오류 시 Alert 창이 표출됩니다. 
	// Debug 시 true로 설정하여 주시고, 실 반영 시 false로 변경하여 주십시오.
	var isDebug = true;
	// 통합 API 로딩 프로세스 호출.
	// loadHrdFrame이 호출되지 않으면 다른 모든 함수가 정상 호출되지 않습니다.
	// 반드시 페이지 로딩 등 초기에 loadHrdFrame 함수가 1회 호출되어야 합니다.
	// 페이지 로딩 시 한번 호출하신 후 반복하여 호출하지 말아주십시오.
	hrdFrame.loadHrdFrame(isDebug); 
}
/*
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
/**
* EUC-KR 기반의 LMS를 사용하시는 훈련기관 대상 함수.
*
* ECU-KR 기반의 LMS 사용 시 메시지의 한글이 깨지는 것을 방지하기 위하여 반드시 아래 함수를 LMS 상에 위치시켜 주십시오.
*/
function EucMsg(msgNo) {		
	try {
		switch(msgNo) {
			case 1 :
				alert("전산장애가 발생하였습니다. 다시 시도하여 주십시오.");
				break;
			case 2 :
				alert("다운로드 중 오류가 발생하였습니다. 다시 다운로드 버튼을 클릭하여 주십시오.");
				break;
			case 3 :
				alert("OTP 호출 과정에서 장애가 발생하였습니다. 다시 시도하여 주십시오.");
				break;
		}
	} catch(e) {
		
	}			
}

/**
* OTP 번호생성이 완료된 후 호출.
* OTP 비밀번호 입력창을 번호생성을 위한 전 과정이 끝난 후 표출하시고자 할 경우 OtpDoneListener이 호출될 때, 비밀번호 입력박스를
* 동적으로 생성하여 주십시오.
*/
function OtpDoneListener(rtype) {
	/* 생성 완료 시 : rtype = 101 */
	//alert(rtype);
	if(rtype=="101") {
		$("#OTPInput").show();
	}else{
		$("#OTP").hide();
		$("#captcha").show();
	}

}


/*
  ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/

/*
  API 로딩 완료 시 Callback
*/
function loadAPIReceiver(rtype, msg) {
	if(rtype === "101") {   // API 로딩 성공 시 101, 실패 시 102
		// 만일 OTP 실행을 페이지 로딩과 동시에 수행하고자 할 경우 여기에 OTP 호출 함수를 넣어주세요.

		var OTPTYPE = "102";
		hrdFrame.loadOTP(AGTID,USRID,SESSIONID,OTPTYPE);
	}
	
}


/*
--> 파라미터 : AGTID, USRID
  ** AGTID : 훈련기관 이몬 로그인 ID
  ** USRID : 훈련생 ID
  
  ** AGTID, USRID 모두 Agent가 수집하는 LMS 데이터 값을 보내주셔야 합니다.
  ** AGTID, USRID 모두 영문,숫자만 허용됩니다. (한글 절대 불가합니다)
*/
/* AGTID 및 USRID는 훈련기관에서 임의 변경하여 테스트하여 주십시오. */
var AGTID = agent_id;
var USRID = user_agent_pk;
var SESSIONID = session_id;




// 1 단계 OTP 서비스 준비상태 및 OTP 단말기 상태 조회.
function checkifOtpStatus() {

	var LectureCode = $("#LectureCode").val();
	var Study_Seq = $("#Study_Seq").val();
	var Chapter_Seq = $("#Chapter_Seq").val();
	var TestType = $("#TestType").val();

	try {
		/* No-Cache, 설정 및 CrossDomain 설정,  */
		$.ajaxSetup({ cache: false });
		$.support.cors = true;
		
		$.ajax({
			type : "POST",
			url  : "https://fds.hrdkorea.or.kr/fdsService/hrdOTP/JSP/clientService/chkOtpDeviceStatus.jsp",
			crossDomain: true,
			timeout : 5000, /* Timeout 권고치 5~10초 */
			data : {
				AGTID : AGTID,
				USRID : USRID
			},
			dataType : "xml",
			success : function(xml) {	
				/*
				--> 응답 값
				  ** ConnStatus : 서비스 준비상태. 101 - 서비스 이용 가능,  102 - 정상 서비스 불가
					 >> 101 : 정상적으로 OTP 호출
					 >> 102 : 한국산업인력공단이 제시하는 대체 인증수단 호출
				  ** OtpStatus : 단말상태. 101 - 정상등록, 102 - 비밀번호 연속오류로 인한 사용정지, 103 - 미등록 단말(최초 접근), 901 - 장애발생
					 >> 101, 103인 경우 정상적으로 OTP 호출. 
					 >> 102인 경우 휴대폰인증을 통한 OTP 초기화 조치. 
					 >> 901인 경우 재시도 또는 대체 인증수단 호출.
				*/
				var ConnStatus = $(xml).find("ConnStatus").text();
				var OtpStatus = $(xml).find("OtpStatus").text();
				var ErrCnt = $(xml).find("ErrCnt").text();
				var Remark = $(xml).find("Remark").text();
		
				if(ConnStatus == "101") {
					if(OtpStatus == "101" || OtpStatus == "103") {
						// 정상적으로 OTP 호출
						ExecuteOTP();
					}
					else if(OtpStatus == "102") {
						// 비밀번호 연속오류로 OTP 이용 정지 상태
						// 본인인증 화면 표출. 본인인증 후 성공일 경우에 한하여 인증결과를 한국산업인력공단으로 전송.
						// 본인인증결과 전송 시 오류기록 초기화로 정상적인 OTP 사용 가능.
						alert("비밀번호 연속오류로 OTP 이용 정지 상태입니다.\n\n본인인증을 통해 OTP를 초기화 합니다.");
						location.href="/player/player_otp_init.php?LectureCode="+LectureCode+"&Study_Seq="+Study_Seq+"&Chapter_Seq="+Chapter_Seq+"&TestType="+TestType;
					}
					else {
						// 장애 발생 시 재시도 또는 한국산업인력공단에서 제시한 대체 인증수단 호출
						//$("#OTP").hide();
						//$("#CaptchaForm").show();
						checkifOtpStatus();
					}
				} 
				else {
					// 정상적인 서비스 불가상태
					// 한국산업인력공단에서 제시한 대체 인증수단 호출
					$("#OTP").hide();
					$("#captcha").show();
				}
			},
			error : function(xhr, textStatus, error) {
				// 장애 발생 시 재시도 또는 한국산업인력공단에서 제시한 대체 인증수단 호출
				//$("#OTP").hide();
				//$("#CaptchaForm").show();
				checkifOtpStatus();
			}
		});
	} catch(e) {
		// 장애 발생 시 재시도 또는 한국산업인력공단에서 제시한 대체 인증수단 호출
		//$("#OTP").hide();
		//$("#CaptchaForm").show();
		checkifOtpStatus();
	}
}


// OTP 비밀번호 연속오류로 인한 정지 시 본인인증을 통한 초기화 예시.
function resetOtpStatus() {
	var m_Ret = "";       // 본인인증 결과 : T/F  (T:성공, F:실패). T에 해당하는 경우만 호출.
	var m_retCD = "";     // 인증서비스 공급자(나이스 등)의 인증결과 코드 값
	var m_trnID = "";     // 인증서비스 공급자가 부여한 인증거래 고유 아이디(일련번호)
	var m_trnDT = "";     // 인증처리 일시 (YYYY-MM-DD HH24:MI:SS)
	
	m_Ret = "T";
	m_retCD = "000000";
	m_trnID = "12345";
	m_trnDT = "2019-12-01 13:26:31";
	
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

<!-- ################################################################################################## -->
<!-- OTP 호출 및 비밀번호 생성                                                                                                                                                                                                   -->
<!-- ################################################################################################## -->

function ExecuteOTP() {  // 함수명은 자유롭게 설정하셔도 무방합니다.
	try {
		/*
		  ##### OTP 로딩 ######################################################
		  OTPTYPE : OTP 호출 방법
		  > 101 : 팝업으로 OTP 표출. 설치형 OTP 배포
		  > 102 : 프레임으로 OTP 표출. 설치형 OTP 배포안함.
			모바일 및 Mac, Linux 등 설치형 배포대상이 아닐 경우 OTPTYPE이 101이더라도 프레임으로 표출함.
		  --> 주의) 현재 다수 훈련기관의 요청으로 팝업이 아닌 프레임 형태만 지원함.  
		  --> 101(팝업) 지원 시 추후 별도 통보함.
		  ###################################################################
		*/
		
		var OTPTYPE = "102";
		hrdFrame.loadOTP(AGTID,USRID,SESSIONID,OTPTYPE);
		
	} catch(e) {
		// 장애 발생 시 재시도 또는 한국산업인력공단에서 제시한 대체 인증수단 호출
		//$("#OTP").hide();
		//$("#captcha").show();
		checkifOtpStatus();
	}
}

/* hrdFrame.loadOTP 호출에 대한 Callback */
function loadOtpReceiver(rtype, msg) { // Callback 함수로 반드시 동일한 함수명 및 파라미터 구조로 등록되어 있어야합니다.
	alert(rtype + " : " + msg);
	/*
		rtype : 102 --> 장애 및 지연발생으로 OTP 호출 중단.
		한국산업인력공단에서 제시한 대체 인증수단 호출
	*/
	if(rtype=="102") {
		$("#OTP").hide();
		$("#captcha").show();
	}
}

<!-- ################################################################################################## -->
<!-- KEYPAD 제어                                                                                                                                                                                                                     -->		
<!-- ################################################################################################## -->

function showKeypad(ele) {
	
	/*
	 ## padType : Layer/Frame
	  >> Layer : 세로타입
	  >> Frame : 가로타입
	 ## fWidth : Frame일 경우 넓이 (Layer일 경우 참조하지 않음)
	*/
	var padType = "Frame";  
	var fWidth = "400px";

	hrdFrame.loadKeyPad(ele, padType, fWidth);
}

/* hrdFrame.loadKeyPad 호출에 대한 Callback */
function loadKeypadReceiver(rtype, msg) { // Callback 함수로 반드시 동일한 함수명 및 파라미터 구조로 등록되어 있어야합니다.
	alert(rtype + " : " + msg);

	/*
	rtype : 102 --> 장애 및 지연발생으로 OTP 호출 중단.
	keypad 대신 일반 좌판을 통한 입력 허용
	
	예제)
	document.getElementById("otpVal").removeAttribute("onclick");
	*/
}

function hideKeypad() {
	hrdFrame.hideKeyPad();
}

<!-- ################################################################################################## -->
<!-- OTP 비밀번호 검증                                                                                                                                                                                                                -->		
<!-- ################################################################################################## -->

function validateOtp() {
	
	try {
		var oNo = document.getElementById("otpVal").value;
		if(oNo == null || oNo == "") {
			alert("otp 번호를 입력하여 주십시오.");
			return false;
		}
		
		var COURSE_AGENT_PK = course_agent_pk;
		var CLASS_AGENT_PK = class_agent_pk;
		var EVAL_CD = eval_cd;
		var EVAL_TYPE = eval_type;
		var CLASS_TME = class_tme.padStart(2, "0");
		var UT = hrdFrame.getUT();
		
		$.ajax({
			type : "POST",
			url  : "https://fds.hrdkorea.or.kr/fdsService/hrdOTP/JSP/validateOtp/chkOtpResult.jsp",
			crossDomain: true,
			data : {
				AGTID : AGTID,
				USRID : USRID,
				SESSIONID : SESSIONID,
				OTPNO : oNo,
				COURSE_AGENT_PK : COURSE_AGENT_PK,
				CLASS_AGENT_PK : CLASS_AGENT_PK,
				EVAL_CD : EVAL_CD,
				EVAL_TYPE : EVAL_TYPE,
				CLASS_TME : CLASS_TME,
				UT : UT
			},
			dataType : "xml",
			success : function(xml) {					
				if($(xml).find("RetVal").text() == "101") {
					hideKeypad();
					alert("OTP 인증이 성공적으로 이루어졌습니다.");
					
					$.post("/player/player_captcha_time.php",
					{
						'Study_Seq': $("#Study_Seq").val(),
						'StepType': $("#StepType").val()
					},function(data,status){
						top.$("#OTP").hide();
						top.$("#AgreeForm").show();
					});
					

				} else {
					/* 키패드를 화면에서 제거함. */
					hideKeypad();
					
					/*
					 ## OTP 화면 갱신.
					  * OTP는 60초 단위의 시간 별 고유 키를 생성하여 검증함.
					  * 훈련생의 디바이스와 서버의 시간이 불일치할 경우 서로 다른 시간 대의 비밀번호를 생성하여 검증하는 경우가 발생할 수 있음.
					  * 이에 따른 오류를 최소화하기 위하여 OTP를 한번 더 로드시켜 시간 불일치로 인한 비밀번호 오류 위험을 최소화함.
					*/
					ExecuteOTP();
					alert("OTP 인증에 실패하였습니다. 비밀번호를 확인 후 다시 입력하여 주십시오.\r\n" + "연속오류 횟수 : " + $(xml).find("ErrCnt").text() + " / " + $(xml).find("RetMsg").text() + "\r\n" + $(xml).find("Remark").text());
				}					
			},
			error : function(xhr, textStatus, error) {
				hideKeypad();
				// 장애 발생 시 재시도 또는 한국산업인력공단에서 제시한 대체 인증수단 호출
				//$("#OTP").hide();
				//$("#captcha").show();
				checkifOtpStatus();
			}
		});
	} catch(e) {
		hideKeypad();
		// 장애 발생 시 재시도 또는 한국산업인력공단에서 제시한 대체 인증수단 호출
		//$("#OTP").hide();
		//$("#captcha").show();
		checkifOtpStatus();
	}
}

<!-- ################################################################################################## -->

function ExecuteFDS() {  // 함수명은 자유롭게 설정하셔도 무방합니다.
	hrdFrame.loadFDS(AGTID,USRID,SESSIONID);
}


