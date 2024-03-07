<?
include "../include/include_function.php";
include "../include/login_check.php";

$Seq = Replace_Check($Study_Seq); //수강내역 Seq
$TestType = Replace_Check($TestType); //평가 구분


##-- 검색 조건
$where = array();

$where[] = "a.Seq=".$Seq;
$where[] = "a.ID='$LoginMemberID'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$Colume = "a.Seq, a.LectureStart, a.LectureEnd, a.MidIP, a.TestIP, a.ReportIP, a.MidCaptchaTime, a.MidSaveTime, a.TestCaptchaTime, a.TestSaveTime, a.ReportCaptchaTime, a.ReportSaveTime, 
				a.MidCheckTime, a.TestCheckTime, a.ReportCheckTime, a.MidStatus, a.TestStatus, a.ReportStatus, a.Mosa, a.StudyEnd, 
				b.ContentsName, b.LectureCode, b.Mid01Score, b.Mid02Score, b.Mid03Score, b.Test01Score, b.Test02Score, b.Test03Score, b.Report01Score, b.Report02Score, b.Report03Score, 
				c.Name, c.ID, 
				d.CompanyName, 
				e.Name AS TutorName, e.ID AS TutorID 
				";

$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
						LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
						LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
					";
//수강생 정보
$Sql = "SELECT $Colume FROM $JoinQuery $where";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Seq = $Row['Seq'];
	$ContentsName = $Row['ContentsName'];
	$LectureCode = $Row['LectureCode'];
	$Name = $Row['Name'];
	$ID = $Row['ID'];
	$CompanyName = $Row['CompanyName'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$MidIP = $Row['MidIP'];
	$TestIP = $Row['TestIP'];
	$ReportIP = $Row['ReportIP'];
	$MidCaptchaTime = $Row['MidCaptchaTime'];
	$MidSaveTime = $Row['MidSaveTime'];
	$TestCaptchaTime = $Row['TestCaptchaTime'];
	$TestSaveTime = $Row['TestSaveTime'];
	$ReportCaptchaTime = $Row['ReportCaptchaTime'];
	$ReportSaveTime = $Row['ReportSaveTime'];
	$MidCheckTime = $Row['MidCheckTime'];
	$TestCheckTime = $Row['TestCheckTime'];
	$ReportCheckTime = $Row['ReportCheckTime'];
	$Mid01Score = $Row['Mid01Score'];
	$Mid02Score = $Row['Mid02Score'];
	$Mid03Score = $Row['Mid03Score'];
	$Test01Score = $Row['Test01Score'];
	$Test02Score = $Row['Test02Score'];
	$Test03Score = $Row['Test03Score'];
	$Report01Score = $Row['Report01Score'];
	$Report02Score = $Row['Report02Score'];
	$Report03Score = $Row['Report03Score'];
	$MidStatus = $Row['MidStatus'];
	$TestStatus = $Row['TestStatus'];
	$ReportStatus = $Row['ReportStatus'];
	$Mosa = $Row['Mosa'];
	$StudyEnd = $Row['StudyEnd'];


}else{
?>
<script type="text/javascript">
<!--
	alert("수강내역이 존재하지 않습니다.");
	location.reload();
//-->
</script>
<?
exit;
}

//평가 응시 정보
$Sql = "SELECT * FROM TestAnswer WHERE ID='$ID' AND LectureCode='$LectureCode' AND Study_Seq=$Seq AND TestType='$TestType' ORDER BY RegDate DESC LIMIT 0,1";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$idx = $Row['idx']; // 평가 결과 idx값
	$ATypeEA = $Row['ATypeEA']; //객관식 문항수
	$BTypeEA = $Row['BTypeEA']; //단답형 문항수
	$CTypeEA = $Row['CTypeEA']; //서술형 문항수
	$ExamA_idx = $Row['ExamA_idx']; //객관식 평가문제 idx
	$ExamB_idx = $Row['ExamB_idx']; //단답형 평가문제 idx
	$ExamC_idx = $Row['ExamC_idx']; //서술형 평가문제 idx
	$ExamA_answer = $Row['ExamA_answer']; //객관식 답변
	$ExamB_answer = $Row['ExamB_answer']; //단답형 답변
	$ExamC_answer = $Row['ExamC_answer']; //서술형 답변
	$ExamA_Point = $Row['ExamA_Point']; //객관식 획득점수
	$ExamB_Point = $Row['ExamB_Point']; //단답형 획득점수
	$ExamC_Point = $Row['ExamC_Point']; //서술형 획득점수	
	$ScoreA = $Row['ScoreA']; //객관식 점수
	$ScoreB = $Row['ScoreB']; //단답형 점수
	$ScoreC = $Row['ScoreC']; //서술형 점수
	$TotalScore = $Row['TotalScore']; //총점
	$ExamRegDate = $Row['RegDate']; //응시일

	$TutorRemarkA = $Row['TutorRemarkA']; //객관식 첨삭지도
	$TutorRemarkB = $Row['TutorRemarkB']; //단답형 첨삭지도
	$TutorRemarkC = $Row['TutorRemarkC']; //서술형 첨삭지도
	

	if($ExamA_idx) {
		$ExamA_idx_array = explode('|',$ExamA_idx);
	}
	if($ExamB_idx) {
		$ExamB_idx_array = explode('|',$ExamB_idx);
	}
	if($ExamC_idx) {
		$ExamC_idx_array = explode('|',$ExamC_idx);
	}

	$ExamA_answer_array = explode('|',$ExamA_answer);
	$ExamB_answer_array = explode('|',$ExamB_answer);
	$ExamC_answer_array = explode('|',$ExamC_answer);

	$ExamA_Point_array = explode('|',$ExamA_Point);
	$ExamB_Point_array = explode('|',$ExamB_Point);
	$ExamC_Point_array = explode('|',$ExamC_Point);

	$TutorRemarkA_array = explode('|',$TutorRemarkA);
	$TutorRemarkB_array = explode('|',$TutorRemarkB);
	$TutorRemarkC_array = explode('|',$TutorRemarkC);

}else{
?>
<script type="text/javascript">
<!--
	alert("평가 응시 정보가 존재하지 않습니다.");
	location.reload();
//-->
</script>
<?
exit;
}



switch($TestType) {
	case "MidTest":
		$TestType_Desc = "중간평가";
		$ExamUserIP = $MidIP;
		$ExamUserTime = $MidCaptchaTime." ~ ".$MidSaveTime;
		$ExamCheckTime = $MidCheckTime;
		$ExamA_Score = $Mid01Score; //객관식 배점
		$ExamB_Score = $Mid02Score; //단답형 배점
		$ExamC_Score = $Mid03Score; //서술형 배점
		$ExamStatus = $MidStatus;
	break;
	case "Test":
		$TestType_Desc = "최종평가";
		$ExamUserIP = $TestIP;
		$ExamUserTime = $TestCaptchaTime." ~ ".$TestSaveTime;
		$ExamCheckTime = $TestCheckTime;
		$ExamA_Score = $Test01Score; //객관식 배점
		$ExamB_Score = $Test02Score; //단답형 배점
		$ExamC_Score = $Test03Score; //서술형 배점
		$ExamStatus = $TestStatus;
	break;
	case "Report":
		$TestType_Desc = "과제";
		$ExamUserIP = $ReportIP;
		$ExamUserTime = $ReportCaptchaTime." ~ ".$ReportSaveTime;
		$ExamCheckTime = $ReportCheckTime;
		$ExamA_Score = $Report01Score; //객관식 배점
		$ExamB_Score = $Report02Score; //단답형 배점
		$ExamC_Score = $Report03Score; //서술형 배점
		$ExamStatus = $ReportStatus;
	break;
	default :
		$TestType_Desc = "";
		$ExamUserIP = "";
		$ExamUserTime = "";
		$ExamCheckTime = "";
		$ExamA_Score = 0;
		$ExamB_Score = 0;
		$ExamC_Score = 0;
		$ExamStatus = "";
}
?>
<style>
#ExamLayer .infoArea input[type=radio] {
display:initial;
}
</style>
<!-- layer 평가결과보기 -->
<div class="layerArea wid900">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title"><?=$TestType_Desc?> 결과</div>
	<!-- info -->
	<div id="ExamLayer" style="height:850px; overflow: auto; overflow-x:hidden;">
	<div class="infoArea">
		<!-- area -->
		<div class="examResult">
			<!-- score -->
			<div class="score">
				<ul>
					<li>
						<strong>총점</strong>
						<span class="fcRed01B"><?=$TotalScore?>점</span>
					</li>
					<li>
						<strong>객관식</strong>
						<?if($ExamA_idx) {?><?=$ScoreA?>점<?}else{?>미출제<?}?>
					</li>
					<li>
						<strong>단답형</strong>
						<?if($ExamB_idx) {?><?=$ScoreB?>점<?}else{?>미출제<?}?>
					</li>
					<li>
						<strong>서술형</strong>
						<?if($ExamC_idx) {?><?=$ScoreC?>점<?}else{?>미출제<?}?>
					</li>
				</ul>
			</div>
			<!-- score // -->
			
			<!-- list -->
			<?
			##객관식 #####################################################################################################################
			$i = 1;

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
						$Answer = $Row['Answer'];
					}

					$UserAnswer = $ExamA_answer_array[$i-1];

					if($UserAnswer==$Answer) {
						$OX_Style = '<img src="/images/common/examresult01.png" alt="정답" class="ml5 vm" />';
						$UserAPoint = $ExamA_Score;
					}else{
						$OX_Style = '<img src="/images/common/examresult02.png" alt="오답" class="ml5 vm" />';
						$UserAPoint = 0;
					}

					if($ExamA_Point_array[$i-1]) {
						$UserAPoint = $ExamA_Point_array[$i-1];
					}
				?>
			<ol>
				<!-- txt info -->
				<em>문제<?=$i?></em>
					<?=$OX_Style?>
				<p class="testQ"><?=$Question?></p>
				<p class="infoTxt">
					<span>배점 : <strong><?=$ExamA_Score?></strong></span>
					<span>획득점수 : <strong><?=$UserAPoint?></strong></span>
					<span class="fcRed01B">정답 : <?=$Answer?></span>
				</p>
				<!-- item -->
				<?if($Example01) {?>
				<li>
					<span><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_1" value="1" <?if($UserAnswer=="1") {?>checked<?}?> disabled></span>
					<strong>1. </strong> <?=$Example01?>
				</li>
				<?}?>
				<?if($Example02) {?>
				<li>
					<span><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_2" value="2" <?if($UserAnswer=="2") {?>checked<?}?> disabled></span>
					<strong>2. </strong> <?=$Example02?>
				</li>
				<?}?>
				<?if($Example03) {?>
				<li>
					<span><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_3" value="3" <?if($UserAnswer=="3") {?>checked<?}?> disabled></span>
					<strong>3. </strong> <?=$Example03?>
				</li>
				<?}?>
				<?if($Example04) {?>
				<li>
					<span><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_4" value="4" <?if($UserAnswer=="4") {?>checked<?}?> disabled></span>
					<strong>4. </strong> <?=$Example04?>
				</li>
				<?}?>
				<?if($Example05) {?>
				<li>
					<span><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_5" value="5" <?if($UserAnswer=="5") {?>checked<?}?> disabled></span>
					<strong>5. </strong> <?=$Example05?>
				</li>
				<?}?>
				<!-- item // -->
				
				<!-- 해설 -->
				<div class="resulTxt">
					<p class="point">문제해설</p>
					<?=$Comment?>
				</div>
				<!-- 해설 // -->
			</ol>
			<?
				$i++;
				}
			}
			##객관식 #####################################################################################################################
			?>

			<?
			##단답형 #####################################################################################################################
			if($ExamB_idx_array) {

				$k = 0;
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

					$UserAnswer = $ExamB_answer_array[$k];

					if($ExamB_Point_array[$k]) {
						$UserBPoint = $ExamB_Point_array[$k];
					}
				?>
			<ol>
				<!-- txt info -->
				<em>문제<?=$i?></em>  (단답형)
				<p class="testQ"><?=$Question?></p>
				<p class="infoTxt">
					<span>배점 : <strong><?=$ExamB_Score?></strong></span>
					<span>획득점수 : <strong><?=$UserBPoint?></strong></span>
				</p>
				<!-- item -->
				<div><?=$UserAnswer?></div>
				<!-- item // -->
				
				<!-- 해설 -->
				<div class="resulTxt">
					<p class="point">모범답안</p>
					<?=$Answer2?>
				</div>
				
				<div class="resulTxt">
					<p class="point">첨삭지도</p>
					<?=$TutorRemarkB_array[$k]?>
				</div>
				<!-- 해설 // -->
			</ol>
			<?
				$k++;
				$i++;
				}
			}
			##단답형 #####################################################################################################################
			?>
			<?
			##서술형 #####################################################################################################################
			if($ExamC_idx_array) {

				$k = 0;
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

					$UserAnswer = $ExamC_answer_array[$k];

					if($ExamC_Point_array[$k]) {
						$UserCPoint = $ExamC_Point_array[$k];
					}
			?>
			<ol>
				<!-- txt info -->
				<em>문제<?=$i?></em>  (서술형)
				<p class="testQ"><?=$Question?></p>
				<p class="infoTxt">
					<span>배점 : <strong><?=$ExamC_Score?></strong></span>
					<span>획득점수 : <strong><?=$UserCPoint?></strong></span>
				</p>
				<!-- item -->
				<div><?=$UserAnswer?></div>
				<!-- item // -->
				
				<!-- 해설 -->
				<div class="resulTxt">
					<p class="point">모범답안</p>
					<?=$Answer2?>
				</div>

				<div class="resulTxt">
					<p class="point">채점기준</p>
					<?=$ScoreBasis?>
				</div>
				
				<div class="resulTxt">
					<p class="point">첨삭지도</p>
					<?=$TutorRemarkC_array[$k]?>
				</div>
				<!-- 해설 // -->
			</ol>
			<?
				$k++;
				$i++;
				?>


				<?
				}
			}
##서술형 #####################################################################################################################
			?>
			<!-- list // -->
			
			<!-- btn -->
			<p class="btnAreaTc02">
				<span class="btnSmGray01"><a href="Javascript:DataResultClose();">확인</a></span>
			</p>
			<!-- btn // -->
		</div>
		<!-- area // -->
	</div>
	</div>
	<!-- info // -->
</div>
<!-- layer 평가결과보기 // -->