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

$where[] = "(a.".$StartColume." >= '".$LectureStart."' AND a.".$EndColume." <= '".$LectureEnd."')";
$where[] = "a.ServiceType=1";
$where[] = "a.SalesID='$SalesID'";


$where2[] = "(".$StartColume." >= '".$LectureStart."' AND ".$EndColume." <= '".$LectureEnd."')";
$where2[] = "ServiceType=1";
$where2[] = "SalesID='$SalesID'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$where2 = implode(" AND ",$where2);
if($where2) $where2 = "WHERE $where2";


$str_orderby = "ORDER BY b.ContentsName ASC";

//영업사원
$Sql = "SELECT * FROM StaffInfo WHERE ID='$SalesID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Name = $Row['Name'];
	$CommissionRatio = $Row['CommissionRatio'];
}
?>

	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>영업통계(사업주) 상세 정보</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                

			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">영업사원 : <?=$Name?></span>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="" />
				<col width="" />
				<col width="" />
				<col width="" />
				<col width="" />
				<col width="" />
				<col width="" />
			  </colgroup>
              <tr>
				<th>강의명</th>
				<th>수강 인원</th>
				<th>수료 인원</th>
				<th>이수율</th>
				<th>전체 매출</th>
				<th>영업자 수수료율</th>
				<th>예상 수당</th>
              </tr>
			<?
			$TotalStudyCount = 0;
			$TotalStudyPassOkCount = 0;
			$TotalSumPrice = 0;
			$TotalCommission = 0;

			$SQL = "SELECT DISTINCT(a.LectureCode), b.ContentsName FROM Study AS a LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode $where $str_orderby";
			//echo $SQL;
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
					extract($ROW);

					$Sql2 = "SELECT COUNT(Seq) FROM Study $where2 AND LectureCode='$LectureCode'";
					$Result2 = mysqli_query($connect, $Sql2);
					$Row2 = mysqli_fetch_array($Result2);
					$StudyCount = $Row2[0];

					$Sql2 = "SELECT COUNT(Seq) FROM Study $where2 AND LectureCode='$LectureCode' AND PassOk='Y'";
					$Result2 = mysqli_query($connect, $Sql2);
					$Row2 = mysqli_fetch_array($Result2);
					$StudyPassOkCount = $Row2[0];

					$Sql2 = "SELECT SUM(rPrice) FROM Study $where2 AND LectureCode='$LectureCode' AND PassOk='Y'";
					$Result2 = mysqli_query($connect, $Sql2);
					$Row2 = mysqli_fetch_array($Result2);
					$SumPrice = $Row2[0];


					$PassOkRatio = $StudyPassOkCount / $StudyCount * 100;
					$Commission = $SumPrice * $CommissionRatio * 0.01;
			?>
			<tr>
                <td><?=$TOT_NO--?><br /><?=$ServiceType_array[$ServiceType]?></td>
				<td><?=$Name?><br /><?=$ID?></td>
				<td><?=$ContentsName?><br />
				<?=$LectureStart?> ~ <?=$LectureEnd?><br />
				첨삭완료 : <?=date("Y-m-d", $Tutor_limit_day)?>까지</td>
				<td><?=$Progress?>%</td>
				<td><?=$Mid_View?></td>
				<td><?=$Test_View?></td>
				<td><?=$Report_View?></td>
				<td><?=$TotalScore_View?><br /><?=$PassOK_View?></td>
				<td><?=$TutorName?></td>
				<td><?=$CompanyName?><?if($Depart) {?><br />부서 : <?=$Depart?><?}?></td>
				<td><?=$certCount?></td>
              </tr>
			<?
				$i++;
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="20" class="tc">내역이 없습니다.</td>
			</tr>
			<? } ?>
            </table>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center"> </td>
					<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
<?
mysqli_close($connect);
?>