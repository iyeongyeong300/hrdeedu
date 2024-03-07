<?
$MenuType = "G";
$PageName = "work_request";
$ReadPage = "work_request_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>작업요청 게시판</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM WorkRequest WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Name = $Row['Name'];
	$Title = $Row['Title'];
	$Content = stripslashes($Row['Content']);
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
	$ViewCount = $Row['ViewCount'];
	$RegDate = $Row['RegDate'];

	$Name2 = $Row['Name2'];
	$Status = $Row['Status'];
	$Content2 = $Row['Content2'];
	$Content2_reply = nl2br($Row['Content2']);

	switch ($Status) {
		case "A": // 접수
			$StatusView = "<font color='#ff6600'>접수</font>";
		break;
		case "B": // 작업중
			$StatusView = "<font color='#0066ff'>작업중</font>";
		break;
		case "C": // 작업완료
			$StatusView = "<font color='#000000'>작업완료</font>";
		break;
	}

}

if(!$Name2) {
	$Name2 = "인터코리아";
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
				<form name="DeleteForm" method="post" action="work_request_script.php" enctype="multipart/form-data" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
						<th>제 목</th>
						<td> <?=$Title?></td>
					</tr>
					<tr>
						<th>작성자</th>
						<td> <?=$Name?> </td>
					</tr>
					<tr>
						<th>상태</th>
						<td> <?=$StatusView?> </td>
					</tr>
					<tr>
						<th>첨부 파일 1</th>
						<td> 
						<?if($FileName1) { ?><A HREF="./download.php?idx=<?=$idx?>&code=WorkRequest&file=1" target="ScriptFrame"><?=$RealFileName1?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>첨부 파일 2</th>
						<td> 
						<?if($FileName2) { ?><A HREF="./download.php?idx=<?=$idx?>&code=WorkRequest&file=2" target="ScriptFrame"><?=$RealFileName2?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>첨부 파일 3</th>
						<td> 
						<?if($FileName3) { ?><A HREF="./download.php?idx=<?=$idx?>&code=WorkRequest&file=3" target="ScriptFrame"><?=$RealFileName3?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>첨부 파일 4</th>
						<td> 
						<?if($FileName4) { ?><A HREF="./download.php?idx=<?=$idx?>&code=WorkRequest&file=4" target="ScriptFrame"><?=$RealFileName4?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>첨부 파일 5</th>
						<td> 
						<?if($FileName5) { ?><A HREF="./download.php?idx=<?=$idx?>&code=WorkRequest&file=5" target="ScriptFrame"><?=$RealFileName5?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>등록일</th>
						<td> <?=$RegDate?> </td>
					</tr>
					<tr>
						<th>내 용</th>
						<td height="28">
						<table border="0" width="970px">
							<tr>
								<td style="border:0px"><?=$Content?></td>
							</tr>
						</table>
						</td>
					</tr>
                </table>
                <!-- 버튼 -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelOk()" class="btn_inputLine01"></td>
						<td align="center" valign="top">
						<input type="button" value="정보 수정" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'" class="btn_inputBlue01"></td>
						<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>

				<br><br><br>
				<?if($Content2) {?>
				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">작업자 답변</span>
              	</div>
				<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
						<th>작업자</th>
						<td> <?=$Name2?></td>
					</tr>
					<tr>
						<th>내 용</th>
						<td height="28">
						<table border="0" width="970px">
							<tr>
								<td style="border:0px"><?=$Content2_reply?></td>
							</tr>
						</table>
						</td>
					</tr>
                </table>
				<?}?>

				<!-- 입력 -->
				<?if($LoginAdminID=="interkorea") {?>
				<br><br>
				<form name="Form1" method="post" action="work_request_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="reply">
		<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
						<th>작성자</font></th>
						<td><input name="Name2" type="text"  size="40" value="<?=$Name2?>"></td>
					</tr>
					<tr>
						<th>상태</font></th>
						<td>
						<select name="Status" id="Status" style="width:150px">
							<option value="A" <?if($Status=="A") {?>selected<?}?>>접수</option>
							<option value="B" <?if($Status=="B") {?>selected<?}?>>작업중</option>
							<option value="C" <?if($Status=="C") {?>selected<?}?>>작업완료</option>
						</select>
						</td>
					</tr>
					<tr>
						<th>내 용</th>
						<td height="28"><textarea name="Content2" id="Content2" rows="10" cols="150" ><?=$Content2?></textarea></td>
					</tr>
                </table>
                </form>
                <!-- 버튼 -->
  		  		<div class="btnAreaTc02" id="SubmitBtn">
                	<input type="button" name="SubmitBtn" id="SubmitBtn" value="답변 작성" class="btn_inputBlue01" onclick="ReplySubmitOk()">
          			<input type="button" name="ResetBtn" id="ResetBtn" value="목록" class="btn_inputLine01" onclick="location.href='<?=$PageName?>.php'">
                </div>
				<div class="btnAreaTc02" id="Waiting" style="display:none"><strong>처리중입니다...</strong></div>

<SCRIPT LANGUAGE="JavaScript">
<!--
function ReplySubmitOk() {

	val = document.Form1;

	Yes = confirm("등록하시겠습니까?");
	if(Yes==true) {
		$("#SubmitBtn").hide();
		$("#Waiting").show();
		val.submit();
	}
}
//-->
</SCRIPT>


		<?}?>

            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>