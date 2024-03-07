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





$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$str_orderby = "ORDER BY a.Seq DESC";

//echo $where."<BR>";

$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.MidStatus, a.MidSaveTime, a.MidScore, a.TestStatus, a.TestScore, a.TestSaveTime, a.ReportStatus, a.ReportSaveTime,
				a.ReportScore, a.TotalScore, a.PassOK, a.certCount, a.StudyEnd, a.StudyIP, a.MidIP, a.TestIP, a.ReportIP, a.TestCheckIP, a.ReportCheckIP, a.LectureCode,
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

$Sql = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];
//echo $TOT_NO;

##-- 페이지 클래스 생성
$PageFun = "StudyIPSearch"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>번호</th>
		<th>구분</th>
		<th>이름<br />ID</th>
		<th>과정명</th>
		<th>수강기간</th>
		<th>수강IP</th>
		<th>중간응시IP</th>
		<th>최종응시IP</th>
		<th>과제제출IP</th>
		<th>강사ID</th>
		<th>첨삭IP(평가/과제)</th>
		<th>차시별 내역</th>
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

	?>
	<tr>
		<td ><?=$PAGE_UNCOUNT--?></td>
		<td ><?=$ServiceType_array[$ServiceType]?></td>
		<td ><a href="Javascript:MemberInfo('<?=$ID?>');"><?=$Name?><br /><?=$ID?></a></td>
		<td align="left"><a href="Javascript:CourseInfo('<?=$LectureCode?>');"><?=$ContentsName?></a></td>
		<td ><?=$LectureStart?> ~ <?=$LectureEnd?><br />
		첨삭완료 : <?=date("Y-m-d", $Tutor_limit_day)?>까지</td>
		<td ><?=$StudyIP?></td>
		<td ><?=$MidIP?></td>
		<td ><?=$TestIP?></td>
		<td ><?=$ReportIP?></td>
		<td ><?=$TutorName?></td>
		<td ><?=$TestCheckIP?> / <?=$ReportCheckIP?></td>
		<td ><button type="button" name="EaBtn01" id="EaBtn01" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="StudyIPChapter('<?=$Seq?>')">상세 보기</button></td>
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