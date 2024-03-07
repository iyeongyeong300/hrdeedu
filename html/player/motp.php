<?php
include "../include/include_function.php"; //DB연결 및 각종 함수 정의
$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, AES_DECRYPT(UNHEX(Tel),'$DB_Enc_Key') AS Tel, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay, (SELECT CompanyName FROM Company WHERE CompanyCode=Member.CompanyCode LIMIT 0,1) AS CompanyName FROM Member WHERE ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$member = mysqli_fetch_array($Result);

$CLASS_TME= $_GET['class_tme'];
$COURSE_AGENT_PK= $_GET['COURSE_AGENT_PK'];
$CLASS_AGENT_PK= $_GET['CLASS_AGENT_PK'];

if($CLASS_TME=='1'){
	$EvalCd= $_GET['EvalCd'];
	if($EvalCd == '00'){
		$EVAL_CD='00';
		$EVAL_TYPE='입과';
		$CLASS_TME='00';
	}else{
		$EVAL_CD='01';
		$EVAL_TYPE='진도';
		$CLASS_TME= $_GET['class_tme'];
	}
}else{
	$EVAL_CD='01';
	$EVAL_TYPE='진도';
	$CLASS_TME= $_GET['class_tme'];
}

if($TestType=="MidTest") {
	$CookieName = "LMS_MidTest_".$Study_Seq;
}
if($TestType=="Test") {
	$CookieName = "LMS_Test_".$Study_Seq;
}
if($TestType=="Report") {
	$CookieName = "LMS_Report_".$Study_Seq;
}

$TestType = $_GET['type'];
if($TestType=="MidTest") {
	$EVAL_CD = "04";
	$EVAL_TYPE = "진행평가";
	$EVAL_TYPE2 = "진행평가_1";
	$StepType = "MidCaptchaTime";
	$CLASS_TME = $_GET['class_tme'];
}
if($TestType=="Test") {
	$EVAL_CD = "02";
	$EVAL_TYPE = "시험";
	$EVAL_TYPE2 = "시험_1";
	$StepType = "TestCaptchaTime";
	$CLASS_TME = $_GET['class_tme'];
}
if($TestType=="Report") {
	$EVAL_CD = "03";
	$EVAL_TYPE = "과제";
	$EVAL_TYPE2 = "과제_1";
	$StepType = "ReportCaptchaTime";
	$CLASS_TME = $_GET['class_tme'];
}
if($TestType==""){ //진도
	$Chapter_Number = $_GET['Chapter_Number'];
	$Study_Seq= $_GET['Study_Seq'];
	$Chapter_Seq= $_GET['Chapter_Seq'];
}

$reqseq2 = $COURSE_AGENT_PK."_".date('YmdHis');
?>
<html>
<head>
<meta charset="UTF-8">
<style>
	@charset "utf-8";


* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  border: none;
  font-family: NanumSquareB;
}

.canvas{
  padding: 70px 0;
  box-sizing: border-box;
  text-align: center;
  width: 550px;
  height: 909px;
  background-color: #f7f7f9;
}

h2{
  margin: 0 auto;
  background-color: #0d539d;
  width: 270px;
  height: 80px;
  font-size: 42px;
  font-weight: 400;
  color: #ffffff;
  border-radius: 5px;
  line-height: 70px;
}
p{
  font-size: 16px;
  line-height: 26px;
  margin-bottom: 30px;
}
input[type="text"], button{
  cursor: pointer;
  border-radius: 5px;
  min-width: 270px;
  height: 40px;
  font-size: 15px;
  line-height: 40px;
}
input[type="text"]{
  border: 1px solid #6c6c6c;
  color: #909090;
  padding-left: 20px;
  box-sizing: border-box;
  margin-bottom: 15px;
}
button{
  background: #0d539d;
  color: #ffffff;
}

.loadingScreen{ background: #fff; }
.otp_error{ width: 100%; padding:15px 20px; margin:10px auto 0;  background:#f76262; color: #fff; font-family: 'Noto Sans KR'; font-size: 13px; font-weight: 400;  border-radius: 5px; box-shadow: 5px 5px 10px rgba(247,98,98,0.2); box-sizing: border-box;}
.otp_error i{display: inline-block; margin-bottom: 5px; font-size: 17px;}
#hrdOtpFrame{ height: auto!important; box-shadow: 2px 2px 7px rgba(0,0,0,0.1); }
.otp_title{font-family: 'Noto Sans KR'; font-size: 30px; color: #262626; font-weight: 300; letter-spacing: -2px; margin: 0;}
.otp_txt{ font-family: 'Noto Sans KR', ; font-size: 18px; color: #5c5c5c; letter-spacing: -1.5px; margin: 0;}
.otp_t1{ font-size: 14px; color: #353535; font-family: 'Noto Sans KR'; font-weight: 400; letter-spacing: -0.5px; line-height: 17px;}
.otp_t1 i{ color: #2174ff; margin-right: 10px;}
.otp_t1 >span{ font-weight: 900; color: #0042af; }
.otpVal_wrap_all{ width: 100%; background: #fff; padding:5px 0px 20px 0; margin-top: 15px; text-align: center; box-shadow: 2px 2px 7px rgba(0,0,0,0.1); }
.otpVal_wrap{ width: 80%; margin: 0 auto; }
.otpVal_wrap:after { content:""; display: block; clear:both; }
.otpVal_wrap>input{ float: left; }
#otpVal{ width: 60%; height: 32px;  border: 1px solid #ccc; border-radius: 5px;  }
.otp_bt2{ width: 30%; height: 37px;margin-left:5px;  font-size: 13px; font-family: 'Noto Sans KR'; font-weight: 400;  background: linear-gradient(150deg, #816eff, #3982ff); color: #fff; border: 0; border-radius: 5px; cursor:pointer;  box-shadow: 5px 5px 10px rgba(102,102,255,0.4); }
.otp_wrap2{ width: 50%; margin:0 auto; }
.otp_bt3{ width: 100%; height: 37px; font-family: 'Noto Sans KR'; font-size: 13px; font-weight: 400;  background: linear-gradient(150deg, #f05138, #ee3a5b, #ed1375); color: #fff;  border:0; border-radius: 5px; cursor:pointer;  box-shadow: 5px 5px 10px rgba(237,19,117,0.2); }
.otp_wrap3:after { content:""; display: block; clear:both; }
.otp_wrap3{ width: 70%; margin:0 auto; }
.otp_wrap3>input{ float: left; }
.otp_bt4{ width: 48%; height: 37px; font-family: 'Noto Sans KR'; font-size: 13px; font-weight: 400; background: linear-gradient(150deg, #816eff, #3982ff); color: #fff; border: 0; border-radius: 5px; cursor:pointer; box-shadow: 5px 5px 10px rgba(102,102,255,0.4);  }
.otp_bt5{ width: 48%; height: 37px; font-family: 'Noto Sans KR'; font-size: 13px; font-weight: 400;  background: linear-gradient(150deg, #fea735, #fe7235);  color: #fff; border: 0; border-radius: 5px; cursor:pointer; box-shadow:3px 3px 7px rgba(254,114,53,0.5); }
#hrdKeyPad{ top:496px; left: 60px; }
#hrdOtpFrame table{background: #fff!important; }

.cssFont18, .cssFont17{ color: #2174ff; font-family: 'Noto Sans KR'; font-size: 14px; font-weight: 500; letter-spacing: -0.5px; line-height: 16px;}
.cssFont16{ color: #333; font-family: 'Noto Sans KR'; font-size: 14px; font-weight: 400; letter-spacing: -0.5px; }
#otpFrameLine{ display: none;}
.btnType05{ height:40px!important; background: #1799a4; border-radius: 30px; font-family: 'Noto Sans KR'; font-size: 15px; font-weight: 300; letter-spacing: -0.5px;  transition: all 0.5s; box-shadow:3px 3px 7px rgba(0,0,0,0.4);  }
#menuArea{ background: #fff; padding: 15px 10px; }
.cssFont06{ background: #f9f9f9; color: #616161; font-family: 'Noto Sans KR'; font-size: 14px; font-weight: 400; letter-spacing: -0.5px; border-radius: 30px; padding: 6px 20px; transition: all 0.3s; }
.cssFont06:hover{ background: #444; color: #fff; }
.cssFont15{ color:#ff8f21; }
#remainSec{ margin: 0; }
.cssFont13{ color: #ff8f21!important;}

</style>
<!-- ###################################################################################################### -->
<!-- Meta 설정환경을 아래와 같이 유지하여 주십시오.                                                                         -->
<!-- ###################################################################################################### -->

<!-- Cache 관리 Meta Tag : Cache는 No-Cache 정책을 유지하여 주십시오. -->
<META http-equiv="Expires" content="-1">
<META http-equiv="Pragma" content="no-cache">
<META http-equiv="Cache-Control" content="No-Cache">

<!-- IE 브라우저 사용자의 경우 최적의 성능을 위하여  IE=edge,chrome=1로 세팅되어 있어야 합니다. -->
<META http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

<!-- ###################################################################################################### -->

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/motp_style.css">
<script type="text/javascript" src="https://fds.hrdkorea.or.kr/fdsService/hrdAPI/hrdFrameLoader.js"></script> <!-- HRD 시간 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<title>HRD-MOTP 인증</title>

<script type="text/javascript">
		window.name 		= "Parent_window";
		var AGTID     		= "<?=$captcha_agent_id?>";
		var USRID   		= "<?=$_SESSION['LoginMemberID']?>"; 
		var USER_NAME 		= "<?=$_SESSION['LoginName']?>";
		var SESSIONID 		= "<?=session_id();?>";
		var USER_BRITH 		= "<?=substr(str_replace('-','',$member['BirthDay']),-6)?>";
		var COURSE_AGENT_PK = "<?=$COURSE_AGENT_PK?>";
		var CLASS_AGENT_PK 	= "<?=$CLASS_AGENT_PK?>";
		var EVAL_CD   		= "<?=$EVAL_CD?>";
		var EVAL_TYPE 		= "<?=$EVAL_TYPE?>";
		var CLASS_TME 		= "<?=str_pad($CLASS_TME,2,'0',STR_PAD_LEFT)?>";
		var USER_IP   		= "<?=$_SERVER['REMOTE_ADDR']?>";
        var returnMsg 		= '';
		var m_retCD 		= "";
		var m_trnID 		= ""; 
		var AUTH_TYPE 		= "";	
		var m_trnDT  		= hrdFrame.getUT();	//인증처리 일시
		var UT  			= hrdFrame.getUT();
		var reqseq2			= "<?=$reqseq2?>";

			if ( m_retCD == '000000'){ // 인증구분 M_RETCD 변경으로 작동 안됨 // 맞게 수정 요망
				var CERTIFIED	=	"본인인증";
			} else if ( m_retCD == 'REQ_0123456789') {
				var CERTIFIED	=	"아이핀";
			} else {
				var CERTIFIED	=	"mOTP인증";				
			}



		function fn_otpAccredit() {	 // motp 인증	

			
			var USER_PHON  = $("#userTel").val();
			var USER_OTP  = $("#otpNo").val();

				if (USER_NAME == "" || USER_NAME == null){
					alert("회원 정보에 성함이 없습니다.");
					return false;
				}
				if( USER_OTP == "" ||  USER_OTP == null) {
					alert("mOTP 번호를 적어주시기 바랍니다.");
					return false;				
				}
				if(USER_PHON == "" || USER_PHON == null) {
					alert("휴대폰 번호 적어주시기 바랍니다.");
					return false;			
				}
				
				$.ajax({
					url:"https://emonotp.hrdkorea.or.kr/api/v2/otp_accredit",
					type:"POST", 
					timeout:10000, 
					
					contentType:"application/x-www-form-urlencoded",
					data:{
						USER_NM    		: USER_NAME, // 이름
						USER_TEL   		: USER_PHON, // 핸드폰 번호
						OTPNO     		: USER_OTP, // OTP
						AGTID			: AGTID, // emon 아이디 예:nayanet
						USRID			: USRID, // 아이디
						SESSIONID		: SESSIONID,// session 테이블 값
						EXIP			: USER_IP, // 접속자 IP
						COURSE_AGENT_PK : COURSE_AGENT_PK, // 과정 코드
						CLASS_AGENT_PK  : CLASS_AGENT_PK, // // (과정코드,개설번호)
						EVAL_CD			: EVAL_CD, // hrdOTP 매위 참고
						EVAL_TYPE		: EVAL_TYPE, // hrdOTP 매위 참고
						CLASS_TME		: CLASS_TME, // hrdOTP 매위 참고
						USRDT			: UT // hrdOTP 매위 참고
						
					},
					success:function(data){

						if(opener==null){
							alert('OK');
							return false;
						}
						if(data.code == 200) { // 인증 성공
						<?php 
							if($_GET['type']==''){ ?>
								if(EVAL_CD=='00'){
									self.close();
									opener.parent.CertCheckProc(UT,true);
								}else if(EVAL_CD=='01'){
									$.post("/player/play_study_auth_insert.php",
									{ 'LectureCode': COURSE_AGENT_PK,
										'Study_Seq': '<?=$Study_Seq?>',
										'Chapter_Seq': '<?=$Chapter_Seq?>',
										'CertType': 'user',
										'AGTID': AGTID,
										'COURSE_AGENT_PK': COURSE_AGENT_PK,
										'CLASS_AGENT_PK': CLASS_AGENT_PK,
										'm_Ret': "T",
										'm_retCD': "000000",
										'm_trnID': reqseq2,
										'm_trnDT': UT
									},function(data){
										if(data=="Y") {
											alert("mOTP 인증처리가 완료되었습니다.");
											self.close();
											opener.DataResultClose();
											opener.Play('<?=$Chapter_Number?>',COURSE_AGENT_PK,'<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$mode?>');
										}else{
											alert("시스템에 장애가 생겼습니다.\n\n다시 시도하여 주세요.");
											self.close();
											opener.DataResultClose();
										}

									});
								}
							<?php
							}else{
							?>
							//opener.parent.ExamNotice();
								opener.parent.AgreeFormShow();
								self.close();
							<?php
							}	
							?>
						}  else if (data.code == "AP001") { // TP 번호가 서버와 다를 경우
							alert(data.msg);	
						}  else if (data.code == "AP002") { // user_nm 공백
							alert(data.msg);	
						} else if (data.code == "AP003") { // user_tel 공백
							alert(data.msg);					
						} else if (data.code == "AP004") { // OTP 공백
							alert(data.msg);	
						} else if (data.code == "AP005") { // 등록되지 않은 사용자
							alert(data.msg);	
						} else if (data.code == "AP006") { // 이미 등록된 사용자
							alert(data.msg);	
						} else if (data.code == "AP007") { // API 호출 에러
							alert(data.msg);	
						} else if (data.code == "AP008") { // 사용자 등록 중 에러 발생
							alert(data.msg);	
						} else if (data.code == "AP009") { // 5회 로그인 실패
							alert(data.msg);	
							//alert("5회 틀리셨습니다. 본인인증 및 아이핀으로 인증하셔서 제한 해제 하셔야 합니다.");
							alert("5회 틀리셨습니다. 본인인증으로 인증하셔서 제한 해제 하셔야 합니다.");
							fnPopupRedirect();
						} else if (data.code == "AP010") { // 패스워드 초기화 실패
							alert(data.msg);	
						} else if (data.code == "AP011") { 
							alert(data.msg);	
						} else if (data.code == "AP012") { // OTP 자릿수 오류[6자리만 가능] 
							alert(data.msg);	
						} else if (data.code == "WE005") { // 과도한 요청 시도시
							alert(data.msg);
						} else if (data.code == "WE001") { // API 전송시 header 의 content-type 에러
							alert(data.msg);
						} else if (data.code == "WE002") { // http 메소드가 post 가 아닌 경우
							alert(data.msg);
						} else if (data.code == "WE003") { // api header 정보가 잘못된 경우
							alert(data.msg);
						} else if (data.code == "WE004") { // 접속 로그를 작성 하는중 user_nm 이 잘 못된 경우
							alert(data.msg);
						} else if (data.code == "IE001") { // api 서버 내부 오류
							alert(data.msg);
						} else if (data.code == "CE001") { // api 서버 내부 오류
							alert(data.msg);
						} else if (data.code == "CE002") { // api 서버 내부 오류
							alert(data.msg);
						} else if (data.code == "CE003") { // api 서버 내부 오류
							alert(data.msg);
						} else {
							alert("현재 시스템에 장애가 생겼습니다.");
							
						}
						
					},
					error : function(xhr, textStatus, error) {
							
						alert("현재 시스템에 장애가 생겼습니다.");
					
					} 
					
				});
				
		}

		function fn_userReset() { // 제한 해제	
		var USER_PHON  = $("#userTel").val();
			$.ajax({
				url:"https://emonotp.hrdkorea.or.kr/api/v2/user_reset",
				type:"POST", 
				contentType:"application/x-www-form-urlencoded",
				timeout:10000,
				data:{
					USER_NM   : USER_NAME,
					USER_TEL  : USER_PHON,
					AGTID     : AGTID,
					USRID     : USRID,
					M_RET     : "T",
					M_RETCD   : m_retCD,
					M_TRNID   : m_trnID, 
					M_TRNDT   : m_trnDT //inputdata
				},
				success:function(data){
					if(data.code == 200) { // 인증 성공
						alert(data.msg);
						
						
						}  else if (data.code == "AP001") { // TP 번호가 서버와 다를 경우
							alert(data.msg);	
						}  else if (data.code == "AP002") { // user_nm 공백
							alert(data.msg);	
						} else if (data.code == "AP003") { // user_tel 공백
							alert(data.msg);					
						} else if (data.code == "AP004") { // OTP 공백
							alert(data.msg);	
						} else if (data.code == "AP005") { // 등록되지 않은 사용자
							alert(data.msg);	
						} else if (data.code == "AP006") { // 이미 등록된 사용자
							alert(data.msg);	
						} else if (data.code == "AP007") { // API 호출 에러
							alert(data.msg);	
						} else if (data.code == "AP008") { // 사용자 등록 중 에러 발생
							alert(data.msg);	
						} else if (data.code == "AP009") { // 패스워드 실페
							alert(data.msg);
						} else if (data.code == "AP010") { // 패스워드 초기화 실패
							alert(data.msg);	
						} else if (data.code == "AP011") { 
							alert(data.msg);	
						} else if (data.code == "AP012") { // OTP 자릿수 오류[6자리만 가능] 
							alert(data.msg);	
						} else if (data.code == "WE005") { // 과도한 요청 시도시
							alert(data.msg);
						} else if (data.code == "WE001") { // API 전송시 header 의 content-type 에러
							alert(data.msg);
						} else if (data.code == "WE002") { // http 메소드가 post 가 아닌 경우
							alert(data.msg);
						} else if (data.code == "WE003") { // api header 정보가 잘못된 경우
							alert(data.msg);
						} else if (data.code == "WE004") { // 접속 로그를 작성 하는중 user_nm 이 잘 못된 경우
							alert(data.msg);
						} else if (data.code == "IE001") { // api 서버 내부 오류
							alert(data.msg);
						} else if (data.code == "CE001") { // api 서버 내부 오류
							alert(data.msg);
						} else if (data.code == "CE002") { // api 서버 내부 오류
							alert(data.msg);
						} else if (data.code == "CE003") { // api 서버 내부 오류
							alert(data.msg);
						} else {
							alert("현재 시스템에 장애가 생겼습니다.");
						}
					
				},
					error : function(xhr, textStatus, error) {
							
						alert("현재 시스템에 장애가 생겼습니다.");
						window.close();
					} 				
				});
				
		};

        function fnPopup(){
            window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
            document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
            document.form_chk.target = "popupChk";
            document.form_chk.submit();
        }

        function fnPopupipin(){
            window.open('', 'popupIPIN2', 'width=450, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
            document.form_ipin.target = "popupIPIN2";
            document.form_ipin.action = "https://cert.vno.co.kr/ipin.cb";
            document.form_ipin.submit();
        }

        // motp 초기화. 인증
		function fnPopupRedirect(){
            window.open('', 'popupChk', 'width=500, height=550, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
			document.form_chk.param_r3.value = "user_reset";
            document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
            document.form_chk.target = "popupChk";
            document.form_chk.submit();
		}

        function mobileCheck(userName,userBirth,sex, certType, mobileNo,m_retCD,m_trnID,m_trnDT){
            var loginUserMobile = '';
            $.get('../api/apiLoginUser.php',function(data){
                loginUserMobile = data.mobile01+data.mobile02+data.mobile03; //로그인 유저 휴대폰번호


                if(USER_NAME != userName){
                    alert('본인인증은 되었으나 사이트에 등록된 회원정보와 일치하지 않습니다. 문제가 있는 경우 고객센터로 연락주시기 바랍니다.(이름 불일치)');
                    return;
                }

                if(userBirth.substring(2) != USER_BRITH) {
                    alert('본인인증은 되었으나 사이트에 등록된 회원정보와 일치하지 않습니다. 문제가 있는 경우 고객센터로 연락주시기 바랍니다.(생년월일 불일치)');
                    return;
                }
					pSubOtpLog(m_retCD,m_trnID,m_trnDT);

            })
        }
	
	    function pSubOtpLog(m_retCD,m_trnID,m_trnDT) { // 대체 인증시 결과 전송
	
            $.ajax({
                type		: "POST",
                url			: "https://emon.hrdkorea.or.kr/EAIServer/SOURCE/ExConn/LMS/pSubOtpLog.jsp",
                crossDomain	: true,
                data 		: {
                    AGTID 			: AGTID,
                    USRID 			: USRID,
                    COURSE_AGENT_PK : COURSE_AGENT_PK,
                    CLASS_AGENT_PK 	: CLASS_AGENT_PK,            
                    EVAL_CD 		: EVAL_CD,
                    EVAL_TYPE 		: EVAL_TYPE,
                    CLASS_TME 		: CLASS_TME,
                    m_Ret 			: "T",           
                    m_retCD 		: m_retCD,
                    m_trnID 		: m_trnID, 
                    m_trnDT 		: m_trnDT           
                },
                dataType	: "xml",
                success		: function(xml) {
                    if($(xml).find("RetVal").text() == "101" ) { 

                        //alert("대체인증이 성공적으로 이루어졌습니다.");
						//opener.parent.AgreeFormShow();
						//self.close();
							
                        <?php if($_GET['type']==''){ ?> //입과, 진도
							
							//인증 처리 성공시 DB작업----------------------------------------------------------------
							$.post("/player/play_study_auth_insert.php",
							{
								'LectureCode': COURSE_AGENT_PK,
								'Study_Seq': '<?=$Study_Seq?>',
								'Chapter_Seq': '<?=$Chapter_Seq?>',
								'CertType': 'user',
								'AGTID': AGTID,
								'COURSE_AGENT_PK': COURSE_AGENT_PK,
								'CLASS_AGENT_PK': CLASS_AGENT_PK,
								'm_Ret': 'T',
								'm_retCD': m_retCD,
								'm_trnID': m_trnID,
								'm_trnDT': m_trnDT
							},function(data){

								if(data=="Y") {
									alert("대체인증이 성공적으로 완료되었습니다.");
									self.close();
									opener.parent.DataResultClose();
									opener.parent.Play('<?=$Chapter_Number?>',COURSE_AGENT_PK,'<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$mode?>');
								}else{
									alert("대체인증을 실패했습니다.\n\n다시 시도해주세요.");
									self.close();
								}

							});
							//인증 처리 성공시 DB작업----------------------------------------------------------------
							
						<?php }else{ ?> //시험, 과제
							alert("대체인증이 성공적으로 완료되었습니다.");
							opener.parent.AgreeFormShow();
							self.close();
						<?php }	?>	

                    } else {
						alert("대체인증을 실패했습니다.");						
                    }	

                },
                error : function(xhr, textStatus, error) {
                    alert("오류발생 : " + error);
				}


			})
		}
	
		function apiSendHrd101() { //인증 성공

			if ( CLASS_TME  == '00') {
					AUTH_TYPE = '101';
			}
			
			$.ajax({
				method		: "POST",
				url			: "/api/apiSendHrd.php",
				dataType	: "json",
				data		: {
						AGTID 			: AGTID,
						USRID 			: USRID,
						COURSE_AGENT_PK : COURSE_AGENT_PK,
						CLASS_AGENT_PK 	: CLASS_AGENT_PK,
						m_Ret 			: "T",
						m_retCD 		: m_retCD,
						m_trnID 		: m_trnID,
						m_trnDT 		: m_trnDT,
						EVAL_CD 		: EVAL_CD,
						EVAL_TYPE 		: EVAL_TYPE,
						CLASS_TME 		: CLASS_TME,
						CERTIFIED		: CERTIFIED,
						AUTH_TYPE 		: AUTH_TYPE,
						RET_VAL			: '101'
				}
					
			});	

		}
		
		function apiSendHrd102() { // 인증 실패

        if ( CLASS_TME  == '00') {
                AUTH_TYPE = '101';
        }	

        $.ajax({
            method		: "POST",
            url			: "/api/apiSendHrd.php",
            dataType	: "json",
            data		: {
                    AGTID 			: AGTID,
                    USRID 			: USRID,
                    COURSE_AGENT_PK : COURSE_AGENT_PK, 
                    CLASS_AGENT_PK 	: CLASS_AGENT_PK,
                    m_Ret 			: "F",
                    m_retCD 		: m_retCD,
                    m_trnID 		: m_trnID,
                    m_trnDT 		: m_trnDT,
                    EVAL_CD 		: EVAL_CD,
                    EVAL_TYPE 		: EVAL_TYPE,
                    CLASS_TME 		: CLASS_TME,
                    CERTIFIED		: CERTIFIED,
                    AUTH_TYPE 		: AUTH_TYPE,
                    RET_VAL			: '102'
            }
        });

    }		
		


</script>
</head>

<body>

  <div class="canvas">
    <h2>MOTP 인증</h2>
		<img src="/images/motp.png" alt="인증 이미지">
		<p>훈련기관 MOTP를 실행하여<br>
	    6자리 숫자의 인증 번호를 입력해주세요.</p>
		<div>
		  <input type="text" id="otpNo" placeholder="OTP 번호" onfocus="this.placeholder=''" onblur="this.placeholder='OTP 번호'">
		</div>
		<div>
		  <input type="text" id="userTel" placeholder="회원 전화번호" onfocus="this.placeholder=''" onblur="this.placeholder='회원 전화번호'">
		</div>
		<div>
		  <button type="button" onclick="fn_otpAccredit();">인증하기</button>
		</div> 
        <br>

		<style>
			#other_otp button{
				width: 30%;
				display: inline-block;
				min-width:0;
				margin: 0 30px;
				
			}
			#other_otp{
			text-align: center;
				overflow: hidden;
				background: #fff;
				padding: 20px 0;
				margin-top: 50px;
				border-bottom: 1px solid #ddd;;
			}
		</style>
		
		<?php if($EVAL_CD != '00'){ ?>
		<div id="other_otp" >
			<div class="red">※<strong style="color:blue;">mOTP </strong>사용이 불가능할 경우 <br>아래 대체 수단으로 본인인증 해주시기 바랍니다.</div>
			<br>
	        <button type="button" onclick="fnPopup();" class="btnPhone" style="background:#cc00ff">휴대폰 인증하기</button>
		</div>
		<?php } ?>
    </div>

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
$returnurl = $SiteURL."/lib/CheckPlusSafe/checkplus_success_etc.php";	// 성공시 이동될 URL
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

<form name="form_chk" method="post">
    <input type="hidden" name="m" value="checkplusSerivce">
    <input type="hidden" name="EncodeData" value="<?= $enc_data ?>">
    <input type="hidden" name="param_r1" value="">
    <input type="hidden" name="param_r2" value="">
    <input type="hidden" name="param_r3" value="">
</form>

<form name="form_ipin" method="post">
    <input type="hidden" name="m" value="pubmain">
    <input type="hidden" name="enc_data" value="<?= $sEncData ?>">
	<input type="hidden" name="param_r1" value="<?=$LectureCode?>">
    <input type="hidden" name="param_r2" value="">
    <input type="hidden" name="param_r3" value="">
</form>

<form name="vnoform" method="post">
    <input type="hidden" name="enc_data">
    <input type="hidden" name="param_r1" value="">
    <input type="hidden" name="param_r2" value="">
    <input type="hidden" name="param_r3" value="">
</form>

<iframe src="https://fds.hrdkorea.or.kr/fdsService/Library/hrdFrame.jsp?agtID=<?=$captcha_agent_id?>&usrID=<?=$LoginMemberID?>&sessionID=<?=session_id();?>" width="0" height="0" Style="display:none" />

</body>
</html>