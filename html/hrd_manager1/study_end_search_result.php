<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$SearchGubun = Replace_Check($SearchGubun); //기간, 사업주 검색 구분
$CompanyName = Replace_Check($CompanyName); //사업주명
$SearchYear = Replace_Check($SearchYear); //검색 년도
$SearchMonth = Replace_Check($SearchMonth); //검색 월
$StudyPeriod = Replace_Check($StudyPeriod); //검색 기간
$StudyPeriod2 = Replace_Check($StudyPeriod2); //검색 기간2(사업주검색)
$CompanyCode = Replace_Check($CompanyCode); //사업자 번호
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일
$pg = Replace_Check($pg); //페이지


##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 10;
$block_size = 10;


##-- 검색 조건
$where = array();


if($SearchGubun=="A") { //기간 검색 

	if($CompanyCode) {
		$where[] = "a.CompanyCode='".$CompanyCode."'";
	}

	if($LectureStart) {
		$where[] = "a.LectureStart='".$LectureStart."'";
	}

	if($LectureEnd) {
		$where[] = "a.LectureEnd='".$LectureEnd."'";
	}

}

if($SearchGubun=="B") { //사업주  검색 

	if($CompanyName) {
		$where[] = "b.CompanyName LIKE '%".$CompanyName."%'";
	}

	if($LectureStart) {
		$where[] = "a.LectureStart='".$LectureStart."'";
	}

	if($LectureEnd) {
		$where[] = "a.LectureEnd='".$LectureEnd."'";
	}

}

$where[] = "a.ServiceType IN (1,3,5)";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$str_orderby = "ORDER BY a.LectureStart ASC, a.LectureEnd ASC";

$Colume = "DISTINCT(a.LectureStart) AS LectureStart, a.LectureEnd 
				 ";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode 
					";

$Sql2 = "SELECT COUNT(DISTINCT(a.LectureStart), a.LectureEnd) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];
//echo $TOT_NO."<br>";
//echo "SELECT COUNT(DISTINCT(a.LectureStart), a.LectureEnd) FROM $JoinQuery $where"."<br>";

##-- 페이지 클래스 생성
$PageFun = "StudyEndSearch"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>번호</th>
		<th>수강기간</th>
		<th>교육비</th>
		<th>최종 환급액</th>
		<th>자부담금</th>
		<th>수강인원</th>
		<th>첨삭현황</th>
		<th>점수확인</th>
		<th>수강마감</th>
		<th>수료증 출력</th>
		<th>수료결과보고서</th>
	</tr>
	<?
	$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
	//echo $SQL."<br><br>";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		while($ROW = mysqli_fetch_array($QUERY))
		{
			extract($ROW);
	
			//첨삭완료일
			$Tutor_limit_day = strtotime("$LectureEnd +4 days");

	?>
	<tr>
		<td  height="28"><?=$PAGE_UNCOUNT--?></td>
		<td ><strong><?=$LectureStart?> ~ <?=$LectureEnd?></strong></td>
		<td  colspan="3">첨삭완료 : <?=date("Y-m-d", $Tutor_limit_day)?> 까지</td>
		<td  colspan="6">&nbsp;</td>
	</tr>
	<?
		if($SearchGubun=="B") {
			$where2 = " AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd'";
		}

		$SQL2 = "SELECT DISTINCT(a.CompanyCode), b.CompanyName, 
					(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5)) AS Price, 
					(SELECT SUM(rPrice) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5)) AS rPrice, 
					(SELECT SUM(rPrice2) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5)) AS rPrice2,
					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS StudyCount, 
					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (3,5)) AS StudyBeCount, 
					(SELECT CONCAT(f.MidRate,'|',f.TestRate,'|',f.ReportRate) FROM Study AS e LEFT OUTER JOIN Course AS f ON e.LectureCode=f.LectureCode WHERE e.LectureStart=a.LectureStart AND e.LectureEnd=a.LectureEnd AND e.CompanyCode=a.CompanyCode AND e.ServiceType=1 LIMIT 1) AS ExamRate, 
					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1 AND MidStatus='C') AS StudyMidCount, 
					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1 AND TestStatus='C') AS StudyTestCount, 
					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1 AND ReportStatus='C') AS StudyReportCount, 
					(SELECT CONCAT_WS('|',ResultViewInputID,ResultViewInputDate,StudyEndInputID,StudyEndInputDate) FROM StudyEnd WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode) AS StudyEndString 
					FROM $JoinQuery $where $where2 ORDER BY b.CompanyName ASC";
		//echo $SQL2."<br><br>";
		$QUERY2 = mysqli_query($connect, $SQL2);
		if($QUERY2 && mysqli_num_rows($QUERY2))
		{
			while($ROW2 = mysqli_fetch_array($QUERY2))
			{

				$CompanyCode = $ROW2['CompanyCode'];

				$ExamRate = $ROW2['ExamRate'];
				$ExamRate_array = explode('|',$ExamRate);
				$MidRate = $ExamRate_array[0];
				$TestRate = $ExamRate_array[1];
				$ReportRate = $ExamRate_array[2];

				$StudyCount = $ROW2['StudyCount'];
				$StudyBeCount = $ROW2['StudyBeCount'];

				if($MidRate>0) {
					$TutorMid = $StudyCount;
				}else{
					$TutorMid = 0;
				}

				if($TestRate>0) {
					$TutorTest = $StudyCount;
				}else{
					$TutorTest = 0;
				}

				if($ReportRate>0) {
					$TutorReport = $ROW2['StudyCount'];
				}else{
					$TutorReport = 0;
				}

				$StudyMidCount = $ROW2['StudyMidCount'];
				$StudyTestCount = $ROW2['StudyTestCount'];
				$StudyReportCount = $ROW2['StudyReportCount'];

				$StudyEndString = $ROW2['StudyEndString'];
				$StudyEndString_array = explode('|',$StudyEndString);
				$ResultViewInputID = $StudyEndString_array[0];
				$ResultViewInputDate = $StudyEndString_array[1];
				$StudyEndInputID = $StudyEndString_array[2];
				$StudyEndInputDate = $StudyEndString_array[3];

	?>
	<tr>
		<td >&nbsp;</td>
		<td ><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$ROW2['CompanyName']?><br><br><?=$CompanyCode?></a></td>
		<td ><?=number_format($ROW2['Price'],0)?></td>
		<td ><?=number_format($ROW2['rPrice'],0)?></td>
		<td ><?=number_format($ROW2['rPrice2'],0)?></td>
		<td >
		환급 : <?=$StudyCount?><br />
		비환급 : <?=$StudyBeCount?></td>
		<td >
		중간 : <?=$StudyMidCount?> / <?=$TutorMid?><br />
		최종 : <?=$StudyTestCount?> / <?=$TutorTest?><br />
		과제 : <?=$StudyReportCount?> / <?=$TutorReport?></td>
		<td >
		<?if($StudyCount>0) {?>
			<?if($ResultViewInputID) {?>
			처리자 : <?=$ResultViewInputID?><br />
			처리일 : <?=$ResultViewInputDate?>
			<?}else{?>
			<input type="button" name="ResultViewBtn" id="ResultViewBtn" value="확인 처리" class="btn_inputSm01" onclick="StudyEndComplete('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','ResultView')" />
			<?}?>
		<?}else{?>
		-
		<?}?>
		</td>
		<td >
		<?if($StudyCount>0) {?>
			<?if($StudyEndInputID) {?>
			처리자 : <?=$StudyEndInputID?><br />
			처리일 : <?=$StudyEndInputDate?>
			<?}else{?>
			<input type="button" name="StudyEndBtn" id="StudyEndBtn" value="마감 처리" class="btn_inputSm01" onclick="StudyEndComplete('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','StudyEnd')" />
			<?}?>
		<?}else{?>
		-
		<?}?>
		</td>
		<td >
			<input type="button" name="CertBtn01" id="CertBtn01" value="개인(환급)" class="btn_inputSm01" style="width:80px" onclick="StudyEndCertificatePrintPage('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','Y')" />
			<input type="button" name="CertBtn02" id="CertBtn02" value="환급  PDF" class="btn_inputSm02" style="width:110px" onclick="StudyEndCertificatePrintPDF('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','Y')" />
			<br />
			<input type="button" name="CertBtn03" id="CertBtn03" value="개인(비환급)" class="btn_inputSm01" style="width:80px" onclick="StudyEndCertificatePrintPage('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','N')" />
			<input type="button" name="CertBtn04" id="CertBtn04" value="비환급 수료증 PDF" class="btn_inputSm02" style="width:110px" onclick="StudyEndCertificatePrintPDF('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','N')" /></td>
		<td >
			<input type="button" name="CertBtn05" id="CertBtn05" value="개설현황" class="btn_inputSm01" style="width:70px" onclick="location.href='study_end_result01.php?CompanyCode=<?=$CompanyCode?>&LectureStart=<?=$LectureStart?>&LectureEnd=<?=$LectureEnd?>'" />
			<input type="button" name="CertBtn06" id="CertBtn06" value="신청현황" class="btn_inputSm01" style="width:70px" onclick="location.href='study_end_result02.php?CompanyCode=<?=$CompanyCode?>&LectureStart=<?=$LectureStart?>&LectureEnd=<?=$LectureEnd?>'" />
			<br />
			<input type="button" name="CertBtn07" id="CertBtn07" value="환급과정만" class="btn_inputSm01" style="width:70px" onclick="StudyEndDocument('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','Y')" />
			<input type="button" name="CertBtn08" id="CertBtn08" value="전체" class="btn_inputSm01" style="width:70px" onclick="StudyEndDocument('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','N')" />
			<br />
			<input type="button" name="CertBtn09" id="CertBtn09" value="수납 확인서" class="btn_inputSm01" style="width:70px" onclick="location.href='receipt_confirm_excel.php?CompanyCode=<?=$CompanyCode?>&LectureStart=<?=$LectureStart?>&LectureEnd=<?=$LectureEnd?>'" />
			<input type="button" name="CertBtn09" id="CertBtn10" value="설문 결과" class="btn_inputSm01" style="width:70px" onclick="StudyEndDocumentPoll('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>');" />
			</td>
	</tr>
	<?
			}
		}



		}
	}else{
	?>
	<tr>
		<td height="28"  colspan="20">검색된 내용이 없습니다.</td>
	</tr>
	<? } ?>
	
	</tr>
</table>

<!--페이지 버튼-->
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:15px;">
  <tr>
	<td align="center" valign="top"><?=$BLOCK_LIST?></td>
  </tr>
</table>
<?
mysqli_close($connect);
?>
