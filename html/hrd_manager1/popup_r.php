<?
$MenuType = "G";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>팝업 관리</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$idx = Replace_Check($idx);
$pg = Replace_Check($pg);
$sw = Replace_Check($sw);
$col = Replace_Check($col);

$Sql = "SELECT * FROM Popup WHERE idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Title = $Row['Title'];
	$ImgWidth = $Row['ImgWidth'];
	$ImgHeight = $Row['ImgHeight'];
	$PopupLeft = $Row['PopupLeft'];
	$PopupTop = $Row['PopupTop'];
	$EndDate = $Row['EndDate'];
	$UseYN = $Row['UseYN'];
	$RegDate = $Row['RegDate'];
}

if(!$Name2) {
	$Name2 = "관리자";
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	function DelSend(no) {

		del = confirm("선택한 팝업을 삭제하시겠습니까?\n\n삭제된 내용은 복구되지 않습니다.");
		if(del==true) {
			document.delform.idx.value=no;
			delform.submit();
		}
	}
//-->
</SCRIPT>
                <!-- 입력 -->
				<form name="delform" method="post" action="popup_reg_script.php" enctype="multipart/form-data">
				<INPUT TYPE="hidden" NAME="idx">
				<INPUT TYPE="hidden" NAME="mode" value="del">
				</form>
				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">팝업 상세 정보</span>
				</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
					<col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>제목</th>
                    <td><?=$Title?></td>
					<th>위치</th>
                    <td>좌측:<?=$PopupLeft?>, 상단:<?=$PopupTop?></td>
                  </tr>
                  <tr>
                    <th>크기</th>
                    <td><?=$ImgWidth?> X <?=$ImgHeight?></td>
					<th>마감일</th>
                    <td><?=$EndDate?></td>
                  </tr>
                  <tr>
                    <th>사용여부</th>
                    <td><?=$UseYN?></td>
					<th>등록일</th>
                    <td><?=$RegDate?></td>
                  </tr>
                </table>
                <!-- 버튼 -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelSend('<?=$idx?>');" class="btn_inputLine01"></td>
						<td align="center" valign="top"><input type="button" value="수 정" onclick="location.href='popup_reg.php?idx=<?=$idx?>&mode=edit'" class="btn_inputBlue01"></td>
						<td align="right" width="150" valign="top"><input type="button" value="목록" onclick="location.href='popup.php?pg=<?=$pg?>&sw=<?=$sw?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>

				<br><br><br>
				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">링크 걸기( <font color=red>전체 영역에 링크를 걸려면 이미지맵 영역은 빈칸으로 함</font>)</span>
				</div>

				<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
					<colgroup>
                    <col width="40px" />
                    <col width="250px" />
                    <col width="" />
                    <col width="80px" />
                  </colgroup>
					<tr>
						<th>번호</th>
						<th>이미지맵 영역</th>
						<th>링크</th>
						<th>삭제</th>
					</tr>
					<?
					$SQL = "SELECT * FROM Popup_Link WHERE idx=$idx ORDER BY num ASC";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY) )
						{
						$i=1;
						while($row = mysqli_fetch_array($QUERY) )
							{
					?>
					<tr>
						<td><?=$i?></td>
						<td><?=$row['ImgArea']?></td>
						<td style="text-align:left"><?=$row['LinkURL']?></td>
						<td><a href="popup_link.php?mode=del&idx=<?=$idx?>&num=<?=$row['num']?>" onClick="return confirm('링크를 삭제합니까?')"><input type="button"  value="삭제" class="btn_inputSm01"></a></td>
					</tr>
					<?
						$i++;
							}
						}
						else
							{
					?>
					<tr>
							<td height="28" align="center" bgcolor="#FFFFFF" class="text01" colspan="10">등록된 링크가 없습니다.</td>
					</tr>
					<? } ?>
				</table>

				<form name="fmbook" method="post" action="popup_link.php?mode=new">
				<input type=hidden name="idx" value='<?=$idx?>'>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
					<col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>이미지맵 영역</th>
                    <td><input type="text" name="ImgArea" size="30" ></td>
					<th>링크 URL</th>
                    <td><input type="text" name="LinkURL" size="120"></td>
                  </tr>
                </table>


				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<td align="left" width="150" valign="top"> </td>
						<td align="center" valign="top">
						<span id="SubmitBtn"><input type="submit" value="등록 하기" onclick="return confirm('등록합니까?')" class="btn_inputBlue01"></span>
						</td>
						<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='popup.php?pg=<?=$pg?>&sw=<?=$sw?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>
				</form>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>