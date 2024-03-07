<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$Study_Seq = Replace_Check_XSS2($Study_Seq);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$MovieNumber = Replace_Check_XSS2($MovieNumber);


$Sql = "SELECT * FROM TestAnswer WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ExamA_Wrong_idx = $Row['ExamA_Wrong_idx']; //객관식 오답 idx
}

$ExamA_Wrong_idx_array = explode('|',$ExamA_Wrong_idx);
$ExamA_Wrong_idx_array_count = count($ExamA_Wrong_idx_array);
$Now_ExamA_Wrong_idx = $ExamA_Wrong_idx_array[$MovieNumber];
$NowPage = $MovieNumber+1;


$Sql = "SELECT * FROM ExamBank WHERE idx=$Now_ExamA_Wrong_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$BClassLecture = $Row['BClassLecture'];
}
?>
<!-- Layer -->
<div style="position:absolute; top:0; z-index:120; width:100%; height:100%; margin:0 auto; background:#000; opacity:0.8; filter:alpha(opacity=80);"></div>
<div class="player_Blev" style="position:absolute; top:0; z-index:120; width:100%; margin:0 auto; background:none;">
	<!-- layer area -->
	<div class="viewArea">
		<!-- info area -->
		<div class="lecName">[<?=$LoginName?>님]을 위한 맞춤형 보충 동영상 학습</div>
		<div class="btnEnd"><a href="Javascript:DataResultClose();">학습종료</a></div>
		<div class="vodBox"><iframe src="https://player.vimeo.com/video/<?=$BClassLecture?>?autoplay=1" width="1024" height="576" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe><!-- 영상자리 1024*576 --></div>
		<!-- info area // -->
		<!-- control -->
		<div class="control">
			<span class="arrBtn"><?if($NowPage>1){?><a href="Javascript:MidExamStudy('<?=$Study_Seq?>','<?=$LectureCode?>','<?=$Chapter_Seq?>','<?=$NowPage-2?>');"><img src="/images/player/pagecontrol_page_prev_w.png" alt="이전" /></a><?}?></span>
			<span class="pageNo"><strong><?=$NowPage?></strong>/<?=$ExamA_Wrong_idx_array_count?></span>
			<span class="arrBtn"><?if($NowPage<$ExamA_Wrong_idx_array_count){?><a href="Javascript:MidExamStudy('<?=$Study_Seq?>','<?=$LectureCode?>','<?=$Chapter_Seq?>','<?=$NowPage?>');"><img src="/images/player/pagecontrol_page_next_w.png" alt="다음" /></a><?}?></span>
		</div>
		<!-- control // -->
	</div>
	<!-- layer area // -->
</div>
<!-- Layer // -->