<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의


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
<script type="text/javascript" src="/include/otp_study.js?ver=2021091501"></script>
<script type="text/javascript" src="/include/captcha_study.js?ver=2021091501"></script>
<script type="text/javascript">
<!--
$(document).ready(function() {

	ExecuteFDS();

});

//-->
</script>
</head>
<body>
<?
include "../include/login_check.php";
?>
<div id="wrap">
	
<!-- OTP 영역 -->
<div id="OTP" style="background:#fff; border:solid 5px #f5f5f5; margin-left:0px; width:850px;">

		<table width="740" height="300" align="center" border="0">
			<tr>
				<td height="50px"><br>
					<P><font size="5"><b>OTP 인증</b></font>&nbsp;&nbsp;<input type="button" value="OTP 재호출 또는 초기화" onclick="javascript:checkifOtpStatus();" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:160px; height:47px; cursor:pointer; vertical-align:middle;"></P>
					<P>&nbsp;</P>
				</td>
			</tr>
			<tr>
				<td height="250px" valign="top">
				<Div id="hrdOtpFrame" style="text-align:center"><br><br><img src="/images/loader.gif" alt="로딩중" /><br><br>OTP 모듈을 불러오는 중입니다...</Div>
				
				</td>
			</tr>
			<tr>
				<td height="100px" id="OTPInput" valign="top" style="display:none">
					<strong>OTP 비밀번호 입력 : </strong>
					<input type="password" id="otpVal" onclick="javascript:showKeypad(this);" style="width:200px; height:35px; padding-left:10px; vertical-align:middle;" /> <input type="button" value="입력확인" onclick="javascript:validateOtp('aa');" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:120px; height:37px; cursor:pointer; vertical-align:middle;" />
				</td>
			</tr>
		</table>
		
</div>
<!-- OTP 영역 -->

<!-- 캡차 영역 -->
<div id="captcha" style="background:#fff; border:solid 5px #f5f5f5; margin-left:0px; width:850px;display:none;">

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

	<table width="540" height="430" align="center" border="0">
			<tr>
				<td colspan="2" height="50px"><br>
					<P><font size="5"><b>CAPTCHA 인증</b></font></P>
					<P>&nbsp;</P>
				</td>
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
				<td rowspan="2"><img id="captcha_img" style="width:300px; height:100px; border:3px dotted #A3C552; text-align: center; padding: 10px;" /></td> 
				<td><button id="btnVoice" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:120px; height:35px">음성</button></td>
			<tr>
				<td><button id="btnRefresh" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:120px; height:35px">새로고침</button></td>
			</tr>
			<tr align="center">
				<td colspan="2" class="fs14b fcOrg01 pt50 pb20">그림에 나타나는 보안문자를 입력하여주세요!</td>
			</tr>
			<tr>
				<td><input type="text" id="user_input" style="width:200px; height:35px; vertical-align:middle; padding-left:10px; font-size:16px;font-weight:bold;" /></td>
				<td><button id="btnConfirm" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px; width:120px; height:35px">인증 하기</button></td>
			</tr>
		</table>

</div>
<!-- 캡차 영역 -->

<input type="hidden" name="Chapter_Number" id="Chapter_Number" value="<?=$Chapter_Number?>">
<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
<input type="hidden" name="Study_Seq" id="Study_Seq" value="<?=$Study_Seq?>">
<input type="hidden" name="Chapter_Seq" id="Chapter_Seq" value="<?=$Chapter_Seq?>">
<input type="hidden" name="Contents_idx" id="Contents_idx" value="<?=$Contents_idx?>">
<input type="hidden" name="mode" id="mode" value="<?=$mode?>">

</body>
</html>
<?
mysqli_close($connect);
?>
