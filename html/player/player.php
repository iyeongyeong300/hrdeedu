<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check.php";
include "../include/play_check.php";// Brad (2021.11.27): 이중 학습 방지 

 
$_SESSION["EndTrigger"] = "N"; //EndTrigger 초기화

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
$mode = Replace_Check_XSS2($mode);

$Captcha_need = "N"; //갭차인증 필요여부 초기값
$MobileAuth_need = "N"; //모바일 본인인증 필요여부 초기값
$MobileAuth_need2 = "N";
$StudyAuthMsg = ""; //본인인증 메시지 초기값
$EvalCd = ""; //EvalCd 초기값


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
	$ContentsURLSelectGlobal = $Row['ContentsURLSelect'];

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
	$LectureTerme_idx = $Row['LectureTerme_idx'];
}

##테스트 아이디 여부 체크 #####################################################################
$TestID = "N";

$Sql = "SELECT * FROM Member WHERE ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$TestID = $Row['TestID'];
}
##테스트 아이디 여부 체크 #####################################################################


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

if($Progress>=100) {
	$_SESSION["EndTrigger"] = "Y";
	// Brad (2021.11.28) : IsPlaying Session 초기화
	$_SESSION['IsPlaying'] = 'N';
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

		if($ContentsURLSelectGlobal=="B") {
			$ContentsURLSelect = "B";
			$ContentsURL = $ContentsURL2;
		}else{
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
	alert("강의 정보에 오류가 발생했습니다.(-1)");
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

			if($ContentsURLSelectGlobal=="B") {
				$ContentsURLSelect = "B";
				$ContentsURL = $ContentsURL2;
			}else{
				if($ContentsURLSelect=="A") {
					$ContentsURL = $ContentsURL;
				}else{
					$ContentsURL = $ContentsURL2;
				}
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




//현재 과정 본인 인증 횟수 ########################################################################
$Sql = "SELECT COUNT(*) FROM UserCertOTP WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$MobileAuth_count = $Row[0];

if($MobileAuth_count<1 && ($ServiceType==1 || $ServiceType==4)) { //과정 인증내역이 없으면 본인인증 필요 (과정당 1회만 인증) 입과시 인증
	$MobileAuth_need = "Y";
	$EvalCd = "00";
	$StudyAuthMsg = "과정입과 시 본인인증이 필요합니다.";
}else{
	
	##### 오늘 첫수강, 8차시 단위 인증 추가 (1,9,17...차시) #####
	if($ServiceType==1 || $ServiceType==4){	//환급과정 체크
		if(empty($_SESSION['PlayStudyAuth_'.$Study_Seq.$Chapter_Seq])){	//해당 차시를 인증 안한경우
			
			//오늘 첫수강인지 체크
			$Sql = "SELECT COUNT(*) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND DATE(RegDate)='".date('Y-m-d')."'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$Today_Progress_count2 = $Row[0];
			if($Today_Progress_count2<1){
				$MobileAuth_need2 = "Y";
				$StudyAuthMsg = "학습 진행 시 본인인증이 필요합니다.";
			}

			//1,9,17...차시인경우
			if($Chapter_Number % 8 == 1){
				//최초 수강인지 체크
				$Sql = "SELECT COUNT(*) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Chapter_Number='$Chapter_Number' AND Study_Seq=$Study_Seq";
				$Result = mysqli_query($connect, $Sql);
				$Row = mysqli_fetch_array($Result);
				$Progress_count = $Row[0];
				
				if($Progress_count<1){
					$MobileAuth_need2 = "Y";
					$StudyAuthMsg = "학습 진행 시 본인인증이 필요합니다.";
				}
			}
		}
	}
	//##############################################

}

//####################################################################################



//금일 수강한 차시수 ########################################################################

$Sql = "SELECT COUNT(*) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND LEFT(RegDate,10)='".date('Y-m-d')."' AND Contents_idx <> $Contents_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$Today_Progress_count = $Row[0];


if($mode=="S") { //신규 수강하기만 적용, 이어보기는 적용하지 하지 않음

	if($ChapterLimit=="Y" && $TestID=="N") {

		if($Today_Progress_count>7) {
		?>
		<script type="text/javascript">
		<!--
		alert("하루 8개 차시까지만 수강이 가능합니다.");
		PlayDenyClose();
		//-->
		</script>
		<?
		exit;
		}

	}

}

//########################################################################

//캡차 인증여부 체크 ########################################################################
/*
if(empty($_SESSION['CAPTCHA_'.$Study_Seq.$Chapter_Seq])) {

	// 차시가 1, 9, 17... 차시 이거나 오늘 첫 수강이면 캡차 인증 처리
	$Chapter_Sequence  = $Chapter_Number % 8;

	if($ServiceType==1 || $ServiceType==4) {
		if($Today_Progress_count<1 || $Chapter_Sequence==1) {
			$Captcha_need = "Y";
		}
	}

}
*/
//########################################################################


// 본인 인증이 필요한 경우 ########################################################
if($MobileAuth_need=="Y") {
?>
<script type="text/javascript">
<!--
var StudyAuthMsg = "<?=$StudyAuthMsg?>";
if(StudyAuthMsg!=""){
	alert(StudyAuthMsg);
}else{
	alert("본인인증이 필요합니다.");
}
PlayDenyClose();
PlayStudyAuth('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$mode?>','<?=$EvalCd?>')
//-->
</script>

<?
exit;
}
// 본인 인증이 필요한 경우 ########################################################
$Captcha_need='N';

// OTP 또는 캡차 인증이 필요한 경우 ########################################################
//if($Captcha_need=="Y"&&false) {
//if($Captcha_need=="Y") {
if($MobileAuth_need2=="Y") {
?>
<form name="form_motp" method="post" target="popupMotp" action="">&nbsp;&nbsp;</form>
<script type="text/javascript">
<!--
	var StudyAuthMsg = "<?=$StudyAuthMsg?>";
	if(StudyAuthMsg!=""){
		alert(StudyAuthMsg);
	}else{
		alert("본인인증이 필요합니다.");
	}

	function fnPopupmotp(){
		var COURSE_AGENT_PK = "<?=$LectureCode?>";
		var CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";
		window.open('', 'popupMotp', 'width=552, height=962, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
		document.form_motp.target = "popupMotp";
		document.form_motp.action = "/player/motp.php?class_tme=<?=$Chapter_Number?>&Chapter_Number=<?=$Chapter_Number?>&EvalCd=<?=$EvalCd?>&COURSE_AGENT_PK=<?=$LectureCode?>&CLASS_AGENT_PK=<?=$LectureCode?>,<?=$LectureTerme_idx?>&Study_Seq=<?=$Study_Seq?>&Chapter_Seq=<?=$Chapter_Seq?>&Contents_idx=<?=$Contents_idx?>&mode=<?=$mode?>"
		document.form_motp.submit();	
	}

	fnPopupmotp();
//-->
</script>

<?
exit;
}
// OTP 또는 캡차 인증이 필요한 경우 ########################################################


// 컨테츠 디스플레이 정보 ###############################################################################################

if($ContentsDetail_count>1) { //하부 컨텐츠가 2개 이상인 경우

	$PlayerFunction = "<div style='background-color:#fff; text-align:center; width:1020px; height:705px' id='MultiContents'><br><br><br><br><br><br><br><br><br><img src='/images/loader.gif' alt='로딩중' /></div>";

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
			$PlayPath = $ContentsURL."?title=0&byline=0&portrait=0&autoplay=1&playsinline=0#t=".$LastStudy."s";
			$PlayerFunction = "<input type='hidden' name='ContentsType' id='ContentsType' value='B'><iframe name='mPlayer' id='mPlayer' src='".$PlayPath."' width='1020' height='655' frameborder='0' allow='autoplay; fullscreen' allowfullscreen></iframe>";

		}
	}
 
}



//환급과정은 기초차시에 수강시간을 기준으로 완료(100%) 시간을 계산하고 비환급과정은 단과컨텐츠의 진도시간 기준을 기준으로 완료시간을 계산한다. 
if($ServiceType==1 || $ServiceType==4) {
	$CompleteTime = $LectureTime;
}else{
	$CompleteTime = $CompleteTime; //Brad(2021.12.19) : 비환급수강 완료시간 수정
}

// Brad(2021.11.27) : 수강중여부 체크 세션
$_SESSION["IsPlaying"] = "Y";
// ###############################################################################################
?>
<script language="JavaScript">
var _0x5540=['metaKey','event','shiftKey','467012ulvaJz','229983hyzlIQ','97wuigqX','90214ZqbuhT','stopPropagation','keyCode','cancelBubble','765086SkkSuE','preventDefault','ctrlKey','11257IlTibu','onload','addEventListener','platform','1795947LXkqyV','549423qvGApi'];var _0x1400=function(_0xa7dd9f,_0x4099e3){_0xa7dd9f=_0xa7dd9f-0x9b;var _0x554000=_0x5540[_0xa7dd9f];return _0x554000;};var _0x428785=_0x1400;(function(_0x33a4f7,_0x9bee6d){var _0x275a1d=_0x1400;while(!![]){try{var _0x56a62c=-parseInt(_0x275a1d(0xa2))+parseInt(_0x275a1d(0x9d))*-parseInt(_0x275a1d(0xa8))+parseInt(_0x275a1d(0xad))+-parseInt(_0x275a1d(0xa6))+parseInt(_0x275a1d(0xa7))+-parseInt(_0x275a1d(0xa9))+parseInt(_0x275a1d(0xa1));if(_0x56a62c===_0x9bee6d)break;else _0x33a4f7['push'](_0x33a4f7['shift']());}catch(_0x27e007){_0x33a4f7['push'](_0x33a4f7['shift']());}}}(_0x5540,0x90a36),window[_0x428785(0x9e)]=function(){var _0x26e8f7=_0x428785;function _0x383326(_0x1a8d80){var _0x239d3d=_0x1400;_0x1a8d80[_0x239d3d(0xaa)]?_0x1a8d80[_0x239d3d(0xaa)]():window[_0x239d3d(0xa4)]&&(window[_0x239d3d(0xa4)][_0x239d3d(0xac)]=!0x0),_0x1a8d80['preventDefault']();}document[_0x26e8f7(0x9f)]('contextmenu',function(_0x486650){var _0x7d6c4a=_0x26e8f7;_0x486650[_0x7d6c4a(0x9b)]();},!0x1),document['addEventListener']('keydown',function(_0x511cd1){var _0x1d0c94=_0x26e8f7;_0x511cd1['ctrlKey']&&_0x511cd1[_0x1d0c94(0xa5)]&&0x49==_0x511cd1['keyCode']&&_0x383326(_0x511cd1),_0x511cd1[_0x1d0c94(0x9c)]&&_0x511cd1[_0x1d0c94(0xa5)]&&0x43==_0x511cd1[_0x1d0c94(0xab)]&&_0x383326(_0x511cd1),_0x511cd1[_0x1d0c94(0x9c)]&&_0x511cd1['shiftKey']&&0x4a==_0x511cd1['keyCode']&&_0x383326(_0x511cd1),0x53==_0x511cd1['keyCode']&&(navigator[_0x1d0c94(0xa0)]['match']('Mac')?_0x511cd1[_0x1d0c94(0xa3)]:_0x511cd1[_0x1d0c94(0x9c)])&&_0x383326(_0x511cd1),_0x511cd1[_0x1d0c94(0x9c)]&&0x55==_0x511cd1['keyCode']&&_0x383326(_0x511cd1),0x7b==event[_0x1d0c94(0xab)]&&_0x383326(_0x511cd1);},!0x1);});
</script>
<input type="hidden" name="Chapter_Number" id="Chapter_Number" value="<?=$Chapter_Number?>">
<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
<input type="hidden" name="Study_Seq" id="Study_Seq" value="<?=$Study_Seq?>">
<input type="hidden" name="Chapter_Seq" id="Chapter_Seq" value="<?=$Chapter_Seq?>">
<input type="hidden" name="Contents_idx" id="Contents_idx" value="<?=$Contents_idx?>">
<input type="hidden" name="ContentsDetail_Seq" id="ContentsDetail_Seq" value="<?=$ContentsDetail_Seq?>">
<input type="hidden" name="CompleteTime" id="CompleteTime" value="<?=$CompleteTime?>">
<?if($ContentsDetail_count>1) {?>
<input type="hidden" name="MultiContentType" id="MultiContentType" value="Y">
<?}else{?>
<input type="hidden" name="MultiContentType" id="MultiContentType" value="N">
<?}?>
<!-- layer Player -->
<div class="eduPlayer">
	<!-- title -->
	<div class="topArea">
		<?=$ContentsName?>
		<p id="drag_play"><?=$ContentsTitle?></p>
		<!-- btn -->
		<?
		if($Captcha_need == "N" && $MobileAuth_need=="N") {
		?>
		<div class="btnEnd"><a href="Javascript:StudyProgressCheck('End','Y');">학습종료</a></div>
		<?
		}else{
		?>
		<div class="btnEnd"><a href="Javascript:DataResultCloseReload();">학습종료</a></div>
		<?
		}
		?>
		<!-- btn // -->
	</div>
	<!-- title // -->
	
	<!-- clip -->
	<div class="clipArea"><?=$PlayerFunction?></div>
	<!-- clip // -->
	
	<!-- info -->
	<div class="infoArea">
		수강시간
		<!-- <input name="StudyTimeNow" id="StudyTimeNow" type="text" value="00:00:00" /> -->
		<input type="hidden" name="StartTime" id="StartTime" value="<?=$StudyTime?>"><!-- 초기 수강시간 시작 초 -->
		<strong><span id="StudyTimeNow">00:00:00</span></strong>
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

<div id="StudyInformation" style="display:none;"></div>

<?
if($Captcha_need == "N" && $MobileAuth_need=="N") {
?>

<script type="text/javascript">
<!--
$(document).ready(function() {

	<?
	if($ContentsDetail_count>1) { //하부컨텐츠가 2개 이상인 경우 사이즈 강제로 고정
	?>
	MultiContentsView('<?=$Chapter_Number?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$Chapter_Seq?>','<?=$Contents_idx?>','<?=$ContentsDetail_Seq?>','<?=$PlayNum?>');
	<?}?>

	StudyProgressCheck('Start','N','<?=$ContentsURLSelect?>'); //시작 진도 - Progress(차시진도), Study(수강내역) 모두 업데이트(트리거 통해 이몬에 등록)

	//수강 시간 초단위로 보여주는 부분
	setInterval(function(){
		StudyTimeCheck();
	},1000);

	//60초 마다 진도 체크 
	setInterval(function(){
		StudyProgressCheck('Middle','N','<?=$ContentsURLSelect?>'); //Progress(차시진도)만 업데이트
	},60000);



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

	$("#drag_play").css("cursor","move");

	$("#drag_play").mouseover(function(){
		$("div[id='DataResult']").draggable();
		$("div[id='DataResult']").draggable("option","disabled",false);
	})

	$("#drag_play").mouseleave(function(){
		$("div[id='DataResult']").draggable("option","disabled",true);
	});
});
//-->
</script>
<?
}
?>