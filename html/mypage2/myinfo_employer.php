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
                                <td><input type="password" class="wid310" name="Pwd" id="Pwd" /><span class="ml30 fc777 fs15">※ 숫자와 영문자, 특수문자 조합으로 6~15자리를 사용해야 합니다.</span></td>
                              </tr>
                              <tr>
                                <th><label for="Pwd2">비밀번호 확인</label></th>
                                <td><input type="password" class="wid310" name="Pwd2" id="Pwd2" />
                                	<span class="ml30 fc777 fs15">※ 정확한 확인을 위해 비밀번호를 한번 더 입력해 주세요.</span></td>
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
<!--
$(document).ready(function() {
	PassFirstChange('<?=$ID?>');
});
//-->
</script>
<?
}
?>
<?
include "../include/include_bottom.php";
?>