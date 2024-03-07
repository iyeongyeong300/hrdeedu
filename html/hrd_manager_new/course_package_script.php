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
$Price01 = Replace_Check($Price01); //교육비용 우선지원 
$Price02 = Replace_Check($Price02); //교육비용 대규모 1000인 미만 
$Price03 = Replace_Check($Price03); //교육비용 대규모 1000인 이상 
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
$Mid02EA = Replace_Check($Mid02EA); //중간평가 주관식 문항수
$Mid02Score = Replace_Check($Mid02Score); //중간평가 주관식 배점
$Test01EA = Replace_Check($Test01EA); //최종평가 객관식 문항수
$Test01Score = Replace_Check($Test01Score); //최종평가 객관식 배점
$Test02EA = Replace_Check($Test02EA); //최종평가 주관식 문항수
$Test02Score = Replace_Check($Test02Score); //최종평가 주관식 배점
$ReportEA = Replace_Check($ReportEA); //과제 문항수
$ReportScore = Replace_Check($ReportScore); //과제 배점
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


$ContentsPeriod = date('Y-m-d H:i:s');
$ContentsAccredit = date('Y-m-d H:i:s');
$ContentsExpire = date('Y-m-d H:i:s');


$cmd = false;

if(!$Category2) {
	$Category2 = 0;
}
if(!$Price) {
	$Price = 0;
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
if(!$ReportEA) {
	$ReportEA = 0;
}
if(!$ReportScore) {
	$ReportScore = 0;
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

$Hit = "N";


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

	$maxno_package = max_number_package();
	$maxno = max_number("idx","Course");

	$Sql = "INSERT INTO Course (idx, LectureCode, UseYN, Category1, Category2, ContentsName, ContentsPeriod, ContentsAccredit, ContentsExpire, Del, RegDate, PackageYN, PackageRef, PackageLectureCode, Hit) VALUES($maxno, '$LectureCode', '$UseYN', $Category1, $Category2, '$ContentsName', '$ContentsPeriod', '$ContentsAccredit', '$ContentsExpire', 'N', NOW(), 'Y',$maxno_package,'', '$Hit')";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_package_read.php?idx=".$maxno;

} //새글 작성-------------------------------------------------------------------------------------------------------------------------

if($mode=="edit") { //글 수정---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Course SET UseYN='$UseYN', Category1=$Category1, Category2=$Category2, ContentsName='$ContentsName', Hit='$Hit' WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_package_read.php?idx=".$idx;

} //글 수정-------------------------------------------------------------------------------------------------------------------------

if($mode=="del") { //글 삭제---------------------------------------------------------------------------------------------------------

	$Sql = "UPDATE Course SET Del='Y' WHERE idx=$idx AND LectureCode='$LectureCode'";
	$Row = mysqli_query($connect, $Sql);

	$cmd = true;
	$url = "course_package.php?col=".$col."&sw=".$sw;

} //글 삭제-------------------------------------------------------------------------------------------------------------------------

if($Row && $cmd) {
	$ProcessOk = "Y";
	$msg = "처리되었습니다.";
}else{
	$ProcessOk = "N";
	$msg = "오류가 발생했습니다.<?=$Sql?>";
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