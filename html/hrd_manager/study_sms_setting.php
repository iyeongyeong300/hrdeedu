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
            <h2>독려내용 관리<span class="fs12 description">학습독려시 SMS, Mail의 내용을 관리하는 곳입니다.</span></h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<table class="view_ty01 tl pt15">
					<tbody>
						<tr>
							<th colspan="3" class="tc" style="background:#e2e9ed;">아래 키워드를 사용하면 해당 메시지가 적용됩니다.</th> 
						</tr>
						<tr>
							<th><strong>{시작}</strong></th>
							<td>수강시작일</td>
							<td>예) 2019-01-01</td>
						</tr>
						<tr>
							<th><strong>{종료}</strong></th>
							<td>수강종료일</td>
							<td>예) 2019-01-31</td>
						</tr>
						<tr>
							<th><strong>{회사명}</strong></th>
							<td>발송 시 앞에 붙는 기관명</td>
							<td>예) ㅇㅇㅇ교육원</td>
						</tr>
						<tr>
							<th><strong>{소속업체명}</strong></th>
							<td>학습자가 소속된 업체명</td>
							<td>예) SK텔레콤</td>
						</tr>
						<tr>
							<th><strong>{도메인}</strong></th>
							<td>학습사이트주소</td>
							<td>예) http://abc.co.kr</td>
						</tr>
						<tr>
							<th><strong>{아이디}</strong></th>
							<td>학습자아이디</td>
							<td>예) aaa54789</td>
						</tr>
						<tr>
							<th><strong>{이름}</strong></th>
							<td>학습자이름</td>
							<td>예) 홍길동</td>
						</tr>
						<tr>
							<th><strong>{과정명}</strong></th>
							<td>수강중인 과정명</td>
							<td>예) 직무필수교육</td>
						</tr>
					</tbody>
				</table>
                <!--목록 -->
				<ul class="flex_wrap col2">
					<li>
						<div class="btnAreaTl02">
							<span class="fs16b fc333B sub_title2">학습시작</span>
						</div>
						<form name="Form_start" id="Form_start" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
						<input type="hidden" name="MessageMode" value="start">
						<table border="0" class="gapT20">
							<colgroup>
								<col>
								<col width="100px">
							</colgroup>
							<tr>
								<td><textarea name="Massage" id="Massage" style="width:100%; height:100px"><?=$Massage_start?></textarea></td>
								<td><button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:100px" onclick="SubmitOk('start')">저장하기</button></td>
							</tr>
						</table>
						</form>
					</li>
					<li>
						<div class="btnAreaTl02">
							<span class="fs16b fc333B sub_title2">0% 미만</span>
						</div>
						<form name="Form_00" id="Form_00" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
						<input type="hidden" name="MessageMode" value="00">
						<table border="0" class="gapT20">
							<colgroup>
								<col>
								<col width="100px">
							</colgroup>
							<tr>
								<td><textarea name="Massage" id="Massage" style="width:100%; height:100px"><?=$Massage_00?></textarea></td>
								<td><button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:100px" onclick="SubmitOk('00')">저장하기</button></td>
							</tr>
						</table>
						</form>
					</li>
					<li>
						<div class="btnAreaTl02">
							<span class="fs16b fc333B sub_title2">30% 미만</span>
						</div>
						<form name="Form_30" id="Form_30" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
						<input type="hidden" name="MessageMode" value="30">
						<table border="0" class="gapT20">
							<colgroup>
								<col>
								<col width="100px">
							</colgroup>
							<tr>
								<td><textarea name="Massage" id="Massage" style="width:100%; height:100px"><?=$Massage_30?></textarea></td>
								<td><button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:100px" onclick="SubmitOk('30')">저장하기</button></td>
							</tr>
						</table>
						</form>
					</li>
					<li>
						<div class="btnAreaTl02">
							<span class="fs16b fc333B sub_title2">50% 미만</span>
						</div>
						<form name="Form_50" id="Form_50" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
						<input type="hidden" name="MessageMode" value="50">
						<table border="0" class="gapT20">
							<colgroup>
								<col>
								<col width="100px">
							</colgroup>
							<tr>
								<td><textarea name="Massage" id="Massage" style="width:100%; height:100px"><?=$Massage_50?></textarea></td>
								<td><button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:100px" onclick="SubmitOk('50')">저장하기</button></td>
							</tr>
						</table>
						</form>
					</li>
					<li>
						<div class="btnAreaTl02">
							<span class="fs16b fc333B sub_title2">80% 미만</span>
						</div>
						<form name="Form_80" id="Form_80" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
						<input type="hidden" name="MessageMode" value="80">
						<table border="0" class="gapT20">
							<colgroup>
								<col>
								<col width="100px">
							</colgroup>
							<tr>
								<td><textarea name="Massage" id="Massage" style="width:100%; height:100px"><?=$Massage_80?></textarea></td>
								<td><button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:100px" onclick="SubmitOk('80')">저장하기</button></td>
							</tr>
						</table>
						</form>
					</li>
					<li>
						<div class="btnAreaTl02">
							<span class="fs16b fc333B sub_title2">최종독려</span>
						</div>
						<form name="Form_final" id="Form_final" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
						<input type="hidden" name="MessageMode" value="final">
						<table border="0" class="gapT20">
							<colgroup>
								<col>
								<col width="100px">
							</colgroup>
							<tr>
								<td><textarea name="Massage" id="Massage" style="width:100%; height:100px"><?=$Massage_final?></textarea></td>
								<td><button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:100px" onclick="SubmitOk('final')">저장하기</button></td>
							</tr>
						</table>
						</form>
					</li>
					<li>
						<div class="btnAreaTl02">
							<span class="fs16b fc333B sub_title2">수강종료</span>
						</div>
						<form name="Form_end" id="Form_end" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
						<input type="hidden" name="MessageMode" value="end">
						<table border="0" class="gapT20">
							<colgroup>
								<col>
								<col width="100px">
							</colgroup>
							<tr>
								<td><textarea name="Massage" id="Massage" style="width:100%; height:100px"><?=$Massage_end?></textarea></td>
								<td><button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:100px" onclick="SubmitOk('end')">저장하기</button></td>
							</tr>
						</table>
						</form>
					</li>
					<li>
						<div class="btnAreaTl02">
							<span class="fs16b fc333B sub_title2">결과확인</span>
						</div>
						<form name="Form_result" id="Form_result" method="POST" action="study_sms_setting_script.php" target="ScriptFrame">
						<input type="hidden" name="MessageMode" value="result">
						<table border="0" class="gapT20">
							<colgroup>
								<col>
								<col width="100px">
							</colgroup>
							<tr>
								<td><textarea name="Massage" id="Massage" style="width:100%; height:100px"><?=$Massage_result?></textarea></td>
								<td><button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:100px" onclick="SubmitOk('result')">저장하기</button></td>
							</tr>
						</table>
						</form>
					</li>
				</ul> 
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>