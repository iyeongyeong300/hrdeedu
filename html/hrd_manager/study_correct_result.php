<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$Seq = Replace_Check($Seq); //수강내역 Seq
$TestType = Replace_Check($TestType); //평가 구분
$SubmitFunction = Replace_Check($SubmitFunction);

##-- 검색 조건
$where = array();

$where[] = "a.Seq=".$Seq;

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


$Colume = "a.Seq, a.LectureStart, a.LectureEnd, a.MidIP, a.TestIP, a.ReportIP, a.MidCaptchaTime, a.MidSaveTime, a.TestCaptchaTime, a.TestSaveTime, a.ReportCaptchaTime, a.ReportSaveTime, 
				a.MidCheckTime, a.TestCheckTime, a.ReportCheckTime, a.MidStatus, a.TestStatus, a.ReportStatus, a.Mosa, 
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


}else{
?>
<script type="text/javascript">
<!--
	alert("수강내역이 존재하지 않습니다.");
	self.close();
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
	$FileName = $Row['FileName']; //첨부파일

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
	self.close();
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<HEAD>
<title>:: <?=$SiteName?> ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<!-- <link rel="stylesheet" href="./css/style.css" type="text/css"> -->
<link rel="stylesheet" href="./css/style2.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
</HEAD>
<BODY leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
      <!--내용 s -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="fs19b" style="padding:10px; background:#5c9cc0; color:#fff;">평가 결과
          	<div style="position:absolute; top:5px; right:10px; font-size:14px;"><a href="Javascript:self.close();"><img src="images/btn_close11.png" alt="창닫기" /></a></div>
          </td>
        </tr>
        <tr>
          <td style="background:#fff;">
            <!-- 평가정보 -->
            <div class="study_correct_result">
            	<!-- info -->
                <div class="titleArea">
                	<p class="title"><?=$TestType_Desc?> | <strong><?=$ContentsName?></strong></p>
                    <p>아이디(이름) : <?=$ID?>(<?=$Name?>)  |  회사명 : <?=$CompanyName?></p>
                </div>
            	<!-- info // -->
                
                <!-- score -->
                <div class="scoreArea">
                	<ul class="score">
                    	<li>
                        	<p class="fb">총점</p>
                            <p class="redB"><?=$TotalScore?></p>
                    	</li>
						<?if($ExamA_idx) {?>
                        <li>
                        	<p class="fb">객관식</p>
                            <p><?=$ScoreA?></p>
                    	</li>
						<?}?>
						<?if($ExamB_idx) {?>
                        <li>
                        	<p class="fb">단답형</p>
                            <p><?=$ScoreB?></p>
                    	</li>
						<?}?>
						<?if($ExamC_idx) {?>
                        <li>
                        	<p class="fb">서술형</p>
                            <p><?=$ScoreC?></p>
                    	</li>
						<?}?>
                    </ul>
                </div>
                <!-- score // -->
                
                <!-- test list -->
                <div class="testArea">
                	<p>문제바로가기</p>
                    <p><select name="ExamNo_Move" id="ExamNo_Move" onchange="ExamNoMove()">
							<?
							$i2 = 1;
							foreach($ExamA_idx_array as $ExamA_idx_array_value) {
							?>
							<option value="ExamNo_<?=$i2?>"><?=$i2?></option>
							<?
							$i2++;
							}
							?>
							<?
							foreach($ExamB_idx_array as $ExamB_idx_array_value) {
							?>
							<option value="ExamNo_<?=$i2?>"><?=$i2?></option>
							<?
							$i2++;
							}
							?>
							<?
							foreach($ExamC_idx_array as $ExamC_idx_array_value) {
							?>
							<option value="ExamNo_<?=$i2?>"><?=$i2?></option>
							<?
							$i2++;
							}
							?>
						</select>
                    </p>
                </div>
                <!-- test list // -->
            </div>
            <!-- 평가정보 // -->
          </td>
        </tr>
        <tr>                  
          <td style="padding:20px;">
            <!-- 기본정보 -->
            <div class="fs18b">기본정보</div>
			<form name="Form1" method="POST" action="study_correct_result_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" id="mode" value="Y"><!-- 채점여부 Y:채점, N:채점취소, T:임시저장 -->
				<input type="hidden" name="Seq" id="Seq" value="<?=$Seq?>">
				<input type="hidden" name="TestType" id="TestType" value="<?=$TestType?>">
				<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="<?=$SubmitFunction?>">
				<input type="hidden" name="idx" id="idx" value="<?=$idx?>">
				<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
				<input type="hidden" name="ExamA_Point" id="ExamA_Point" value="<?=$ExamA_Point?>">
				<input type="hidden" name="ExamB_Point" id="ExamB_Point" value="<?=$ExamB_Point?>">
				<input type="hidden" name="ExamC_Point" id="ExamC_Point" value="<?=$ExamC_Point?>">
				<input type="hidden" name="TutorRemarkA" id="TutorRemarkA" value="<?=$TutorRemarkA?>">
				<input type="hidden" name="TutorRemarkB" id="TutorRemarkB" value="<?=$TutorRemarkB?>">
				<input type="hidden" name="TutorRemarkC" id="TutorRemarkC" value="<?=$TutorRemarkC?>">
				
            <table width="100%" border="0" cellpadding="4" cellspacing="1" bgcolor="#c0d3de" style="margin-top:15px;">
              <tr>
                <td width="120" align="center" bgcolor="#e2e9ed">수강기간</td>
                <td height="28" align="left" bgcolor="#FFFFFF"><?=$LectureStart?> ~ <?=$LectureEnd?></td>
                <td width="120" align="center" bgcolor="#e2e9ed">응시 IP</td>
                <td height="28" align="left" bgcolor="#FFFFFF"> <?=$ExamUserIP?></td>
              </tr>
              <tr>
                <td align="center" bgcolor="#e2e9ed" class="text01">평가한 시간</td>
				<td height="28" colspan="3" align="left" bgcolor="#FFFFFF"><?=$ExamUserTime?></td>
			  </tr>
              <tr>
                <td align="center" bgcolor="#e2e9ed">응시일</td>
                <td height="28" align="left" bgcolor="#FFFFFF"><?=$ExamRegDate?></td>
                <td align="center" bgcolor="#e2e9ed">채점시간</td>
                <td height="28" align="left" bgcolor="#FFFFFF"><?=$ExamCheckTime?></td>
			  </tr>
            </table>
            
            <!-- 문제 -->
            <div class="study_correct_result_list">
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
							$Answer = html_quote($Row['Answer']);
						}

						$UserAnswer = html_quote($ExamA_answer_array[$i-1]);

						if($UserAnswer==$Answer) {
							$OX_Style = "testNo_ty01";
							$UserAPoint = $ExamA_Score;
						}else{
							$OX_Style = "testNo_ty02";
							$UserAPoint = 0;
						}

						if($ExamA_Point_array[$i-1]) {
							$UserAPoint = $ExamA_Point_array[$i-1];
						}
					?>
					<input type="hidden" name="ExamA_Point_Temp" id="ExamA_Point_Temp" value="<?=$UserAPoint?>">
					<ul class="list">
						<!-- test info -->
						<div class="<?=$OX_Style?>">문제 <?=$i?></div>
						<div class="title"><?=$Question?></div>
						<div class="point">
							획득점수 : <span><?=$UserAPoint?></span> 배점 : <span><?=$ExamA_Score?></span> 정답 : <span><?=$Answer?></span>
						</div>
						<?if($Example01) {?>
						<li><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_1" value="1" <?if($UserAnswer=="1") {?>checked<?}?> disabled>
						1. <?=$Example01?></li>
						<?}?>
						<?if($Example02) {?>
						<li><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_2" value="2" <?if($UserAnswer=="2") {?>checked<?}?> disabled>
						2. <?=$Example02?></li>
						<?}?>
						<?if($Example03) {?>
						<li><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_3" value="3" <?if($UserAnswer=="3") {?>checked<?}?> disabled>
						3. <?=$Example03?></li>
						<?}?>
						<?if($Example04) {?>
						<li><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_4" value="4" <?if($UserAnswer=="4") {?>checked<?}?> disabled>
						4. <?=$Example04?></li>
						<?}?>
						<?if($Example05) {?>
						<li><input type="radio" name="AQ<?=$i?>" id="AQ<?=$i?>_5" value="5" <?if($UserAnswer=="5") {?>checked<?}?> disabled>
						5. <?=$Example05?></li>
						<?}?>
						<!-- test info // -->
						<!-- test comment -->
						<div class="comment" >
							<p class="item">문제해설</p>
							<?=$Comment?>
						</div>
						<!-- test comment // -->
						<div class="testNo_ty03" id="ExamNo_<?=$i?>"></div>
					</ul>
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
							$Answer2 = html_quote($Row['Answer2']);
							$Comment = $Row['Comment'];
							$ScoreBasis = $Row['ScoreBasis'];
						}

						$UserAnswer = html_quote($ExamB_answer_array[$k]);

						if($ExamB_Point_array[$k]) {
							$UserBPoint = $ExamB_Point_array[$k];
						}
					?>
					<ul class="list">
						<!-- test info -->
						<div class="testNo_ty03">문제 <?=$i?> (단답형)</div>
						<div class="title"><?=$Question?></div>
						<div class="point">
							획득점수 : <span><input type="text" name="ExamB_Point_Temp" id="ExamB_Point_Temp" value="<?=$UserBPoint?>" size="5"></span> 배점 : <span><?=$ExamB_Score?></span></span>
						</div>
						<li>
						  <textarea name="UserAnswer"><?=$UserAnswer?></textarea>
						</li>
						<!-- test info // -->
						<!-- test comment -->
						<div class="comment">
							<p class="item">모범답안</p>
							<?=$Answer2?>
						</div>
						
						<div class="comment">
							<p class="item">첨삭지도</p>
							<textarea name="TutorRemarkB_Temp" id="TutorRemarkB_Temp"><?=$TutorRemarkB_array[$k]?></textarea>
						</div>
						
						<!-- test comment // -->
						<div class="testNo_ty03" id="ExamNo_<?=$i?>"></div>
					</ul>
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
							$Answer2 = html_quote($Row['Answer2']);
							$Comment = $Row['Comment'];
							$ScoreBasis = $Row['ScoreBasis'];
						}

						$UserAnswer = html_quote($ExamC_answer_array[$k]);

						if($ExamC_Point_array[$k]) {
							$UserCPoint = $ExamC_Point_array[$k];
						}
					?>
					<ul class="list">
						<!-- test info -->
						<div class="testNo_ty03">문제 <?=$i?> (서술형)</div>
						<div class="title"><?=$Question?></div>
						<div class="point">
							획득점수 : <span><input type="text" name="ExamC_Point_Temp" id="ExamC_Point_Temp" value="<?=$UserCPoint?>" size="5"></span> 배점 : <span><?=$ExamC_Score?></span></span>
						</div>
						<li>
						  <textarea name="UserAnswer" style="height:300px" ><?=$UserAnswer?></textarea>
						</li>
						<!-- test info // -->
						<!-- test comment -->
						<div class="comment">
							<p class="item">모범답안</p>
							<?=$Answer2?>
						</div>
						<input type="hidden" name="MosaCheck01_<?=$k?>" id="MosaCheck01_<?=$k?>" value="<?=$UserAnswer?>">
						<input type="hidden" name="MosaCheck02_<?=$k?>" id="MosaCheck02_<?=$k?>" value="<?=$Answer2?>">

						<div class="comment">
							<p class="item">채점기준</p>
							<?=$ScoreBasis?>
						</div>
						
						
						<div class="comment">
							<p class="item">첨삭지도</p>
							<textarea name="TutorRemarkC_Temp" id="TutorRemarkC_Temp"><?=$TutorRemarkC_array[$k]?></textarea>
						</div>
						
						
						<!-- test comment // -->
						<div class="testNo_ty03" id="ExamNo_<?=$i?>"></div>
					</ul>
					<ul class="list" style="margin-top:-50px;">
						<div class="comment" >
							<p class="item">모사답안 여부</p>
							<input type="button" name="" id="" value="모사율 조회하기" class="btn_inputSm03" onclick="ExamMosaCheck('MosaCheck01_<?=$k?>','MosaCheck02_<?=$k?>','MosaResult_<?=$k?>')" />&nbsp;&nbsp;&nbsp;&nbsp;<span id="MosaResult_<?=$k?>"></span>
						</div>
					</ul>
					<?
					$k++;
					$i++;
					?>

					<ul class="list">
						<div class="comment" >
							<p class="item">모사답안 판정</p>
							<label for="Mosa"><span class="fc000B">모사의심</span></label>&nbsp;&nbsp;&nbsp;&nbsp;
							<select name="Mosa" id="Mosa" style="width:150px">
								<option value="N" <?if($Mosa=="N" || !$Mosa) {?>selected<?}?>>정상</option>
								<option value="D" <?if($Mosa=="D") {?>selected<?}?>>의심</option>
								<option value="Y" <?if($Mosa=="Y") {?>selected<?}?>>확정</option>
							</select>
						</div>
					</ul>
					<?
					}

				}
				##서술형 #####################################################################################################################
				?>
				<ul class="list">
					<div class="comment" >
                    	<p class="item">첨부파일</p>
						<?if($FileName) {?><span class="fc000B"><A HREF='./direct_download.php?code=Report&file=<?=$FileName?>'><?=$FileName?></a></span><?}else{?>등록된 첨부파일이 없습니다.<?}?>
                    </div>
				</ul>
            </div>
            <!-- 문제 // -->
			</form>

            
            <!-- btn -->
            <div class="mt20 tc pb5" id="SubmitBtn">
				<?if($LoginAdminDept=="C" || $LoginAdminID=="interkorea") { //첨삭강사만 버튼 보이기?>
				<?if($ExamStatus=="Y") {//채점 대기중에만 보이기?>
				<input type="button" name="ResultBtn" id="ResultBtn" value="채점 완료" class="btn_input01" style="width:230px;" onclick="StudyCorrectResultMark('Y')">
				<input type="button" name="ResultSaveBtn" id="ResultSaveBtn" value="임시 저장" class="btn_input01" style="width:230px;" onclick="StudyCorrectResultMark('T')">
				<?}?>
				<?if($ExamStatus=="C") {//채점 완료시에만 보이기?>
            	<input type="button" name="ResultCancelBtn" id="ResultCancelBtn" value="채점 완료 취소" class="btn_input01" style="width:230px;" onclick="StudyCorrectResultMarkCancel('C')">
				<?}?>
				<?}?>
            </div>
			<div class="mt20 tc pb5" id="SubmitWait" style="display:none">
				<strong>처리중입니다...</strong>
            </div>
            <!-- btn // -->
            
          </td>
        </tr>
      </table>
    <!--내용 e --></td>
  </tr>
</table>
<iframe name="ScriptFrame" id="ScriptFrame" frameborder="0" border="0" width="0" height="0" style="display:none"></iframe>
</BODY>
</html>
<?
mysqli_close($connect);
?>