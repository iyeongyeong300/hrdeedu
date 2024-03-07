<?
$MenuType = "E";
$PageName = "notice";
$ReadPage = "notice_read";
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
            <h2>공지사항 <?=$ScriptTitle?></h2>

            <div class="conZone">
            	<!-- ## START -->
<?
if($mode!="new") {

	$Sql = "SELECT * FROM Notice WHERE idx=$idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$UseYN = $Row['UseYN']; //사용유무
		$Notice = $Row['Notice']; //공지여부
		$Title = html_quote($Row['Title']); //제목
		$Content = stripslashes($Row['Content']); //내용
		$FileName1 = $Row['FileName1']; //첨부파일1
		$RealFileName1 = $Row['RealFileName1']; //첨부파일1 실제파일명
		$FileName2 = $Row['FileName2']; //첨부파일2
		$RealFileName2 = $Row['RealFileName2']; //첨부파일2 실제파일명
		$FileName3 = $Row['FileName3']; //첨부파일3
		$RealFileName3 = $Row['RealFileName3']; //첨부파일3 실제파일명
		$FileName4 = $Row['FileName4']; //첨부파일4
		$RealFileName4 = $Row['RealFileName4']; //첨부파일4 실제파일명
		$FileName5 = $Row['FileName5']; //첨부파일5
		$RealFileName5 = $Row['RealFileName5']; //첨부파일5 실제파일명
		$ViewCount = $Row['ViewCount']; //조회수
	}

}
?>

                <!-- 입력 -->
				<form name="Form1" method="post" action="notice_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
						<th>공지 여부</font></th>
						<td><input type="radio" name="Notice" id="Notice1" value="Y" <?if($Notice=="Y") {?>checked<?}?>> <label for="Notice1">공지글</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="Notice" id="Notice2" value="N" <?if($Notice=="N" || !$Notice) {?>checked<?}?>> <label for="Notice2">일반글</label></td>
					</tr>
					<tr>
						<th>사용 여부</font></th>
						<td><input type="radio" name="UseYN" id="UseYN1" value="N" <?if($UseYN=="N") {?>checked<?}?>> <label for="UseYN1">미사용</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="UseYN" id="UseYN2" value="Y" <?if($UseYN=="Y" || !$UseYN) {?>checked<?}?>> <label for="UseYN2">사용</label></td>
					</tr>
					<tr>
						<th>제목</th>
						<td><input name="Title" type="text"  size="120" value="<?=$Title?>"></td>
					</tr>

					<tr>
						<th>첨부파일 1</th>
						<td><input name="file" type="file"  size="80"></td>
					</tr>
					<?if(($mode=="edit") && ($FileName1)) { ?>
					<tr>
						<th>첨부된 파일 1</th>
						<td><A HREF="./download.php?idx=<?=$idx?>&code=Notice&file=1"><?=$RealFileName1?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel1" value="Y"> 현재 파일 삭제</td>
					</tr>
					<? } ?>
					<tr>
						<th>첨부파일 2</th>
						<td><input name="file2" type="file"  size="80"></td>
					</tr>
					<?if(($mode=="edit") && ($FileName2)) { ?>
					<tr>
						<th>첨부된 파일 2</th>
						<td><A HREF="./download.php?idx=<?=$idx?>&code=Notice&file=2"><?=$RealFileName2?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel2" value="Y"> 현재 파일 삭제</td>
					</tr>
					<? } ?>
					<tr>
						<th>첨부파일 3</th>
						<td><input name="file3" type="file"  size="80"></td>
					</tr>
					<?if(($mode=="edit") && ($FileName3)) { ?>
					<tr>
						<th>첨부된 파일 3</th>
						<td><A HREF="./download.php?idx=<?=$idx?>&code=Notice&file=3"><?=$RealFileName3?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel3" value="Y"> 현재 파일 삭제</td>
					</tr>
					<? } ?>
					<tr>
						<th>첨부파일 4</th>
						<td><input name="file4" type="file"  size="80"></td>
					</tr>
					<?if(($mode=="edit") && ($FileName4)) { ?>
					<tr>
						<th>첨부된 파일 4</th>
						<td><A HREF="./download.php?idx=<?=$idx?>&code=Notice&file=4"><?=$RealFileName4?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel4" value="Y"> 현재 파일 삭제</td>
					</tr>
					<? } ?>
					<tr>
						<th>첨부파일 5</th>
						<td><input name="file5" type="file"  size="80"></td>
					</tr>
					<?if(($mode=="edit") && ($FileName5)) { ?>
					<tr>
						<th>첨부된 파일 5</th>
						<td><A HREF="./download.php?idx=<?=$idx?>&code=Notice&file=5"><?=$RealFileName5?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel5" value="Y"> 현재 파일 삭제</td>
					</tr>
					<? } ?>

					<tr>
						<th>내 용</th>
						<td height="28"><textarea name="Content" id="Content" rows="10" cols="100" style="width:970px; height:420px; display:none;"><?=$Content?></textarea></td>
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
<script type="text/javascript">
var oEditors = [];

// 추가 글꼴 목록
//var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "Content",
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

	if(val.Title.value=="") {
		alert("제목을 입력하세요.");
		val.Title.focus();
		return;
	}

	oEditors.getById["Content"].exec("UPDATE_CONTENTS_FIELD", []);

	if(document.getElementById("Content").value.length < 15) {
		alert("내용을 입력해주세요");
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