<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$LectureCode = Replace_Check($LectureCode);

$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ctype = $Row['ctype'];
	$ClassGrade = $Row['ClassGrade']; //등급
	$LectureCode = $Row['LectureCode']; //과정코드
	$UseYN = $Row['UseYN']; //사이트 노출
	$PassCode = $Row['PassCode']; //심사코드
	$HrdCode = $Row['HrdCode']; //HRD-NET 과정코드
	$Category1 = $Row['Category1']; //과정분류 대분류
	$Category2 = $Row['Category2']; //과정분류 소분류
	$ServiceType = $Row['ServiceType']; //서비스 구분
	$ContentsName = html_quote($Row['ContentsName']); //과정명
	$CompleteTime = $Row['CompleteTime']; //진도시간 기준
	$ProgressCheck = $Row['ProgressCheck']; //진도체크방식
	$Chapter = $Row['Chapter']; //차시수
	$ContentsTime = $Row['ContentsTime']; //교육시간
	$Price = $Row['Price']; //교육비용 일반
	$Price01 = $Row['Price01']; //자부담금 환급비용 우선지원 
	$Price02 = $Row['Price02']; //자부담금 환급비용 대규모 1000인 미만 
	$Price03 = $Row['Price03']; //자부담금 환급비용 대규모 1000인 이상 
	$Price01View = $Row['Price01View']; //환급비용 우선지원 
	$Price02View = $Row['Price02View']; //환급비용 대규모 1000인 미만 
	$Price03View = $Row['Price03View']; //환급비용 대규모 1000인 이상 
	$Professor = $Row['Professor']; //내용전문가 
	$Limited = $Row['Limited']; //학급정원
	$ContentsPeriod = substr($Row['ContentsPeriod'],0,10); //컨텐츠 유효기간
	$ContentsAccredit = substr($Row['ContentsAccredit'],0,10); //인정만료일 시작일
	$ContentsExpire = substr($Row['ContentsExpire'],0,10); //인정만료일 종료일
	$Cp = html_quote($Row['Cp']); //cp사
	$Commission = $Row['Commission']; //cp 수수료
	$Mobile = $Row['Mobile']; //모바일 지원
	$BookPrice = $Row['BookPrice']; //교재비
	$BookIntro = html_quote($Row['BookIntro']); //참고도서설명
	$attachFile = html_quote($Row['attachFile']); //학습자료
	$PreviewImage = html_quote($Row['PreviewImage']); //과정 이미지
	$BookImage = html_quote($Row['BookImage']); //교재 이미지
	$Mid01EA = $Row['Mid01EA']; //중간평가 객관식 문항수
	$Mid01Score = $Row['Mid01Score']; //중간평가 객관식 배점
	$Mid02EA = $Row['Mid02EA']; //중간평가 단답형 문항수
	$Mid02Score = $Row['Mid02Score']; //중간평가 단답형 배점
	$Mid03EA = $Row['Mid03EA']; //중간평가 서술형 문항수
	$Mid03Score = $Row['Mid03Score']; //중간평가 서술형 배점
	$Test01EA = $Row['Test01EA']; //최종평가 객관식 문항수
	$Test01Score = $Row['Test01Score']; //최종평가 객관식 배점
	$Test02EA = $Row['Test02EA']; //최종평가 단답형 문항수
	$Test02Score = $Row['Test02Score']; //최종평가 단답형 배점
	$Test03EA = $Row['Test03EA']; //최종평가 서술형 문항수
	$Test03Score = $Row['Test03Score']; //최종평가 서술형 배점
	$Report01EA = $Row['Report01EA']; //과제 객관식 문항수
	$Report01Score = $Row['Report01Score']; //과제 객관식 배점
	$Report02EA = $Row['Report02EA']; //과제 단답형 문항수
	$Report02Score = $Row['Report02Score']; //과제 단답형 배점
	$Report03EA = $Row['Report03EA']; //과제 서술형 문항수
	$Report03Score = $Row['Report03Score']; //과제 서술형 배점
	$TestTime = $Row['TestTime']; //시험제한시간
	$MidRate = $Row['MidRate']; //반영비율 중간평가 
	$TestRate = $Row['TestRate']; //반영비율 최종평가 
	$ReportRate = $Row['ReportRate']; //반영비율 과제
	$PassProgress = $Row['PassProgress']; //진도율  
	$TotalPassMid = $Row['TotalPassMid']; //중간평가 : 총점
	$TotalPassTest = $Row['TotalPassTest']; //최종평가 : 총점
	$PassTest = $Row['PassTest']; //최종평가 : 득점
	$TotalPassReport = $Row['TotalPassReport']; //과제 : 총점
	$PassReport = $Row['PassReport']; //과제 : 득점
	$PassScore = $Row['PassScore']; //반영비율을 적용한 총점
	$Intro = $Row['Intro']; //과정소개
	$EduTarget = $Row['EduTarget']; //교육대상
	$EduGoal = $Row['EduGoal']; //교육목표
	$Hit = $Row['Hit']; //인기강의여부
	$ChapterLimit = $Row['ChapterLimit']; //차시제한 여부
	$tok2 = $Row['tok2']; //tok2 연계여부

	$Intro = str_replace("\r\n","<BR />",$Intro);
	$EduTarget = str_replace("\r\n","<BR />",$EduTarget);
	$EduGoal = str_replace("\r\n","<BR />",$EduGoal);
}

if($attachFile) {
	$attachFileView = "<A HREF='./direct_download.php?code=Course&file=".$attachFile."'><B>".$attachFile."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('attachFile','attachFileArea') class='btn_inputLine01'>";
}

if($PreviewImage) {
	$PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('PreviewImage','attachFileArea') class='btn_inputLine01'>";
}

if($BookImage) {
	$BookImageView = "<img src='/upload/Course/".$BookImage."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('BookImage','attachFileArea') class='btn_inputLine01'>";
}

if(!$PassProgress) {
	$PassProgress = 80;
}

if(!$CompleteTime) {
	$CompleteTime = 5;
}

if(!$ChapterLimit) {
	$ChapterLimit = "Y";
}

mysqli_close($connect);
?>
<script type="text/javascript">
<!--
	top.$("#ClassGrade").val("<?=$ClassGrade?>");
	top.$("#UseYN").val("<?=$UseYN?>");
	top.$("#PassCode").val("<?=$PassCode?>");
	top.$("#HrdCode").val("<?=$HrdCode?>");
	<?if($ctype_session==$ctype) {?>
	top.$("#Category1").val("<?=$Category1?>");
	top.CourseCategorySelectAfter(<?=$Category1?>,<?=$Category2?>);
	<?}?>
	top.$("#ServiceType").val("<?=$ServiceType?>");
	top.$("#ContentsName").val("<?=$ContentsName?>");
	top.$("#ChapterLimit").val("<?=$ChapterLimit?>");
	top.$("#CompleteTime").val("<?=$CompleteTime?>");
	top.$("#ProgressCheck").val("<?=$ProgressCheck?>");
	top.$("#Chapter").val("<?=$Chapter?>");
	top.$("#ContentsTime").val("<?=$ContentsTime?>");
	top.$("#Price").val("<?=$Price?>");
	top.$("#Price01View").val("<?=$Price01View?>");
	top.$("#Price02View").val("<?=$Price02View?>");
	top.$("#Price03View").val("<?=$Price03View?>");
	top.$("#Price01").val("<?=$Price01?>");
	top.$("#Price02").val("<?=$Price02?>");
	top.$("#Price03").val("<?=$Price03?>");
	top.$("#Professor").val("<?=$Professor?>");
	top.$("#Limited").val("<?=$Limited?>");
	top.$("#ContentsPeriod").val("<?=$ContentsPeriod?>");
	top.$("#ContentsAccredit").val("<?=$ContentsAccredit?>");
	top.$("#ContentsExpire").val("<?=$ContentsExpire?>");
	top.$("#Cp").val("<?=$Cp?>");
	top.$("#Commission").val("<?=$Commission?>");
	top.$("#Mobile").val("<?=$Mobile?>");
	top.$("#BookPrice").val("<?=$BookPrice?>");
	top.$("#BookIntro").val("<?=$BookIntro?>");
	top.$("#attachFile").val("<?=$attachFile?>");
	top.$("#attachFileArea").html("<?=$attachFileView?>");
	top.$("#PreviewImage").val("<?=$PreviewImage?>");
	top.$("#PreviewImageArea").html("<?=$PreviewImageView?>");
	top.$("#BookImage").val("<?=$BookImage?>");
	top.$("#BookImageArea").html("<?=$BookImageView?>");
	top.$("#Mid01EA").val("<?=$Mid01EA?>");
	top.$("#Mid01Score").val("<?=$Mid01Score?>");
	top.$("#Mid02EA").val("<?=$Mid02EA?>");
	top.$("#Mid02Score").val("<?=$Mid02Score?>");
	top.$("#Mid03EA").val("<?=$Mid03EA?>");
	top.$("#Mid03Score").val("<?=$Mid03Score?>");
	top.$("#Test01EA").val("<?=$Test01EA?>");
	top.$("#Test01Score").val("<?=$Test01Score?>");
	top.$("#Test02EA").val("<?=$Test02EA?>");
	top.$("#Test02Score").val("<?=$Test02Score?>");
	top.$("#Test03EA").val("<?=$Test03EA?>");
	top.$("#Test03Score").val("<?=$Test03Score?>");
	top.$("#Report01EA").val("<?=$Report01EA?>");
	top.$("#Report01Score").val("<?=$Report01Score?>");
	top.$("#Report02EA").val("<?=$Report02EA?>");
	top.$("#Report02Score").val("<?=$Report02Score?>");
	top.$("#Report03EA").val("<?=$Report03EA?>");
	top.$("#Report03Score").val("<?=$Report03Score?>");
	top.$("#MidRate").val("<?=$MidRate?>");
	top.$("#TestRate").val("<?=$TestRate?>");
	top.$("#ReportRate").val("<?=$ReportRate?>");
	top.$("#TestTime").val("<?=$TestTime?>");
	top.$("#PassProgress").val("<?=$PassProgress?>");
	top.$("#TotalPassMid").val("<?=$TotalPassMid?>");
	top.$("#TotalPassTest").val("<?=$TotalPassTest?>");
	top.$("#PassTest").val("<?=$PassTest?>");
	top.$("#PassReport").val("<?=$PassReport?>");
	top.$("#TotalPassReport").val("<?=$TotalPassReport?>");
	top.$("#PassScore").val("<?=$PassScore?>");

	var Intro_temp = "<?=$Intro?>";
	top.$('#Intro').val(Intro_temp.replace(/<BR\s?\/?>/g,"\n")); 

	var EduTarget_temp = "<?=$EduTarget?>";
	top.$('#EduTarget').val(EduTarget_temp.replace(/<BR\s?\/?>/g,"\n")); 

	var EduGoal_temp = "<?=$EduGoal?>";
	top.$('#EduGoal').val(EduGoal_temp.replace(/<BR\s?\/?>/g,"\n")); 


	top.DataResultClose();
//-->
</script>