<?
$MenuType = "D";
$PageName = "poll_bank";
$ReadPage = "poll_bank_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>강사 관리</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM PollBank WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Gubun = $Row['Gubun'];
	$ExamType = $Row['ExamType'];
	$Question = nl2br($Row['Question']);
	$Example01 = $Row['Example01'];
	$Example02 = $Row['Example02'];
	$Example03 = $Row['Example03'];
	$Example04 = $Row['Example04'];
	$Example05 = $Row['Example05'];
	$UseYN = $Row['UseYN'];
	$RegDate = $Row['RegDate'];
	$OrderByNum = $Row['OrderByNum'];
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 설문 내용을 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}
//-->
</SCRIPT>
                <!-- 입력 -->
				<form name="DeleteForm" method="post" action="poll_bank_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
						<th>설문 구분</th>
						<td> <?=$Gubun?></td>
					</tr>
					<tr>
						<th>질문 유형</th>
						<td> <?=$PollType_array[$ExamType]?></td>
					</tr>
					<tr>
						<th>질문</th>
						<td> <?=$Question?></td>
					</tr>
					<tr>
						<th>예문1</th>
						<td> <?=$Example01?></td>
					</tr>
					<tr>
						<th>예문2</th>
						<td> <?=$Example02?></td>
					</tr>
					<tr>
						<th>예문3</th>
						<td> <?=$Example03?></td>
					</tr>
					<tr>
						<th>예문4</th>
						<td> <?=$Example04?></td>
					</tr>
					<tr>
						<th>예문5</th>
						<td> <?=$Example05?></td>
					</tr>
					<tr>
						<th>사용 여부</th>
						<td> <?=$UseYN_array[$UseYN]?></td>
					</tr>
					<tr>
						<th>등록일</th>
						<td> <?=$RegDate?></td>
					</tr>
					<tr>
						<th>정렬 순서</th>
						<td> <?=$OrderByNum?></td>
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