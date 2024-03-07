<?
$MenuType = "A";
$PageName = "member";
$ReadPage = "member_read";
?>
<? include "./include/include_top.php"; ?>
<?
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

Switch ($mode) {
	case "new":
		$ScriptTitle = "등록";
	break;
	case "edit":
		$ScriptTitle = "수정";
	break;
	case "del":
		$ScriptTitle = "삭제";
	break;
}
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>수강생 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT *, AES_DECRYPT(UNHEX(ResNo),'$DB_Enc_Key') AS ResNo, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, AES_DECRYPT(UNHEX(Tel),'$DB_Enc_Key') AS Tel, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay, (SELECT CompanyName FROM Company WHERE CompanyCode=Member.CompanyCode LIMIT 0,1) AS CompanyName FROM Member WHERE idx=$idx AND MemberOut='N'";
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
	$Etc01 = $Row['Etc01']; //관심분야
	$Etc02 = $Row['Etc02']; //가입경로
	$Mailling = $Row['Mailling']; //메일링서비스
	$ACS = $Row['ACS']; //메일링서비스
	$Marketing = $Row['Marketing']; //마케팅 수신동의
	$EduManager = $Row['EduManager']; //교육담당자 여부
	$UseYN = $Row['UseYN']; //계정 사용 여부
	$ProtectID = $Row['ProtectID']; //대리수강 방지
	$ResNo = $Row['ResNo']; //주민번호
	//echo $ResNo."<BR>";
	$ResNo1 = substr($ResNo,0,6);
	$ResNo2 = substr($ResNo,6,7);
	$ResNo = $ResNo1."-".$ResNo2;
	//echo $ResNo."<BR>";

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

	$Etc01_Arrary = explode(",",$Etc01);
	$Etc02_Arrary = explode(",",$Etc02);

	$CardNumber_Arrary = explode("-",$CardNumber);
	$CardNumber01 = $CardNumber_Arrary[0];
	$CardNumber02 = $CardNumber_Arrary[1];
	$CardNumber03 = $CardNumber_Arrary[2];
	$CardNumber04 = $CardNumber_Arrary[3];


	}

}

if(!$ACS) {
	$ACS = "Y";
}

if(!$Mailling) {
	$Mailling = "Y";
}

if(!$ProtectID) {
	$ProtectID = "Y";
}

if(!$Marketing) {
	$Marketing = "N";
}
?>
<script src="https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function(){

	$("#BirthDay").datepicker({
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		defaultDate: "<?=$Birth?>",
		yearRange: "1940:<?=date('Y')?>",
		showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
		buttonImage: "images/icn_calendar.gif", //이미지 주소
		buttonImageOnly: true //이미지만 보이기
	});
	$('#BirthDay').val("<?=$BirthDay?>");

	$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
});

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
                <!-- 입력 -->
				<form name="Form1" method="post" action="member_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" id="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" id="idx" value="<?=$idx?>">
				<input type="hidden" name="CompanyCode" id="CompanyCode" value="<?=$CompanyCode?>">
				<input type="hidden" name="Etc01" id="Etc01" value="<?=$Etc01?>">
				<input type="hidden" name="Etc02" id="Etc02" value="<?=$Etc02?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
				  <tr>
                    <th>회원 구분</th>
                    <td>
					<select name="MemberType">
						<?while (list($key,$value)=each($CategoryType_array)) {?>
						<option value="<?=$key?>" <?if($MemberType==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					</td>
                  </tr>
				  <?if($mode=="new") {?>
                  <tr>
                    <th>아이디</th>
                    <td><input name="ID" id="ID" type="text"  size="20" value="<?=$ID?>">&nbsp;&nbsp;
						<button type="button" onclick="MemberIDCheck();" class="btn round btn_LBlue line">중복 검색</button>&nbsp;&nbsp;&nbsp;&nbsp;<span id="id_check_msg"></span>
					</td>
                  </tr>
				  <?}else{?>
                  <tr>
                    <th>아이디</th>
                    <td><?=$ID?></td>
                  </tr>
				  <?}?>
				  <?if($mode=="new") {?>
                  <tr>
                    <th>비밀번호</th>
                    <td><input name="Pwd" type="text"  size="40" value="1111"></td>
                  </tr>
				  <?}?>
                  <tr>
                    <th>이름</th>
                    <td><input name="Name" id="Name" type="text"  size="40" value="<?=$Name?>"></td>
                  </tr>
                  <tr>
                    <th>주민번호</th>
                    <td><input name="ResNo" id="ResNo" type="text"  size="20" value="<?=$ResNo?>" maxlength="14" >&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="jumin_validate_check" id="jumin_validate_check" value="Y" checked style="width:18px"> <label for="jumin_validate_check">주민번호 유효성 체크하기</label> (유효성 체크를 하지 않더라도 앞자리 생년월일과 뒷자리의 첫번째 숫자는 정확하게 입력하세요. 내국인 : 1~4, 외국인 : 5~8)</td>
                  </tr>
                  <tr>
                    <th>성별</th>
                    <td>
					<select name="Gender">
						<option value="">-- 성별 선택 --</option>
						<?while (list($key,$value)=each($Gender_array)) {?>
						<option value="<?=$key?>" <?if($Gender==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					</td>
                  </tr>
                  <tr>
                    <th>이메일</th>
                    <td><input name="Email" id="Email" type="text"  size="60" value="<?=$Email?>"></td>
                  </tr>
				  <tr>
                    <th>전화번호</th>
                    <td><input name="Tel01" id="Tel01" type="text"  size="6" value="<?=$Tel01?>" maxlength="3"> - <input name="Tel02" id="Tel02" type="text"  size="6" value="<?=$Tel02?>" maxlength="4"> - <input name="Tel03" id="Tel03" type="text"  size="6" value="<?=$Tel03?>" maxlength="4"></td>
                  </tr>
				  <tr>
                    <th>휴대폰</th>
                    <td><input name="Mobile01" id="Mobile01" type="text"  size="6" value="<?=$Mobile01?>" maxlength="3"> - <input name="Mobile02" id="Mobile02" type="text"  size="6" value="<?=$Mobile02?>" maxlength="4"> - <input name="Mobile03" id="Mobile03" type="text"  size="6" value="<?=$Mobile03?>" maxlength="4"></td>
                  </tr>
				  <tr>
                    <th>주소</th>
                    <td><input name="Zipcode" id="Zipcode" type="text"  size="10" value="<?=$Zipcode?>">&nbsp;&nbsp;<button type="button" onclick="ZipcodeFind();" class="btn round btn_LBlue line"><i class="xi-maker"></i> 주소 찾기</button>
					<p><input name="Address01" id="Address01" type="text"  size="60" value="<?=$Address01?>" placeholder="주소"> <input name="Address02" id="Address02" type="text"  size="60" value="<?=$Address02?>" placeholder="나머지 주소"></p></td>
                  </tr>
				  <tr>
                    <th>영문이름</th>
                    <td><input name="NameEng" id="NameEng" type="text"  size="40" value="<?=$NameEng?>"></td>
                  </tr>
				  <tr>
                    <th>회사명</th>
                    <td><input name="CompanyName" id="CompanyName" type="text"  size="40" value="<?=$CompanyName?>">&nbsp;
						<button type="button" onclick="MemberCompanySearch();" class="btn round btn_LBlue line"><i class="xi-search"></i> 검색</button>&nbsp;&nbsp;<span id="company_search_result"></span>
					</td>
                  </tr>
				  <tr>
                    <th>부서</th>
                    <td><input name="Depart" id="Depart" type="text"  size="40" value="<?=$Depart?>"></td>
                  </tr>
				  <tr>
                    <th>직위</th>
                    <td><input name="Position" id="Position" type="text"  size="40" value="<?=$Position?>"></td>
                  </tr>
				  <tr>
                    <th>관심분야</th>
                    <td>
					<input type="checkbox" name="Etc01Temp" id="Etc01_01" value="일반과정" <?if(in_array("일반과정",$Etc01_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc01_01">일반과정</label>&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="Etc01Temp" id="Etc01_02" value="유아교육" <?if(in_array("유아교육",$Etc01_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc01_02">유아교육</label>&nbsp;
					<input type="checkbox" name="Etc01Temp" id="Etc01_03" value="자격증" <?if(in_array("자격증",$Etc01_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc01_03">자격증</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="Etc01Temp" id="Etc01_04" value="개인환급" <?if(in_array("개인환급",$Etc01_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc01_04">개인환급</label>&nbsp;
					<input type="checkbox" name="Etc01Temp" id="Etc01_05" value="기업환급" <?if(in_array("기업환급",$Etc01_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc01_05">기업환급</label>
					</td>
                  </tr>
				  <tr>
                    <th>가입경로</th>
                    <td>
					<input type="checkbox" name="Etc02Temp" id="Etc02_01" value="인터넷검색" <?if(in_array("인터넷검색",$Etc02_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc02_01">인터넷검색</label>&nbsp;
					<input type="checkbox" name="Etc02Temp" id="Etc02_02" value="SNS" <?if(in_array("SNS",$Etc02_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc02_02">SNS</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name="Etc02Temp" id="Etc02_03" value="직장동료소개" <?if(in_array("직장동료소개",$Etc02_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc02_03">직장동료소개</label>&nbsp;
					<input type="checkbox" name="Etc02Temp" id="Etc02_04" value="홍보책자" <?if(in_array("홍보책자",$Etc02_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc02_04">홍보책자</label>&nbsp;
					<input type="checkbox" name="Etc02Temp" id="Etc02_05" value="기타" <?if(in_array("기타",$Etc02_Arrary)) {?>checked<?}?> style="width:18px" /> <label for="Etc02_05">기타</label>
					</td>
                  </tr>
				  <tr>
                    <th>메일링 서비스</th>
                    <td><input type="checkbox" name="Mailling" id="Mailling" value="Y" <?if($Mailling=="Y") {?>checked<?}?> style="width:18px" /> <label for="Mailling">최신 메일링 서비스를 받겠습니다.</label></td>
                  </tr>
				  <tr>
                    <th>수강확인<br>문자발송</th>
                    <td><input type="checkbox" name="ACS" id="ACS" value="Y" <?if($ACS=="Y") {?>checked<?}?> style="width:18px" /> <label for="ACS">수강확인 문자발송에 동의합니다.</label></td>
                  </tr>
				  <tr>
                    <th>교육담당자 여부</th>
                    <td><input type="checkbox" name="EduManager" id="EduManager" value="Y" <?if($EduManager=="Y") {?>checked<?}?> style="width:18px" /> <label for="EduManager">교육담당자로 설정합니다.</label></td>
                  </tr>
				  <tr>
                    <th>대리수강 방지</th>
                    <td><input type="checkbox" name="ProtectID" id="ProtectID" value="Y" <?if($ProtectID=="Y") {?>checked<?}?> style="width:18px" /><label for="ProtectID">체크 해제시 대리수강 방지를 해제합니다.</label></td>
                  </tr>
				  <tr>
                    <th>내일배움카드</th>
                    <td>
						<select name="CardName" id="CardName" class="wid250">
						<option value="">- 카드사 선택 -</option>
						<?while (list($key,$value)=each($Card_array)) {?>
						<option value="<?=$key?>" <?if($CardName==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
						</select>&nbsp;&nbsp;
						카드번호 : 
						<input type="text" name="CardNumber01" id="CardNumber01" style="width:50px" value="<?=$CardNumber01?>" maxlength="4" />
						<input type="text" name="CardNumber02" id="CardNumber02" style="width:50px" value="<?=$CardNumber02?>" maxlength="4" />
						<input type="text" name="CardNumber03" id="CardNumber03" style="width:50px" value="<?=$CardNumber03?>" maxlength="4" />
						<input type="text" name="CardNumber04" id="CardNumber04" style="width:50px" value="<?=$CardNumber04?>" maxlength="4" />
					</td>
                  </tr>
				  <tr>
                    <th>계정 사용유무</th>
                    <td>
					<select name="UseYN">
						<?while (list($key,$value)=each($UseYN_array)) {?>
						<option value="<?=$key?>" <?if($UseYN==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					</td>
                  </tr>
				  <tr>
                    <th>마케팅 수신동의</th>
                    <td>
					<select name="Marketing">
						<?while (list($key,$value)=each($CompanySMS_array)) {?>
						<option value="<?=$key?>" <?if($Marketing==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					</td>
                  </tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
                	<button type="button" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue" onclick="SubmitOk()"><?=$ScriptTitle?></button>
					<button type="button" name="ResetBtn" id="ResetBtn" class="btn btn_DGray line" onClick="location.reload();">다시 작성</button>
                </div>
				<div class="btnAreaTc02" id="Waiting" style="display:none"><strong>처리중입니다...</strong></div>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function SubmitOk() {

	val = document.Form1;

	<?if($mode=="new") {?>
	if($("#ID").val()=="") {
		alert("아이디를 입력하세요.");
		$("#ID").focus();
		return;
	}

	if($("#Pwd").val()=="") {
		alert("비밀번호를 입력하세요.");
		$("#Pwd").focus();
		return;
	}
	<?}?>

	if($("#Name").val()=="") {
		alert("이름을 입력하세요.");
		return;
	}

	
	if($("#ResNo").val()=="") {
		alert("주민번호를 입력하세요.");
		$("#ResNo").focus();
		return;
	}
	if($("#ResNo").val().length!=14) {
		alert("주민번호를 정확하게 입력하세요.\n\nex)820304-1172917");
		$("#ResNo").focus();
		return;
	}

	var jumin_validate_check_value = $(':checkbox[name="jumin_validate_check"]:checked').val();

	jumin_num = $("#ResNo").val().split("-");
	jumin_num1 = jumin_num[0];
	jumin_num2 = jumin_num[1];

	if(jumin_validate_check_value=="Y") {

		jumin_check = fn_jumin_validate(jumin_num1, jumin_num2);

		if(jumin_check==false) {
			return;
		}

	}else{

		if(jumin_num2.substring(0, 1) == "1" || jumin_num2.substring(0, 1) == "2" || jumin_num2.substring(0, 1) == "3" || jumin_num2.substring(0, 1) == "4" || jumin_num2.substring(0, 1) == "5" || jumin_num2.substring(0, 1) == "6" || jumin_num2.substring(0, 1) == "7" || jumin_num2.substring(0, 1) == "8") {
		
		}else{
			alert("주민번호 두번째 자리의 첫번째 숫자는 1~8의 숫자를 입력하세요.");
			return;
		}

	}

	/*
	if($("#BirthDay").val()=="") {
		alert("생년월일을 입력하세요.");
		return;
	}

	if($("#Email").val()=="") {
		alert("이메일을 입력하세요.");
		$("#Email").focus();
		return;
	}

	if($("#Email").val().length < 8) {
		alert("이메일을 정확하게 입력하세요.");
		$("#Email").focus();
		return;
	}
	*/
	
	if(($("#Email").val()!="")&&($("#Email").val().length < 8)) {
		alert("이메일을 정확하게 입력하세요.");
		$("#Email").focus();
		return;
	}


	if($("#Mobile01").val()=="") {
		alert("휴대폰을 입력하세요.");
		$("#Mobile01").focus();
		return;
	}

	if($("#Mobile02").val()=="") {
		alert("휴대폰을 입력하세요.");
		$("#Mobile02").focus();
		return;
	}

	if($("#Mobile03").val()=="") {
		alert("휴대폰을 입력하세요.");
		$("#Mobile03").focus();
		return;
	}

	if(IsNumber($("#Mobile01").val())==false) {
		alert("휴대폰은 숫자만 입력하세요.");
		$("#Mobile01").focus();
		return;
	}

	if(IsNumber($("#Mobile02").val())==false) {
		alert("휴대폰은 숫자만 입력하세요.");
		$("#Mobile02").focus();
		return;
	}

	if(IsNumber($("#Mobile03").val())==false) {
		alert("휴대폰은 숫자만 입력하세요.");
		$("#Mobile03").focus();
		return;
	}
	/*
	if($("#CompanyCode").val()=="") {
		alert("소속된 회사명을 입력하고 검색하세요.");
		$("#CompanyName").focus();
		return;
	}
	*/

	var Etc01Temp_value = "";
	var Etc01Temp_length = $("input[name='Etc01Temp']").length;

	for(i=0;i<Etc01Temp_length;i++) {
		if($("input[name='Etc01Temp']:eq("+i+")").is(":checked")==true) {
			if(Etc01Temp_value=="") {
				Etc01Temp_value += $("input[name='Etc01Temp']:eq("+i+")").val();
			}else{
				Etc01Temp_value += ","+$("input[name='Etc01Temp']:eq("+i+")").val();
			}
		}
	}
	$("#Etc01").val(Etc01Temp_value);

	var Etc02Temp_value = "";
	var Etc02Temp_length = $("input[name='Etc02Temp']").length;

	for(i=0;i<Etc02Temp_length;i++) {
		if($("input[name='Etc02Temp']:eq("+i+")").is(":checked")==true) {
			if(Etc02Temp_value=="") {
				Etc02Temp_value += $("input[name='Etc02Temp']:eq("+i+")").val();
			}else{
				Etc02Temp_value += ","+$("input[name='Etc02Temp']:eq("+i+")").val();
			}
		}
	}
	$("#Etc02").val(Etc02Temp_value);

	Yes = confirm("<?=$ScriptTitle?> 하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}
//-->
</SCRIPT>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>