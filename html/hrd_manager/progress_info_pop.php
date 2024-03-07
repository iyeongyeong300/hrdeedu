<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$LectureCode = Replace_Check($LectureCode);
$Study_Seq = Replace_Check($Study_Seq);
?>

	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>학습내역 상세 정보</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
	<div class="btnAreaTl02">
		<span class="fs16b fc333B sub_title2">수강 정보</span>
	</div>
<?
$where = "WHERE a.ID='$ID' AND a.LectureCode='$LectureCode' AND a.Seq=$Study_Seq";

$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.MidStatus, a.MidSaveTime, a.MidScore, a.TestStatus, a.TestScore, a.TestSaveTime, a.ReportStatus, a.ReportSaveTime,
	a.ReportScore, a.TotalScore, a.PassOK, a.certCount, a.StudyEnd, 
	b.ContentsName, b.MidRate, b.TestRate, b.ReportRate, 
	c.Name, c.Depart, 
	d.CompanyName, 
	e.Name AS TutorName 
	 ";

$JoinQuery = " Study AS a 
			LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
			LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
			LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
			LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
		";

$Sql = "SELECT $Colume FROM $JoinQuery $where ORDER BY a.Seq DESC";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ServiceType = $Row['ServiceType'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$Progress = $Row['Progress'];
	$MidStatus = $Row['MidStatus'];
	$MidSaveTime = $Row['MidSaveTime'];
	$MidScore = $Row['MidScore'];
	$TestStatus = $Row['TestStatus'];
	$TestScore = $Row['TestScore'];
	$TestSaveTime = $Row['TestSaveTime'];
	$ReportStatus = $Row['ReportStatus'];
	$ReportSaveTime = $Row['ReportSaveTime'];
	$ContentsName = $Row['ContentsName'];
	$MidRate = $Row['MidRate'];
	$TestRate = $Row['TestRate'];
	$ReportRate = $Row['ReportRate'];
	$Name = $Row['Name'];
	$Depart = $Row['Depart'];
	$CompanyName = $Row['CompanyName'];
	$TutorName = $Row['TutorName'];
	$ReportScore = $Row['ReportScore'];
	$TotalScore = $Row['TotalScore'];
	$PassOK = $Row['PassOK'];
	$certCount = $Row['certCount'];
	$StudyEnd = $Row['StudyEnd'];

	//첨삭완료일
	$Tutor_limit_day = strtotime("$LectureEnd +4 days");

	//중간평가
	if($MidRate<1) {
		$Mid_View = "평가 없음";
	}else{
		switch($MidStatus) {
			case "C":
				$MidRatePercent = $MidScore * $MidRate / 100;
				$Mid_View = $MidScore."(".$MidRatePercent.")<BR>".$MidSaveTime;
			break;
			case "Y":
				$Mid_View = "채점 대기중<BR>".$MidSaveTime;
			break;
			case "N":
				$Mid_View = "<span class='fcOrg01B'>미응시</span>";
			break;
			default :
				$Mid_View = "";
		}
	}

	//최종평가
	if($TestRate<1) {
		$Test_View = "평가 없음";
	}else{
		switch($TestStatus) {
			case "C":
				$TestRatePercent = $TestScore * $TestRate / 100;
				$Test_View = $TestScore."(".$TestRatePercent.")<BR>".$TestSaveTime;
			break;
			case "Y":
				$Test_View = "채점 대기중<BR>".$TestSaveTime;
			break;
			case "N":
				$Test_View = "<span class='fcOrg01B'>미응시</span>";
			break;
			default :
				$Test_View = "";
		}
	}

	//과제
	if($ReportRate<1) {
		$Report_View = "과제 없음";
	}else{
		switch($ReportStatus) {
			case "C":
				$ReportRatePercent = $ReportScore * $ReportRate / 100;
				$Report_View = $ReportScore."(".$ReportRatePercent.")<BR>".$ReportSaveTime;
			break;
			case "Y":
				$Report_View = "채점 대기중<BR>".$ReportSaveTime;
			break;
			case "N":
				$Report_View = "<span class='fcOrg01B'>미응시</span>";
			break;
			case "R":
				$Report_View = "반려";
			break;
			default :
				$Report_View = "";
		}
	}


	if(is_null($TotalScore)) {
		$TotalScore_View = "-";
	}else{
		$TotalScore_View = $TotalScore;
	}

	switch($PassOK) {
		case "N":
			$PassOK_View = "<span class='fcOrg01B'>미수료</span>";
		break;
		case "Y":
			$PassOK_View = "<span class='fcSky01B'>수료</span>";
		break;
		default :
			$PassOK_View = "";
	}



}
?>
	<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
		<tr>
			<th>구분</th>
			<th colspan="2">과정명</th>
			<th>이름</th>
			<th>ID</th>
			<th>진도율</th>
			<th>수강기간</th>
		</tr>
		<tr>
			<td ><?=$ServiceType_array[$ServiceType]?></td>
			<td colspan="2"><?=$ContentsName?></td>
			<td><?=$Name?></td>
			<td><?=$ID?></td>
			<td><?=$Progress?>%</td>
			<td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
		</tr>
		<tr>
			<th>중간평가(%) / 응시일</th>
			<th>최종평가(%) / 응시일</th>
			<th>과제(%) / 제출일</th>
			<th>총점</th>
			<th>수료여부</th>
			<th>교·강사</th>
			<th>사업주</th>
		</tr>
		<tr>
			<td><?=$Mid_View?></td>
			<td><?=$Test_View?></td>
			<td><?=$Report_View?></td>
			<td><?=$TotalScore_View?></td>
			<td><?=$PassOK_View?></td>
			<td><?=$TutorName?></td>
			<td><?=$CompanyName?></td>
		</tr>
	</table>

	<div class="btnAreaTl02">
		<span class="fs16b fc333B sub_title2">학습 내역</span>
	</div>

	<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
		<tr>
			<th>차시</th>
			<th>차시명</th>
			<th>진도</th>
			<th>학습시간</th>
			<th>최종 수강 IP</th>
			<th>최종 수강시간</th>
		</tr>
		<?
		$k = 1;
		$SQL = "SELECT a.Seq AS Chapter_Seq, a.ChapterType, a.OrderByNum, a.Sub_idx, 
						b.Gubun AS ContentGubun, b.ContentsTitle, b.idx AS Contents_idx, 
						c.Progress AS ChapterProgress, c.UserIP AS ChapterUserIP, c.RegDate AS ChapterRegDate, c.TriggerYN, c.StudyTime 
						FROM Chapter AS a 
						LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx 
						LEFT OUTER JOIN Progress AS c ON a.Seq=c.Chapter_Seq AND b.idx=c.Contents_idx AND c.ID='$ID' AND c.LectureCode='$LectureCode' AND c.Study_Seq=$Study_Seq 
						WHERE a.LectureCode='$LectureCode' ORDER BY a.OrderByNum ASC";
		//echo $SQL;
		$QUERY = mysqli_query($connect, $SQL);
		if($QUERY && mysqli_num_rows($QUERY))
		{
			while($ROW = mysqli_fetch_array($QUERY))
			{
			//extract($ROW);
		?>
		<?
		//강의 차시인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if($ROW['ChapterType']=="A") {

			if($ROW['ChapterProgress']>100) {
				$ChapterProgress = 100;
			}else{
				$ChapterProgress = $ROW['ChapterProgress'];
			}

			$ChapterProgress = number_format($ChapterProgress,0);
			$StudyTime = Sec_To_His($ROW['StudyTime']);
		?>
		<tr bgcolor="#FFFFFF">
			<td ><?=$k?></td>
			<td class="tl"><a href="Javascript:ProgressInfoLog(<?=$k-1?>,'<?=$ID?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$ROW['Chapter_Seq']?>','<?=$ROW['Contents_idx']?>');"><?=$ROW['ContentsTitle']?></a></td>
			<td ><?=$ChapterProgress?>%</td>
			<td ><?=$StudyTime?></td>
			<td ><?=$ROW['ChapterUserIP']?></td>
			<td ><?=$ROW['ChapterRegDate']?></td>
		</tr>
		<tr style="display:none" id="ProgressDetail">
			<td  colspan="6"><div id="Progress_log"></div></td>
		</tr>
		<?
		$k++;
		}
		//강의 차시인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		?>
		<?
		//중간평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if($ROW['ChapterType']=="B") {

			$MidTestOk = "Y"; //중간평가가 존재하는 경우 Y로 설정(최종평가와 과제 응시 체크를 위해)

			if($Progress<50) { //중간평가는 진도율 50%이상만 응시가능

				$MidTest_msg = "진도부족";
				$MidTestStudy = "N";
				$LectureStudy = "N";

			}else{

				switch($MidStatus) { //중간평가 상태
					case "C": //채점 완료
						$MidTest_msg = $MidScore."점";
						$MidTestStudy = "N";
						$LectureStudy = "Y";
					break;
					case "N": //미응시
						$MidTest_msg = "미응시";
						$MidTestStudy = "Y";
						$LectureStudy = "N";
					break;
					case "Y": //응시완료
						$MidTest_msg = "응시완료 (채점중)";
						$MidTestStudy = "N";
						$LectureStudy = "Y";
					break;
				}

			}
		?>
		<tr class="total">
			<td >[평가]</td>
			<td><strong>중간평가</strong></td>
			<td  colspan="3"><?if($MidSaveTime) {?>시험응시일 : <?=$MidSaveTime?><?}?></td>
			<td ><?=$MidTest_msg?></td>
		</tr>
		<?
		}
		//중간평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		?>
		<?
		//최종평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if($ROW['ChapterType']=="C") {

			$TestOk = "Y"; //최종평가가 존재하는 경우 Y로 설정(과제 응시 체크를 위해)

			if($Progress<$PassProgress) { //최종평가는 진도율이 수료기준 진도율 이상만 응시가능

				$Test_msg = "진도부족";
				$TestStudy = "N";
				$LectureStudy = "N";

			}else{

				if($MidTestOk == "Y" && $MidStatus=="N") { //중간평가가 있고 미응시 했다면 최종평가 불가

					$Test_msg = "중간평가 미응시";
					$TestStudy = "N";
					$LectureStudy = "N";

				}else{

					switch($TestStatus) { //최종평가 상태
						case "C": //채점완료
							$Test_msg = $TestScore."점";
							$TestStudy = "N";
							$LectureStudy = "Y";
						break;
						case "N": //미응시
							$Test_msg = "미응시";
							$TestStudy = "Y";
							$LectureStudy = "N";
						break;
						case "Y": //응시완료
							$Test_msg = "응시완료 (채점중)";
							$TestStudy = "N";
							$LectureStudy = "Y";
						break;
					}

				}

			}
		?>
		<tr class="total">
			<td >[평가]</td>
			<td><strong>최종평가</strong></td>
			<td  colspan="3"><?if($TestSaveTime) {?>시험응시일 : <?=$TestSaveTime?><?}?></td>
			<td ><?=$Test_msg?></td>
		</tr>
		<?
		}
		//최종평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		?>
		<?
		//과제인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if($ROW['ChapterType']=="D") {

			$ReportOk = "N"; //과제가 존재하는 경우 Y로 설정

			if($Progress<$PassProgress) { //과제는 진도율이 수료기준 진도율 이상만 응시가능

				$Report_msg = "진도부족";
				$ReportStudy = "N";
				$LectureStudy = "N";

			}else{

				if($TestOk == "Y" && $TestStatus=="N") { //최종평가가 있고 미응시 했다면 과제 불가

					$Report_msg = "최종평가 미응시";
					$ReportStudy = "N";
					$LectureStudy = "N";

				}else{

					switch($ReportStatus) {
						case "C":
							$Report_msg = $ReportScore."점";
							$ReportStudy = "N";
							$LectureStudy = "Y";
						break;
						case "N":
							$Report_msg = "미응시";
							$ReportStudy = "Y";
							$LectureStudy = "N";
						break;
						case "Y":
							$Report_msg = "제출완료 (채점중)";
							$ReportStudy = "N";
							$LectureStudy = "Y";
						break;
					}

				}

			}
		?>
		<tr class="total">
			<td >[평가]</td>
			<td><strong>과제</strong></td>
			<td  colspan="3"><?if($ReportSaveTime) {?>시험응시일 : <?=$ReportSaveTime?><?}?></td>
			<td ><?=$Report_msg?></td>
		</tr>
		<?
		}
		//과제인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		?>
		<?
			}
		}else{
		?>
		<tr>
			<td  colspan="20">학습 내역이 없습니다.</td>
		</tr>
		<? } ?>
	</table>


	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
		<tr>
			<td align="left" width="200">&nbsp;</td>
			<td align="center"> </td>
			<td width="200" align="right"><button type="button" onclick="DataResultClose();" class="btn btn_DGray line">닫기</button></td>
		</tr>
	</table>

	


                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>