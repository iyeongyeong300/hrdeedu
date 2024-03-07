<?
$MenuType = "E";
$PageName = "study_qna";
$ReadPage = "study_qna_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>1:1 상담문의</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM StudyCounsel WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ID = $Row['ID'];
	$Category = $Row['Category'];
	$LectureCode = $Row['LectureCode'];
	$Contents_idx = $Row['Contents_idx'];
	$Title = $Row['Title'];
	$Contents = nl2br(stripslashes($Row['Contents']));
	$RegDate = $Row['RegDate'];
	$Name2 = $Row['Name2'];
	$Contents2 = stripslashes($Row['Contents2']);
	$RegDate2 = $Row['RegDate2'];
	$FileName1 = $Row['FileName1'];
	$RealFileName1 = $Row['RealFileName1'];
	$FileName2 = $Row['FileName2'];
	$RealFileName2 = $Row['RealFileName2'];
	$FileName3 = $Row['FileName3'];
	$RealFileName3 = $Row['RealFileName3'];
	$FileName4 = $Row['FileName4'];
	$RealFileName4 = $Row['RealFileName4'];
	$FileName5 = $Row['FileName5'];
	$RealFileName5 = $Row['RealFileName5'];
	$Status = $Row['Status'];
	$ViewCount = $Row['ViewCount'];
}

$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay FROM Member WHERE ID='$ID'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$MemberType = $Row['MemberType']; //회원구분
	$Name = $Row['Name']; //이름
	$Email = $Row['Email']; //이메일
	$Mobile = $Row['Mobile']; //휴대폰

	$Email = InformationProtection($Email,'Email','S');
	$Mobile = InformationProtection($Mobile,'Mobile','S');
}

$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsName = $Row['ContentsName'];
}

$Sql = "SELECT * FROM Contents WHERE idx=$Contents_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsTitle = $Row['ContentsTitle'];
}

if(!$Name2) {
	$Name2 = "관리자";
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 글을 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}

//-->
</SCRIPT>
                <!-- 입력 -->
				<form name="DeleteForm" method="post" action="study_qna_script.php" enctype="multipart/form-data" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>과정명</th>
                    <td><?=$ContentsName?></td>
                  </tr>
				  <tr>
                    <th>차시명</th>
                    <td><?=$ContentsTitle?></td>
                  </tr>
				  <tr>
                    <th>문의 제목</th>
                    <td><?=$Title?></td>
                  </tr>
                  <tr>
                    <th>이름</th>
                    <td><?=$Name?></td>
                  </tr>
                  <tr>
                    <th>아이디</th>
                    <td><?=$ID?></td>
                  </tr>
				  <tr>
                    <th>연락처</th>
                    <td><span id="InfoProt_Mobile"><a href="Javascript:InformationProtection('Member','Mobile','InfoProt_Mobile','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','휴대폰');"><?=$Mobile?></a></span></td>
                  </tr>
				  <tr>
                    <th>이메일</th>
                    <td><span id="InfoProt_Email"><a href="Javascript:InformationProtection('Member','Email','InfoProt_Email','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','이메일');"><?=$Email?></a></span></td>
                  </tr>
				  <tr>
                    <th>등록일</th>
                    <td><?=$RegDate?></td>
                  </tr>
				  <tr>
                    <th>조회수</th>
                    <td><?=$ViewCount?></td>
                  </tr>
				  <tr>
                    <th>내용</th>
                    <td>
					<table border="0" width="970px">
						<tr>
							<td style="line-height:1.6em; letter-spacing:-0.02em; border:0px"><?=$Contents?></td>
						</tr>
					</table>
					</td>
                  </tr>
                </table>
                <!-- 버튼 -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelOk()" class="btn_inputLine01"></td>
						<td align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>

				<br><br><br>
				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">답변</span>
				</div>

				<form name="Form1" method="post" action="study_qna_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="reply">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="UserID" value="<?=$ID?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>처리 상태</th>
                    <td>
					<select name="Status" id="Status" style="width:120px">
						<?
						while (list($key,$value)=each($CounselStatus_array)) {
						?>
						<option value="<?=$key?>" <?if($Status==$key) {?>selected<?}?>><?=$value?></option>
						<?
						}
						?>
					</select>
					</td>
                  </tr>
                  <tr>
                    <th>작성자</th>
                    <td><input name="Name2" type="text"  size="30" value="<?=$Name2?>"></td>
                  </tr>
                  <tr>
					<th>첨부파일 1</th>
					<td><input name="file" type="file"  size="80"></td>
				</tr>
				<?if($FileName1) { ?>
				<tr>
					<th>첨부된 파일 1</th>
					<td><A HREF="./download.php?idx=<?=$idx?>&code=StudyCounsel&file=1"><?=$RealFileName1?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel1" value="Y"> 현재 파일 삭제</td>
				</tr>
				<? } ?>
				<tr>
					<th>첨부파일 2</th>
					<td><input name="file2" type="file"  size="80"></td>
				</tr>
				<?if($FileName2) { ?>
				<tr>
					<th>첨부된 파일 2</th>
					<td><A HREF="./download.php?idx=<?=$idx?>&code=StudyCounsel&file=2"><?=$RealFileName2?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel2" value="Y"> 현재 파일 삭제</td>
				</tr>
				<? } ?>
				<tr>
					<th>첨부파일 3</th>
					<td><input name="file3" type="file"  size="80"></td>
				</tr>
				<?if($FileName3) { ?>
				<tr>
					<th>첨부된 파일 3</th>
					<td><A HREF="./download.php?idx=<?=$idx?>&code=StudyCounsel&file=3"><?=$RealFileName3?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel3" value="Y"> 현재 파일 삭제</td>
				</tr>
				<? } ?>
				<tr>
					<th>첨부파일 4</th>
					<td><input name="file4" type="file"  size="80"></td>
				</tr>
				<?if($FileName4) { ?>
				<tr>
					<th>첨부된 파일 4</th>
					<td><A HREF="./download.php?idx=<?=$idx?>&code=StudyCounsel&file=4"><?=$RealFileName4?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel4" value="Y"> 현재 파일 삭제</td>
				</tr>
				<? } ?>
				<tr>
					<th>첨부파일 5</th>
					<td><input name="file5" type="file"  size="80"></td>
				</tr>
				<?if($FileName5) { ?>
				<tr>
					<th>첨부된 파일 5</th>
					<td><A HREF="./download.php?idx=<?=$idx?>&code=StudyCounsel&file=5"><?=$RealFileName5?></A>&nbsp;&nbsp;<input type="checkbox" name="FileDel5" value="Y"> 현재 파일 삭제</td>
				</tr>
				<? } ?>

				<tr>
					<th>답변 내용</th>
					<td height="28"><textarea name="Contents2" id="Contents2" rows="10" cols="100" style="width:970px; height:420px; display:none;"><?=$Contents2?></textarea></td>
				</tr>
                </table>
                </form>


				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<td align="left" width="150" valign="top"> </td>
						<td align="center" valign="top">
						<?if($AdminWrite=="Y") {?>
						<span id="SubmitBtn"><input type="button" value="답변 하기" onclick="SubmitOk()" class="btn_inputBlue01"></span>
						<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
						<?}?>
						</td>
						<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>
                
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
	elPlaceHolder: "Contents2",
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

	if(val.Name2.value=="") {
		alert("작성자를 입력하세요.");
		val.Name2.focus();
		return;
	}

	oEditors.getById["Contents2"].exec("UPDATE_CONTENTS_FIELD", []);

	if(document.getElementById("Contents2").value.length < 15) {
		alert("답변 내용을 입력해주세요");
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