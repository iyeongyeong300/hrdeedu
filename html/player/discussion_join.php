<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$TestType = Replace_Check_XSS2($TestType);

// 23.03.21. Chapter_Number 구하기 
$Sql = "SELECT Chapter_Number FROM Progress WHERE ID='$LoginMemberID' AND Study_Seq=$Study_Seq AND Chapter_Seq='$Chapter_Seq' ";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$Chapter_Number = $Row["Chapter_Number"];
if (!$Chapter_Number) $Chapter_Number = 1;


$Captcha_token_string = makeRand();
$_SESSION['CAPTCHA_TOKEN'] = $Captcha_token_string;

include "../include/login_check.php";

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

	if($TestType=="MidTest") {
		$ExamStatus = $MidStatus;
	}
	if($TestType=="Test") {
		$ExamStatus = $TestStatus;
	}
	if($TestType=="Report") {
		$ExamStatus = $ReportStatus;
	}

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
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$Course_idx = $Row['idx']; //과정 고유번호
	$ContentsName = $Row['ContentsName']; //과정명
	$TestTime = $Row['TestTime']; //시험제한시간

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

}else{
?>
<script type="text/javascript">
<!--
	alert("평가 과정정보를 확인할수 없습니다.");
	location.reload();
//-->
</script>
<?
exit;
}
## 과정 정보 구하기 ########################################################################

if($TestType=="MidTest") {
	$eval_cd = "04";
	$eval_type = "진행평가";
	$eval_type2 = "진행평가_1";
	$StepType = "MidCaptchaTime";
}
if($TestType=="Test") {
	$eval_cd = "02";
	$eval_type = "시험";
	$eval_type2 = "시험_1";
	$StepType = "TestCaptchaTime";
}
if($TestType=="Report") {
	$eval_cd = "03";
	$eval_type = "과제";
	$eval_type2 = "과제_1";
	$StepType = "ReportCaptchaTime";
}
?>

<!-- ## 주의사항 동의 부분 ########################################################### -->




<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
<input type="hidden" name="Study_Seq" id="Study_Seq" value="<?=$Study_Seq?>">
<input type="hidden" name="Chapter_Seq" id="Chapter_Seq" value="<?=$Chapter_Seq?>">
<input type="hidden" name="TestType" id="TestType" value="<?=$TestType?>">
<input type="hidden" name="token" id="token" value="<?=$Captcha_token_string?>">

<form action="" name="form_motp"></form>

<!-- ## 주의사항 동의 부분 ########################################################### -->
 <div class="eduExam" id="AgreeForm" style="display:none">
	<!-- info -->
	<div class="ruleArea">
		<p class="tr"><span class="btnSmGray01"><a href="Javascript:DataResultClose();">닫기</a></span></p>
		<p class="tc"><img src="/images/sub/eduexam_rule_title.png" alt="주의사항" /></p>
		<ol>
			 
			<?if($TestType=="Discussion") {?>
			<li>토론 <span class="fcRed01B">참여 제한시간은 <?=$TestTime?>분 입니다.</span></li>
			<li><span class="fcRed01B">반드시 PC에서 진행</span>하여 주시고, 장애가 발생하지 않도록 유선 인터넷 등을 사용하시기 바랍니다.</li>
			<li><span class="fcRed01B">토론 참여 버튼까지 클릭</span> 해야지만 토론 참여가 완료됩니다.</li>
			<li>최종제출을 하지 않은 상태로 평가시간이 종료될 경우 <span class="fcRed01B">작성한 답안으로 자동 제출</span>됩니다.</li>
			<li>토론의 점수는 최종 점수에 반영되지 않습니다.</li>
			<li>평가 결과는 학습기간이 종료되고, <span class="fcOrg01B"> 답변이 완료된 후 제공</span>됩니다. </li>
			<li><span class="fcOrg01B"><모사답안의 정의></span><br>
			· 훈련생간에 제출답안 비교시 100% 동일 답안으로 판별될 경우(제출한 답안의 byte수 검사)<br>
			· 서술한 답안의 유사성이 확실한 경우<br>
			· 오타 및 띄어쓰기, 접두/접미어를 이용한 유사한 답안을 제출한 경우<br>
			· 모사답안 판정 여부는 첨삭강사에 의해 최종 결정</li>
			</li>
			<li><span class="fcOrg01B"><모사답안 발생 시 처리기준></span><br>
			· 모사답안이 발생할 경우 해당문항 및 과제가 0점 처리 됩니다.<br>
			· 모사답안이 발생하여 수료점수 미달 시 재시험 및 과제 재 제출은 없습니다.<br>
			· 모사답안이 발생하여 수료점수 미달 시 미수료로 처리 됩니다.
			</li>
			<?}?>
		</ol>
		<!-- agree -->
		<div class="agree">
			<span class="inpCheck">
				<input type="checkbox" name="Agree" id="Agree">
				<label for="Agree">위 사항을 모두 숙지하였으며, 공정하게 토론에 참여하겠습니다.</label>
			</span>
		</div>
		<!-- agree // -->
	</div>
	<!-- btn -->
	<div class="btnOrg01"><a href="Javascript:DiscussionJoin();">토론참여하기</a></div>
	<!-- info // -->
</div>
<!-- ## 주의사항 동의 부분 ########################################################### -->

<!--
<div class="agree" style="display:none;">
			<span class="inpCheck">
				<input type="checkbox" checked name="Agree" id="Agree">
				<label for="Agree">위 사항을 모두 숙지하였으며, 공정하게 평가에 응시하겠습니다.</label>
			</span>
		</div>
-->
        <!-- agree // -->
<!-- 
	<div class="btnOrg01" ><a href="Javascript:ExamNotice();">평가 시작하기</a></div> -->
	<!-- info // -->


<script type="text/javascript">
    var COURSE_AGENT_PK = "<?=$LectureCode?>";
    var CLASS_AGENT_PK = "<?=$LectureCode?>,<?=$LectureTerme_idx?>";
    <?
    if($ServiceType==1 || $ServiceType==4) { //환급과정의 경우 
    ?>
     //   window.open('/player/motp.php?class_tme=<?=$Chapter_Number?>&COURSE_AGENT_PK=<?=$LectureCode?>&CLASS_AGENT_PK=<?=$LectureCode?>,<?=$LectureTerme_idx?>&type=<?=$TestType?>', 'popupMotp', 'width=552, height=962, top=100, left=100, fullscreen=no, menubar=no, status=no, toolbar=no, titlebar=yes, location=no, scrollbar=no');
    <?
    }
    ?>
<!--

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


	<?
	if($ServiceType==1 || $ServiceType==4) { //환급과정의 경우 
	?>

	//기존에 진행된 평가시간이 있으면 적용
	var sName = "<?=$CookieName?>";
	var SaveUNIXTime = GetCookieExam(sName);


		$("#OTP").show();
		$("#AgreeForm").hide();

		//ExecuteFDS();

	<?
	}else{ //비환급 과정은 캡차 숨기기 
	?>
        AgreeFormShow();
	<?
	}
	?>

    function AgreeFormShow() {
        $("#OtpFrame").html("");
        $("#OTP").hide();
        $("#AgreeForm").show();
    }
	
	 AgreeFormShow();
//-->
</script>
<?
mysqli_close($connect);
?>