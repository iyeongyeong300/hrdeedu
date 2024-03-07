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
$customize 	= "Mobile";		//없으면 기본 웹페이지 / Mobile : 모바일페이지 (default값은 빈값, 환경에 맞는 화면 제공)

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
			<td colspan="2" class="fs24b fc999B pt30">본인 인증</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp</td>
		</tr>
		<tr>
			<td colspan="2" class="info" align="center">원격훈련과정은 입과 시점에 1회 본인인증이 의무화되어 있습니다.</td>
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
							location.reload();
						}else{
							alert("본인 인증처리에 실패하였습니다.");
							location.reload();
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