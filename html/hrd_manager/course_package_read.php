<?
$MenuType = "D";
$PageName = "course_package";
$ReadPage = "course_package_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>패키지 컨텐츠 관리</h2>

            <div class="conZone">
            	<!-- ## START -->
<?
$Sql = "SELECT * FROM Course WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$LectureCode = $Row['LectureCode']; //과정코드
	$UseYN = $Row['UseYN']; //사이트 노출
	$Category1 = $Row['Category1']; //과정분류 대분류
	$Category2 = $Row['Category2']; //과정분류 소분류
	$ContentsName = html_quote($Row['ContentsName']); //과정명

	$PackageYN = $Row['PackageYN']; //패키지 유무
	$PackageRef = $Row['PackageRef']; //패키지 번호
	$PackageLectureCode = $Row['PackageLectureCode']; //패키지에 포함된 강의 코드

	$PackageRef_pad = PackageRefLeftString($PackageRef);
}

$Sql = "SELECT * FROM CourseCategory WHERE Deep=1 AND UseYN='Y' AND Del='N' AND idx=$Category1";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Category1Name = $Row['CategoryName'];
}

$Sql = "SELECT * FROM CourseCategory WHERE Deep=2 AND UseYN='Y' AND Del='N' AND idx=$Category2";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Category2Name = " > ".$Row['CategoryName'];
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 컨텐츠를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}
//-->
</SCRIPT>

                <!-- 입력 -->
				<input type="hidden" name="LectureCodeValue" id="LectureCodeValue" value="<?=$LectureCode?>">
				<form name="DeleteForm" method="post" action="course_package_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
					<INPUT TYPE="hidden" name="LectureCode" value="<?=$LectureCode?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
					<col width="120px" />
                    <col width="" />
                  </colgroup>
					<tr>
						<th>과정코드</th>
						<td> <span class="redB"><?=$LectureCode?></span></td>
						<th>패키지 번호</th>
						<td> <span class="redB"><?=$PackageRef_pad?></span></td>
					</tr>
					<tr>
						<th>과정분류</th>
						<td> <?=$Category1Name?> <?=$Category2Name?></td>
						<th>사이트노출</th>
						<td> <?=$UseYN_array[$UseYN]?></td>
					</tr>
					<tr>
						<th>과정명</th>
						<td colspan="3"> <?=$ContentsName?></td>
					</tr>
                </table>
                <!-- 버튼 -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<td align="left" width="150" valign="top"><input type="button" value="컨텐츠 삭제" onclick="DelOk()" class="btn_inputLine01"></td>
						<td align="center" valign="top">
						<input type="button" value="컨텐츠 수정" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'" class="btn_inputBlue01"></td>
						<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>
				<br><br>
				<?if($AdminWrite=="Y") {?>
				<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">패키지 강의 검색</span>
				</div>
				<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
					<tr>
						<th>강의 검색</th>
						<td> <input name="ContentsName" id="ContentsName" type="text"  size="100" value="" maxlength="120">&nbsp;<input type="button" value="검색" onclick="PackageSearch();" class="btn_inputSm01"></td>
					</tr>
					<tr>
						<th>검색 결과</th>
						<td> <span id="PackageSearchResult"></span></td>
					</tr>
                </table>
				<?}?>

				<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">패키지로 선택한 단과 컨텐츠</span>
				</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="80px" />
				<col width="100px" />
				<col width="100px" />
				<col width="" />
				<col width="100px" />
				<col width="100px" />
				<?if($AdminWrite=="Y") {?>
				<col width="60px">
				<?}?>
			  </colgroup>
              <tr>
				<th>순서</th>
                <th>순서 조정</th>
				<th>강의 코드</th>
                <th>과정명</th>
                <th>수강 유형</th>
				<th>차시수</th>
				<?if($AdminWrite=="Y") {?>
				<th>삭제</th>
				<?}?>
              </tr>
			</table>
			<table id="PackageCourseTable" width="100%" cellpadding="0" cellspacing="0" class="list_ty01">
				<colgroup>
					<col width="80px" />
					<col width="100px" />
					<col width="100px" />
					<col width="" />
					<col width="100px" />
					<col width="100px" />
					<?if($AdminWrite=="Y") {?>
					<col width="60px">
					<?}?>
				  </colgroup>
			<?
			if($PackageLectureCode) {

				$PackageLectureCode_Array = explode("|",$PackageLectureCode);

				$i = 1;
				foreach ($PackageLectureCode_Array as $PackageLectureCode_Array_value) {

					$Sql = "SELECT * FROM Course WHERE PackageYN='N' AND Del='N' AND LectureCode='$PackageLectureCode_Array_value'";
					$Result = mysqli_query($connect, $Sql);
					$Row = mysqli_fetch_array($Result);
			?>
			<tr>
                <td align="center"><?=$i?></td>
                <td align="center"><input type="hidden" name="LectureCode_value_temp" id="LectureCode_value_temp" value="<?=$Row['LectureCode']?>"><input type="button" value="▲" onclick="PackageChapterListMoveUp(this);" style="width:30px;"> <input type="button" value="▼" onclick="PackageChapterListMoveDown(this);" style="width:30px;"></td>
				<td align="center"><?=$Row['LectureCode']?></td>
				<td align="left"><?=$Row['ContentsName']?></td>
                <td align="center"><?=$ServiceTypeCourse_array[$Row['ServiceType']]?></td>
				<td align="center"><?=$Row['Chapter']?>차시</td>
				<td align="center"><input type="button" value="삭제" onclick="Javascript:PackageChapterExamDelRow(this);" class="btn_inputSm01"></td>
              </tr>
			<?
				$i++;
				}
			}
			?>
            </table>
			<?if($AdminWrite=="Y") {?>
			<form name="Form1" method="POST" action="package_lecture_script.php" target="ScriptFrame">
				<input type="hidden" name="idx" id="idx" value="<?=$idx?>">
				<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
				<input type="hidden" name="PackageLectureCode" id="PackageLectureCode" value="<?=$PackageLectureCode?>">
			</form>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:20px">
				<tr>
					<td valign="top" ><input type="button" value="저장 하기" class="btn_inputBlue01" onclick="PackageChapterSave();"></td>
				</tr>
			</table>
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