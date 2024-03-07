<?
$MenuType = "D";
$PageName = "contents";
$ReadPage = "contents_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>기초차시 관리</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM Contents WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Gubun = $Row['Gubun'];
	$ContentsTitle = $Row['ContentsTitle'];
	$LectureTime = $Row['LectureTime']; //수강시간
	$Expl01 = nl2br($Row['Expl01']);
	$Expl02 = nl2br($Row['Expl02']);
	$Expl03 = nl2br($Row['Expl03']);
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 기초차시를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}

function ContentsDetailDelete(mode,Seq,Contents_idx) {
	del_confirm = confirm("클릭한 상세 구성을 삭제하시겠습니까?");
	if(del_confirm==true) {
		document.DeleteForm2.Seq.value = Seq;
		document.DeleteForm2.Contents_idx.value = Contents_idx;
		DeleteForm2.submit();
	}
}
//-->
</SCRIPT>
                <!-- 입력 -->
				<form name="DeleteForm" method="post" action="contents_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
				<form name="DeleteForm2" method="post" action="contents_detail_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="Seq">
					<INPUT TYPE="hidden" name="Contents_idx">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
					<tr>
						<th>차시 구분</th>
						<td> <?=$Gubun?></td>
					</tr>
					<tr>
						<th>차시명</th>
						<td> <?=$ContentsTitle?></td>
					</tr>
					<tr>
						<th>수강시간</th>
						<td> <?=$LectureTime?>분</td>
					</tr>
					<tr>
						<th>차시 목표</th>
						<td> <?=$Expl01?></td>
					</tr>
					<tr>
						<th>훈련 내용</th>
						<td> <?=$Expl02?></td>
					</tr>
					<tr>
						<th>학습 활동</th>
						<td> <?=$Expl03?></td>
					</tr>
                </table>
                <!-- 버튼 -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<td align="left" width="150" valign="top"><input type="button" value="기초차시 삭제" onclick="DelOk()" class="btn_inputLine01"></td>
						<td align="center" valign="top">
						<input type="button" value="기초차시 수정" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'" class="btn_inputBlue01"></td>
						<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>
				<br><br>
				<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">기초차시 상세 구성</span>
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="추가 하기" class="btn_inputLine01" onclick="ContentsDetail('new','','<?=$idx?>');">
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="40px" />
				<col width="100px" />
				<col width="80px" />
				<col width="55px" />
				<col width="55px" />
				<col width="" />
				<col width="" />
				<col width="200px" />
				<col width="50px" />
				<col width="50px" />
				<col width="50px" />
			  </colgroup>
              <tr>
				<th>정렬<br>번호</th>
                <th>컨텐츠 유형</th>
				<th>강사명</th>
                <th>차시<br>페이지</th>
                <th>모바일<br>페이지</th>
				<th>컨텐츠 URL</th>
				<th>모바일 URL</th>
				<th>문제풀이 질문</th>
				<th>사용<br>유무</th>
				<th>수정</th>
				<th>삭제</th>
              </tr>
			<?
			$SQL = "SELECT *, (SELECT Name FROM Teacher WHERE idx=ContentsDetail.Teacher) AS TeacherName FROM ContentsDetail WHERE Contents_idx=$idx ORDER BY OrderByNum ASC, Seq ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
					extract($ROW);

					if($ContentsURLSelect=="A") {
						$ContentsURLSelectView ="(주)";
					}else{
						$ContentsURLSelectView ="(예비)";
					}

					if($ContentsType=="A") {
						$PlayerFunction = "FlashPlayer('".$ContentsURL."');";
					}
					if($ContentsType=="B") {
						$PlayerFunction = "MoviePlayer('".$ContentsURL."','A');";
						$PlayerFunction2 = "MoviePlayer('".$ContentsURL2."','B');";
					}
			?>
			<tr>
                <td align="center"  class="text01"><?=$OrderByNum?></td>
                <td align="center"  class="text01"><?=$ContentsType_array[$ContentsType]?><?if($ContentsType=="B") {?><?=$ContentsURLSelectView?><?}?></td>
				<td align="center"  class="text01"><?=$TeacherName?></td>
				<td align="center"  class="text01"><?=$ContentsPage?></td>
                <td align="center"  class="text01"><?=$ContentsMobilePage?></td>
				<td align="left" class="text01">
				<?if($ContentsURL && $ContentsType=="A") {?><a href="Javascript:<?=$PlayerFunction?>"><?=$ContentsURL?></a><?}?>
				<?if($ContentsURL && $ContentsType=="B") {?><a href="Javascript:<?=$PlayerFunction?>">(주) <?=$ContentsURL?></a><?}?>
				<?if($ContentsURL2 && $ContentsType=="B") {?><br><a href="Javascript:<?=$PlayerFunction2?>">(예비) <?=$ContentsURL2?></a><?}?>
				</td>
				<td align="left" class="text01">
				<?if($MobileURL && $ContentsType=="A") {?><a href="Javascript:MobilePlayer('<?=$MobileURL?>','A');"><?=$MobileURL?></a><?}?>
				<?if($MobileURL && $ContentsType=="B") {?><a href="Javascript:MobilePlayer('<?=$MobileURL?>','A');">(주) <?=$MobileURL?></a><?}?>
				<?if($MobileURL2 && $ContentsType=="B") {?><br><a href="Javascript:MobilePlayer('<?=$MobileURL2?>','B');">(예비) <?=$MobileURL2?></a><?}?>
				</td>
				<td class="text01" ><?=strcut_utf8($Question,30)?></td>
				<td align="center"  class="text01"><?=$UseYN_array[$UseYN]?></td>
				<td align="center"  class="text01"><input type="button"  value="수정" class="btn_inputSm01" onclick="ContentsDetail('edit','<?=$Seq?>','<?=$Contents_idx?>');"></td>
				<td align="center"  class="text01"><input type="button"  value="삭제" class="btn_inputSm01" onclick="ContentsDetailDelete('del','<?=$Seq?>','<?=$Contents_idx?>');"></td>
              </tr>
			<?
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="20" class="tc">상세 구성 내역이 없습니다.</td>
			</tr>
			<? } ?>
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