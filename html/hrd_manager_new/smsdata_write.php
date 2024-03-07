<?
$MenuType = "C";
$PageName = "smsdata";
$ReadPage = "smsdat_read";
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
            <h2>문자/템플릿 관리 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT * FROM SendMessage WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
 		
		$MessageMode = $Row['MessageMode']; 
		$TemplateCode = $Row['TemplateCode']; 
		$Massage = stripslashes($Row['Massage']); //내용
		$TemplateMessage = stripslashes($Row['TemplateMessage']); //내용
	
	}

}
?>

                <!-- 입력 -->
				<form name="Form1" method="post" action="smsdata_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
				<colgroup>
					<col width="120px" />
                    <col width="" />
				</colgroup>
				<tr>
					<th>모드</th>
					<td><input name="MessageMode" type="text"  size="120" value="<?=$MessageMode?>"></td>
				</tr>
				<tr>
					<th>템플릿코드</th>
					<td><input name="TemplateCode" type="text"  size="120" value="<?=$TemplateCode?>"></td>
				</tr>				
				<tr>
					<th>메시지</th>
					<td height="28"><textarea name="TemplateMessage" id="TemplateMessage" rows="10" cols="100" style="width:970px; height:420px;"><?=$TemplateMessage?></textarea></td>
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

	if(val.MessageMode.value=="") {
		alert("모드를 입력하세요.");
		val.Title.focus();
		return;
	}

	if(val.TemplateCode.value=="") {
		alert("템플릿코드를 입력하세요.");
		val.Title.focus();
		return;
	}


  
  if(val.TemplateMessage.value=="") {
		alert("카카오톡 메시지를 입력하세요.");
		val.Title.focus();
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