<?
$MenuType = "G";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>사이트 정보 관리</h2>
            
            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM SiteInfomation ORDER BY RegDate DESC LIMIT 0,1";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyName = $Row['CompanyName'];
	$Ceo = $Row['Ceo'];
	$CompanyNumber = $Row['CompanyNumber'];
	$SalesReportNumber = $Row['SalesReportNumber'];
	$Phone = $Row['Phone'];
	$Fax = $Row['Fax'];
	$Email = $Row['Email'];
	$PersonalInformationManager = $Row['PersonalInformationManager'];
	$Address = $Row['Address'];
	$Copyright = $Row['Copyright'];
}
?>
                <!-- 입력 -->
				<form name="Form1" method="post" action="site_info_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="140px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>상호명</th>
                    <td><input name="CompanyName" type="text" id="CompanyName" class="wid600" value="<?=$CompanyName?>" /></td>
                  </tr>
                  <tr>
                    <th>대표자명</th>
                    <td><input name="Ceo" type="text" id="Ceo" class="wid600" value="<?=$Ceo?>" /></td>
                  </tr>
				  <tr>
                    <th>사업자등록번호</th>
                    <td><input name="CompanyNumber" type="text" id="CompanyNumber" class="wid600" value="<?=$CompanyNumber?>" /></td>
                  </tr>
				  <tr>
                    <th>통신판매업신고번호</th>
                    <td><input name="SalesReportNumber" type="text" id="SalesReportNumber" class="wid600" value="<?=$SalesReportNumber?>" /></td>
                  </tr>
				  <tr>
                    <th>고객상담센터 번호</th>
                    <td><input name="Phone" type="text" id="Phone" class="wid600" value="<?=$Phone?>" /></td>
                  </tr>
				  <tr>
                    <th>FAX</th>
                    <td><input name="Fax" type="text" id="Fax" class="wid600" value="<?=$Fax?>" /></td>
                  </tr>
				  <tr>
                    <th>이메일</th>
                    <td><input name="Email" type="text" id="Email" class="wid600" value="<?=$Email?>" /></td>
                  </tr>
				  <tr>
                    <th>개인정보책임자</th>
                    <td><input name="PersonalInformationManager" type="text" id="PersonalInformationManager" class="wid600" value="<?=$PersonalInformationManager?>" /></td>
                  </tr>
				  <tr>
                    <th>주소</th>
                    <td><input name="Address" type="text" id="Address" class="wid600" value="<?=$Address?>" /></td>
                  </tr>
				  <tr>
                    <th>Copyright</th>
                    <td><input name="Copyright" type="text" id="Copyright" class="wid600" value="<?=$Copyright?>" /></td>
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

function SubmitOk() {

	val = document.Form1;

	if(val.CompanyName.value=="") {
		alert("상호명을 입력하세요.");
		val.CompanyName.focus();
		return;
	}
	if(val.Ceo.value=="") {
		alert("대표자명을 입력하세요.");
		val.Ceo.focus();
		return;
	}
	if(val.CompanyNumber.value=="") {
		alert("사업자번호를 입력하세요.");
		val.CompanyNumber.focus();
		return;
	}
	if(val.SalesReportNumber.value=="") {
		alert("통신판매업신고번호를 입력하세요.");
		val.SalesReportNumber.focus();
		return;
	}
	if(val.Phone.value=="") {
		alert("고객상담센터 번호를 입력하세요.");
		val.Phone.focus();
		return;
	}
	if(val.Fax.value=="") {
		alert("FAX를 입력하세요.");
		val.Fax.focus();
		return;
	}
	if(val.Email.value=="") {
		alert("이메일을 입력하세요.");
		val.Email.focus();
		return;
	}
	if(val.PersonalInformationManager.value=="") {
		alert("개인정보책임자를 입력하세요.");
		val.PersonalInformationManager.focus();
		return;
	}
	if(val.Address.value=="") {
		alert("주소를 입력하세요.");
		val.Address.focus();
		return;
	}
	if(val.Copyright.value=="") {
		alert("Copyright를 입력하세요.");
		val.Copyright.focus();
		return;
	}

	Yes = confirm("등록 하시겠습니까?");
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