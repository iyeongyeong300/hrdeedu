<?
$MenuType = "Z";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>정보변경</h2>
            
            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT *, (SELECT DeptString FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptString FROM StaffInfo WHERE ID='$LoginAdminID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ID = $Row['ID']; //아이디
	$Dept_idx = $Row['Dept_idx']; //부서(DeptStructure) idx값
	$Dept = $Row['Dept']; //관리자 구분
	$Name = $Row['Name']; //이름
	$Team = $Row['Team']; //소속
	$Mobile = $Row['Mobile']; //휴대폰
	$Phone = $Row['Phone']; //연락처
	$Email = $Row['Email']; //이메일
	$UseYN = $Row['UseYN']; //사용유무
	$DeptString = $Row['DeptString']; //카테고리 정보
	$BankName = $Row['BankName']; //은행명
	$BankNumber = $Row['BankNumber']; //은행 계좌번호

	$Mobile_Arrary = explode("-",$Mobile);
	$Mobile01 = $Mobile_Arrary[0];
	$Mobile02 = $Mobile_Arrary[1];
	$Mobile03 = $Mobile_Arrary[2];

	$Phone_Arrary = explode("-",$Phone);
	$Phone01 = $Phone_Arrary[0];
	$Phone02 = $Phone_Arrary[1];
	$Phone03 = $Phone_Arrary[2];

	$DeptStringName = DeptStringNaming($DeptString);
}

?>
                <!-- 입력 -->
				<form name="Form1" method="post" action="my_info_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>카테고리</th>
                    <td><?=$DeptStringName?></td>
                  </tr>
                  <tr>
                    <th>아이디</th>
                    <td><?=$ID?></td>
                  </tr>
				  <tr>
                    <th>이&nbsp;&nbsp;름</th>
                    <td><?=$Name?></td>
                  </tr>
                  <tr>
                    <th>소&nbsp;&nbsp;속</th>
                    <td><input name="Team" type="text" id="Team" class="wid300" value="<?=$Team?>" /></td>
                  </tr>
                  <tr>
                    <th>비밀번호</th>
                    <td><input name="Passwd" type="password" class="wid200" value="********" disabled>&nbsp;<input type="checkbox" name="PwdChange" id="PwdChange" value="Y" onclick="PassChange()" style="width:18px">&nbsp;<label for="PwdChange">* 비밀번호 변경시 체크하세요. (비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용해야합니다.) </label></td>
                  </tr>
				  <tr>
                    <th>비밀번호 재입력</th>
                    <td><input name="Passwd2" type="password" class="wid200" value="********" disabled>&nbsp;&nbsp;* 비밀번호는 암호화 되어 저장되어 있습니다. 확인은 불가능하며 변경만 가능합니다.</td>
                  </tr>
				  <tr>
                    <th>휴대폰</th>
                    <td><input name="Mobile01" type="text"  class="wid100" value="<?=$Mobile01?>" maxlength="3"> - <input name="Mobile02" type="text"  class="wid100" value="<?=$Mobile02?>" maxlength="4"> - <input name="Mobile03" type="text"  class="wid100" value="<?=$Mobile03?>" maxlength="4"></td>
                  </tr>
				  <tr>
                    <th>연락처</th>
                    <td><input name="Phone01" type="text"  class="wid100" value="<?=$Phone01?>" maxlength="3"> - <input name="Phone02" type="text"  class="wid100" value="<?=$Phone02?>" maxlength="4"> - <input name="Phone03" type="text"  class="wid100" value="<?=$Phone03?>" maxlength="4"></td>
                  </tr>
				  <?if($Dept=="B" || $Dept=="C") {?>
				  <tr>
                    <th>계좌정보</th>
                    <td>은행명 : <input name="BankName" type="text"  class="wid120" value="<?=$BankName?>">&nbsp;&nbsp;계좌번호 : <input name="BankNumber" type="text"  class="wid300" value="<?=$BankNumber?>"></td>
                  </tr>
				  <?}?>
				  <tr>
                    <th>이메일</th>
                    <td><input name="Email" type="text" id="Email" class="wid300" value="<?=$Email?>" /></td>
                  </tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
                	<input type="button" name="Submit" id="Submit" value="수정 하기" class="btn_inputBlue01" onClick="SubmitOk()">
                </div>
				<div class="btnAreaTc02" id="Waiting" style="display:none">
                	<strong>처리중입니다...</strong>
                </div>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
<SCRIPT LANGUAGE="JavaScript">
<!--
function PassChange() {

val = document.Form1;

	if(val.PwdChange.checked==true) {

		val.Passwd.disabled = false;
		val.Passwd2.disabled = false;

		val.Passwd.value = "";
		val.Passwd2.value = "";
		val.Passwd.focus();

	}else{

		val.Passwd.disabled = true;
		val.Passwd2.disabled = true;

		val.Passwd.value = "********";
		val.Passwd2.value = "********";
		val.Name.focus();

	}

}

function SubmitOk() {

	val = document.Form1;

	if(val.Team.value=="") {
		alert("소속을 입력하세요.");
		val.Team.focus();
		return;
	}

	if(val.PwdChange.checked==true) {

		if(val.Passwd.value=="") {
			alert("비밀번호를 입력하세요.");
			val.Passwd.focus();
			return;
		}
		
		if (CheckPassword(val.Passwd.value) == false) {
			val.Passwd.focus();
			return;
		}
		
		if(val.Passwd2.value=="") {
			alert("비밀번호를 재입력하세요.");
			val.Passwd2.focus();
			return;
		}
		
		if(val.Passwd.value!=val.Passwd2.value) {
			alert("비밀번호가 일치하지 않습니다.");
			val.Passwd.value = "";
			val.Passwd2.value = "";
			val.Passwd.focus();
			return;
		}

	}


	if(val.Mobile01.value=="") {
		alert("휴대폰을 입력하세요.");
		val.Mobile01.focus();
		return;
	}
	if(val.Mobile02.value=="") {
		alert("휴대폰을 입력하세요.");
		val.Mobile02.focus();
		return;
	}
	if(val.Mobile03.value=="") {
		alert("휴대폰을 입력하세요.");
		val.Mobile03.focus();
		return;
	}
	if(val.Email.value=="") {
		alert("이메일을 입력하세요.");
		val.Email.focus();
		return;
	}

	Yes = confirm("수정 하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}

//비밀번호 유효성 체크
//비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용해야합니다. 
function CheckPassword(str) {	
	if (/(\w)\1\1\1\1\1/.test(str) || isContinuedValue(str, 6)) {
		alert('비밀번호에 6자 이상의 연속 또는 반복 문자 및 숫자를 사용하실 수 없습니다.');
		return false;
	}

	var pwRule1 = /^(?=.*[a-zA-Z])(?=.*[0-9]).{10,}$/;
    var pwRule2 = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-]).{10,}$/;
    var pwRule3 = /^(?=.*[0-9])(?=.*[!@#$%^*+=-]).{10,}$/;
    var pwRule4 = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,}$/;
	var pwVaild = false;

	if(str.length >= 10) {
		if(pwRule1.test(str) && (str.search(/[a-z]/ig) >= 0) && (str.search(/[0-9]/g) >= 0)) {
			pwVaild = true;
		}

		if(pwRule2.test(str) && (str.search(/[a-z]/ig) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
			pwVaild = true;
		}

		if(pwRule3.test(str) && (str.search(/[0-9]/g) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
			pwVaild = true;
		}
	} else if(str.length >= 8) {
		if(pwRule4.test(str)) {
			if((str.search(/[a-z]/ig) >= 0) && (str.search(/[0-9]/g) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
				pwVaild = true;
			}
		}
	}

	if(pwVaild==false){
		alert('비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용하세요.');
		return false;
	}
	
	return true;
}

function isContinuedValue(str, limit) {
	var o, d, p, n = 0, l = limit == null ? 4 : limit;
    for (var i = 0; i < str.length; i++) {
        var c = str.charCodeAt(i);
        if (i > 0 && (p = o - c) > -2 && p < 2 && (n = p == d ? n + 1 : 0) > l - 3) 
            return true;
            d = p, o = c;
    }
    return false;
}

//-->
</SCRIPT>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>