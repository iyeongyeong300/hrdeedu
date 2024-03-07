<?
$MenuType = "E";
$PageName = "faq";
$ReadPage = "faq_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>자주 묻는 질문</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM Faq WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$UseYN = $Row['UseYN'];
	$OrderByNum = $Row['OrderByNum'];
	$Category = $Row['Category'];
	$Title = $Row['Title'];
	$Content = stripslashes($Row['Content']);
	$RegDate = $Row['RegDate'];

	if($UseYN=="Y") {
		$UseYN_MSG = "<font color='blue'>사용</font>";
	}else{
		$UseYN_MSG = "<font color='red'>미사용</font>";
	}
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
				<form name="DeleteForm" method="post" action="faq_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>제목</th>
                    <td><?=$Title?></td>
                  </tr>
                  <tr>
                    <th>분류</th>
                    <td><?=$Faq_array[$Category]?></td>
                  </tr>
                  <tr>
                    <th>정렬 순서</th>
                    <td><?=$OrderByNum?></td>
                  </tr>
				  <tr>
                    <th>사용 유무</th>
                    <td><?=$UseYN_MSG?></td>
                  </tr>
				  <tr>
                    <th>등록일</th>
                    <td><?=$RegDate?></td>
                  </tr>
				  <tr>
                    <th>내용</th>
                    <td>
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