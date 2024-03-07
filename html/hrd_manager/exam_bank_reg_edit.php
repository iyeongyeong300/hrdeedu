<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$Sql = "SELECT * FROM ExamBankExcelTemp WHERE idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Gubun = html_quote($Row['Gubun']); //차시 구분
	$ExamType = $Row['ExamType']; //문제유형
	$Question = stripslashes($Row['Question']); //질문
	$Example01 = html_quote($Row['Example01']); //예문1
	$Example02 = html_quote($Row['Example02']); //예문2
	$Example03 = html_quote($Row['Example03']); //예문3
	$Example04 = html_quote($Row['Example04']); //예문4
	$Example05 = html_quote($Row['Example05']); //예문5
	$Answer = $Row['Answer']; //정답
	$Answer2 = $Row['Answer2']; //단답형 정답
	$Comment = stripslashes($Row['Comment']); //해답 설명
	$ScoreBasis = stripslashes($Row['ScoreBasis']); //채점기준
}

if(!$ExamType) {
	$ExamType = "A";
}
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
</head>

<body leftmargin="0" topmargin="0">

<div id="wrap">

    
    <!-- Content -->
	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>업로드한 엑셀파일 수정</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="EditForm" method="post" action="exam_bank_edit_script.php" target="ScriptFrame">
				<input type="hidden" name="idx2" id="idx2" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>차시 구분</th>
                    <td><input name="Gubun" id="Gubun" type="text"  size="80" value="<?=$Gubun?>"></td>
                  </tr>
                  <tr>
                    <th>문제 유형</th>
                    <td>
					<?
					$i = 1;
					while (list($key,$value)=each($ExamType_array)) {
					?>
					<input type="radio" name="ExamType" id="ExamType<?=$i?>" value="<?=$key?>" <?if($ExamType==$key) {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer" onclick="ExamTypeSelected();"><label for="ExamType<?=$i?>" style="cursor:pointer"><?=$value?></label>&nbsp;&nbsp;&nbsp;&nbsp;
					<?
					$i++;
					}
					?>
					</td>
                  </tr>
			      <tr>
                    <th>질문(과제 등록)</th>
                    <td><textarea name="Question" id="Question" rows="10" cols="100" style="width:750px; height:120px;;"><?=$Question?></textarea></td>
                  </tr>
				  <tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
                    <th>보기 1</th>
                    <td><input type="radio" name="Answer" id="Answer" value="1" <?if($Answer=="1") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example01" id="Example01" type="text"  size="110" value="<?=$Example01?>"></td>
                  </tr>
				  <tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th>보기 2</th>
					<td><input type="radio" name="Answer" id="Answer" value="2" <?if($Answer=="2") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example02" id="Example02" type="text"  size="110" value="<?=$Example02?>"></td>
				</tr>
				<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th >보기 3</th>
					<td><input type="radio" name="Answer" id="Answer" value="3" <?if($Answer=="3") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example03" id="Example03" type="text"  size="110" value="<?=$Example03?>"></td>
				</tr>
				<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th>보기 4</th>
					<td><input type="radio" name="Answer" id="Answer" value="4" <?if($Answer=="4") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example04" id="Example04" type="text"  size="110" value="<?=$Example04?>"></td>
				</tr>
				<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th>보기 5</th>
					<td><input type="radio" name="Answer" id="Answer" value="5" <?if($Answer=="5") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example05" id="Example05" type="text"  size="110" value="<?=$Example05?>"></td>
				</tr>
				<tr id="Answer2TR" style="display:<?=$Answer2TR?>">
					<th>단답형, 서술형<br>모범 답안</th>
					<td><textarea name="Answer2" id="Answer2" rows="10" cols="100" style="width:750px; height:120px;;"><?=$Answer2?></textarea></td>
				</tr>
				<tr>
					<th>해답 설명</th>
					<td><textarea name="Comment" id="Comment" rows="10" cols="100" style="width:840px; height:320px;"><?=$Comment?></textarea></td>
				</tr>
				<tr id="ExamTR" style="display:<?=$ExamTR?>">
					<th>채점기준(서술형)</td>
					<td><textarea name="ScoreBasis" id="ScoreBasis" rows="10" cols="100" style="width:840px; height:320px;"><?=$ScoreBasis?></textarea></td>
				</tr>
                </table>
				</form>
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td>&nbsp;</td>
						<td height="15">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td width="150" valign="top">&nbsp;</td>
						<td align="center" valign="top">
						<span id="EditSubmitBtn"><input type="button" value="수정 하기" onclick="ExamBankEditSubmitOk()" class="btn_inputBlue01"></span>
						<span id="EditWaiting" style="display:none"><strong>처리중입니다...</strong></span>
						</td>
						<td width="150" align="right" valign="top"><input type="button" value="닫기" onclick="DataResultClose();" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
    <!-- Content // -->


</div>

<script type="text/javascript">
var oEditors = [];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "Comment",
	sSkinURI: "./smarteditor/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//var sHTML = "";
		//oEditors.getById["contents"].exec("PASTE_HTML", [sHTML]);
	},
	fCreator: "createSEditor2"
});

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "ScoreBasis",
	sSkinURI: "./smarteditor/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		ExamTypeSelected(); //문제 유형별로 선택항목 보이기
	},
	fCreator: "createSEditor2"
});

</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function ExamBankEditSubmitOk() {

	val = document.EditForm;

	var checked_value = $(':radio[name="ExamType"]:checked').val();

	oEditors.getById["Comment"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors.getById["ScoreBasis"].exec("UPDATE_CONTENTS_FIELD", []);

	if(val.Gubun.value=="") {
		alert("차시구분을 입력하세요.");
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
		if($(':radio[name="Answer"]:checked').length < 1) {
			alert("보기중 정답을 선택하세요.");
			$(":radio[name='Answer']:eq(0)").focus();
			return;
		}
	}


	if(document.getElementById("Comment").value.length < 15) {
		alert("해답설명을 입력해주세요");
		return;
	}


	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		val.submit();
	}
}

//-->
</SCRIPT>

</body>
</html>
<?
mysqli_close($connect);
?>