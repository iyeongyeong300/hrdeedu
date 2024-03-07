<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$TargetLectureCode = Replace_Check($TargetLectureCode);

$where = array();

$where[] = "a.PackageYN='N'";
$where[] = "a.Del='N'";
$where[] = "a.LectureCode!='$TargetLectureCode'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY a.ctype ASC, a.ContentsName ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}
?>
<div class="Content">

	<div class="contentBody">
		<!-- ########## -->
		<h2>차시 정보 가져오기</h2>
		
		<div class="conZone">
			<!-- ## START -->
			<div id="CourseList" style="left:0px; top:10px; width:100%; height:800px; z-index:1; overflow: auto; overflow-x:hidden;">
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="40px" />
				<col width="50px" />
				<col width="70px" />
				<col width="80px" />
				<col width="" />
				<col width="70px" />
				<col width="50px" />
				<col width="70px" />
				<col width="80px" />
				<col width="40px" />
				<col width="40px" />
				<col width="40px" />
				<col width="40px" />
				<col width="40px" />
			  </colgroup>
              <tr>
				<th>번호</th>
				<th>구분</th>
				<th>등&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;급<br>과정 코드</th>
				<th>서비스<br>구분</th>
				<th>과정 분류<br>과&nbsp;&nbsp;정&nbsp;&nbsp;명</th>
				<th>총차시<br>교육시간</th>
				<th>모바일</th>
				<th>사이트<br>노출</th>
				<th>8개 차시<br>수강 제한</th>
				<th>강의<br>차시</th>
				<th>중간<br>평가</th>
				<th>최종<br>평가</th>
				<th>과제</th>
				<th>선택</th>
              </tr>
			<?
			$i = 1;
			$SQL = "SELECT a.*, b.CategoryName AS Category1Name, c.CategoryName AS Category2Name,
				(SELECT COUNT(Seq) FROM Chapter WHERE LectureCode=a.LectureCode AND ChapterType='A') AS ChapterA, 
				(SELECT COUNT(Seq) FROM Chapter WHERE LectureCode=a.LectureCode AND ChapterType='B') AS ChapterB, 
				(SELECT COUNT(Seq) FROM Chapter WHERE LectureCode=a.LectureCode AND ChapterType='C') AS ChapterC, 
				(SELECT COUNT(Seq) FROM Chapter WHERE LectureCode=a.LectureCode AND ChapterType='D') AS ChapterD 
				FROM Course AS a 
				LEFT OUTER JOIN CourseCategory AS b ON a.Category1=b.idx 
				LEFT OUTER JOIN CourseCategory AS c ON a.Category2=c.idx 
				$where $str_orderby";
			//echo $SQL;
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
					extract($ROW);
			?>
			<tr>
				<td align="center"  ><?=$i?></td>
				<td align="center"  ><?=$CategoryType_array[$ctype]?></td>
				<td align="center" ><?=$ClassGrade_array[$ClassGrade]?><br><strong><?=$LectureCode?></strong></td>
				<td align="center" ><?=$ServiceTypeCourse_array[$ServiceType]?></td>
				<td align="left"><span class="sm"><?=$Category1Name?> <?if($Category2Name) {?> > <?=$Category2Name?><?}?></span><br><?if($Hit=="Y") {?><span class="redB">[인기]</span> <?}?><strong><?=$ContentsName?></strong></td>
				<td align="center" ><?=$Chapter?> 차시<br><?=$ContentsTime?> 시간</td>
				<td align="center" ><?=$UseYN_array[$Mobile]?></td>
				<td align="center" ><?=$UseYN_array[$UseYN]?></td>
				<td align="center" ><?=$ChapterLimit_array[$ChapterLimit]?></td>
				<td align="center" ><?=$ChapterA?>건</td>
				<td align="center" ><?=$ChapterB?>건</td>
				<td align="center" ><?=$ChapterC?>건</td>
				<td align="center" ><?=$ChapterD?>건</td>
				<td align="center" ><a href="Javascript:ChapterCopyApply('<?=$LectureCode?>');"><img src="images/btn_select.gif"></a></td>
              </tr>
			<?
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="20" class="tc">등록된 단과 컨텐츠가 없습니다.</td>
			</tr>
			<? } ?>
            </table>
			</div>

			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>&nbsp;</td>
					<td height="15">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="100" valign="top">&nbsp;</td>
					<td align="center" valign="top">&nbsp;</td>
					<td width="100" align="right" valign="top"><input type="button" value="닫기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>
			<form name="ChapterCopyForm" action="chapter_copy_apply.php" target="ScriptFrame">
				<input type="hidden" name="TargetLectureCode" id="TargetLectureCode" value="<?=$TargetLectureCode?>">
				<input type="hidden" name="LectureCode" id="LectureCode">
			</form>

			
			<!-- ## END -->
		</div>
		<!-- ########## // -->
	</div>

</div>

<?
mysqli_close($connect);
?>