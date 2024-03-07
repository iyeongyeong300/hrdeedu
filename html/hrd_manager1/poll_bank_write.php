<?
$MenuType = "D";
$PageName = "poll_bank";
$ReadPage = "poll_bank_read";
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
            <h2>설문 관리 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT * FROM PollBank WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$Gubun = html_quote($Row['Gubun']); //설문 구분
		$ExamType = $Row['ExamType']; //설문 유형
		$Question = stripslashes($Row['Question']); //질문
		$Example01 = html_quote($Row['Example01']); //예문1
		$Example02 = html_quote($Row['Example02']); //예문2
		$Example03 = html_quote($Row['Example03']); //예문3
		$Example04 = html_quote($Row['Example04']); //예문4
		$Example05 = html_quote($Row['Example05']); //예문5
		$UseYN = $Row['UseYN']; //사용유무
		$OrderByNum = $Row['OrderByNum'];
	}

}

if(!$ExamType) {
	$ExamType = "A";
}

if(!$OrderByNum) {
	$Sql = "SELECT MAX(OrderByNum) FROM PollBank";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	$Max_OrderByNum = $Row[0];

	if(!$Max_OrderByNum) {
		$OrderByNum = 1;
	}else{
		$OrderByNum = $Max_OrderByNum + 1;
	}
}
?>

                <!-- 입력 -->
				<form name="Form1" method="post" action="poll_bank_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>설문구분 선택</th>
                    <td>
					<select name="GubunSelect" id="GubunSelect" onchange="GubunSelected();">
						<option value="">-- 설문구분 선택 --</option>
						<?
						$SQL = "SELECT DISTINCT(Gubun) FROM PollBank WHERE Del='N' ORDER BY Gubun ASC";
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							while($Row = mysqli_fetch_array($QUERY))
							{
						?>
						<option value="<?=$Row['Gubun']?>" <?if($Row['Gubun']==$Gubun) {?>selected<?}?>><?=$Row['Gubun']?></option>
						<?
							}
						}
						?>
					</select>
					</td>
                  </tr>
                  <tr>
                    <th>설문 구분</th>
                    <td><input name="Gubun" id="Gubun" type="text"  size="60" value="<?=$Gubun?>"> (설문구분 선택에 없는 경우 직접 입력하세요.)</td>
                  </tr>
                  <tr>
                    <th>설문 유형</th>
                    <td>
					<?
					$i = 1;
					while (list($key,$value)=each($PollType_array)) {
					?>
					<input type="radio" name="ExamType" id="ExamType<?=$i?>" value="<?=$key?>" <?if($ExamType==$key) {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer" onclick="ExamTypeSelected();"><label for="ExamType<?=$i?>" style="cursor:pointer"><?=$value?></label>&nbsp;&nbsp;&nbsp;&nbsp;
					<?
					$i++;
					}
					?>
					</td>
                  </tr>
				  <tr>
						<th>질문</th>
						<td><textarea name="Question" id="Question" rows="10" cols="100" style="width:750px; height:120px;;"><?=$Question?></textarea></td>
					</tr>
					<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
						<th>보기 1</font></th>
						<td><input name="Example01" id="Example01" type="text"  size="110" value="<?=$Example01?>"></td>
					</tr>
					<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
						<th>보기 2</font></th>
						<td><input name="Example02" id="Example02" type="text"  size="110" value="<?=$Example02?>"></td>
					</tr>
					<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
						<th>보기 3</font></th>
						<td><input name="Example03" id="Example03" type="text"  size="110" value="<?=$Example03?>"></td>
					</tr>
					<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
						<th>보기 4</font></th>
						<td><input name="Example04" id="Example04" type="text"  size="110" value="<?=$Example04?>"></td>
					</tr>
					<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
						<th>보기 5</font></th>
						<td><input name="Example05" id="Example05" type="text"  size="110" value="<?=$Example05?>"></td>
					</tr>
					<tr>
						<th>정렬 순서</font></th>
						<td><input name="OrderByNum" id="OrderByNum" type="text"  size="10" value="<?=$OrderByNum?>"></td>
					</tr>
					<tr>
						<th>사용 여부</font></th>
						<td><input type="radio" name="UseYN" id="UseYN2" value="Y" <?if($UseYN=="Y" || !$UseYN) {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer"> <label for="UseYN2">사용</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="UseYN" id="UseYN1" value="N" <?if($UseYN=="N") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer"> <label for="UseYN1">미사용</label></td>
					</tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
                	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="SubmitOk()">
          			<input type="button" name="ResetBtn" id="ResetBtn" value="목록" class="btn_inputLine01" onclick="location.href='<?=$PageName?>.php'">
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

	var checked_value = $(':radio[name="ExamType"]:checked').val();


	if(val.Gubun.value=="") {
		alert("설문구분을 입력하세요.");
		val.Gubun.focus();
		return;
	}

	if($("#Question").val()=="") {
		alert("질문 내용을 입력하세요.");
		$("#Question").focus();
		return;
	}

	if(checked_value=="A") {
		if($("#Example01").val()=="") {
			alert("보기1을 입력하세요.");
			$("#Example01").focus();
			return;
		}
		if($("#Example02").val()=="") {
			alert("보기2를 입력하세요.");
			$("#Example02").focus();
			return;
		}
	}

	if($("#OrderByNum").val()=="") {
		alert("정렬 순서를 입력하세요.");
		$("#OrderByNum").focus();
		return;
	}

	if(IsNumber($("#OrderByNum").val())==false) {
		alert("정렬 순서는 숫자만 입력하세요.");
		$("#OrderByNum").focus();
		return;
	}

	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}

$(window).load(function() {

ExamTypeSelected(); //설문 유형별로 선택항목 보이기

});



//-->
</SCRIPT>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>