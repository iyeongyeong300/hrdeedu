<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
$ContentsDetail_Seq = Replace_Check_XSS2($ContentsDetail_Seq);
$PlayNum= Replace_Check_XSS2($PlayNum);


$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsName = $Row['ContentsName']; //과정명
}

$Sql = "SELECT * FROM Contents WHERE idx='$Contents_idx'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsTitle = $Row['ContentsTitle']; //차시명
	$Expl01 = nl2br($Row['Expl01']); //차시 목표
	$Expl02 = nl2br($Row['Expl02']); //훈련 내용
	$Expl03 = nl2br($Row['Expl03']); //학습 활동
}

$PlayNum_array = array();

$i = 0;
$SQL = "SELECT * FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND UseYN='Y' ORDER BY OrderByNum ASC, Seq ASC";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{

		$PlayNum_array[$i] = $ROW['Seq'];

$i++;
	}
}

$Content_count = count($PlayNum_array);

$ContentsDetail_Seq2 = $PlayNum_array[$PlayNum];

$Sql = "SELECT * FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND Seq=$ContentsDetail_Seq2";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsDetail_Seq = $Row['Seq'];
	$ContentsType = $Row['ContentsType'];
	$ContentsURL = $Row['ContentsURL'];
	$Question = nl2br($Row['Question']);
	$Example01 = $Row['Example01'];
	$Example02 = $Row['Example02'];
	$Example03 = $Row['Example03'];
	$Example04 = $Row['Example04'];
	$Example05 = $Row['Example05'];

	$Answer = $Row['Answer'];
	$Comment = nl2br($Row['Comment']);
	$Teacher = $Row['Teacher'];
}

$PlayPath = $MovieServerURL.$ContentsURL;

if($Teacher) {

	$Sql = "SELECT * FROM Teacher WHERE idx=$Teacher";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$TeacherName = $Row['Name'];
		$Photo = $Row['Photo'];
		$Profile = nl2br($Row['Profile']);
	}

}

//다음 차시
$Sql = "SELECT * FROM Chapter WHERE Seq=$Chapter_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$OrderByNum = $Row['OrderByNum'];
}


$Sql = "SELECT b.ContentsTitle 
FROM Chapter AS a LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx LEFT OUTER JOIN Progress AS c ON a.Seq=c.Chapter_Seq AND 
b.idx=c.Contents_idx AND c.ID='$LoginMemberID' AND c.LectureCode='$LectureCode' AND c.Study_Seq=$Study_Seq 
WHERE a.LectureCode='$LectureCode' AND OrderByNum>$OrderByNum ORDER BY a.OrderByNum ASC ";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsTitleNext = $Row['ContentsTitle'];
}
?>
<input type='hidden' name='ContentsType' id='ContentsType' value='<?=$ContentsType?>'>
<input type='hidden' name='PlayNum' id='PlayNum' value='<?=$PlayNum?>'>
<!-- Content -->
<div class="player_video_1">
	<!-- page View -->
	<div class="viewArea">
<?
// 강의 시작의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if($ContentsType=="E") {
?>
		<!-- view -->
		<div class="view viewBack01">
			<!-- view info -->
			<div class="lecTitle">
				<p class="title"><?=$ContentsName?></p>
				<p class="notitle"><span><?=$Chapter_Number?>차시</span><?=$ContentsTitle?></p>
			</div>
			<!-- btn -->
			<div class="btn"><a href="Javascript:MultiContentsView('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$ContentsDetail_Seq?>','1');"><img src="/images/player/pageview_btn_play.png" alt="강의듣기" /></a></div>
			<!-- view info // -->
		</div>
		<!-- view // -->
<?
}
// 강의 시작의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
<?
// 강사 소개의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if($ContentsType=="F") {
?>
		<!-- view -->
		<div class="view viewBack02">
		<!-- view info -->
		<div class="careerInfo">
			<!-- photo career -->
			<ul class="photocareer">
				<li>
					<p class="photo"><img src="/upload/Course/<?=$Photo?>" width="400" height="257"></p>
					<p class="name"><?=$TeacherName?> <span>강사</span></p>
					<ul class="txt">
						<li><p class="item">약력</p>
							<?=$Profile?>
						</li>
					</ul>
				</li>
			</ul>
			<!-- lecture info -->
			<ul class="lecInfo">
				<li><p class="item">학습목표</p>
					<?=$Expl01?>
				</li>
				<li><p class="item">학습내용</p>
					<?=$Expl02?>
				</li>
			</ul>
			<!-- lecture info // -->
		</div>
		<!-- view info // -->
	</div>
		<!-- view // -->
<?
}
// 강사 소개의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
<?
// mp4 영상강의의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if($ContentsType=="B") {
?>
		<!-- view -->
		<div class="view">
			<!-- view info -->
			<video id='mPlayer' width='1020' height='655' controls autoplay><source src='<?=$PlayPath?>' type='video/mp4'></video>
			<!-- view info // -->
		</div>
		<!-- view // -->
<?
}
// mp4 영상강의의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
<?
// 문제풀이 객관식의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if($ContentsType=="C") {
?>
		<!-- view -->
		<div class="view viewBack03">
		<!-- view info -->
		<div class="testView">
			<!-- test -->
			<div class="titleItem"><span>확인하기</span>다음 문제를 풀어보세요.</div>
			<!-- type1 -->
			
			<!-- type2 -->
			<ul>
				<p class="examTitle"><?=$Question?></p>
				<li class="examSel"><input name="Answer" id="Answer1" type="radio" value="1" />
					<span class="fb">1. </span><label for="Answer1"><?=$Example01?></label><br />
				</li>
				<li class="examSel"><input name="Answer" id="Answer2" type="radio" value="2" />
					<span class="fb">2. </span><label for="Answer2"><?=$Example02?></label>
				</li>
				<?if($Example03) {?>
				<li class="examSel"><input name="Answer" id="Answer3" type="radio" value="3" />
					<span class="fb">3. </span><label for="Answer3"><?=$Example03?></label><br />
				</li>
				<?}?>
				<?if($Example04) {?>
				<li class="examSel"><input name="Answer" id="Answer4" type="radio" value="4" />
					<span class="fb">4. </span><label for="Answer4"><?=$Example04?></label>
				</li>
				<?}?>
				<?if($Example05) {?>
				<li class="examSel"><input name="Answer" id="Answer5" type="radio" value="5" />
					<span class="fb">5. </span><label for="Answer5"><?=$Example05?></label>
				</li>
				<?}?>
				<br>
				<p class="mt20 tc"><a href="Javascript:MultiPlayerExamType01Result();" id="MultiPlayerExamType01_01"><img src="/images/player/pageview_btn_submit.png" alt="정답확인" /></a></p>
				<p class="examCheck" style="display:none" id="MultiPlayerExamType01_02">[정답확인] <span><?=$Answer?></span></p>
			</ul>
			<!-- exam Comment -->
			<!-- test // -->
		</div>
		<!-- view info // -->
	</div>
		<!-- view // -->
<?
}
// 문제풀이 객관식의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
<?
// 문제풀이 주관식의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if($ContentsType=="D") {
?>
		<!-- view -->
		<div class="view viewBack03">
		<!-- view info -->
		<div class="testView">
			<!-- test -->
			<div class="titleItem"><span>확인하기</span>다음 문제를 풀어보세요.</div>
			<!-- type1 -->
			<ul>
				<p class="examTitle"><?=$Question?></p>
				<li class="examTxt"><input name="Answer2" id="Answer2" type="text" />
					<p class="mt20 tc"><a href="Javascript:MultiPlayerExamType02Result();" id="MultiPlayerExamType02_01"><img src="/images/player/pageview_btn_submit.png" alt="정답확인" /></a></p>
				</li>
				<p class="examCheck" id="MultiPlayerExamType02_02" style="display:none">[해답 설명] <span><br><?=$Comment?></span></p>
			</ul>
			<!-- type2 -->
			<!-- exam Comment -->
			<!-- test // -->
		</div>
		<!-- view info // -->
	</div>
		<!-- view // -->
<?
}
// 문제풀이 주관식의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
<?
// 강의 종료의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if($ContentsType=="G") {
?>
		<!-- view -->
		<div class="view viewBack04">
			<!-- view info -->
			<div class="lecTitle">
				<p class="title">다음강의</p>
				<p class="notitle"><span><?=$Chapter_Number+1?>차시</span><?=$ContentsTitleNext?></p>
			</div>
			<!-- btn -->
			<div class="btn"><a href="Javascript:StudyProgressCheck('End','Y');"><img src="/images/player/pageview_btn_end.png" alt="강의종료" /></a></div>
			<!-- view info // -->
		</div>
		<!-- view // -->
<?
}
// 강의 종료의 경우 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
?>
		<!-- control -->
		<div class="control">
			<span class="pr10"><a href="Javascript:MultiContentsView('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$ContentsDetail_Seq?>','0');"><img src="/images/player/pagecontrol_btn_first.png" alt="처음으로" /></a></span>
			<span class="arrBtn"><?if($PlayNum>0) {?><a href="Javascript:MultiContentsView('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$ContentsDetail_Seq?>','<?=$PlayNum-1?>');"><img src="/images/player/pagecontrol_page_prev.png" alt="이전" /></a><?}?></span>
			<span class="pageNo"><strong><?=$PlayNum+1?></strong>/<?=$Content_count?></span>
			<span class="arrBtn"><?if($PlayNum<$Content_count-1) {?><a href="Javascript:MultiContentsView('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$ContentsDetail_Seq?>','<?=$PlayNum+1?>');"><img src="/images/player/pagecontrol_page_next.png" alt="다음" /></a><?}?></span>
		</div>
		<!-- control // -->
	
	</div>

</div>
<!-- Content // -->

<?
mysqli_close($connect);
?>