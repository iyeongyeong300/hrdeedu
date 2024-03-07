<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$TestType = Replace_Check_XSS2($TestType);

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
	alert("산업인력관리공단 정책변경에 따라 본인인증 정보가 필요합니다.\n\n위 학습차시 중 수강하기 버튼을 클릭하여 본인인증을 완료하고\n\n평가를 진행하시기 바랍니다.");
	location.reload();
//-->
</script>
<?
exit;
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
	alert("평가 응시 내역이 이미 존재합니다.");
	location.reload();
//-->
</script>
<?
	exit;
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

## 평가 문제 가져오기 ########################################################################
$Sql = "SELECT * FROM Chapter WHERE LectureCode='$LectureCode' AND Seq=$Chapter_Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$Sub_idx = $Row['Sub_idx']; //문제은행 idx값 배열
	$Sub_idx_Array = explode("|",$Sub_idx);
	$Exam_Where = "";
	foreach ($Sub_idx_Array as $Sub_idx_Array_value) {
		//echo $Sub_idx_Array_value."<BR>";
		if(!$Exam_Where) {
			$Exam_Where = $Sub_idx_Array_value;
		}else{
			$Exam_Where = $Exam_Where.",".$Sub_idx_Array_value;
		}
	}
	$Exam_Where = "idx IN (".$Exam_Where.")";


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



if($TestType=="MidTest") {
	$CookieName = "LMS_MidTest_".$Study_Seq;
	$ExamTitle = "중간평가";
	$Exam01EA = $Mid01EA;
	$Exam01Score = $Mid01Score;
	$Exam02EA = $Mid02EA;
	$Exam02Score = $Mid02Score;
	$Exam03EA = $Mid03EA;
	$Exam03Score = $Mid03Score;
}
if($TestType=="Test") {
	$CookieName = "LMS_Test_".$Study_Seq;
	$ExamTitle = "최종평가";
	$Exam01EA = $Test01EA;
	$Exam01Score = $Test01Score;
	$Exam02EA = $Test02EA;
	$Exam02Score = $Test02Score;
	$Exam03EA = $Test03EA;
	$Exam03Score = $Test03Score;
}
if($TestType=="Report") {
	$CookieName = "LMS_Report_".$Study_Seq;
	$ExamTitle = "과제";
	$Exam01EA = $Report01EA;
	$Exam01Score = $Report01Score;
	$Exam02EA = $Report02EA;
	$Exam02Score = $Report02Score;
	$Exam03EA = $Report03EA;
	$Exam03Score = $Report03Score;
	$TestTime = 43200;
}




//객관식 문항 번호 배열로 만들기
$ExamA_idx1 = "";

$SQL = "SELECT * FROM ExamBank WHERE $Exam_Where AND ExamType='A' AND Del='N' AND UseYN='Y' ORDER BY RAND() LIMIT 0,$Exam01EA";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		if(!$ExamA_idx1) {
			$ExamA_idx1 = $ROW['idx'];
		}else{
			$ExamA_idx1 = $ExamA_idx1."|".$ROW['idx'];
		}
		
	}
}

//단답형 문항 번호 배열로 만들기
$ExamB_idx1 = "";

$SQL = "SELECT * FROM ExamBank WHERE $Exam_Where AND ExamType='B' AND Del='N' AND UseYN='Y' ORDER BY RAND() LIMIT 0,$Exam02EA";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		if(!$ExamB_idx1) {
			$ExamB_idx1 = $ROW['idx'];
		}else{
			$ExamB_idx1 = $ExamB_idx1."|".$ROW['idx'];
		}
		
	}
}


//서술형 문항 번호 배열로 만들기
$ExamC_idx1 = "";

$SQL = "SELECT * FROM ExamBank WHERE $Exam_Where AND ExamType='C' AND Del='N' AND UseYN='Y' ORDER BY RAND() LIMIT 0,$Exam03EA";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		if(!$ExamC_idx1) {
			$ExamC_idx1 = $ROW['idx'];
		}else{
			$ExamC_idx1 = $ExamC_idx1."|".$ROW['idx'];
		}
		
	}
}





//임시 저장된 평가 내역 여부 확인
$Sql = "SELECT * FROM TestAnswerTempSave WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND TestType='$TestType' AND Chapter_Seq=$Chapter_Seq ORDER BY RegDate DESC LIMIT 0,1";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ExamA_idx2 = $Row['ExamA_idx']; //객관식 평가문제 idx
	$ExamB_idx2 = $Row['ExamB_idx']; //단답형 평가문제 idx
	$ExamC_idx2 = $Row['ExamC_idx']; //서술형 평가문제 idx
	$ExamA_answer = $Row['ExamA_answer']; //객관식 답변
	$ExamB_answer = $Row['ExamB_answer']; //단답형 답변
	$ExamC_answer = $Row['ExamC_answer']; //서술형 답변
	$FileName = $Row['FileName']; //첨부파일
}

if($ExamA_idx2) {
	$ExamA_idx = $ExamA_idx2;
}else{
	$ExamA_idx = $ExamA_idx1;
}

if($ExamB_idx2) {
	$ExamB_idx = $ExamB_idx2;
}else{
	$ExamB_idx = $ExamB_idx1;
}

if($ExamC_idx2) {
	$ExamC_idx = $ExamC_idx2;
}else{
	$ExamC_idx = $ExamC_idx1;
}


if($ExamA_idx) {
	$ExamA_idx_array = explode('|',$ExamA_idx);
}
if($ExamB_idx) {
	$ExamB_idx_array = explode('|',$ExamB_idx);
}
if($ExamC_idx) {
	$ExamC_idx_array = explode('|',$ExamC_idx);
}

if($ExamA_answer) {
	$ExamA_answer_array = explode('|',$ExamA_answer);
}
if($ExamB_answer) {
	$ExamB_answer_array = explode('|',$ExamB_answer);
}
if($ExamC_answer) {
	$ExamC_answer_array = explode('|',$ExamC_answer);
}
?>
<!-- layer Exam -->
 <div class="eduExam">
	<!-- info -->
	<div class="examArea">
		<!-- title -->
		<div class="examTitle"><?=$ExamTitle?>
			<span class="title"><?=$ContentsName?></span>
			<!-- time -->
			<div class="time">남은시간
				<span id="ExamRemainTime"><?=$TestTime?> : 00</span><input type="hidden" name="NowExamTime" id="NowExamTime" value="<?=$TestTime*60?>">
			</div>
			<!-- time // -->
		</div>
		<!-- title // -->
		<p class="ruleTxt">평가는 <span class="fcRed01B">1회만 응시 가능</span>하며, <span class="fcRed01B">재응시가 불가능</span>하므로 신중히 응시하시길 바랍니다.</p>
		<form name="ExamForm1" method="POST" action="/player/exam_ok.php" target="ScriptFrame">
		<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
		<input type="hidden" name="Study_Seq" id="Study_Seq" value="<?=$Study_Seq?>">
		<input type="hidden" name="Chapter_Seq" id="Chapter_Seq" value="<?=$Chapter_Seq?>">
		<input type="hidden" name="TestType" id="TestType" value="<?=$TestType?>">

		<input type="hidden" name="ATypeEA" id="ATypeEA" value="<?=$Exam01EA?>">
		<input type="hidden" name="BTypeEA" id="BTypeEA" value="<?=$Exam02EA?>">
		<input type="hidden" name="CTypeEA" id="CTypeEA" value="<?=$Exam03EA?>">
		<input type="hidden" name="ExamA_idx_value" id="ExamA_idx_value">
		<input type="hidden" name="ExamB_idx_value" id="ExamB_idx_value">
		<input type="hidden" name="ExamC_idx_value" id="ExamC_idx_value">
		<input type="hidden" name="ExamA_answer" id="ExamA_answer">
		<input type="hidden" name="ExamB_answer" id="ExamB_answer">
		<input type="hidden" name="ExamC_answer" id="ExamC_answer">
		<div id="ExamLayer" style="height:750px; overflow: auto; overflow-x:hidden;">
		<!-- start -->
		<div class="examBody">
		
			<!-- no list -->
			<div class="noList">
				<ol>
					<?
					$i = 1;
					//객관식 답안지
					for($k=0;$k<$Exam01EA;$k++) {
					?>
					<li>
						<a href="Javascript:ExamMoveToQuestion('Step<?=$i?>');"><span>문제<?=$i?></span>
						<span id="Amark<?=$i?>"><?=$ExamA_answer_array[$k]?></span></a>
					</li>
					<?
					$i++;
					}
					?>
					<?
					$i2 = 1;
					//단답형 답안지
					for($k=0;$k<$Exam02EA;$k++) {
					?>
					<li>
						<a href="Javascript:ExamMoveToQuestion('Step<?=$i?>');"><span>문제<?=$i?></span>
						<span id="Bmark<?=$i2?>"><?=$ExamB_answer_array[$k]?></span></a>
					</li>
					<?
					$i2++;
					$i++;
					}
					?>
					<?
					//서술형 답안지
					$i3 = 1;
					for($k=0;$k<$Exam03EA;$k++) {
					?>
					<li>
						<a href="Javascript:ExamMoveToQuestion('Step<?=$i?>');"><span>문제<?=$i?></span>
						<span id="Cmark<?=$i3?>"><?=$ExamC_answer_array[$k]?></span></a>
					</li>
					<?
					$i3++;
					$i++;
					}
					?>
				</ol>
			</div>
			<!-- no list // -->
			
			<!-- test list -->
			<div class="testxt">
				
				<?
				$i = 1;
				//객관식 문항 가져오기
				if($ExamA_idx_array) {

					foreach($ExamA_idx_array as $ExamA_idx_array_value) {

						$Sql = "SELECT * FROM ExamBank WHERE ExamType='A' AND idx=$ExamA_idx_array_value";
						$Result = mysqli_query($connect, $Sql);
						$Row = mysqli_fetch_array($Result);

						if($Row) {
							$Question = $Row['Question'];
							$Comment = $Row['Comment'];
							$Example01 = $Row['Example01'];
							$Example02 = $Row['Example02'];
							$Example03 = $Row['Example03'];
							$Example04 = $Row['Example04'];
							$Example05 = $Row['Example05'];
						}

						$UserTempAnswer = $ExamA_answer_array[$i-1];
				?>
				<ol>
					<!-- txt -->
					<a href="Javascript:void(0)" id="Step<?=$i?>"></a><em>문제<?=$i?></em><input type="hidden" name="ExamA_idx" id="ExamA_idx" value="<?=$ExamA_idx_array_value?>">
					<p class="testQ" ><?=$Question?>
						<span class="point">(배점 : <?=$Exam01Score?>)</span>
					</p>
					
					<!-- item -->
					<?if($Example01) {?>
					<li>
						<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_1" type="radio" value="1" onclick="Exam_ExamType_A('<?=$i?>');" <?if($UserTempAnswer=="1") {?>checked<?}?> /></span>
						<label for="AQ<?=$i?>_1"><strong>1. </strong> <?=$Example01?></label>
					</li>
					<?}?>
					<?if($Example02) {?>
					<li>
						<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_2" type="radio" value="2" onclick="Exam_ExamType_A('<?=$i?>');" <?if($UserTempAnswer=="2") {?>checked<?}?> /></span>
						<label for="AQ<?=$i?>_2"><strong>2. </strong> <?=$Example02?></label>
					</li>
					<?}?>
					<?if($Example03) {?>
					<li>
						<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_3" type="radio" value="3" onclick="Exam_ExamType_A('<?=$i?>');" <?if($UserTempAnswer=="3") {?>checked<?}?> /></span>
						<label for="AQ<?=$i?>_3"><strong>3. </strong> <?=$Example03?></label>
					</li>
					<?}?>
					<?if($Example04) {?>
					<li>
						<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_4" type="radio" value="4" onclick="Exam_ExamType_A('<?=$i?>');" <?if($UserTempAnswer=="4") {?>checked<?}?> /></span>
						<label for="AQ<?=$i?>_4"><strong>4. </strong> <?=$Example04?></label>
					</li>
					<?}?>
					<?if($Example05) {?>
					<li>
						<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_5" type="radio" value="5" onclick="Exam_ExamType_A('<?=$i?>');" <?if($UserTempAnswer=="5") {?>checked<?}?> /></span>
						<label for="AQ<?=$i?>_5"><strong>5. </strong> <?=$Example05?></label>
					</li>
					<?}?>
					<!-- item // -->
				</ol>
				<?
				$i++;
					}
				}
				?>
				<?
				//단답형 문항 가져오기
				$i2=1;
				if($ExamB_idx_array) {

					foreach($ExamB_idx_array as $ExamB_idx_array_value) {

						$Sql = "SELECT * FROM ExamBank WHERE ExamType='B' AND idx=$ExamB_idx_array_value";
						$Result = mysqli_query($connect, $Sql);
						$Row = mysqli_fetch_array($Result);

						if($Row) {
							$Question = $Row['Question'];
							$Answer2 = $Row['Answer2'];
							$Comment = $Row['Comment'];
							$ScoreBasis = $Row['ScoreBasis'];
						}

						$UserAnswer = $ExamB_answer_array[$i2-1];
				?>
				<ol>
					<!-- txt -->
					<a href="Javascript:void(0)" id="Step<?=$i?>"></a><em>문제<?=$i?></em><input type="hidden" name="ExamB_idx" id="ExamB_idx" value="<?=$ExamB_idx_array_value?>">
					<p class="testQ"><?=$Question?>
						<span class="point">(배점 : <?=$Exam02Score?>)</span>
					</p>
					<!-- item -->
					<p><input name="BQ<?=$i2?>" id="BQ<?=$i2?>" type="text" class="widp100 hei30" onkeyup="Exam_ExamType_B('<?=$i2?>');" onblur="ExamTempSave();" value="<?=$UserAnswer?>" /></p>
					<!-- item // -->
				</ol>
				<?
					$i2++;
					$i++;
					}
				}
				?>
				<?
				//서술형 문항 가져오기
				if($ExamC_idx_array) {

					$i3=1;
					foreach($ExamC_idx_array as $ExamC_idx_array_value) {

						$Sql = "SELECT * FROM ExamBank WHERE ExamType='C' AND idx=$ExamC_idx_array_value";
						$Result = mysqli_query($connect, $Sql);
						$Row = mysqli_fetch_array($Result);

						if($Row) {
							$Question = $Row['Question'];
							$Answer2 = $Row['Answer2'];
							$Comment = $Row['Comment'];
							$ScoreBasis = $Row['ScoreBasis'];
						}

						$UserAnswer = $ExamC_answer_array[$i3-1];
				?>
				<ol>
					<!-- txt -->
					<a href="Javascript:void(0)" id="Step<?=$i?>"></a><em>문제<?=$i?></em><input type="hidden" name="ExamC_idx" id="ExamC_idx" value="<?=$ExamC_idx_array_value?>">
					<p class="testQ"><?=$Question?>
						<span class="point">(배점 : <?=$Exam03Score?>)</span>
					</p>
					<!-- item -->
					<p><textarea name="CQ<?=$i3?>" id="CQ<?=$i3?>" class="widp100 hei200" onkeyup="Exam_ExamType_C('<?=$i3?>');" onblur="ExamTempSave();"><?=$UserAnswer?></textarea></p>
					<!-- item // -->
				</ol>
				<?
					$i3++;
					$i++;
					}
				}
				?>
				<?if($TestType=="Report") {?>
				<ol>
					<!-- txt -->
					<em>첨부파일</em>
					<p class="testQ">파일 업로드</p>
					<!-- item -->
					<p>
					<span id="FileExpl"><?if($FileName) {?><?=$FileName?>&nbsp;&nbsp;<a href="Javascript:UploadFileDelete('FileExpl','FileName');" style='background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px;'>&nbsp;&nbsp;파일 삭제하기&nbsp;&nbsp;</a><?}else{?>과제 제출에 필요한 파일을 업로드 하세요.<?}?></span>&nbsp;&nbsp;<a href="Javascript:UploadFile('FileExpl','FileName');" style="background:#949494; color:#fff; font-weight:bold; text-align:center; font-size:14px; display:inline-block; -webkit-border-radius:4px; -moz-border-radius:4px; border-radius:4px;">&nbsp;&nbsp;업로드 하기&nbsp;&nbsp;</a>
					</p>
					<!-- item // -->
				</ol>
				<?}?>
			</div>
			<input type="hidden" name="FileName" id="FileName" value="<?=$FileName?>">
			
			<!-- test list // -->
		</div>
		</form>
		
		<!-- start // -->
		</div>
		<!-- btn -->
		<div class="btnOrg01"><a href="Javascript:ExamValueCheck();">최종제출</a></div>
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
	<div class="title">최종제출</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<p class="fc777">최종제출 후에는 수정하실 수 없습니다.</p>
		<p class="mt10 fc333B fs19">최종제출 하시겠습니까?</p>
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