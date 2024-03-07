<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";

$_SESSION["EndTrigger"] = "N"; //EndTrigger 초기화

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
$mode = Replace_Check_XSS2($mode);


## 과정 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$Course_idx = $Row['idx']; //과정 고유번호
	$ContentsName = $Row['ContentsName']; //과정명
	$attachFile = $Row['attachFile']; //학습자료
	$Professor = $Row['Professor']; //내용전문가 
	$CompleteTime = $Row['CompleteTime'] * 60; //진도시간 기준 
	$ChapterLimit = $Row['ChapterLimit']; //차시제한 여부
	$IE8Compat = $Row['IE8Compat']; //브라우저 호환성 여부

	$ext = substr(strrchr($attachFile,"."),1);
	$attachFileView = "학습자료_".$ContentsName.".".$ext;

}

## 차시 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Contents WHERE idx='$Contents_idx'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsTitle = $Row['ContentsTitle']; //차시명
	$Expl01 = nl2br($Row['Expl01']); //차시 목표
	$Expl02 = nl2br($Row['Expl02']); //훈련 내용
	$Expl03 = nl2br($Row['Expl03']); //학습 활동
	$LectureTime = ceil(($Row['LectureTime'] * 60) / 2); //수강시간

}
## 차시 정보 구하기 ########################################################################

$Sql = "SELECT * FROM Study WHERE LectureCode='$LectureCode' AND Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ServiceType = $Row['ServiceType']; //서비스 구분

}


## 최종 수강내역 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq AND Contents_idx=$Contents_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$ContentsDetail_Seq = $Row['ContentsDetail_Seq'];
	$LastStudy = $Row['LastStudy'];
	$Progress = $Row['Progress'];
	$StudyTime = $Row['StudyTime'];

}else{

	$Progress = 0;
	$StudyTime = 0;

}


## 최종 수강내역 정보 구하기 ########################################################################


## 플레쉬 또는 동영상 정보 구하기 ########################################################################
//하부 컨테츠 수 구하기
$Sql = "SELECT COUNT(*) FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND UseYN='Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$ContentsDetail_count = $Row[0];

if($mode=="S") { //수강하기의 경우, 처음부터 나오게--------------------------------------------------------------------------------

	$Sql = "SELECT * FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND UseYN='Y' ORDER BY OrderByNum ASC, Seq ASC LIMIT 0,1";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {

		$ContentsDetail_Seq = $Row['Seq'];
		$ContentsType = $Row['ContentsType'];
		$ContentsURLSelect = $Row['ContentsURLSelect'];
		$ContentsURL = $Row['ContentsURL'];
		$ContentsURL2 = $Row['ContentsURL2'];
		$Caption = $Row['Caption']; //자막 파일

		if($ContentsURLSelect=="A") {
			$ContentsURL = $ContentsURL;
		}else{
			$ContentsURL = $ContentsURL2;
		}


	}else{
	?>
	<script type="text/javascript">
	<!--
	alert("강의 정보에 오류가 발생했습니다.");
	location.reload();
	//-->
	</script>
	<?
	exit;
	}

	if($ContentsDetail_count>1) { //하부 컨텐츠가 2개 이상인 경우
		$PlayNum = "0";
	}

} //수강하기의 경우, 처음부터 나오게--------------------------------------------------------------------------------

if($mode=="C") { //이어보기의 경우 최종 수강내역에서 시작--------------------------------------------------------------------------------

	$Sql = "SELECT * FROM ContentsDetail WHERE Contents_idx=$Contents_idx AND Seq=$ContentsDetail_Seq";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {

		$ContentsDetail_Seq = $Row['Seq'];
		$ContentsType = $Row['ContentsType'];
		$ContentsURLSelect = $Row['ContentsURLSelect'];
		$ContentsURL = $Row['ContentsURL'];
		$ContentsURL2 = $Row['ContentsURL2'];
		$Caption = $Row['Caption']; //자막 파일

		if(!$LastStudy || $LastStudy=="blank") {
			$LastStudy = $ContentsURL;
		}

		if($ContentsType=="A") {
			$ContentsURL = $LastStudy;
		}

		if($ContentsType=="B") {

			if($ContentsURLSelect=="A") {
				$ContentsURL = $ContentsURL;
			}else{
				$ContentsURL = $ContentsURL2;
			}

		}

	}else{
	?>
	<script type="text/javascript">
	<!--
	alert("강의 정보에 오류가 발생했습니다.");
	location.reload();
	//-->
	</script>
	<?
	exit;
	}

	if($ContentsDetail_count>1) { //하부 컨텐츠가 2개 이상인 경우
		$PlayNum = $LastStudy;
		if(!$PlayNum) {
			$PlayNum = "0";
		}
	}

} //이어보기의 경우 최종 수강내역에서 시작--------------------------------------------------------------------------------







// 컨테츠 디스플레이 정보 ###############################################################################################

if($ContentsDetail_count>1) { //하부 컨텐츠가 2개 이상인 경우

	$PlayerFunction = "<div style='background-color:#fff; text-align:center; width:1020px; height:655px' id='MultiContents'><br><br><br><br><br><br><br><br><br><img src='/images/loader.gif' alt='로딩중' /></div>";

}else{ //하부 컨텐츠가 1개인 경우

	if($ContentsType=="A") { //플레쉬 강의의 경우
		$PlayPath = $FlashServerURL.$ContentsURL;
		$PlayerFunction = "<input type='hidden' name='ContentsType' id='ContentsType' value='A'><iframe name='mPlayer' id='mPlayer' src='".$PlayPath."' border='0' frameborder='0' scrolling='no' onload='PlayerResizeIframe(this)'></iframe>";
	}

	if($ContentsType=="B") { //동영상 강의의 경우
		if($ContentsURLSelect=="A") {

			$PlayPath = $MovieServerURL.$ContentsURL;

			if($Caption) {
				$PlayerFunction = "<input type='hidden' name='ContentsType' id='ContentsType' value='B'>
										<video id='mPlayer' width='1020' height='655' controls autoplay>
											<source src='".$PlayPath."' type='video/mp4'>
											<track kind='captions' src='/upload/Caption/".$Caption."' srclang='ko' label='한국어' default='' />
										</video>";
			}else{
				$PlayerFunction = "<input type='hidden' name='ContentsType' id='ContentsType' value='B'>
										<video id='mPlayer' width='1020' height='655' controls autoplay>
											<source src='".$PlayPath."' type='video/mp4'>
										</video>";
			}

		}else{

			$PlayPath = $ContentsURL;
			$PlayerFunction = "<input type='hidden' name='ContentsType' id='ContentsType' value='B'><iframe name='mPlayer' id='mPlayer' src='".$PlayPath."' width='1020' height='655' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>";

		}
	}

}


// ###############################################################################################
?>
<!-- layer Player -->
<div class="eduPlayer">
	<!-- title -->
	<div class="topArea">
		<?=$ContentsName?>
		<p><?=$ContentsTitle?></p>
		<!-- btn -->
		<div class="btnEnd"><a href="Javascript:DataResultCloseReload();">학습종료</a></div>
		<!-- btn // -->
	</div>
	<!-- title // -->
	
	<!-- clip -->
	<div class="clipArea"><?=$PlayerFunction?></div>
	<!-- clip // -->
	
	<!-- info -->
	<div class="infoArea">
		<!-- btn -->
		<div class="btn">
			<span><a href="Javascript:PlayStudyInfo('<?=$LectureCode?>','<?=$Contents_idx?>')">학습요점</a></span>
			<span><a href="Javascript:PlayStudyCounsel('<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Contents_idx?>')">학습내용 질문하기</a></span>
			<span><?if($attachFile) {?><a href="/player/lecture_download.php?LectureCode=<?=$LectureCode?>" target="ScriptFrame">학습자료 다운로드</a><?}?></span>
		</div>
		<!-- btn // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Player // -->

<div id="StudyInformation" style="display:none"></div>


<script type="text/javascript">
<!--

	<?
	if($ContentsDetail_count>1) { //하부컨텐츠가 2개 이상인 경우 사이즈 강제로 고정
	?>
	MultiContentsView('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$ContentsDetail_Seq?>','<?=$PlayNum?>');
	<?}?>

	//동영상 이어보기의 경우 해당 시간으로 이동
	<?
	if($mode=="C" && $ContentsType=="B" && $ContentsURLSelect=="A" && $Progress < 100) {
	?>
	setTimeout(function(){
		mPlayer.currentTime=<?=$LastStudy?>;
	},2000);
	<?
	}
	?>


//-->
</script>