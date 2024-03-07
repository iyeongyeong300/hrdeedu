<script type="text/javascript" src="https://fds.hrdkorea.or.kr/fdsService/hrdAPI/hrdFrameLoader.js"></script>
<script type="text/javascript">
<!--
	var session_id = "<?=session_id()?>";
	var agent_id = "<?=$captcha_agent_id?>";
	var user_agent_pk = "<?=$LoginMemberID?>";
	var m_trnDT = "<?=date('Y-m-d H:i:s')?>";
	var course_agent_pk = "<?=$LectureCode?>";
	var class_agent_pk = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";
	var eval_cd = "01";
	var eval_type = "진도";
	var class_tme = "<?=$Chapter_Number?>";
//-->
</script>
<script type="text/javascript" src="./include/otp_study.js"></script>

<div id="OTP" align="center">

				<Table width="100%" align="center">
				<Tr height="50px">
					<Td width="100%" align="CENTER"><br>
						<P><font size="5"><b>OTP 인증</b></font></P>
						<P>&nbsp;</P>
					</Td>
				</Tr>
				<tr>
					<td width="100%" align="center" valign="top"><input type="button" value="OTP 재호출 또는 초기화" onclick="javascript:checkifOtpStatus();" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:180px; height:47px; cursor:pointer; vertical-align:middle;"></td>
				</tr>
				<tr>
					<td width="100%" height="500px" valign="TOP" align="center">
						
						<BR/>
						<!-- **************************************************************************************
							** OTP 프레임 영역 세팅
							**하단 DIV 태그에 OTP 프레임이 위치하게 되므로 반드시 세팅되어 있어야 합니다.
							**Div id는 "hrdOtpFrame"으로 반드시 동일하게 설정되어 있어야합니다.
							**사이즈는 자율적으로 적용하여 주십시오.
						************************************************************************************** -->
						<Div id="hrdOtpFrame" style="width:400px;height:800px; text-align:center"></Div>
					</Td>
				</tr>
				<tr>
					<td width="100%" height="50px" align="center" valign="top" id="OTPInput" style="display:none">
						OTP 비밀번호 입력 : 
						<input type="password" id="otpVal" onclick="javascript:showKeypad(this);" style="width:150px; height:35px; padding-left:10px; vertical-align:middle;" /> <input type="button" value="입력확인" onclick="javascript:validateOtp('aa');" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:80px; height:37px; cursor:pointer; vertical-align:middle;" /><br><br>
					</td>
				</tr>
				
			</Table>

</div>






<script type="text/javascript" src="./include/captcha_study.js"></script>
<!-- 훈련기관에서 넘겨 줄 파라메터 -->
<form id='formAgent' name='formAgent' method='POST'>
	<!-- 인증방법 (ex. A:API,   I: IFrame) -->
	<input type='hidden' id='auth_method' 	name='auth_method'   value='A' >
	<!-- 훈련기관 ID-->
	<input type='hidden' id='agent_id' 	name='agent_id'   value='<?=$captcha_agent_id?>' >
	<!-- 회원ID -->
	<input type='hidden' id='user_agent_pk'   name='user_agent_pk'  value='<?=$LoginMemberID?>' >
	<!--과정코드 -->
	<input type='hidden' id='course_agent_pk'	name='course_agent_pk'   value='<?=$LectureCode?>' >
	<!-- 수업코드 -->
	<input type='hidden' id='class_agent_pk'	name='class_agent_pk'   value='<?=$LectureCode?>,<?=$LectureTerme_idx?>' >	
	<!--평가구분 코드 (ex. 01:진도,  02:시험,  03:과제,  04:진행평가,  99:기타) -->
	<input type='hidden' id='eval_cd'	name='eval_cd' 	value='01' >
	<!-- 평가방법 (ex. '시험_1')-->
	<input type='hidden' id='eval_type'	name='eval_type' 	value='진도_<?=$Chapter_Number?>' >
	<!-- 캡차 사용자 입력 값 (input)-->
	<input type='hidden' id='captchaInput'   name='captchaInput'>
	<!-- 인증 후 돌아갈 페이지 (API 사용시 ''로 설정) -->
	<input type='hidden' id='succ_url' 	name='succ_url'  value='' >
	<!-- 인증 실패 시 돌아갈 페이지 (API 사용시 ''로 설정)-->
	<input type='hidden' id='fail_url' 	name='fail_url'    value='' >
</form>
<div id="captcha" align="center" style="display:none">
	<table border="0">
		<tr align="center">
			<td colspan="2" class="fs24b fc999B pt30">CAPTCHA 인증</td>
		</tr>
		<tr align="center">
			<td colspan="2" class="info">자동등록방지를 위해 보안절차(CAPTCHA)를 거치고 있습니다.</td>
		</tr>
		<tr align="center">
			<td colspan="2" class="pt25"><button id="btnExplain" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:120px; height:35px">화면 음성 설명</button></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp</td>
		</tr>
		<tr>
			<td rowspan="2"><img id="captcha_img" style="width:200px; height:60px; border:3px dotted #A3C552; text-align: center; padding: 10px;" /></td> 
			<td><button id="btnVoice" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:120px; height:35px">음성</button></td>
		<tr>
			<td><button id="btnRefresh" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:120px; height:35px">새로고침</button></td>
		</tr>
		<tr align="center">
			<td colspan="2" class="fs14b fcOrg01 pt50 pb20">그림에 나타나는 보안문자를 입력하여주세요!</td>
		</tr>
		<tr>
			<td><input type="text" id="user_input" style="width:200px; height:35px; vertical-align:middle; padding-left:10px;" /></td>
			<td><button id="btnConfirm" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:120px; height:35px">인증 하기</button></td>
		</tr>
	</table>
</div>

<!-- Layer -->
<div class="layerArea" id="CaptchaFail" style="position:absolute; top:50px; width:100%; display:none">
	<!-- layer area -->
	<div class="testExam">
		<!-- info -->
		<div class="info">
			CAPTCHA 인증에 실패하였습니다.<br />다시 시도하여 주세요.
			<!-- btn -->
			<div class="btnAreaTc01" id="Btn01">
				<span class="btnSmGray01"><a href="Javascript:CaptchaReset();">확인</a></span>
			</div>
			<!-- btn // -->
		</div>
		<!-- info -->
	</div>
	<!-- layer area // -->
</div>
<!-- Layer // -->



<div id="SysBg_White" style="position:absolute; left:0; top:0; z-index:10; width: 100%; height: 100%; background-color: #FFFFFF;display:none;"></div>

<!-- 아래와 같이 CAPTCHA를 호출하고 있는 LMS 페이지 BODY 안에 단말정보 수집 API를 연동하여 주십시오. -->
<!-- <iframe src="https://fds.hrdkorea.or.kr/fdsService/Library/hrdFrame.jsp?agtID=<?=$captcha_agent_id?>&usrID=<?=$LoginMemberID?>&sessionID=<?=session_id();?>" 
width="0" height="0" Style="display:none" /> -->