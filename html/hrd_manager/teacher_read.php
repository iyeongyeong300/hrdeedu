<?
$MenuType = "D";
$PageName = "teacher";
$ReadPage = "teacher_read";
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
$Sql = "SELECT * FROM Teacher WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Name = $Row['Name'];
	$Photo = $Row['Photo'];
	$Profile = $Row['Profile'];
	$Profile = nl2br($Profile);
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 강사를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}

//-->
</SCRIPT>
                <!-- 입력 -->
				<form name="DeleteForm" method="post" action="teacher_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>이름</th>
                    <td><?=$Name?></td>
                  </tr>
                  <tr>
                    <th>사진</th>
                    <td><img src="../upload/Course/<?=$Photo?>" width="150"></td>
                  </tr>
                  <tr>
                    <th>약력</th>
                    <td><?=$Profile?></td>
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