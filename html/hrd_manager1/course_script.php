<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);
$mode = Replace_Check($mode);

$ClassGrade = Replace_Check($ClassGrade); //등급
$LectureCode = Replace_Check($LectureCode); //과정코드
$UseYN = Replace_Check($UseYN); //사이트 노출
$PassCode = Replace_Check($PassCode); //심사코드
$HrdCode = Replace_Check($HrdCode); //HRD-NET 과정코드
$Category1 = Replace_Check($Category1); //과정분류 대분류
$Category2 = Replace_Check($Category2); //과정분류 소분류
$ServiceType = Replace_Check($ServiceType); //수강방법
$ContentsName = Replace_Check($ContentsName); //과정명
$CompleteTime = Replace_Check($CompleteTime); //진도시간 기준
$ProgressCheck = Replace_Check($ProgressCheck); //진도체크방식
$Chapter = Replace_Check($Chapter); //차시수
$ContentsTime = Replace_Check($ContentsTime); //교육시간
$Price = Replace_Check($Price); //교육비용 일반
$Price01View = Replace_Check($Price01View); //교육비용 우선지원 
$Price02View = Replace_Check($Price02View); //교육비용 대규모 1000인 미만 
$Price03View = Replace_Check($Price03View); //교육비용 대규모 1000인 이상 
$Price01 = Replace_Check($Price01); //자부담금 교육비용 우선지원 
$Price02 = Replace_Check($Price02); //자부담금 교육비용 대규모 1000인 미만 
$Price03 = Replace_Check($Price03); //자부담금 교육비용 대규모 1000인 이상 
$Professor = Replace_Check($Professor); //내용전문가 
$Limited = Replace_Check($Limited); //학급정원
$ContentsPeriod = Replace_Check($ContentsPeriod); //컨텐츠 유효기간
$ContentsAccredit = Replace_Check($ContentsAccredit); //인정만료일 시작일
$ContentsExpire = Replace_Check($ContentsExpire); //인정만료일 종료일
$Cp = Replace_Check($Cp); //cp사
$Commission = Replace_Check($Commission); //cp 수수료
$Mobile = Replace_Check($Mobile); //모바일 지원
$BookPrice = Replace_Check($BookPrice); //교재비
$BookIntro = Replace_Check($BookIntro); //참고도서설명
$attachFile = Replace_Check($attachFile); //학습자료
$PreviewImage = Replace_Check($PreviewImage); //과정 이미지
$BookImage = Replace_Check($BookImage); //교재 이미지
$Mid01EA = Replace_Check($Mid01EA); //중간평가 객관식 문항수
$Mid01Score = Replace_Check($Mid01Score); //중간평가 객관식 배점
$Mid02EA = Replace_Check($Mid02EA); //중간평가 단답형 문항수
$Mid02Score = Replace_Check($Mid02Score); //중간평가 단답형 배점
$Mid03EA = Replace_Check($Mid03EA); //중간평가 서술형 문항수
$Mid03Score = Replace_Check($Mid03Score); //중간평가 서술형 배점
$Test01EA = Replace_Check($Test01EA); //최종평가 객관식 문항수
$Test01Score = Replace_Check($Test01Score); //최종평가 객관식 배점
$Test02EA = Replace_Check($Test02EA); //최종평가 단답형 문항수
$Test02Score = Replace_Check($Test02Score); //최종평가 단답형 배점
$Test03EA = Replace_Check($Test03EA); //최종평가 서술형 문항수
$Test03Score = Replace_Check($Test03Score); //최종평가 서술형 배점
$Report01EA = Replace_Check($Report01EA); //과제 객관식 문항수
$Report01Score = Replace_Check($Report01Score); //과제 객관식 배점
$Report02EA = Replace_Check($Report02EA); //과제 단답형 문항수
$Report02Score = Replace_Check($Report02Score); //과제 단답형 배점
$Report03EA = Replace_Check($Report03EA); //과제 서술형 문항수
$Report03Score = Replace_Check($Report03Score); //과제 서술형 배점
$TestTime = Replace_Check($TestTime); //시험제한시간
$MidRate = Replace_Check($MidRate); //반영비율 중간평가 
$TestRate = Replace_Check($TestRate); //반영비율 최종평가 
$ReportRate = Replace_Check($ReportRate); //반영비율 과제
$PassProgress = Replace_Check($PassProgress); //진도율  
$TotalPassMid = Replace_Check($TotalPassMid); //중간평가 : 총점
$TotalPassTest = Replace_Check($TotalPassTest); //최종평가 : 총점
$PassTest = Replace_Check($PassTest); //최종평가 : 득점
$TotalPassReport = Replace_Check($TotalPassReport); //과제 : 총점
$PassReport = Replace_Check($PassReport); //과제 : 득점
$PassScore = Replace_Check($PassScore); //반영비율을 적용한 총점
$Intro = Replace_Check2($Intro); //과정소개
$EduTarget = Replace_Check2($EduTarget); //교육대상
$EduGoal = Replace_Check2($EduGoal); //교육목표
$Hit = Replace_Check($Hit); //인기강의
$ChapterLimit = Replace_Check($ChapterLimit); //차시제한 여부
$tok2 = Replace_Check($tok2); //tok2 연계여부
$ctype = Replace_Check($ctype);
$IE8Compat = Replace_Check($IE8Compat);
$ContentsURLSelect = Replace_Check($ContentsURLSelect);

$ContentsPeriod = $ContentsPeriod." 23:59:55";
$ContentsAccredit = $ContentsAccredit." 00:01:55";
$ContentsExpire = $ContentsExpire." 23:59:55";


$cmd = false;

if(!$Category2) {
	$Category2 = 0;
}
if(!$Price) {
	$Price = 0;
}
if(!$Price01View) {
	$Price01View = 0;
}
if(!$Price02View) {
	$Price02View = 0;
}
if(!$Price03View) {
	$Price03View = 0;
}
if(!$Price01) {
	$Price01 = 0;
}
if(!$Price02) {
	$Price02 = 0;
}
if(!$Price03) {
	$Price03 = 0;
}
if(!$Limited) {
	$Limited = 0;
}
if(!$Commission) {
	$Commission = 0;
}
if(!$BookPrice) {
	$BookPrice = 0;
}
if(!$Mid01EA) {
	$Mid01EA = 0;
}
if(!$Mid01Score) {
	$Mid01Score = 0;
}
if(!$Mid02EA) {
	$Mid02EA = 0;
}
if(!$Mid02Score) {
	$Mid02Score = 0;
}
if(!$Mid03EA) {
	$Mid03EA = 0;
}
if(!$Mid03Score) {
	$Mid03Score = 0;
}
if(!$Test01EA) {
	$Test01EA = 0;
}
if(!$Test01Score) {
	$Test01Score = 0;
}
if(!$Test02EA) {
	$Test02EA = 0;
}
if(!$Test02Score) {
	$Test02Score = 0;
}
if(!$Test03EA) {
	$Test03EA = 0;
}
if(!$Test03Score) {
	$Test03Score = 0;
}
if(!$Report01EA) {
	$Report01EA = 0;
}
if(!$Report01Score) {
	$Report01Score = 0;
}
if(!$Report02EA) {
	$Report02EA = 0;
}
if(!$Report02Score) {
	$Report02Score = 0;
}
if(!$Report03EA) {
	$Report03EA = 0;
}
if(!$Report03Score) {
	$Report03Score = 0;
}
if(!$TestTime) {
	$TestTime = 0;
}
if(!$MidRate) {
	$MidRate = 0;
}
if(!$TestRate) {
	$TestRate = 0;
}
if(!$ReportRate) {
	$ReportRate = 0;
}
if(!$PassProgress) {
	$PassProgress = 0;
}
if(!$TotalPassMid) {
	$TotalPassMid = 0;
}
if(!$TotalPassTest) {
	$TotalPassTest = 0;
}
if(!$PassTest) {
	$PassTest = 0;
}
if(!$TotalPassReport) {
	$TotalPassReport = 0;
}
if(!$PassReport) {
	$PassReport = 0;
}
if(!$PassScore) {
	$PassScore = 0;
}
if(!$Hit) {
	$Hit = "N";
}
if(!$tok2) {
	$tok2 = "N";
}
if(!$ctype) {
	$ctype = "A";
}
if(!$IE8Compat) {
	$IE8Compat = "N";
}

if($mode=="new") { //새글 작성---------------------------------------------------------------------------------------------------------

	//과정코드 중복체크
	$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
	?>
	<script type="text/javascript">
	<!--
		alert("동일한 과정코드가 존재하거나 삭제된 과정코드입니다.");
		top.$("#SubmitBtn").show();
		top.$("#Waiting").hide();
	//-->
	</script>
	<?
	exit;
	}

	$maxno = max_number("idx","Course");

	$Sql = "INSERT INTO Course 

				(idx, ClassGrade, LectureCode, UseYN, PassCode, HrdCode, Category1, Category2, ServiceType, ContentsName, CompleteTime, ProgressCheck, 
				Chapter, ContentsTime, Price, Price01, Price02, Price03, Price01View, Price02View, Price03View, Professor, Limited, ContentsPeriod, ContentsAccredit, ContentsExpire, Cp, Commission, 
				Mobile, BookPrice, BookIntro, attachFile, PreviewImage, BookImage, Mid01EA, Mid01Score, Mid02EA, Mid02Score, Mid03EA, Mid03Score, Test01EA, Test01Score, Test02EA, 
				Test02Score, Test03EA, 
				Test03Score, Report01EA, Report01Score, Report02EA, Report02Score, Report03EA, Report03Score, TestTime, MidRate, TestRate, ReportRate, PassProgress, TotalPassMid, TotalPassTest, PassTest, TotalPassReport, 
				PassReport, PassScore, Intro, EduTarget, EduGoal, Hit, Del, RegDate, PackageYN, PackageRef, PackageLectureCode, ChapterLimit, tok2, ctype, IE8Compat, ContentsURLSelect) 

				VALUES 
				($maxno, '$ClassGrade', '$LectureCode', '$UseYN', '$PassCode', '$HrdCode', $Category1, $Category2, '$ServiceType', '$ContentsName', $CompleteTime, '$ProgressCheck', 
				'$Chapter', '$ContentsTime',$Price, $Price01, $Price02, $Price03, $Price01View, $Price02View, $Price03View, '$Professor', $Limited, '$ContentsPeriod', '$ContentsAccredit', '$ContentsExpire', '$Cp', $Commission, 
				'$Mobile', $BookPrice, '$BookIntro', '$attachFile', '$PreviewImage', '$BookImage', $Mid01EA, $Mid01Score, $Mid02EA, $Mid02Score, $Mid03EA, $Mid03Score, $Test01EA, $Test01Score, $Test02EA, 
				$Test02Score, $Test03EA, 
				$Test03Score, $Report01EA, $Report01Score, $Report02EA, $Report02Score, $Report03EA, $Report03Score, $TestTime, $MidRate, $TestRate, $ReportRate, $PassProgress, $TotalPassMid, $TotalPassTest, $PassTest, $TotalPassReport, 
				$PassReport, $PassScore, '$Intro', '$EduTarget', '$EduGoal', '$Hit', 'N', NOW(), 'N',0,'', '$ChapterLimit', '$tok2', '$ctype', '$IE8Compat', '$ContentsURLSelect')";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_read.php?idx=".$maxno;

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Course SET 

					ClassGrade='$ClassGrade', UseYN='$UseYN', PassCode='$PassCode', HrdCode='$HrdCode', Category1=$Category1, Category2=$Category2, ServiceType='$ServiceType', 
					ContentsName='$ContentsName', CompleteTime=$CompleteTime, ProgressCheck='$ProgressCheck', Chapter='$Chapter', ContentsTime='$ContentsTime', Price=$Price, 
					Price01=$Price01, Price02=$Price02, Price03=$Price03, Price01View=$Price01View, Price02View=$Price02View, Price03View=$Price03View, Professor='$Professor', Limited=$Limited, ContentsPeriod='$ContentsPeriod', ContentsAccredit='$ContentsAccredit', 
					ContentsExpire='$ContentsExpire', Cp='$Cp', Commission=$Commission, Mobile='$Mobile', BookPrice=$BookPrice, BookIntro='$BookIntro', attachFile='$attachFile', 
					PreviewImage='$PreviewImage', BookImage='$BookImage', Mid01EA=$Mid01EA, Mid01Score=$Mid01Score, Mid02EA=$Mid02EA, Mid02Score=$Mid02Score, Mid03EA=$Mid03EA, Mid03Score=$Mid03Score, Test01EA=$Test01EA, 
					Test01Score=$Test01Score, Test02EA=$Test02EA, Test02Score=$Test02Score, Test03EA=$Test03EA, Test03Score=$Test03Score, Report01EA=$Report01EA, Report01Score=$Report01Score, Report02EA=$Report02EA, Report02Score=$Report02Score, Report03EA=$Report03EA, Report03Score=$Report03Score, TestTime=$TestTime, MidRate=$MidRate, 
					TestRate=$TestRate, ReportRate=$ReportRate, PassProgress=$PassProgress, TotalPassMid=$TotalPassMid, TotalPassTest=$TotalPassTest, PassTest=$PassTest, 
					TotalPassReport=$TotalPassReport, PassReport=$PassReport, PassScore=$PassScore, Intro='$Intro', EduTarget='$EduTarget', EduGoal='$EduGoal', Hit='$Hit', ChapterLimit='$ChapterLimit', tok2='$tok2', IE8Compat='$IE8Compat', ContentsURLSelect='$ContentsURLSelect'  
				WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Course SET Del='Y' WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course.php?col=".$col."&sw=".$sw;

} //글 삭제-------------------------------------------------------------------------------------------------------------------------

if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.";
}

mysqli_close($connect);
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
	alert("<?=$msg?>");
	top.$("#SubmitBtn").show();
	top.$("#Waiting").hide();
	<?if($ProcessOk=="Y") {?>
	top.location.href="<?=$url?>";
	<?}?>
//-->
</SCRIPT>