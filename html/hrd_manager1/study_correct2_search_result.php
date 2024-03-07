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
$TestCopy = Replace_Check($TestCopy); //평가모사답안 여부
$ReportCopy = Replace_Check($ReportCopy); //과제모사답안 여부
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

	if($LectureStart) {
		$where[] = "a.LectureStart='".$LectureStart."'";
	}

	if($LectureEnd) {
		$where[] = "a.LectureEnd='".$LectureEnd."'";
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
}else{
	$where[] = "a.ServiceType IN (4)";
}

if($PackageYN) {
	if($PackageYN=="Y") {
		$where[] = "a.PackageRef>0";
	}
	if($PackageYN=="N") {
		$where[] = "a.PackageRef<1";
	}
}

if($certCount!=="") {
	$where[] = "a.certCount=".$certCount;
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

if($TestCopy) {
	$where[] = "a.TestCopy='".$TestCopy."'";
}

if($ReportCopy) {
	$where[] = "a.ReportCopy='".$ReportCopy."'";
}




//첨삭강사의 경우 본인의 건만 체크
if($LoginAdminDept=="C") {
	$where[] = "a.Tutor='".$LoginAdminID."'";
}

//영업사원의 경우 본인의 건만 체크
if($LoginAdminDept=="B") {
	$where[] = "a.SalesID='".$LoginAdminID."'";
}


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


//$str_orderby = "ORDER BY a.Seq DESC";
$str_orderby = "ORDER BY c.Name ASC, a.Seq DESC";

//echo $where."<BR>";

$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.MidStatus, a.MidSaveTime, a.MidScore, a.TestStatus, a.TestScore, a.TestSaveTime, a.ReportStatus, a.ReportSaveTime,
				a.ReportScore, a.TotalScore, a.PassOK, a.certCount, a.StudyEnd, a.StudyIP, a.MidIP, a.TestIP, a.ReportIP, a.TestCheckIP, a.ReportCheckIP, a.LectureCode, a.Mosa, a.MidCheckIP, 
				b.ContentsName, b.MidRate, b.TestRate, b.ReportRate, 
				c.Name, c.Depart, 
				d.CompanyName, 
				e.Name AS TutorName, e.ID AS TutorID 
				 ";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
						LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
						LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
					";

$Sql = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];
//echo $TOT_NO;

##-- 페이지 클래스 생성
$PageFun = "StudyCorrectSearch2"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>번호</th>
		<th>구분</th>
		<th>ID<br />이름</th>
		<th>과정명<br />수강기간</th>
		<th>진도율</th>
		<th>첨삭기간</th>
		<th>강사ID<br />강사명</th>
		<th>중간 평가(%)<br />첨삭IP</th>
		<th>최종 평가(%)<br />첨삭IP</th>
		<th>과제(%)<br />첨삭IP</th>
		<th>모사의심</th>
		<th>첨삭여부</th>
		<th>총점<br />수료여부</th>
	</tr>
	<?
	$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
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
				$MidStatus = "C";
				$MidTutor = "N";
			}else{
				$MidTutor = "Y";
			}

			//최종평가
			if($TestRate<1) {
				$TestStatus = "C";
				$TestTutor = "N";
			}else{
				$TestTutor = "Y";
			}

			//과제
			if($ReportRate<1) {
				$ReportStatus = "C";
				$ReportTutor = "N";
			}else{
				$ReportTutor = "Y";
			}

			//중간평가 상태
			if(!$MidCheckIP) {
				$MidCheckIP = "-";
			}

			if($MidTutor == "N") {
				$MidTutor_View = "평가 없음<BR>-";
			}else{
				switch($MidStatus) {
					case "C":
						$MidRatePercent = $MidScore * $MidRate / 100;
						$MidTutor_View = "<a href=Javascript:StudyCorrectResult('".$Seq."','MidTest');>".$MidScore."(".$MidRatePercent.")<BR>".$MidCheckIP."</a>";
					break;
					case "Y":
						$MidTutor_View = "<a href=Javascript:StudyCorrectResult('".$Seq."','MidTest');>채점 대기중<BR>".$MidCheckIP."</a>";
					break;
					case "N":
						$MidTutor_View = "미응시<BR>-";
					break;
					default :
						$MidTutor_View = "";
				}
			}

			//최종평가 상태
			if(!$TestCheckIP) {
				$TestCheckIP = "-";
			}

			if($TestTutor == "N") {
				$TestTutor_View = "평가 없음<BR>-";
			}else{
				switch($TestStatus) {
					case "C":
						$TestRatePercent = $TestScore * $TestRate / 100;
						$TestTutor_View = "<a href=Javascript:StudyCorrectResult('".$Seq."','Test');>".$TestScore."(".$TestRatePercent.")<BR>".$TestCheckIP."</a>";
					break;
					case "Y":
						$TestTutor_View = "<a href=Javascript:StudyCorrectResult('".$Seq."','Test');>채점 대기중<BR>".$TestCheckIP."</a>";
					break;
					case "N":
						$TestTutor_View = "미응시<BR>-";
					break;
					default :
						$TestTutor_View = "";
				}
			}

			//과제 상태
			if(!$ReportCheckIP) {
				$ReportCheckIP = "-";
			}

			if($ReportTutor == "N") {
				$ReportTutor_View = "과제 없음<BR>-";
			}else{
				switch($ReportStatus) {
					case "C":
						$ReportRatePercent = $ReportScore * $ReportRate / 100;
						$ReportTutor_View = "<a href=Javascript:StudyCorrectResult('".$Seq."','Report');>".$ReportScore."(".$ReportRatePercent.")<BR>".$ReportCheckIP."</a>";
					break;
					case "Y":
						$ReportTutor_View = "<a href=Javascript:StudyCorrectResult('".$Seq."','Report');>채점 대기중<BR>".$ReportCheckIP."</a>";
					break;
					case "N":
						$ReportTutor_View = "미응시<BR>-";
					break;
					default :
						$ReportTutor_View = "";
				}
			}


			if($MidStatus=="Y" || $TestStatus=="Y" || $ReportStatus=="Y") {
				$tutorComplete = "첨삭중";
			}else{
				if($MidStatus=="C" && $TestStatus=="C" && $ReportStatus=="C") {
					$tutorComplete = "완료";
				}else{
					$tutorComplete = "-";
				}
			}


			if($Mosa=="Y") {
				$Mosa_View = "<span class='fcOrg01B'>의심</span>";
			}else{
				if($MidStatus=="C" && $TestStatus=="C" && $ReportStatus=="C") {
					$Mosa_View = "정상";
				}else{
					$Mosa_View = "-";
				}
				
			}


			if(is_null($TotalScore)) {
				$TotalScore_View = "-";
			}else{
				$TotalScore_View = $TotalScore;
			}


			if($StudyEnd=="N") {
				$PassOK_View = "진행중";
			}else{
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
	<tr>
		<td ><?=$PAGE_UNCOUNT--?><!-- |<?=$Seq?> --></td>
		<td ><?=$ServiceType_array[$ServiceType]?></td>
		<td ><a href="Javascript:MemberInfo('<?=$ID?>');"><?=$Name?><br /><?=$ID?></a></td>
		<td ><a href="Javascript:CourseInfo('<?=$LectureCode?>');"><?=$ContentsName?></a><br />
		<?=$LectureStart?> ~ <?=$LectureEnd?></td>
		<td ><a href="Javascript:ProgressInfo('<?=$ID?>','<?=$LectureCode?>',<?=$Seq?>);"><?=$Progress?>%</a></td>
		<td ><?=date("Y-m-d", $Tutor_limit_day)?>까지</td>
		<td ><?=$TutorID?><br />
		  <?=$TutorName?></td>
		<td ><?=$MidTutor_View?></td>
		<td ><?=$TestTutor_View?></td>
		<td ><?=$ReportTutor_View?></td>
		<td ><?=$Mosa_View?></td>
		<td ><?=$tutorComplete?></td>
		<td ><?=$TotalScore_View?><br /><?=$PassOK_View?></td>
	</tr>
	<?
		}
	}else{
	?>
	<tr>
		<td height="28"  colspan="20">검색된 내용이 없습니다.</td>
	</tr>
	<? } ?>
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