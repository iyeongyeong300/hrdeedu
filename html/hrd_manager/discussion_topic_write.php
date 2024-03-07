<?
$MenuType = "D";
$PageName = "exam_bank";
$ReadPage = "exam_bank_read";
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
            <h2>토론방 주제 관리 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT * FROM DiscussionTopic WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$Gubun = html_quote($Row['Gubun']); //차시 구분
	
		$Topic = stripslashes($Row['Topic']); //질문
		$Example01 = html_quote($Row['Example01']); //예문1
		$Example02 = html_quote($Row['Example02']); //예문2
		$Example03 = html_quote($Row['Example03']); //예문3
		$Example04 = html_quote($Row['Example04']); //예문4
		$Example05 = html_quote($Row['Example05']); //예문5
		
		$Comment = stripslashes($Row['Comment']); //해답 설명
		$UseYN = $Row['UseYN']; //사용유무
	}

}

 
?>

                <!-- 입력 -->
				<form name="Form1" method="post" action="discussion_topic_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
					
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>과목 선택</th>
                    <td>
					<select name="GubunSelect" id="GubunSelect" onchange="GubunSelected();">
						<option value="">-- 과목구분 선택 --</option>
						<?
						$SQL = "SELECT DISTINCT(Gubun) FROM DiscussionTopic WHERE Del='N' ORDER BY Gubun ASC";
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
                    <th>과목 구분</th>
                    <td><input name="Gubun" id="Gubun" type="text"  size="60" value="<?=$Gubun?>"> (차시구분 선택에 없는 경우 직접 입력하세요.)</td>
                  </tr>
				  
                  <tr>
                    <th>토론주제</th>
                    <td><textarea name="Topic" id="Topic" rows="10" cols="100" style="width:840px; height:320px;"><?=$Topic?></textarea></td>
                  </tr>
				  <tr>
						<th width="100">토론주제 설명</th>
						<td height="28"><textarea name="Comment" id="Comment" rows="10" cols="100" style="width:840px; height:320px;"><?=$Comment?></textarea></td>
					</tr>
				  <tr  >
						<th>예시 1&nbsp;</th>
						<td><textarea name="Example01" id="Example01" rows="10" cols="100" style="width:840px; height:120px;"><?=$Example01?></textarea></td>
					</tr>
					<tr 'U'>
						<th>보기 2&nbsp;</th>
						<td><textarea name="Example02" id="Example02" rows="10" cols="100" style="width:840px; height:120px;"><?=$Example02?></textarea></td>
					</tr>
					<tr 'U'>
						<th>보기 3&nbsp;</th>
						<td><textarea name="Example03" id="Example03" rows="10" cols="100" style="width:840px; height:120px;"><?=$Example03?></textarea></td>
					</tr>
					<tr 'U'>
						<th>보기 4&nbsp;</th>
						<td><textarea name="Example04" id="Example04" rows="10" cols="100" style="width:840px; height:120px;"><?=$Example04?></textarea></td>
					</tr>
					<tr 'U'>
						<th>보기 5&nbsp;</th>
						<td><textarea name="Example05" id="Example05" rows="10" cols="100" style="width:840px; height:120px;"><?=$Example05?></textarea></td>
					</tr>
					
					<tr>
						<th>사용 여부</th>
						<td><input type="radio" name="UseYN" id="UseYN2" value="Y" <?if($UseYN=="Y" || !$UseYN) {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer"> <label for="UseYN2">사용</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="UseYN" id="UseYN1" value="N" <?if($UseYN=="N") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer"> <label for="UseYN1">미사용</label></td>
					</tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
                	<button type="button" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue" onclick="SubmitOk()"><?=$ScriptTitle?></button>
					<button type="button" name="ResetBtn" id="ResetBtn" class="btn btn_DGray line" onclick="location.href='<?=$PageName?>.php'">목록</button>
                </div>
				<div class="btnAreaTc02" id="Waiting" style="display:none"><strong>처리중입니다...</strong></div>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->
<script type="text/javascript">
var oEditors = [];




nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "Topic",
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
	elPlaceHolder: "Example01",
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
	elPlaceHolder: "Example02",
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
	elPlaceHolder: "Example03",
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
	elPlaceHolder: "Example04",
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
	elPlaceHolder: "Example05",
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

</script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function SubmitOk() {

	val = document.Form1;


	oEditors.getById["Topic"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors.getById["Example01"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors.getById["Example02"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors.getById["Example03"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors.getById["Example04"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors.getById["Example05"].exec("UPDATE_CONTENTS_FIELD", []);
	oEditors.getById["Comment"].exec("UPDATE_CONTENTS_FIELD", []);
	
	
	if(val.Gubun.value=="") {
		alert("과목구분을 입력하세요.");
		val.Gubun.focus();
		return;
	}
	if(document.getElementById("Topic").value.length < 10) {
		alert("토론주제를 입력하세요.");
		return;
	}
	if(document.getElementById("Comment").value.length < 10) {
		alert("설명을 10자 이상 입력해주세요");
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