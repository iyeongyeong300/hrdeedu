<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$Sql = "SELECT * FROM ContentsExcelTemp WHERE idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Gubun = html_quote($Row['Gubun']); //차시 구분
	$ContentsTitle = html_quote($Row['ContentsTitle']); //차시명
	$LectureTime = $Row['LectureTime']; //수강시간
	$Expl01 = stripslashes($Row['Expl01']); //차시목표
	$Expl02 = stripslashes($Row['Expl02']); //훈련내용
	$Expl03 = stripslashes($Row['Expl03']); //학습활동
}
?>
<!-- <script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script> -->
<div class="Content">

	<div class="contentBody">
		<!-- ########## -->
		<h2>업로드한 엑셀파일 수정</h2>
		
		<div class="conZone">
			<!-- ## START -->
			
			<form name="EditForm" method="post" action="contents_edit_script.php" target="ScriptFrame">
			<input type="hidden" name="idx2" id="idx2" value="<?=$idx?>">
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
			  <colgroup>
				<col width="120px" />
				<col width="" />
			  </colgroup>
			  <tr>
				<th>차시 구분</th>
				<td><input name="Gubun" id="Gubun" type="text"  size="60" value="<?=$Gubun?>"></td>
			  </tr>
			  <tr>
				<th>차시명</th>
				<td><input name="ContentsTitle" id="ContentsTitle" type="text"  size="120" value="<?=$ContentsTitle?>"></td>
			  </tr>
			  <tr>
				<th>수강시간</th>
				<td><input name="LectureTime" id="LectureTime" type="text"  size="5" value="<?=$LectureTime?>">분</td>
			  </tr>
			  <tr>
				<th>차시 목표</th>
				<td><textarea name="Expl01" id="Expl01" rows="10" cols="100" style="width:870px; height:220px;;"><?=$Expl01?></textarea></td>
			  </tr>
			  <tr>
				<th>훈련 내용</th>
				<td><textarea name="Expl02" id="Expl02" rows="10" cols="100" style="width:870px; height:220px;"><?=$Expl02?></textarea></td>
			  </tr>
			  <tr>
				<th>학습 활동</th>
				<td><textarea name="Expl03" id="Expl03" rows="10" cols="100" style="width:870px; height:220px;"><?=$Expl03?></textarea></td>
			  </tr>
			</table>
			</form>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center">
					<span id="EditSubmitBtn"><input type="button" value="수정 하기" onclick="ContentsEditSubmitOk();" class="btn_inputBlue01"></span>
					<span id="EditWaiting" style="display:none"><strong>처리중입니다...</strong></span>
					</td>
					<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>

			
			<!-- ## END -->
		</div>
		<!-- ########## // -->
	</div>

</div>


<SCRIPT LANGUAGE="JavaScript">
<!--
function ContentsEditSubmitOk() {

	val = document.EditForm;

	if($("#Gubun").val()=="") {
		alert("차시구분을 입력하세요.");
		$("#Gubun").focus();
		return;
	}

	if($("#ContentsTitle").val()=="") {
		alert("차시명을 입력하세요.");
		$("#ContentsTitle").focus();
		return;
	}

	if(val.LectureTime.value=="") {
		alert("수강시간을 입력하세요.");
		val.LectureTime.focus();
		return;
	}

	if(IsNumber(val.LectureTime.value)==false) {
		alert("수강시간은 숫자만 입력하세요.");
		val.LectureTime.focus();
		return;
	}


	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		val.submit();
	}
}
//-->
</SCRIPT>
<?
mysqli_close($connect);
?>