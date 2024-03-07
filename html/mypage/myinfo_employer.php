<?
include "../include/include_top.php";
?>
        
        <!-- Container -->
        <div id="container">
        	
			<!-- Content -->
            <div class="Content">
            
            	<!-- left -->
            	<?
				include "./include_mypage.php";
				?>
                <!-- left // -->
                
                <!-- content area -->
                <div class="contentArea" id="ContentGo">
                
                	<!-- page Title -->
                	<div class="titleZone">
                    	<h3>회원정보관리</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 회원정보관리</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
<?
$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, AES_DECRYPT(UNHEX(Tel),'$DB_Enc_Key') AS Tel, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay, (SELECT CompanyName FROM Company WHERE CompanyCode=Member.CompanyCode LIMIT 0,1) AS CompanyName FROM Member WHERE ID='$LoginMemberID' AND MemberOut='N' AND UseYN='Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$MemberType = $Row['MemberType']; //회원구분
	$ID = $Row['ID']; //아이디
	$Name = $Row['Name']; //이름
	$BirthDay = $Row['BirthDay']; //생년월일
	$Gender = $Row['Gender']; //성별
	$Email = $Row['Email']; //이메일
	$Tel = $Row['Tel']; //전화번호
	$Mobile = $Row['Mobile']; //휴대폰
	$Zipcode = $Row['Zipcode']; //우편번호
	$Address01 = $Row['Address01']; //주소
	$Address02 = $Row['Address02']; //나머지 주소
	$NameEng = $Row['NameEng']; //영문이름
	$CompanyCode = $Row['CompanyCode']; //소속기업 사업자번호
	$CompanyName = $Row['CompanyName']; //소속기업명
	$Depart = $Row['Depart']; //부서
	$Position = $Row['Position']; //직위
	$Mailling = $Row['Mailling']; //메일링서비스
	$Marketing = $Row['Marketing']; //마케팅 수신 동의
	$PassChange = $Row['PassChange']; //비번 변경여부
	$CardName = $Row['CardName'];
	$CardNumber = $Row['CardNumber'];


	$Tel_Arrary = explode("-",$Tel);
	$Tel01 = $Tel_Arrary[0];
	$Tel02 = $Tel_Arrary[1];
	$Tel03 = $Tel_Arrary[2];

	$Mobile_Arrary = explode("-",$Mobile);
	$Mobile01 = $Mobile_Arrary[0];
	$Mobile02 = $Mobile_Arrary[1];
	$Mobile03 = $Mobile_Arrary[2];

	$CardNumber_Arrary = explode("-",$CardNumber);
	$CardNumber01 = $CardNumber_Arrary[0];
	$CardNumber02 = $CardNumber_Arrary[1];
	$CardNumber03 = $CardNumber_Arrary[2];
	$CardNumber04 = $CardNumber_Arrary[3];

}else{
?>
<script type="text/javascript">
<!--
	alert("회원정보에 문제가 있습니다.\n\n관리자에게 문의하세요.");
	location.href="/member/logout.php";
//-->
</script>
<?
}
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script type="text/javascript">
<!--
function ZipcodeFind() {

	new daum.Postcode({
		oncomplete: function(data) {

			$("#Zipcode").val(data.zonecode);
			$("#Address01").val(data.address);
			$("#Address02").val(data.buildingName);
			$("#Address02").focus();

		}
	}).open();

}
//-->
</script>
                    <!-- info area -->
					<form name="EditForm" method="POST" action="/mypage/myinfo_ok.php" target="ScriptFrame">
					<input type="hidden" name="CompanyCode" id="CompanyCode" value="<?=$CompanyCode?>">
					<input type="hidden" name="MemberType" id="MemberType" value="<?=$MemberType?>">
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <!-- input -->                        
                      <h4 class="tc" style="background:none; padding-top:0;">[ 필수정보 ]</h4>
                  		<div class="join_input">
                            <table cellpadding="0">
                              <caption>회원정보 입력</caption>
                              <colgroup>
                                  <col class="wid170" />
                                  <col class="" />
                              </colgroup>
                              <tr>
                                <th>아이디</th>
                                <td><strong><?=$ID?></strong></td>
                              </tr>
                              <tr>
                                <th><label for="Pwd">비밀번호</label></th>
                                <td>
									<input type="password" class="wid310" name="Pwd" id="Pwd" />
                                	<div class="mt7 fc777 fs15">※ 비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용하세요.</div>
								</td>
                              </tr>
                              <tr>
                                <th><label for="Pwd2">비밀번호 확인</label></th>
                                <td>
									<input type="password" class="wid310" name="Pwd2" id="Pwd2" />
                                	<div class="mt7 fc777 fs15">※ 정확한 확인을 위해 비밀번호를 한번 더 입력하세요.</div>
								</td>
                              </tr>
                              <tr>
                                <th>이름</th>
                                <td><?=$Name?></td>
                              </tr>
                              <!-- <tr>
                                <th>생년월일</th>
                                <td>1999-02-02&nbsp;&nbsp;&nbsp;
                               	  <input type="button" name="btn" value="실명인증" class="btnInputSm" onclick=""></td>
                              </tr> -->
                              <tr>
                                <th><label for="Mobile01">휴대폰</label></th>
								<td><input type="text" name="Mobile01" id="Mobile01" class="wid80" value="<?=$Mobile01?>" maxlength="3" />
                                    -
                                    <input type="text" name="Mobile02" id="Mobile02" class="wid100" value="<?=$Mobile02?>" maxlength="4" />
                                    -
                                <input type="text" name="Mobile03" id="Mobile03" class="wid100" value="<?=$Mobile03?>" maxlength="4" /></td>
                              </tr>
                              <tr>
                                <th><label for="Email">이메일</label></th>
								<td><input type="text" class="wid400" name="Email" id="Email" value="<?=$Email?>" /></td>
                              </tr>
                            </table>
                   	  	</div>
                        
                      	<h4 class="tc" style="background:none; padding-top:0;">[ 추가정보 ]</h4>
                        <div class="join_input">
                            <table cellpadding="0">
                              <caption>회원정보 입력</caption>
                              <colgroup>
                                  <col class="wid170" />
                                  <col class="" />
                              </colgroup>
                              <tr>
                                <th><label for="Address01">주소</label></th>
                                <td><input type="button" name="btn" value="주소검색" class="btnInputSm" onclick="ZipcodeFind();">
                                	<input type="text" name="Zipcode" id="Zipcode" class="wid100" placeholder="우편번호" value="<?=$Zipcode?>" readonly />
                                    <p class="mt5"><input type="text" name="Address01" id="Address01" class="wid530" placeholder="주소" value="<?=$Address01?>" /></p>
                                    <p class="mt5"><input type="text" name="Address02" id="Address02" class="wid530" placeholder="나머지 주소 입력" value="<?=$Address02?>" />
                                    <span class="ml30 fc777 fs15">※ 나머지 주소를 입력하세요.</span></p>
                                </td>
                              </tr>
                              <tr>
                                <th><label for="CompanyName">회사명</label></th>
                                <td><input type="text" name="CompanyName" id="CompanyName" class="wid380" placeholder="회사명 입력" value="<?=$CompanyName?>"  />
                                	<input type="button" name="btn" value="사업주정보 매칭하기" class="btnInputSm" onclick="JoinCompanySearch();"><div id="company_search_result"></div></td>
                              </tr>
                              <tr>
                                <th><label for="Depart">부서</label></th>
                                <td><input type="text" name="Depart" id="Depart" class="wid380" placeholder="부서 입력" value="<?=$Depart?>" /></td>
                              </tr>
                              <tr>
                                <th><label for="Position">직위</label></th>
                                <td><input type="text" name="Position" id="Position" class="wid380" placeholder="직위 입력" value="<?=$Position?>" /></td>
                              </tr>
							  <?if($MemberType=="B") {?>
							  <tr class="grow">
                                <th><label for="CardName">내일배움카드</label></th>
                                <td>
									<select name="CardName" id="CardName" class="wid250">
										<option value="">- 카드사 선택 -</option>
										<?while (list($key,$value)=each($Card_array)) {?>
										<option value="<?=$key?>" <?if($CardName==$key) {?>selected<?}?>><?=$value?></option>
										<?}?>
									</select>
                                    
                                    <span class="ml80 mr10 fcBlue01B">카드번호</span>
                                	<input type="text" name="CardNumber01" id="CardNumber01" class="wid60" value="<?=$CardNumber01?>" maxlength="4" />
                                    <input type="text" name="CardNumber02" id="CardNumber02" class="wid60" value="<?=$CardNumber02?>" maxlength="4" />
                                    <input type="text" name="CardNumber03" id="CardNumber03" class="wid60" value="<?=$CardNumber03?>" maxlength="4" />
                                    <input type="text" name="CardNumber04" id="CardNumber04" class="wid60" value="<?=$CardNumber04?>" maxlength="4" /></td>
                              </tr>
							  <?}else{?>
								<input type="hidden" name="CardName" id="CardName" value="<?=$CardName?>">
								<input type="hidden" name="CardNumber01" id="CardNumber01" value="<?=$CardNumber01?>">
								<input type="hidden" name="CardNumber02" id="CardNumber02" value="<?=$CardNumber02?>">
								<input type="hidden" name="CardNumber03" id="CardNumber03" value="<?=$CardNumber03?>">
								<input type="hidden" name="CardNumber04" id="CardNumber04" value="<?=$CardNumber04?>">
							  <?}?>
                              <tr>
                                <th><label for="Mailling">메일/SMS/알림톡</label></th>
                                <td><span class="inpCheck">
                                  <input type="checkbox" name="Mailling" id="Mailling" value="Y" <?if($Mailling=="Y") {?>checked<?}?>>
                                  <label for="Mailling">메일/SMS/알림톡 수신에 동의합니다.</label></span></td>
                              </tr>
                              <tr>
                                <th><label for="Marketing">마케팅</label></th>
                                <td><span class="inpCheck">
                                  <input type="checkbox" name="Marketing" id="Marketing" value="Y" <?if($Marketing=="Y") {?>checked<?}?>>
                                  <label for="Marketing">마케팅 수신에 동의합니다.</label></span></td>
                              </tr>
                            </table>
                   	  	</div>
   		        		<!-- input // -->
                        
                        <!-- btn -->
						<div class="btnAreaTc04" id="SubmitBtn">
                        	<span class="btnSky01"><a href="Javascript:MemberEdit();" class="wid180">회원정보 변경</a></span>
                        </div>
						<div class="tc mt20" id="WaitMag" style="display:none">
                        	<br><br>처리중입니다. 기다려 주세요.
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
if($PassChange=="N") {
?>
<script type="text/javascript">
$(document).ready(function() {
    // 휴대폰 인증 팝업
    function fnPopup(){
        var currentWidth = $(window).width();
        var LocWidth = (currentWidth / 2);
        var body_width =  screen.width-20;
        var body_height =  $('html body').height()+1000;

        $("div[id='SysBg_Black']").css({
            "width": body_width,
            "height": body_height,
            "opacity":"0.4",
            "position": "absolute",
            "z-index":"2000"
        }).show();

        window.open('', 'popupChk', 'width=500, height=550, top=100, left=400, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
        document.form_chk.action = "https://nice.checkplus.co.kr/CheckPlusSafeModel/checkplus.cb";
        document.form_chk.target = "popupChk";
        document.form_chk.submit();
    }
//    window.location.href = "/new/";
    fnPopup();
//    PassFirstChange('<?=$ID?>');
});
//-->
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
$returnurl = $SiteURL."/lib/CheckPlusSafe/checkplus_success_first.php";	// 성공시 이동될 URL
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
//$sCPRequest = $LectureCode."_".date('YmdHis');

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
    <input type="hidden" name="param_r1" value="<?=$ID?>">
    <input type="hidden" name="param_r2" value="">
    <input type="hidden" name="param_r3" value="">
</form>
<?
}
?>
<?
include "../include/include_bottom.php";
?>