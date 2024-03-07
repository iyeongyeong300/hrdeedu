<?
$MenuType = "A";
$PageName = "company";
$ReadPage = "company_read";
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
            <h2>사업주 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT *, (SELECT Name FROM StaffInfo WHERE ID=Company.SalesManager) AS SalesName FROM Company WHERE idx=$idx AND Del='N'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$CompanyScale = $Row['CompanyScale']; //회사규모
		$CompanyCode = $Row['CompanyCode']; //사업자번호
		$CompanyName = $Row['CompanyName']; //회사명
		$CompanyID = $Row['CompanyID']; //회사아이디
		$HRD = $Row['HRD']; //HRD번호
		$Ceo = $Row['Ceo']; //대표자명
		$Uptae = $Row['Uptae']; //업태
		$Upjong = $Row['Upjong']; //업종
		$Zipcode = $Row['Zipcode']; //우편번호
		$Address01 = $Row['Address01']; //주소
		$Address02 = $Row['Address02']; //상세주소
		$Tel = $Row['Tel']; //대표 연락처
		$Tel2 = $Row['Tel2']; //고객센터 연락처
		$Fax = $Row['Fax']; //대표 FAX
		$Fax2 = $Row['Fax2']; //고객센터 FAX
		$Email = $Row['Email']; //이메일
		$BankName = $Row['BankName']; //은행명
		$BankNumber = $Row['BankNumber']; //계좌번호
		$CSEnabled = $Row['CSEnabled']; //고객센터 번호 사용여부
		$CyberEnabled = $Row['CyberEnabled']; //사이버교육센터 사용여부
		$HomePage = $Row['HomePage']; //홈페이지
		$CyberURL = $Row['CyberURL']; //사이버교육센터 주소
		$EduManager = $Row['EduManager']; //교육담당자명
		$EduManagerPhone = $Row['EduManagerPhone']; //교육담당자 연락처
		$EduManagerEmail = $Row['EduManagerEmail']; //교육담당자 이메일
		$SalesManager = $Row['SalesManager']; //영업담당자 아이디
		$Remark = $Row['Remark']; //메모
		$SalesName = $Row['SalesName']; //영업담당자 이름
		$SendSMS = $Row['SendSMS']; //독려수신 여부

		$Tel_Arrary = explode("-",$Tel);
		$Tel01 = $Tel_Arrary[0];
		$Tel02 = $Tel_Arrary[1];
		$Tel03 = $Tel_Arrary[2];

		$Tel2_Arrary = explode("-",$Tel2);
		$Tel2_01 = $Tel2_Arrary[0];
		$Tel2_02 = $Tel2_Arrary[1];
		$Tel2_03 = $Tel2_Arrary[2];

		$Fax_Arrary = explode("-",$Fax);
		$Fax01 = $Fax_Arrary[0];
		$Fax02 = $Fax_Arrary[1];
		$Fax03 = $Fax_Arrary[2];

		$Fax2_Arrary = explode("-",$Fax2);
		$Fax2_01 = $Fax2_Arrary[0];
		$Fax2_02 = $Fax2_Arrary[1];
		$Fax2_03 = $Fax2_Arrary[2];
	}

	mysqli_free_result($Result);

}

if(!$CyberEnabled) {
	$CyberEnabled = "N";
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
                <!-- 입력 -->
				<form name="Form1" method="post" action="company_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" id="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" id="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="SalesManager" id="SalesManager" value="<?=$SalesManager?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>회사 규모</th>
                    <td>
					<select name="CompanyScale">
						<?while (list($key,$value)=each($CompanyScale_array)) {?>
						<option value="<?=$key?>" <?if($CompanyScale==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					</td>
                  </tr>
                  <tr>
                    <th>회사명</th>
                    <td><input name="CompanyName" id="CompanyName" type="text"  size="80" value="<?=$CompanyName?>"></td>
                  </tr>
				  <?if($mode=="new") {?>
				  <tr>
                    <th>사업자 번호</th>
                    <td><input name="CompanyCode" id="CompanyCode" type="text"  size="20" value="<?=$CompanyCode?>" maxlength="10">&nbsp;&nbsp;<input type="button" value="중복 검색" onclick="CompanyCodeCheck();" class="btn_inputLine01" >&nbsp;&nbsp;&nbsp;&nbsp;<span id="CompanyCode_check_msg"></span></td>
                  </tr>
				  <?}else{?>
				  <tr>
                    <th>사업자 번호</th>
                    <td><?=$CompanyCode?></td>
                  </tr>
				  <?}?>
                  <tr>
                    <th>HRD 번호</th>
                    <td><input name="HRD" id="HRD" type="text"  size="40" value="<?=$HRD?>"></td>
                  </tr>
				  <?if($mode=="new") {?>
                  <tr>
                    <th>사업주 ID</th>
                    <td><input name="CompanyID" id="CompanyID" type="text"  size="20" value="<?=$CompanyID?>">&nbsp;&nbsp;<input type="button" value="중복 검색" onclick="CompanyIDCheck();" class="btn_inputLine01" >&nbsp;&nbsp;&nbsp;&nbsp;<span id="CompanyID_check_msg"></span></td>
                  </tr>
				  <?}else{?>
                  <tr>
                    <th>사업주 ID</th>
                    <td><?=$CompanyID?></td>
                  </tr>
				  <?}?>
                  <tr>
                    <th>대표자명</th>
                    <td><input name="Ceo" id="Ceo" type="text"  size="40" value="<?=$Ceo?>"></td>
                  </tr>
                  <tr>
                    <th>대표 전화번호</th>
                    <td>
					<input name="Tel01" id="Tel01" type="text"  size="6" value="<?=$Tel01?>" maxlength="3"> - <input name="Tel02" id="Tel02" type="text"  size="6" value="<?=$Tel02?>" maxlength="4"> - <input name="Tel03" id="Tel03" type="text"  size="6" value="<?=$Tel03?>" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;
					<font color="#555">고객센터 전화번호</font>
					<input name="Tel2_01" id="Tel2_01" type="text"  size="6" value="<?=$Tel2_01?>" maxlength="3"> - <input name="Tel2_02" id="Tel2_02" type="text"  size="6" value="<?=$Tel2_02?>" maxlength="4"> - <input name="Tel2_03" id="Tel2_03" type="text"  size="6" value="<?=$Tel2_03?>" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="CSEnabled" id="CSEnabled" value="Y" <?if($CSEnabled=="Y") {?>checked<?}?> style="width:18px"> <label for="CSEnabled">고객센터 번호 사용</label></td>
                  </tr>
                  <tr>
                    <th>대표 팩스번호</th>
                    <td>
					<input name="Fax01" id="Fax01" type="text"  size="6" value="<?=$Fax01?>" maxlength="3"> - <input name="Fax02" id="Fax02" type="text"  size="6" value="<?=$Fax02?>" maxlength="4"> - <input name="Fax03" id="Fax03" type="text"  size="6" value="<?=$Fax03?>" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;
					<font color="#555">고객센터 팩스번호</font>
					<input name="Fax2_01" id="Fax2_01" type="text"  size="6" value="<?=$Fax2_01?>" maxlength="3"> - <input name="Fax2_02" id="Fax2_02" type="text"  size="6" value="<?=$Fax2_02?>" maxlength="4"> - <input name="Fax2_03" id="Fax2_03" type="text"  size="6" value="<?=$Fax2_03?>" maxlength="4"></td>
                  </tr>
                  <tr>
                    <th>업태/업종</th>
                    <td><input name="Uptae" id="Uptae" type="text"  size="30" value="<?=$Uptae?>"> <input name="Upjong" id="Upjong" type="text"  size="30" value="<?=$Upjong?>"></td>
                  </tr>
				  <tr>
                    <th>주소</th>
                    <td><input name="Zipcode" id="Zipcode" type="text"  size="10" value="<?=$Zipcode?>">&nbsp;&nbsp;<input type="button" value="주소 찾기" onclick="ZipcodeFind();" class="btn_inputLine01">
					<p><input name="Address01" id="Address01" type="text"  size="60" value="<?=$Address01?>"> <input name="Address02" id="Address02" type="text"  size="60" value="<?=$Address02?>"></p></td>
                  </tr>
				  <tr>
                    <th>계좌정보</th>
                    <td>
					은행명 : 
					<select name="BankName">
						<option value="">-- 은행 선택 --</option>
						<?while (list($key,$value)=each($Bank_array)) {?>
						<option value="<?=$key?>" <?if($BankName==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					&nbsp;&nbsp;계좌번호 : <input name="BankNumber" type="text"  size="25" value="<?=$BankNumber?>">
					</td>
                  </tr>
				  <tr>
                    <th>이메일</th>
                    <td><input name="Email" id="Email" type="text"  size="60" value="<?=$Email?>"></td>
                  </tr>
				  <tr>
                    <th>홈페이지</th>
                    <td><input name="HomePage" id="HomePage" type="text"  size="60" value="<?=$HomePage?>"></td>
                  </tr>
				  <tr>
                    <th>사이버교육센터 주소</th>
                    <td><input name="CyberURL" id="CyberURL" type="text"  size="60" value="<?=$CyberURL?>">&nbsp;&nbsp;&nbsp;&nbsp;
					사이버교육센터 사용여부 : 
					<select name="CyberEnabled">
						<?while (list($key,$value)=each($CyberEnabled_array)) {?>
						<option value="<?=$key?>" <?if($CyberEnabled==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select></td>
                  </tr>
				  <tr>
                    <th>교육담당자명</th>
                    <td><input name="EduManager" id="EduManager" type="text"  size="40" value="<?=$EduManager?>"></td>
                  </tr>
				  <tr>
                    <th>교육담당자<br>연락처</th>
                    <td><input name="EduManagerPhone" id="EduManagerPhone" type="text"  size="40" value="<?=$EduManagerPhone?>"></td>
                  </tr>
				  <tr>
                    <th>교육담당자<br>이메일</th>
                    <td><input name="EduManagerEmail" id="EduManagerEmail" type="text"  size="40" value="<?=$EduManagerEmail?>"></td>
                  </tr>
				  <tr>
                    <th>영업담당자명</th>
                    <td><input name="SalesName" id="SalesName" type="text"  size="20" value="<?=$SalesName?>"> <input type="button" value="검색" onclick="SalesManagerSearch();" class="btn_inputLine01">&nbsp;&nbsp;<span id="SalesManagerHtml"></span></td>
                  </tr>
				  <tr>
                    <th>메모</th>
                    <td><input name="Remark" id="Remark" type="text"  size="80" value="<?=$Remark?>"></td>
                  </tr>
				  <tr>
                    <th>독려문자 수신</th>
                    <td>
					<select name="SendSMS">
						<?while (list($key,$value)=each($CompanySMS_array)) {?>
						<option value="<?=$key?>" <?if($SendSMS==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					</td>
                  </tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
                	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="SubmitOk()">
          			<input type="button" name="ResetBtn" id="ResetBtn" value="다시 작성" class="btn_inputLine01" onClick="location.reload();">
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

	if(val.CompanyName.value=="") {
		alert("회사명을 입력하세요.");
		val.CompanyName.focus();
		return;
	}

	<?if($mode=="new") {?>
	if(val.CompanyCode.value=="") {
		alert("사업자번호를 입력하세요.");
		val.CompanyCode.focus();
		return;
	}
	if(val.CompanyID.value=="") {
		alert("사업주 아이디를 입력하세요.");
		val.CompanyID.focus();
		return;
	}
	<?}?>

	if($("#EduManagerTemp").length>0) {

		if($("#EduManagerTemp option:selected").val()=="") {
			alert("교육담당자를 선택하세요.");
			return;
		}

		$("#EduManager").val($("#EduManagerTemp").val());

	}

	if($("#SalesManagerTemp").length>0) {

		if($("#SalesManagerTemp").val()=="") {
			alert("영업담당자를 선택하세요.");
			return;
		}

		$("#SalesManager").val($("#SalesManagerTemp").val());

	}

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