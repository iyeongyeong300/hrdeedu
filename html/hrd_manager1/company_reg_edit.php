<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$Sql = "SELECT * FROM CompanyExcelTemp WHERE idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyScale = $Row['CompanyScale']; //회사규모
	$CompanyCode = $Row['CompanyCode']; //사업자번호
	$CompanyName = $Row['CompanyName']; //회사명
	$CompanyID = $Row['CompanyID']; //회사아이디
	$HRD = $Row['HRD']; //HRD번호
	$Ceo = $Row['Ceo']; //대표자명
	$Zipcode = $Row['Zipcode']; //우편번호
	$Address01 = $Row['Address01']; //주소
	$Address02 = $Row['Address02']; //상세주소
	$Uptae = $Row['Uptae']; //업태
	$Upjong = $Row['Upjong']; //업종
	$Tel = $Row['Tel']; //대표 연락처
	$Email = $Row['Email']; //이메일
	$EduManager = $Row['EduManager']; //교육담당자명
	$EduManagerPhone = $Row['EduManagerPhone']; //교육담당자 연락처
	$EduManagerEmail = $Row['EduManagerEmail']; //교육담당자 이메일
	$SalesManager = $Row['SalesManager']; //영업담당자 아이디
	$Remark = $Row['Remark']; //메모
	$CyberEnabled = $Row['CyberEnabled']; //사이버교육센터 사용여부
	$Tel2 = $Row['Tel2']; //고객센터 연락처
	$Fax2 = $Row['Fax2']; //고객센터 FAX
	$CSEnabled = $Row['CSEnabled']; //고객센터 번호 사용여부

	$Tel_Arrary = explode("-",$Tel);
	$Tel01 = $Tel_Arrary[0];
	$Tel02 = $Tel_Arrary[1];
	$Tel03 = $Tel_Arrary[2];

	$Tel2_Arrary = explode("-",$Tel2);
	$Tel2_01 = $Tel2_Arrary[0];
	$Tel2_02 = $Tel2_Arrary[1];
	$Tel2_03 = $Tel2_Arrary[2];



	$Fax2_Arrary = explode("-",$Fax2);
	$Fax2_01 = $Fax2_Arrary[0];
	$Fax2_02 = $Fax2_Arrary[1];
	$Fax2_03 = $Fax2_Arrary[2];


}

if(!$CyberEnabled) {
	$CyberEnabled = "N";
}
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>

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

function CompanyEditSubmitOk() {

	val = document.EditForm;

	if(val.CompanyName.value=="") {
		alert("회사명을 입력하세요.");
		val.CompanyName.focus();
		return;
	}
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
	if(val.Ceo.value=="") {
		alert("대표자명을 입력하세요.");
		val.Ceo.focus();
		return;
	}
	if(val.Address01.value=="") {
		alert("주소를 입력하세요.");
		val.Address01.focus();
		return;
	}
	if(val.Uptae.value=="") {
		alert("업태를 입력하세요.");
		val.Uptae.focus();
		return;
	}
	if(val.Upjong.value=="") {
		alert("업종을 입력하세요.");
		val.Upjong.focus();
		return;
	}
	if(val.Tel01.value=="" || val.Tel02.value=="" || val.Tel03.value=="") {
		alert("대표 전화번호를 입력하세요.");
		val.Tel01.focus();
		return;
	}
	if(val.EduManager.value=="") {
		alert("교육담당자명을 입력하세요.");
		val.EduManager.focus();
		return;
	}
	if(val.EduManagerPhone.value=="") {
		alert("교육담당자 연락처를 입력하세요.");
		val.EduManagerPhone.focus();
		return;
	}
	if(val.EduManagerEmail.value=="") {
		alert("교육담당자 이메일을 입력하세요.");
		val.EduManagerEmail.focus();
		return;
	}

	if($("#SalesManagerTemp").length>0) {

		if($("#SalesManagerTemp").val()=="") {
			alert("영업담당자를 선택하세요.");
			return;
		}

		$("#SalesManager").val($("#SalesManagerTemp").val());

	}


	Yes = confirm("수정하시겠습니까?");
	if(Yes==true) {
		val.submit();
	}


}
//-->
</script>

<div id="wrap">

    
    <!-- Content -->
	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>업로드한 엑셀파일 수정</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="EditForm" method="post" action="company_reg_edit_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="idx2" id="idx2" value="<?=$idx?>">
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
				  <tr>
                    <th>사업자 번호</th>
                    <td><input name="CompanyCode" id="CompanyCode" type="text"  size="20" value="<?=$CompanyCode?>" maxlength="10">&nbsp;&nbsp;<input type="button" value="중복 검색" onclick="CompanyCodeCheck();" class="btn_inputLine01" >&nbsp;&nbsp;&nbsp;&nbsp;<span id="CompanyCode_check_msg"></span></td>
                  </tr>
				  <tr>
                    <th>HRD 번호</th>
                    <td><input name="HRD" id="HRD" type="text"  size="40" value="<?=$HRD?>"></td>
                  </tr>
				  <tr>
                    <th>사업주 ID</th>
                    <td><input name="CompanyID" id="CompanyID" type="text"  size="20" value="<?=$CompanyID?>">&nbsp;&nbsp;<input type="button" value="중복 검색" onclick="CompanyIDCheck();" class="btn_inputLine01">&nbsp;&nbsp;&nbsp;&nbsp;<span id="CompanyID_check_msg"></span></td>
                  </tr>
				  <tr>
                    <th>대표자명</th>
                    <td><input name="Ceo" id="Ceo" type="text"  size="40" value="<?=$Ceo?>"></td>
                  </tr>
				  <tr>
                    <th>주소</th>
                    <td><input name="Zipcode" id="Zipcode" type="text"  size="10" value="<?=$Zipcode?>">&nbsp;&nbsp;<input type="button" value="주소 찾기" onclick="ZipcodeFind();" class="btn_inputLine01" >
					<p><input name="Address01" id="Address01" type="text"  size="60" value="<?=$Address01?>"> <input name="Address02" id="Address02" type="text"  size="60" value="<?=$Address02?>"></td>
                  </tr>
				  <tr>
                    <th>업태/업종</th>
                    <td><input name="Uptae" id="Uptae" type="text"  size="30" value="<?=$Uptae?>"> <input name="Upjong" id="Upjong" type="text"  size="30" value="<?=$Upjong?>"></td>
                  </tr>
				  <tr>
                    <th>대표 전화번호</th>
                    <td><input name="Tel01" id="Tel01" type="text"  size="6" value="<?=$Tel01?>" maxlength="3"> - <input name="Tel02" id="Tel02" type="text"  size="6" value="<?=$Tel02?>" maxlength="4"> - <input name="Tel03" id="Tel03" type="text"  size="6" value="<?=$Tel03?>" maxlength="4"></td>
                  </tr>
				  <tr>
                    <th>고객센터</th>
                    <td><font color="#616343">고객센터 전화번호</font>
			<input name="Tel2_01" id="Tel2_01" type="text"  size="6" value="<?=$Tel2_01?>" maxlength="3"> - <input name="Tel2_02" id="Tel2_02" type="text"  size="6" value="<?=$Tel2_02?>" maxlength="4"> - <input name="Tel2_03" id="Tel2_03" type="text"  size="6" value="<?=$Tel2_03?>" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="CSEnabled" id="CSEnabled" value="Y" <?if($CSEnabled=="Y") {?>checked<?}?> > <label for="CSEnabled">고객센터 번호 사용</label>&nbsp;&nbsp;&nbsp;&nbsp;
			<font color="#616343">고객센터 팩스번호</font>
			<input name="Fax2_01" id="Fax2_01" type="text"  size="6" value="<?=$Fax2_01?>" maxlength="3"> - <input name="Fax2_02" id="Fax2_02" type="text"  size="6" value="<?=$Fax2_02?>" maxlength="4"> - <input name="Fax2_03" id="Fax2_03" type="text"  size="6" value="<?=$Fax2_03?>" maxlength="4"></td>
                  </tr>
				  <tr>
                    <th>이메일</th>
                    <td><input name="Email" id="Email" type="text"  size="60" value="<?=$Email?>"></td>
                  </tr>
				  <tr>
                    <th>교육담당자명</th>
                    <td><input name="EduManager" id="EduManager" type="text"  size="40" value="<?=$EduManager?>"></td>
                  </tr>
				  <tr>
                    <th>교육담당자 연락처</th>
                    <td><input name="EduManagerPhone" id="EduManagerPhone" type="text"  size="40" value="<?=$EduManagerPhone?>"></td>
                  </tr>
				  <tr>
                    <th>교육담당자 이메일</th>
                    <td><input name="EduManagerEmail" id="EduManagerEmail" type="text"  size="40" value="<?=$EduManagerEmail?>"></td>
                  </tr>
				  <tr>
                    <th>영업담당자명</th>
                    <td><input name="SalesName" id="SalesName" type="text"  size="20" value="<?=$SalesName?>"> <input type="button" value="검색" onclick="SalesManagerSearch();" class="btn_inputLine01">&nbsp;&nbsp;<span id="SalesManagerHtml"></span></td>
                  </tr>
				  <tr>
                    <th>사이버교육센터</th>
                    <td>
					<select name="CyberEnabled">
						<?while (list($key,$value)=each($CyberEnabled_array)) {?>
						<option value="<?=$key?>" <?if($CyberEnabled==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					</td>
                  </tr>
				  <tr>
                    <th>메모</th>
                    <td><input name="Remark" id="Remark" type="text"  size="80" value="<?=$Remark?>"></td>
                  </tr>
                </table>
				</form>
				<div class="btnAreaTc02" id="EditSubmitBtn">
                	<input type="button" name="SubmitBtn" id="SubmitBtn" value="수정 하기" class="btn_inputBlue01" onclick="CompanyEditSubmitOk()">
          			<input type="button" name="ResetBtn" id="ResetBtn" value="닫기" class="btn_inputLine01" onClick="DataResultClose();">
                </div>
				<div class="btnAreaTc02" id="EditWaiting" style="display:none"><strong>처리중입니다...</strong></div>
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
    <!-- Content // -->


</div>
<?
mysqli_close($connect);
?>