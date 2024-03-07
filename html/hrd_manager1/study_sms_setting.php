<?
$MenuType = "C";
$PageName = "study_sms_setting";
$ReadPage = "study_sms_setting_read";
?>
<? include "./include/include_top.php"; ?>
<?
//학습시작
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='start'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage_start = $Row['Massage'];
}

//0% 미만
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='00'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage_00 = $Row['Massage'];
}

//30% 미만
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='30'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage_30 = $Row['Massage'];
}

//50% 미만
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='50'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage_50 = $Row['Massage'];
}

//80% 미만
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='80'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage_80 = $Row['Massage'];
}

//최종독려
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='final'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage_final = $Row['Massage'];
}

//수강종료
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='end'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage_end = $Row['Massage'];
}

//결과확인
$Sql = "SELECT * FROM SendMessage WHERE MessageMode='result'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Massage_result = $Row['Massage'];
}
?>
<script type="text/javascript">
<!--
function SubmitOk(mode) {

	var form = "";

	if(mode=="start") {
		if(document.Form_start.Massage.value=="") {
			alert("[학습시작] 내용을 입력하세요.");
			document.Form_start.Massage.focus();
			return;
		}
		form = "Form_start";
	}

	if(mode=="00") {
		if(document.Form_00.Massage.value=="") {
			alert("[0% 미만] 내용을 입력하세요.");
			document.Form_00.Massage.focus();
			return;
		}
		form = "Form_00";
	}

	if(mode=="30") {
		if(document.Form_30.Massage.value=="") {
			alert("[30% 미만] 내용을 입력하세요.");
			document.Form_30.Massage.focus();
			return;
		}
		form = "Form_30";
	}

	if(mode=="50") {
		if(document.Form_50.Massage.value=="") {
			alert("[50% 미만] 내용을 입력하세요.");
			document.Form_50.Massage.focus();
			return;
		}
		form = "Form_50";
	}

	if(mode=="80") {
		if(document.Form_80.Massage.value=="") {
			alert("[80% 미만] 내용을 입력하세요.");
			document.Form_80.Massage.focus();
			return;
		}
		form = "Form_80";
	}

	if(mode=="final") {
		if(document.Form_final.Massage.value=="") {
			alert("[최종독려] 내용을 입력하세요.");
			document.Form_final.Massage.focus();
			return;
		}
		form = "Form_final";
	}

	if(mode=="end") {
		if(document.Form_end.Massage.value=="") {
			alert("[수강종료] 내용을 입력하세요.");
			document.Form_end.Massage.focus();
			return;
		}
		form = "Form_end";
	}

	if(mode=="result") {
		if(document.Form_result.Massage.value=="") {
			alert("[결과확인] 내용을 입력하세요.");
			document.Form_result.Massage.focus();
			return;
		}
		form = "Form_result";
	}


	Yes = confirm("저장하시겠습니까?");
	if(Yes==true) {
		$("#"+form).submit();
	}

}
//-->
</script>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>독려내용 관리 | <span class="fs12 fcfff">학습독려시 SMS, Mail의 내용을 관리하는 곳입니다.</span></h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<div class="tl pt15">
                                #{시작} : 수강시작일 (예: 2019-01-01) <br>
                                #{종료} : 수강종료일 (예: 2019-01-31) <br>
                                #{회사명} : 발송 시 앞에 붙는 기관명 (예: ㅇㅇㅇ교육원)<br>
                                #{소속업체명} : 학습자가 소속된 업체명 (예: SK텔레콤) <br>
                                #{도메인} : 학습사이트주소 (예: http://abc.co.kr) <br>
                                #{아이디} : 학습자아이디 (예: aaa54789) <br>
                                #{이름} : 학습자이름 (예: 홍길동) <br>
                                #{과정명} : 수강중인 과정명 (예: 직무필수교육)

<!--
				아래 키워드를 사용하면 해당 메시지가 적용됩니다.<br>
				#{시작일} : 수강시작일 | 예) 2019-01-01 <br>
				#{종료일} : 수강종료일 | 예) 2019-01-31 <br>
				#{기관명} : 발송 시 앞에 붙는 기관명 | 예) ㅇㅇㅇ교육원 <br>
				#{소속명} : 학습자가 소속된 업체명 | 예) SK텔레콤 <br>
				#{도메인} : 학습사이트주소 | 예) http://abc.co.kr <br>
				#{아이디} : 학습자아이디 | 예) aaa54789 <br>
				#{학습자} : 학습자이름 | 예) 홍길동 <br>
				#{과정명} : 수강중인 과정명 예) 직무필수교육
-->
				</div>
                <!--목록 -->
				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">학습시작</span>
              	</div>
                <form name="Form_start" id="Form_start" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
				<input type="hidden" name="MessageMode" value="start">
				<table border="0" class="gapT20">
					<tr>
						<td><textarea name="Massage" id="Massage" style="width:1100px; height:80px"><?=$Massage_start?></textarea></td>
						<td><input type="button" value="저장 하기" onclick="SubmitOk('start')" style="cursor:pointer;width:100px;height:80px" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">0% 미만</span>
              	</div>
                <form name="Form_00" id="Form_00" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
				<input type="hidden" name="MessageMode" value="00">
				<table border="0" class="gapT20">
					<tr>
						<td><textarea name="Massage" id="Massage" style="width:1100px; height:80px"><?=$Massage_00?></textarea></td>
						<td><input type="button" value="저장 하기" onclick="SubmitOk('00')" style="cursor:pointer;width:100px;height:80px" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">30% 미만</span>
              	</div>
                <form name="Form_30" id="Form_30" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
				<input type="hidden" name="MessageMode" value="30">
				<table border="0" class="gapT20">
					<tr>
						<td><textarea name="Massage" id="Massage" style="width:1100px; height:80px"><?=$Massage_30?></textarea></td>
						<td><input type="button" value="저장 하기" onclick="SubmitOk('30')" style="cursor:pointer;width:100px;height:80px" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">50% 미만</span>
              	</div>
                <form name="Form_50" id="Form_50" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
				<input type="hidden" name="MessageMode" value="50">
				<table border="0" class="gapT20">
					<tr>
						<td><textarea name="Massage" id="Massage" style="width:1100px; height:80px"><?=$Massage_50?></textarea></td>
						<td><input type="button" value="저장 하기" onclick="SubmitOk('50')" style="cursor:pointer;width:100px;height:80px" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">80% 미만</span>
              	</div>
                <form name="Form_80" id="Form_80" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
				<input type="hidden" name="MessageMode" value="80">
				<table border="0" class="gapT20">
					<tr>
						<td><textarea name="Massage" id="Massage" style="width:1100px; height:80px"><?=$Massage_80?></textarea></td>
						<td><input type="button" value="저장 하기" onclick="SubmitOk('80')" style="cursor:pointer;width:100px;height:80px" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">최종독려</span>
              	</div>
                <form name="Form_final" id="Form_final" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
				<input type="hidden" name="MessageMode" value="final">
				<table border="0" class="gapT20">
					<tr>
						<td><textarea name="Massage" id="Massage" style="width:1100px; height:80px"><?=$Massage_final?></textarea></td>
						<td><input type="button" value="저장 하기" onclick="SubmitOk('final')" style="cursor:pointer;width:100px;height:80px" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">수강종료</span>
              	</div>
                <form name="Form_end" id="Form_end" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
				<input type="hidden" name="MessageMode" value="end">
				<table border="0" class="gapT20">
					<tr>
						<td><textarea name="Massage" id="Massage" style="width:1100px; height:80px"><?=$Massage_end?></textarea></td>
						<td><input type="button" value="저장 하기" onclick="SubmitOk('end')" style="cursor:pointer;width:100px;height:80px" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">결과확인</span>
              	</div>
                <form name="Form_result" id="Form_result" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
				<input type="hidden" name="MessageMode" value="result">
				<table border="0" class="gapT20">
					<tr>
						<td><textarea name="Massage" id="Massage" style="width:1100px; height:80px"><?=$Massage_result?></textarea></td>
						<td><input type="button" value="저장 하기" onclick="SubmitOk('result')" style="cursor:pointer;width:100px;height:80px" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>
                

 
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>
