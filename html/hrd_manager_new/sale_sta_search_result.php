<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Dept_idx = Replace_Check($Dept_idx);
$DeptString = Replace_Check($DeptString);
$StartColume = Replace_Check($StartColume);
$EndColume = Replace_Check($EndColume);
$LectureStart = Replace_Check($LectureStart);
$LectureEnd = Replace_Check($LectureEnd);
$SalesID = Replace_Check($SalesID);

##-- 검색 조건
$where = array();
$where2 = array();
$where3 = array();
$where4 = array();

$where[] = "a.Dept='B'";

if($DeptString) {
	$where[] = "a.DeptString LIKE '".$DeptString."%'";
}


$where2[] = "b.Dept='B'";
$where2[] = "b.UseYN='Y'";
$where2[] = "b.Del='N'";

if($SalesID) {
	$where2[] = "(b.ID='".$SalesID."' OR b.Name='".$SalesID."')";
}


if(!$StartColume) {
	$StartColume = "LectureStart";
}

if(!$EndColume) {
	$EndColume = "LectureEnd";
}

if(!$LectureStart) {
	$LectureStart = date("Y")."-01-01";
}

if(!$LectureEnd) {
	$LectureEnd = date("Y-m-").get_end_day(date("Y"),date("m"));
}

if($StartColume=="InputDate") {
	$LectureStart = $LectureStart." 00:00:01";
}

if($EndColume=="InputDate") {
	$LectureEnd = $LectureEnd." 59:59:59";
}

$where3[] = "(c.".$StartColume." >= '".$LectureStart."' AND c.".$EndColume." <= '".$LectureEnd."')";
$where3[] = "c.ServiceType=1";
$where3[] = "c.SalesID=b.ID";


$where4[] = "e.Dept_idx=a.idx";
$where4[] = "(d.".$StartColume." >= '".$LectureStart."' AND d.".$EndColume." <= '".$LectureEnd."')";
$where4[] = "d.ServiceType=1";
$where4[] = "e.Dept='B'";
$where4[] = "e.UseYN='Y'";
$where4[] = "e.Del='N'";



$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$where2 = implode(" AND ",$where2);
if($where2) $where2 = "WHERE $where2";

$where3 = implode(" AND ",$where3);
if($where3) $where3 = "WHERE $where3";

$where4 = implode(" AND ",$where4);
if($where4) $where4 = "WHERE $where4";

$str_orderby = "ORDER BY a.OrderByNum ASC";
$str_orderby2 = "ORDER BY b.Name ASC";



//수강 인원
$FirstSubQuery01 = "(SELECT COUNT(d.Seq) FROM StaffInfo AS e LEFT OUTER JOIN Study AS d ON e.ID=d.SalesID $where4) AS StudyCount";
//수료 인원
$FirstSubQuery02 = "(SELECT COUNT(d.Seq) FROM StaffInfo AS e LEFT OUTER JOIN Study AS d ON e.ID=d.SalesID $where4 AND d.PassOk='Y') AS StudyPassOkCount";
//전체 매출
$FirstSubQuery03 = "(SELECT SUM(d.rPrice) FROM StaffInfo AS e LEFT OUTER JOIN Study AS d ON e.ID=d.SalesID $where4 AND d.PassOk='Y') AS SumPrice";
//수수료율 평균
$FirstSubQuery04 = "(SELECT AVG(e.CommissionRatio) FROM StaffInfo AS e WHERE e.Dept_idx=a.idx AND e.Dept='B' AND e.UseYN='Y' AND e.Del='N') AS CommissionRatio";
//예상 수당
$FirstSubQuery05 = "(SELECT SUM(d.rPrice * e.CommissionRatio * 0.01) FROM StaffInfo AS e LEFT OUTER JOIN Study AS d ON e.ID=d.SalesID $where4 AND d.PassOk='Y') AS Commission";



//수강 인원
$SecondSubQuery01 = "(SELECT COUNT(c.Seq) FROM Study AS c $where3) AS StudyCount";
//수료 인원
$SecondSubQuery02 = "(SELECT COUNT(c.Seq) FROM Study AS c $where3 AND c.PassOk='Y') AS StudyPassOkCount";
//전체 매출
$SecondSubQuery03 = "(SELECT SUM(c.rPrice) FROM Study AS c $where3 AND c.PassOk='Y') AS SumPrice";
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>구분</th>
		<th>수강 인원</th>
		<th>수료 인원</th>
		<th>이수율</th>
		<th>전체 매출</th>
		<th>영업자 수수료율</th>
		<th>예상 수당</th>
		<th>상세 보기</th>
	</tr>
	<?
	$TotalStudyCount = 0;
	$TotalStudyPassOkCount = 0;
	$TotalSumPrice = 0;
	$TotalCommission = 0;
	$TotalCount = 0;

	$SQL = "SELECT *, $FirstSubQuery01, $FirstSubQuery02, $FirstSubQuery03, $FirstSubQuery04, $FirstSubQuery05 FROM DeptStructure AS a $where $str_orderby";
	//echo $SQL;
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		while($ROW = mysqli_fetch_array($QUERY))
		{
			extract($ROW);

			switch($Deep) {
				case 1:
					$bgcolor = "#f2f2f2";
				break;
				case 2:
					$bgcolor = "#ffffe1";
				break;
				case 3:
					$bgcolor = "#ffdddd";
				break;
				case 4:
					$bgcolor = "#d9d9ff";
				break;
				case 5:
					$bgcolor = "#d9ecff";
				break;
				case 6:
					$bgcolor = "#d9ffd9";
				break;
				case 7:
					$bgcolor = "#e6ffe6";
				break;
				case 8:
					$bgcolor = "#ebf5f5";
				break;
				case 9:
					$bgcolor = "#e6f2f2";
				break;
				case 9:
					$bgcolor = "#d7ebff";
				break;

				default:
					$bgcolor = "#FFFFFF";
			}

			if(!$StudyPassOkCount || !$StudyCount) {
				$FirstPassOkRatio = 0;
			}else{
				$FirstPassOkRatio = $StudyPassOkCount / $StudyCount * 100;
			}

			if(!$CommissionRatio) {
				$CommissionRatio = 0;
			}
	?>
	<?
	if(!$SalesID) {
	?>
	<tr>
		<td align="center" bgcolor="<?=$bgcolor?>" class="text01"><?=$DeptName?></td>
		<td align="right" bgcolor="<?=$bgcolor?>" class="text01"><?=number_format($StudyCount) ?></td>
		<td align="right" bgcolor="<?=$bgcolor?>" class="text01"><?=number_format($StudyPassOkCount) ?></td>
		<td align="right" bgcolor="<?=$bgcolor?>" class="text01"><?=number_format($FirstPassOkRatio,2) ?> %</td>
		<td align="right" bgcolor="<?=$bgcolor?>" class="text01"><?=number_format($SumPrice) ?></td>
		<td align="right" bgcolor="<?=$bgcolor?>" class="text01"><?=number_format($CommissionRatio,2)?> %</td>
		<td align="right" bgcolor="<?=$bgcolor?>" class="text01"><?=number_format($Commission) ?></td>
		<td align="center" bgcolor="<?=$bgcolor?>" class="text01"><!-- <input type="button" name="SaleStaDetail" id="SaleStaDetail" value="상세 보기" class="btn_inputSm01" onclick="" /> --></td>
	</tr>
	<?
		$TotalCount++;
	}
	?>
	<?
		$SQL2 = "SELECT *, $SecondSubQuery01, $SecondSubQuery02, $SecondSubQuery03 FROM StaffInfo AS b $where2 AND b.Dept_idx=$idx $str_orderby2";
		//echo $SQL2."<BR><BR>";
		$QUERY2 = mysqli_query($connect, $SQL2);
		if($QUERY2 && mysqli_num_rows($QUERY2))
		{
			while($ROW2 = mysqli_fetch_array($QUERY2))
			{

			if(!$ROW2['StudyCount'] || !$ROW2['StudyPassOkCount']) {
				$SecondPassOkRatio = 0;
			}else{
				$SecondPassOkRatio = $ROW2['StudyPassOkCount'] / $ROW2['StudyCount'] * 100;
			}

			if(!$ROW2['SumPrice'] || !$ROW2['CommissionRatio']) {
				$SecondCommission = 0;
			}else{
				$SecondPassOkRatio = $ROW2['StudyPassOkCount'] / $ROW2['StudyCount'] * 100;
			}
	?>
	<tr>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$ROW2['Name']?><input type="hidden" name="check_seq" id="check_seq" value="<?=$ROW2['idx']?>"></td>
		<td align="right" bgcolor="#FFFFFF" class="text01"><?=number_format($ROW2['StudyCount']) ?></td>
		<td align="right" bgcolor="#FFFFFF" class="text01"><?=number_format($ROW2['StudyPassOkCount']) ?></td>
		<td align="right" bgcolor="#FFFFFF" class="text01"><?=number_format($SecondPassOkRatio,2) ?> %</td>
		<td align="right" bgcolor="#FFFFFF" class="text01"><?=number_format($ROW2['SumPrice']) ?></td>
		<td align="right" bgcolor="#FFFFFF" class="text01"><?=number_format($ROW2['CommissionRatio'],2)?> %</td>
		<td align="right" bgcolor="#FFFFFF" class="text01"><?=number_format($SecondCommission) ?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="SaleStaDetail" id="SaleStaDetail" value="상세 보기" class="btn_inputSm01" onclick="SaleStaDeptDetail('<?=$ROW2['ID']?>');" /></td>
	</tr>
	<?
		$TotalStudyCount = $TotalStudyCount + $ROW2['StudyCount'];
		$TotalStudyPassOkCount = $TotalStudyPassOkCount + $ROW2['StudyPassOkCount'];
		$TotalSumPrice = $TotalSumPrice + $ROW2['SumPrice'];
		$TotalCommission = $TotalCommission + $SecondCommission;
		$TotalCount++;
			}
		}
	?>
	<?
		}

		if(!$TotalStudyPassOkCount || !$TotalStudyCount) {
			$TotalPassOkRatio = 0;
		}else{
			$TotalPassOkRatio = $TotalStudyPassOkCount / $TotalStudyCount * 100;
		}
	?>
	<tr>
		<td align="center" bgcolor="#e2e9ed" class="text01"><strong>합계</strong></td>
		<td align="right" bgcolor="#e2e9ed" class="text01"><strong><?=number_format($TotalStudyCount) ?></strong></td>
		<td align="right" bgcolor="#e2e9ed" class="text01"><strong><?=number_format($TotalStudyPassOkCount) ?></strong></td>
		<td align="right" bgcolor="#e2e9ed" class="text01"><strong><?=number_format($TotalPassOkRatio,2) ?> %</strong></td>
		<td align="right" bgcolor="#e2e9ed" class="text01"><strong><?=number_format($TotalSumPrice) ?></strong></td>
		<td align="right" bgcolor="#e2e9ed" class="text01"> </td>
		<td align="right" bgcolor="#e2e9ed" class="text01"><strong><?=number_format($TotalCommission) ?></strong></td>
		<td align="center" bgcolor="#e2e9ed" class="text01"><input type="hidden" name="TotalCount" id="TotalCount" value="<?=$TotalCount?>"></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td height="28" align="center" bgcolor="#FFFFFF" class="text01" colspan="13">검색된 내용이 없습니다.</td>
	</tr>
	<? } ?>
</table>
<?
mysqli_close($connect);
?>