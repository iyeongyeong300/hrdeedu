<?
$MenuType = "E";
$PageName = "edudata";
$ReadPage = "edudata_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>학습자료실</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM StudyPDS WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$UseYN = $Row['UseYN'];
	$Notice = $Row['Notice'];
	$Category = $Row['Category']; //분류
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

	if($UseYN=="Y") {
		$UseYN_MSG = "<font color='blue'>사용</font>";
	}else{
		$UseYN_MSG = "<font color='red'>미사용</font>";
	}
	
	$CategoryName = $Edudata_array[$Category];
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
				<form name="DeleteForm" method="post" action="edudata_script.php" enctype="multipart/form-data" target="ScriptFrame">
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
						<td> <?if($Notice=="Y") {?><FONT COLOR="#FF3300">[공지]</FONT>&nbsp;&nbsp;<?}?><?=$Title?></td>
					</tr>
					<tr>
						<th>분 류</th>
						<td><?=$CategoryName?></td>
					</tr>
					<tr>
						<th>사용 유무</th>
						<td> <?=$UseYN_MSG?> </td>
					</tr>
					<tr>
						<th>조회수</th>
						<td> <?=$ViewCount?> </td>
					</tr>
					<tr>
						<th>첨부 파일 1</th>
						<td> 
						<?if($FileName1) { ?><A HREF="./download.php?idx=<?=$idx?>&code=StudyPDS&file=1" target="ScriptFrame"><?=$RealFileName1?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>첨부 파일 2</th>
						<td> 
						<?if($FileName2) { ?><A HREF="./download.php?idx=<?=$idx?>&code=StudyPDS&file=2" target="ScriptFrame"><?=$RealFileName2?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>첨부 파일 3</th>
						<td> 
						<?if($FileName3) { ?><A HREF="./download.php?idx=<?=$idx?>&code=StudyPDS&file=3" target="ScriptFrame"><?=$RealFileName3?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>첨부 파일 4</th>
						<td> 
						<?if($FileName4) { ?><A HREF="./download.php?idx=<?=$idx?>&code=StudyPDS&file=4" target="ScriptFrame"><?=$RealFileName4?></A><?}?>
						</td>
					</tr>
					<tr>
						<th>첨부 파일 5</th>
						<td> 
						<?if($FileName5) { ?><A HREF="./download.php?idx=<?=$idx?>&code=StudyPDS&file=5" target="ScriptFrame"><?=$RealFileName5?></A><?}?>
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
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>