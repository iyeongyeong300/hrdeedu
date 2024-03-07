<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

include "../include/login_check_pop.php";

$LectureCode = Replace_Check_XSS2($LectureCode);
$Study_Seq = Replace_Check_XSS2($Study_Seq);

## 수강정보 구하기 ########################################################################
$Sql = "SELECT * FROM Study WHERE Seq=$Study_Seq AND ID='$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$Survey = $Row['Survey']; //설문 상태

	if($Survey!="N") {
?>
<script type="text/javascript">
<!--
	alert("설문 참여 내역이 이미 존재합니다.");
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

}else{
?>
<script type="text/javascript">
<!--
	alert("과정정보를 확인할수 없습니다.");
	location.reload();
//-->
</script>
<?
exit;
}
## 과정 정보 구하기 ########################################################################


//객관식 설문 문항수
$Sql = "SELECT COUNT(*) FROM PollBank WHERE ExamType='A' AND UseYN='Y' AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$Survey01EA = $Row[0];

//주관식 설문 문항수
$Sql = "SELECT COUNT(*) FROM PollBank WHERE ExamType='B' AND UseYN='Y' AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$Survey02EA = $Row[0];
?>
<!-- layer 설문조사 -->
<div class="layerArea wid600">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">설문조사</div>
	<!-- info -->
	<form name="SurveyForm1" method="POST" action="/player/survey_take_ok.php" target="ScriptFrame">
	<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
	<input type="hidden" name="Study_Seq" id="Study_Seq" value="<?=$Study_Seq?>">

	<input type="hidden" name="ATypeEA" id="ATypeEA" value="<?=$Survey01EA?>">
	<input type="hidden" name="BTypeEA" id="BTypeEA" value="<?=$Survey02EA?>">
	<input type="hidden" name="ExamA_idx_value" id="ExamA_idx_value">
	<input type="hidden" name="ExamB_idx_value" id="ExamB_idx_value">
	<input type="hidden" name="ExamA_answer" id="ExamA_answer">
	<input type="hidden" name="ExamB_answer" id="ExamB_answer">
	<div class="infoArea">
		<!-- area -->
		<div class="survey">
			<!-- list -->
			<?
			$i = 1;
			//객관식 문항 가져오기
			$SQL = "SELECT * FROM PollBank WHERE ExamType='A' AND UseYN='Y' AND Del='N' ORDER BY OrderByNum ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
					extract($ROW);
			?>
			<ol>
				<p><?=$i?>. <?=$Question?></p><input type="hidden" name="ExamA_idx" id="ExamA_idx" value="<?=$idx?>">
				<!-- item -->
				<?if($Example01) {?>
				<li>
					<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_1" type="radio" value="1" /></span>
					<label for="AQ<?=$i?>_1"><strong>1. </strong> <?=$Example01?></label>
				</li>
				<?}?>
				<?if($Example02) {?>
				<li>
					<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_2" type="radio" value="2" /></span>
					<label for="AQ<?=$i?>_2"><strong>2. </strong> <?=$Example02?></label>
				</li>
				<?}?>
				<?if($Example03) {?>
				<li>
					<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_3" type="radio" value="3" /></span>
					<label for="AQ<?=$i?>_3"><strong>3. </strong> <?=$Example03?></label>
				</li>
				<?}?>
				<?if($Example04) {?>
				<li>
					<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_4" type="radio" value="4" /></span>
					<label for="AQ<?=$i?>_4"><strong>4. </strong> <?=$Example04?></label>
				</li>
				<?}?>
				<?if($Example05) {?>
				<li>
					<span><input name="AQ<?=$i?>" id="AQ<?=$i?>_5" type="radio" value="5" /></span>
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
			//주관식 문항 가져오기
			$i2=1;
			$SQL = "SELECT * FROM PollBank WHERE ExamType='B' AND UseYN='Y' AND Del='N' ORDER BY OrderByNum ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
					extract($ROW);
			?>
			<ol>
				<p><?=$i?>. <?=$Question?></p><input type="hidden" name="ExamB_idx" id="ExamB_idx" value="<?=$idx?>">
				<!-- item -->
				<li><textarea name="BQ<?=$i2?>" rows="5" id="BQ<?=$i2?>" class="widp100" ></textarea>
				</li>
				<!-- item // -->
			</ol>
			<?
			$i2++;
			$i++;
				}
			}
			?>
			<!-- list // -->
			
			<!-- btn -->
			<p class="btnAreaTc02" id="SurveyBtn01">
				<span class="btnSmSky01"><a href="Javascript:SurveyValueCheck()">제출하기</a></span>
			</p>
			<p class="tc" id="SurveyBtn02" style="display:none">
				<strong>처리중입니다...</strong>
			</p>
			<!-- btn // -->
		</div>
		<!-- area // -->
	</div>
	</form>
	<!-- info // -->
</div>
<!-- layer 설문조사 // -->
<?
mysqli_close($connect);
?>