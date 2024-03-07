<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Seq = Replace_Check($Seq);

$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.PassOK, a.certCount, a.StudyEnd, a.LectureCode, a.CompanyCode, 
				b.ContentsName, b.MidRate, b.TestRate, b.ReportRate 
				 ";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
					";

$where = "WHERE a.Seq=$Seq";

$Sql = "SELECT $Colume FROM $JoinQuery $where";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Seq = $Row['Seq'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$ID = $Row['ID'];
	$ContentsName = $Row['ContentsName'];
}



?>

	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>차시별 상세 수강내역</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>과정명</th>
                    <td><?=$ContentsName?></td>
                  </tr>
				  <tr>
                    <th>수강 기간</th>
                    <td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
                  </tr>
                </table>
				<div id="ProgressHistory" style="left:10px; top:20px; width:100%; height:500px; z-index:1; overflow: auto; overflow-x:hidden;">
				<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
					<tr>
						<th>차시</th>
						<th>차시명</th>
						<th>진도</th>
						<th>수강시간</th>
						<th>수강IP</th>
						<th>수강일</th>
					</tr>
					<?
					$SQL = "SELECT a.Contents_idx, b.idx, a.Chapter_Number, b.ContentsTitle, a.Progress, a.StudyTime, a.UserIP, a.RegDate FROM Progress AS a LEFT OUTER JOIN Contents AS b ON a.Contents_idx=b.idx WHERE a.Study_Seq=$Seq AND ID='$ID' ORDER BY CAST(Chapter_Number AS SIGNED) ASC, idx ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							$StudyTime2 = Sec_To_His($StudyTime);
					?>
					<tr>
						<td><?=$Chapter_Number?></td>
						<td align="left"><?=$ContentsTitle?></td>
						<td><?=$Progress?>%</td>
						<td><?=$StudyTime2?></td>
						<td><?=$UserIP?></td>
						<td><?=$RegDate?></td>
					</tr>
					<?
						}
					}else{
					?>
					<tr>
						<td height="28" align="center" bgcolor="#FFFFFF" colspan="20">학습 내역이 없습니다.</td>
					</tr>
					<? } ?>
				</table>
				</div>

				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200">&nbsp;</td>
						<td align="center">&nbsp;</td>
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