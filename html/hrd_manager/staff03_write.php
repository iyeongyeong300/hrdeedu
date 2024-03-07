<?
$MenuType = "A";
$PageName = "staff03";
$ReadPage = "staff03_read";
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
            <h2>첨삭강사 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT *, (SELECT DeptString FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptString FROM StaffInfo WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$ID = $Row['ID']; //아이디
		$Dept_idx = $Row['Dept_idx']; //부서(DeptStructure) idx값
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

	mysqli_free_result($Result);

}
?>

                <!-- 입력 -->
				<form name="Form1" method="post" action="staff03_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="Dept_idx" id="Dept_idx" value="<?=$Dept_idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
				  <?if($mode=="edit") {?>
                  <tr>
                    <th>등록된 카테고리</th>
                    <td><?=$DeptStringName?></td>
                  </tr>
				  <?}?>
                  <tr>
                    <th>카테고리</th>
                    <td><span id="DeptCategorySelected"></span>&nbsp;<button type="button" onclick="DeptCategorySelect('C');" class="btn round btn_LBlue line"><i class="xi-folder-open"></i> 카테고리 찾기</button></td>
                  </tr>
				  <?if($mode=="new") {?>
				  <tr>
                    <th>아이디</th>
                    <td><input name="ID" id="ID" type="text"  size="40" value="" maxlength="30">&nbsp;&nbsp;<button type="button" onclick="IDCheck();" class="btn round btn_LBlue line">중복 검색</button>&nbsp;&nbsp;&nbsp;&nbsp;<span id="id_check_msg"></span></td>
                  </tr>
				  <?}else{?>
				  <tr>
                    <th>아이디</th>
                    <td><?=$ID?></td>
                  </tr>
				  <?}?>
                  <tr>
                    <th>이&nbsp;&nbsp;름</th>
                    <td><input name="Name" type="text"  size="40" value="<?=$Name?>"></td>
                  </tr>
                  <tr>
                    <th>소&nbsp;&nbsp;속</th>
                    <td><input name="Team" type="text"  size="40" value="<?=$Team?>"></td>
                  </tr>
				  <?if($mode=="new") {?>
				  <tr>
                    <th>비밀번호</th>
                    <td><input name="Pwd" type="text"  size="40" value="1111"></td>
                  </tr>
				  <?}?>
                  <tr>
                    <th>휴대폰</th>
                    <td><input name="Mobile01" type="text"  size="6" value="<?=$Mobile01?>" maxlength="3"> - <input name="Mobile02" type="text"  size="6" value="<?=$Mobile02?>" maxlength="4"> - <input name="Mobile03" type="text"  size="6" value="<?=$Mobile03?>" maxlength="4"></td>
                  </tr>
                  <tr>
                    <th>연락처</th>
                    <td><input name="Phone01" type="text"  size="6" value="<?=$Phone01?>" maxlength="3"> - <input name="Phone02" type="text"  size="6" value="<?=$Phone02?>" maxlength="4"> - <input name="Phone03" type="text"  size="6" value="<?=$Phone03?>" maxlength="4"></td>
                  </tr>
                  <tr>
                    <th>이메일</th>
                    <td><input name="Email" type="text"  size="40" value="<?=$Email?>"></td>
                  </tr>
				  <tr>
                    <th>계좌정보</th>
                    <td>은행명 : 
						<select name="BankName">
							<option value="">-- 은행 선택 --</option>
							<?while (list($key,$value)=each($Bank_array)) {?>
							<option value="<?=$key?>" <?if($BankName==$key) {?>selected<?}?>><?=$value?></option>
							<?}?>
						</select>
						&nbsp;&nbsp;계좌번호 : <input name="BankNumber" type="text"  size="25" value="<?=$BankNumber?>"></td>
                  </tr>
				  <tr>
                    <th>사용 여부</th>
                    <td><input type="radio" name="UseYN" id="UseYN2" value="Y" <?if($UseYN=="Y" || !$UseYN) {?>checked<?}?> class="inputN"> <label for="UseYN2">사용</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="UseYN" id="UseYN1" value="N" <?if($UseYN=="N") {?>checked<?}?> class="inputN"> <label for="UseYN1">미사용</label></td>
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

	if(val.Dept_idx.value=="") {
		alert("카테고리를 선택하세요.");
		return;
	}

	<?if($mode=="new") {?>
	if(val.ID.value=="") {
		alert("아이디를 입력하세요.");
		val.ID.focus();
		return;
	}
	<?}?>
	if(val.Name.value=="") {
		alert("이름을 입력하세요.");
		val.Name.focus();
		return;
	}
	if(val.Team.value=="") {
		alert("소속을 입력하세요.");
		val.Team.focus();
		return;
	}
	<?if($mode=="new") {?>
	if(val.Pwd.value=="") {
		alert("비밀번호를 입력하세요.");
		val.Pwd.focus();
		return;
	}
	<?}?>
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

	Yes = confirm("등록하시겠습니까?");
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