<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$SearchGubun = Replace_Check($SearchGubun); //기간, 사업주 검색 구분
$CompanyName = Replace_Check($CompanyName); //사업주명
$SearchYear = Replace_Check($SearchYear); //검색 년도
$SearchMonth = Replace_Check($SearchMonth); //검색 월
$StudyPeriod = Replace_Check($StudyPeriod); //검색 기간
$CompanyCode = Replace_Check($CompanyCode); //사업자 번호
$ID = Replace_Check($ID); //이름, 아이디
$Progress1 = Replace_Check($Progress1); //진도율 시작
$Progress2 = Replace_Check($Progress2); //진도율 종료
$TotalScore1 = Replace_Check($TotalScore1); //총점 시작
$TotalScore2 = Replace_Check($TotalScore2); //총점 종료
$TutorStatus = Replace_Check($TutorStatus); //첨삭 여부
$LectureCode = Replace_Check($LectureCode); //강의 코드
$PassOk = Replace_Check($PassOk); //수료여부
$ServiceType = Replace_Check($ServiceType); //환급여부
$PackageYN = Replace_Check($PackageYN); //패키지 여부
$certCount = Replace_Check($certCount); //실명인증 횟수
$MidStatus = Replace_Check($MidStatus); //중간평가 상태
$TestStatus = Replace_Check($TestStatus); //최종평가 상태
$ReportStatus = Replace_Check($ReportStatus); //과제 상태
$ReportCopy = Replace_Check($ReportCopy); //모사답안 여부
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일
$pg = Replace_Check($pg); //페이지


##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 30;
$block_size = 10;


##-- 검색 조건
$where = array();


if($SearchGubun=="A") { //기간 검색 

	if($SearchYear) {
		$where[] = "YEAR(a.LectureStart)=".$SearchYear;
	}

	if($SearchMonth) {
		$where[] = "MONTH(a.LectureStart)=".$SearchMonth;
	}

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
		$where[] = "d.CompanyName LIKE '%".$CompanyName."%'";
	}

}



if($ID) {
	$where[] = "(a.ID='".$ID."' OR c.Name='".$ID."')";
}

if($Progress2) {
	if(!$Progress1) {
		$Progress1 = 0;
	}
	$where[] = "(a.Progress BETWEEN ".$Progress1." AND ".$Progress2.")";
}

if($TotalScore2) {
	if(!$TotalScore1) {
		$TotalScore1 = 0;
	}
	$where[] = "(a.TotalScore BETWEEN ".$TotalScore1." AND ".$TotalScore2.")";
}

if($TutorStatus=="N") {
	$where[] = "a.StudyEnd='N'";
}

if($LectureCode) {
	$where[] = "a.LectureCode='".$LectureCode."'";
}

if($PassOk) {
	$where[] = "a.PassOk='".$PassOk."'";
}

if($ServiceType) {
	$where[] = "a.ServiceType=".$ServiceType;
}

if($PackageYN) {
	if($PackageYN=="Y") {
		$where[] = "a.PackageRef>0";
	}
	if($PackageYN=="N") {
		$where[] = "a.PackageRef<1";
	}
}

if($certCount) {
	if($certCount=="Y") {
		$where[] = "g.CertDate IS NOT NULL";
	}else{
		$where[] = "g.CertDate IS NULL";
	}
}

if($MidStatus) {
	$where[] = "a.MidStatus='".$MidStatus."'";
}

if($TestStatus) {
	$where[] = "a.TestStatus='".$TestStatus."'";
}

if($ReportStatus) {
	$where[] = "a.ReportStatus='".$ReportStatus."'";
}

if($ReportCopy) {
	$where[] = "(a.TestCopy='".$ReportCopy."' OR a.ReportCopy='".$ReportCopy."')";
}


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


//$str_orderby = "ORDER BY a.Seq DESC";
$str_orderby = "ORDER BY c.Name ASC, a.Seq DESC";

//echo $where."<BR>";

$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.MidStatus, a.MidSaveTime, a.MidScore, a.TestStatus, a.TestScore, a.TestSaveTime, a.ReportStatus, a.ReportSaveTime,
				a.ReportScore, a.TotalScore, a.PassOK, a.certCount, a.StudyEnd, a.LectureCode, a.CompanyCode, 
				b.ContentsName, b.MidRate, b.TestRate, b.ReportRate, 
				c.Name, c.Depart, 
				d.CompanyName, 
				e.Name AS TutorName, 
				g.CertDate 
				 ";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
						LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
						LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
						LEFT OUTER JOIN UserCertOTP AS g ON a.Seq=g.Study_Seq AND a.ID=g.ID 
					";

$Sql2 = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];
//echo $TOT_NO;

?>
<script type="text/javascript">
<!--
	$(document).ready(function(){

	$(document).bind("scroll", function() {
		if(batching==true) {
			ProcesssRatioTop = $(window).scrollTop() + 300;
			$("div[id='ProcesssRatio']").animate({ top : ProcesssRatioTop }, 200);
		}
	});

});
//-->
</script>
<!--타이틀 -->
<?
if($TOT_NO>0) {
?>


<div class="mt20 tc pb5">
	<input type="button" name="SmsBtn" id="SmsBtn" value="SMS 발송" class="btn_inputGray01" style="width:230px;" onclick="StudySmsSend('sms')">
	<input type="button" name="EmailBtn" id="EmailBtn" value="e-mail 발송" class="btn_inputGray01" style="width:230px;" onclick="StudySmsSend('email')">
</div>
<?
}
?>
<!-- SMS // -->

<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>번호</th>
		<th>이름<br />ID</th>
		<th>과정명<br />수강기간</th>
		<th>진도율</th>
		<th>중간평가(%)<br />응시일</th>
		<th>최종평가(%)<br />응시일</th>
		<th>과제(%)<br />제출일</th>
		<th>
		<input type="radio" name="MessageMode" id="MessageMode_01" value="start" style="width:15px; height:15px; background:none; border:none;" /><br><label for="MessageMode_01">학습시작</label></th>
		<th>
		<input type="radio" name="MessageMode" id="MessageMode_02" value="00" style="width:15px; height:15px; background:none; border:none;" /><br><label for="MessageMode_02">0% 미만</label></th>
		<th>
		<input type="radio" name="MessageMode" id="MessageMode_03" value="30" style="width:15px; height:15px; background:none; border:none;" /><br><label for="MessageMode_03">30% 미만</label></th>
		<th>
		<input type="radio" name="MessageMode" id="MessageMode_04" value="50" style="width:15px; height:15px; background:none; border:none;" /><br><label for="MessageMode_04">50% 미만</label></th>
		<th>
		<input type="radio" name="MessageMode" id="MessageMode_05" value="80" style="width:15px; height:15px; background:none; border:none;" /><br><label for="MessageMode_05">80% 미만</label></th>
		<th>
		<input type="radio" name="MessageMode" id="MessageMode_06" value="final" style="width:15px; height:15px; background:none; border:none;" /><br><label for="MessageMode_06">최종독려</label></th>
		<th>
		<input type="radio" name="MessageMode" id="MessageMode_07" value="end" style="width:15px; height:15px; background:none; border:none;" /><br><label for="MessageMode_07">수강종료</label></th>
		<th>
		<input type="radio" name="MessageMode" id="MessageMode_08" value="result" style="width:15px; height:15px; background:none; border:none;" /><br><label for="MessageMode_08">결과확인</label></th>
		<th>사업주</th>
		<th>상태</th>
	</tr>
	<?
	$num = $TOT_NO;
	$i = 1;
	$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		while($ROW = mysqli_fetch_array($QUERY))
		{
			extract($ROW);
	
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
	?>
	<tr>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$num--?><br /><?=$ServiceType_array[$ServiceType]?><input type="hidden" name="check_seq" id="check_seq_<?=$i-1?>" value="<?=$Seq?>"></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:MemberInfo('<?=$ID?>');"><?=$Name?><br /><?=$ID?></a></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:CourseInfo('<?=$LectureCode?>');"><?=$ContentsName?></a><br />
		<?=$LectureStart?> ~ <?=$LectureEnd?><br />
		첨삭완료 : <?=date("Y-m-d", $Tutor_limit_day)?>까지</td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$Progress?>%</td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$Mid_View?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$Test_View?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$Report_View?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="EaBtn01" id="EaBtn01" value="내용보기" class="btn_inputSm01" onclick="StudySmsEASend('<?=$Seq?>','start')" /></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="EaBtn02" id="EaBtn02" value="내용보기" class="btn_inputSm01" onclick="StudySmsEASend('<?=$Seq?>','00')" /></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="EaBtn03" id="EaBtn03" value="내용보기" class="btn_inputSm01" onclick="StudySmsEASend('<?=$Seq?>','30')" /></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="EaBtn04" id="EaBtn04" value="내용보기" class="btn_inputSm01" onclick="StudySmsEASend('<?=$Seq?>','50')" /></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="EaBtn05" id="EaBtn05" value="내용보기" class="btn_inputSm01" onclick="StudySmsEASend('<?=$Seq?>','80')" /></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="EaBtn06" id="EaBtn06" value="내용보기" class="btn_inputSm01" onclick="StudySmsEASend('<?=$Seq?>','final')" /></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="EaBtn07" id="EaBtn07" value="내용보기" class="btn_inputSm01" onclick="StudySmsEASend('<?=$Seq?>','end')" /></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><input type="button" name="EaBtn08" id="EaBtn08" value="내용보기" class="btn_inputSm01" onclick="StudySmsEASend('<?=$Seq?>','result')" /></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$CompanyName?></a></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><div id="status">-</div></td>
	</tr>
	<?
		$i++;
		}
	}else{
	?>
	<tr>
		<td height="28" align="center" colspan="20">검색된 내용이 없습니다.</td>
	</tr>
	<? } ?>

</table>

<!-- btn -->
<?
if($TOT_NO>0) {
?>
<div class="mt20 tc pb5">
	<input type="button" name="SmsBtn" id="SmsBtn" value="SMS 발송" class="btn_inputGray01" style="width:230px;" onclick="StudySmsSend('sms')">
	<input type="button" name="EmailBtn" id="EmailBtn" value="e-mail 발송" class="btn_inputGray01" style="width:230px;" onclick="StudySmsSend('email')">
</div>
<?
}
?>
<div id="ProcesssRatio" style="position:absolute; left:800px;top:800px; width:500px; height:100px; background-color:#fff;font-size:60px; padding-top:15px;padding-bottom:15px; text-align:center; opacity:1.0; display:none"><br><br><span style="font-size:25px;">진행률</span> 0.00 %</div>