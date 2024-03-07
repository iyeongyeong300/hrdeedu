<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$TestType = Replace_Check_XSS2($TestType);

$Captcha_token_string = makeRand();
$_SESSION['CAPTCHA_TOKEN'] = $Captcha_token_string;

include "../include/login_check.php";

$ExamTitle = "토론방";

$Sql = "SELECT * FROM Study WHERE LectureCode='$LectureCode' AND Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$ServiceType = $Row['ServiceType'];
	$OpenChapter = $Row['OpenChapter'];
	$LectureTerme_idx = $Row['LectureTerme_idx'];

}

//현재 과정 본인 인증 횟수
$Sql = "SELECT COUNT(*) FROM UserCertOTP WHERE ID='$LoginMemberID' AND Study_Seq=$Study_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$MobileAuth_count = $Row[0];

if($MobileAuth_count<1 && ($ServiceType==1 || $ServiceType==4)) { //과정 인증내역이 없으면 본인인증 필요 (과정당 1회만 인증)
?>
<script type="text/javascript">
<!--
//	alert("산업인력관리공단 정책변경에 따라 본인인증 정보가 필요합니다.\n\n위 학습차시 중 수강하기 버튼을 클릭하여 본인인증을 완료하고\n\n평가를 진행하시기 바랍니다.");
//	location.reload();
//-->
</script>
<?
//exit;
}
?>
<?
## 수강정보 구하기 ########################################################################
$Sql = "SELECT * FROM Study WHERE Seq=$Study_Seq AND ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$MidStatus = $Row['MidStatus']; //중간평가 상태
	$TestStatus = $Row['TestStatus']; //최종평가 상태
	$ReportStatus = $Row['ReportStatus']; //과제 상태
	$User_Id= $Row['Id']; // 사용자아이디 
	if($TestType=="MidTest") {
		$ExamStatus = $MidStatus;
	}
	if($TestType=="Test") {
		$ExamStatus = $TestStatus;
	}
	if($TestType=="Report") {
		$ExamStatus = $ReportStatus;
	}
	// -> 변경 필요 _. 토론 참여 여부로 변경 필요
	if($ExamStatus!="N") {
?>
<script type="text/javascript">
<!--
//	alert("평가 응시 내역이 이미 존재합니다.");
//	location.reload();
//-->
</script>
<?
//	exit;
	}

}else{
?>
<script type="text/javascript">
<!--
	alert("수강정보를 확인할수 없습니다.");
	location.reload();
//-->
</script>
<?
exit;
}
## 수강정보 구하기 ########################################################################
 
## 과정 정보 구하기 ########################################################################


## 과정 정보 구하기 ########################################################################
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$Course_idx = $Row['idx']; //과정 고유번호
	$ContentsName = $Row['ContentsName']; //과정명
}
## 평가 문제 가져오기 ########################################################################
$Sql = "SELECT * FROM Chapter WHERE LectureCode='$LectureCode' AND Seq=$Chapter_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
//echo $Sql;
if($Row) {

	$Sub_idx = $Row['Sub_idx']; //문제은행 idx값 배열
	$Sql_discussion  = "select * from DiscussionTopic where idx=".$Sub_idx;
//echo $Sql_discussion;
	$Result_Discussion = mysqli_query($connect, $Sql_discussion);
	$Row_Discussion = mysqli_fetch_array($Result_Discussion);

	if($Row_Discussion) {
		$Course_idx = $Row['idx']; //과정 고유번호
		$Topic = $Row_Discussion['Topic']; //과정명
		$Example01 = $Row_Discussion['Example01']; //과정명
		$Example02 = $Row_Discussion['Example02']; //과정명
		$Example03 = $Row_Discussion['Example03']; //과정명		
		$Example04 = $Row_Discussion['Example04']; //과정명
		$Example05 = $Row_Discussion['Example05']; //과정명		
		$Comment = $Row_Discussion['Comment']; //과정명		


	}
}else{
?>
<script type="text/javascript">
<!--
	alert("등록된 문제정보를 확인할수 없습니다.");
	location.reload();
//-->
</script>
<?
exit;
}
## 평가 문제 가져오기 ########################################################################
?>
<!-- layer Exam -->
 <div class="eduExam">
	<!-- info -->
	<div class="examArea">
		<!-- title -->
		<div class="examTitle"><?=$ExamTitle?>
			<span class="title"><?=$ContentsName?></span>
			<!-- time
			<div class="time">남은시간
				<span id="ExamRemainTime"><?=$TestTime?> : 00</span><input type="hidden" name="NowExamTime" id="NowExamTime" value="<?=$TestTime*60?>">
			</div>
			<!-- time // -->
		</div>
		<!-- title // -->
		<p class="ruleTxt">토론은 <span class="fcRed01B">1회만 참여 가능</span>하며, <span class="fcRed01B">재참여가 불가능</span>하므로 신중히 응시하시길 바랍니다.</p>
		<form name="ExamForm1" method="POST" action="/player/discussion_ok.php" target="ScriptFrame">
		
			<input type="hidden" name="LectureCode" 	id="LectureCode" value="<?=$LectureCode?>">
			<input type="hidden" name="Study_Seq" 		id="Study_Seq" value="<?=$Study_Seq?>">
			<input type="hidden" name="Chapter_Seq" 	id="Chapter_Seq" value="<?=$Chapter_Seq?>">
			<input type="hidden" name="User_Id" 		id="User_Id" value="<?=$User_Id?>">

		<div id="ExamLayer" style="height:650px; overflow: auto; overflow-x:hidden;">
		<!-- start -->
		<div class="examBody">
		
			
			<!-- test list -->
			<div class="testxt">
				<ol>
					<!-- txt -->
					<a href="Javascript:void(0)" id="Step<?=$i?>"></a><em>주제</em>
					<p class="testQ"><?=$Topic?></p>
					<!-- item -->
					<p><textarea name="UserAnswer" id="UserAnswer" class="widp100 hei200"><?=$UserAnswer?></textarea></p>
					<!-- item // -->
					<p>	
						<?
							if(strlen($Comment)> 1 ){
						?>
							<?=$Comment?>
						<?
							}
						?>
						<?
							if(strlen($Example01)> 1 ){
						?>
							예시 : <?=$Example01?>
						<?
							}
						?>
						<?
							if(strlen($Example02)> 1 ){
						?>
							예시 : <?=$Example02?>
						<?
							}
						?>
						<?
							if(strlen($Example03)> 1 ){
						?>
							예시 : <?=$Example03?>
						<?
							}
						?>
						<?
							if(strlen($Example04)> 1 ){
						?>
							예시 : <?=$Example04?>
						<?
							}
						?>
						
						<?
							if(strlen($Example05)> 1 ){
						?>
							예시 : <?=$Example06?>
						<?
							}
						?>
					</p>
				</ol>
				
				 
			</div>
			
			<!-- test list // -->
		</div>
		</form>
		
		<!-- start // -->
		</div>
		<!-- btn -->
		<div class="btnOrg01"><a href="Javascript:ExamValueCheck();">참여하기</a></div>
		<!-- btn // -->
	</div>
	
	<!-- info // -->
</div>
<!-- layer Exam // -->

<div id="ExamEtc" style="display:none"></div>

<?
$NowUNIX_Time = time();
?>
<script type="text/javascript">
<!--
$(document).ready(function() {

	//1초마당 평가 진행시간 체크
	setInterval(function(){
		ExamTimeView();
	},1000);



	var sName = "<?=$CookieName?>";
	var SaveUNIXTime = GetCookieExam(sName);

	if(SaveUNIXTime) {
		var RemainTime = <?=$TestTime*60?> - (<?=$NowUNIX_Time?> - SaveUNIXTime);
		if(RemainTime<1) {
			RemainTime = 5;
		}
		$("#NowExamTime").val(RemainTime);
	}else{
		sValue = "<?=$NowUNIX_Time?>";
		SetCookieExam(sName, sValue);
	}




	$(document).keydown(function(e) {

		if(e.which===112 || e.which===114 || e.which===115 || e.which===116 || e.which===118 || e.which===122 || e.which===123 || e.which===17) {
			if(typeof event=="object") {
				event.keyCode = 0;
			}
			return false;
		}
		if(e.which===82 && e.ctrlKey) {
			return false;
		}
		if(e.which===78 && e.ctrlKey) {
			return false;
		}
		if(e.which===67 && e.ctrlKey) {
			return false;
		}
		if(e.which===86 && e.ctrlKey) {
			return false;
		}
		if(e.which===220 && e.shiftKey) {
			return false;
		}

	});

	//Disable cut copy paste
	$('body').bind('cut copy paste', function (e) {
		e.preventDefault();
	});

	//Disable mouse right click
	$("body").on("contextmenu",function(e){
		return false;
	});






});
//-->
</script>
<?
mysqli_close($connect);
?>
 
<div class="layerArea wid450" id="ResultConfirm" style="display:none">
	<!-- close -->
	<div class="close"><a href="Javascript:ExamSubmitCancel();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">토론</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<p class="fc777">직성 완료 후에는 수정하실 수 없습니다.</p>
		<p class="mt10 fc333B fs19">작성 완료 하시겠습니까?</p>
		<p class="btnAreaTc02" id="ExamBtn01">
			<span class="btnSmSky01"><a href="Javascript:ExamSubmit()">확인</a></span>
			<span class="btnSmGray01"><a href="Javascript:ExamSubmitCancel();">취소</a></span>
		</p>
		<p  id="ExamBtn02" style="display:none"><br>
			<strong>처리중입니다...</strong>
		</p>
	  <!-- area // -->
	</div>
	<!-- info // -->
</div>