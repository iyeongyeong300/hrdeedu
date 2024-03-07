<?
include "./include/include_top.php";
?>
<?
include "./login_check.php";
?>

        <!-- Content -->
        <div id="Content">
        
        	<!-- h2 -->
        	<h2>모바일 학습실</h2>
<?
$Seq = Replace_Check_XSS2($Seq);

$NowDate = date('Y-m-d');
$Sql = "SELECT a.*, a.Seq AS Study_Seq, a.MidSaveTime, a.TestSaveTime, a.ReportSaveTime, a.MidIP, a.TestIP, a.ReportIP, a.PassOk, 
			b.PreviewImage, b.ContentsName, b.idx AS Course_idx, b.Mobile, b.Chapter, b.Limited, b.PassProgress, b.TotalPassMid, b.MidRate, b.TotalPassTest, b.TestRate, b.TotalPassReport, b.ReportRate, b.PassScore, b.attachFile, b.ctype, b.Professor, 
			c.CategoryName AS Category1Name, c.idx AS Category1_idx, 
			d.CategoryName AS Category2Name, d.idx AS Category2_idx, 
			e.Name AS TutorName, 
			(SELECT COUNT(idx) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode=a.LectureCode AND Study_Seq=a.Seq) AS ProgressCount, 
			(SELECT COUNT(idx) FROM PaymentSheet WHERE CompanyCode=a.CompanyCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND PayStatus='Y') AS PaymentCount 
			FROM Study AS a 
			LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
			LEFT OUTER JOIN CourseCategory AS c ON b.Category1=c.idx 
			LEFT OUTER JOIN CourseCategory AS d ON b.Category2=d.idx 
			LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
			WHERE a.ID='$LoginMemberID' AND ((a.LectureStart <= '$NowDate' AND a.LectureEnd >= '$NowDate') AND a.StudyEnd='N') AND a.Seq=$Seq";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {

	$LectureCode = $Row['LectureCode'];
	$Category1_idx = $Row['Category1_idx'];
	$Category2_idx = $Row['Category2_idx'];
	$ctype = $Row['ctype'];
	$Course_idx = $Row['Course_idx'];
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$ServiceType = $Row['ServiceType'];
	$Study_Seq = $Row['Study_Seq'];
	$ContentsName = $Row['ContentsName'];
	$Professor = $Row['Professor'];
	$ProgressCount = $Row['ProgressCount'];
	$Chapter = $Row['Chapter'];
	$Progress = $Row['Progress'];
	$attachFile = $Row['attachFile'];
	$PassProgress = $Row['PassProgress'];
	$MidStatus = $Row['MidStatus'];
	$MidSaveTime = $Row['MidSaveTime'];
	$MidIP = $Row['MidIP'];
	$MidScore = $Row['MidScore'];
	$MidRate = $Row['MidRate'];
	$TestStatus = $Row['TestStatus'];
	$TestScore = $Row['TestScore'];
	$TestRate = $Row['TestRate'];
	$TestSaveTime = $Row['TestSaveTime'];
	$TestIP = $Row['TestIP'];
	$ReportStatus = $Row['ReportStatus'];
	$ReportScore = $Row['ReportScore'];
	$ReportRate = $Row['ReportRate'];
	$ReportSaveTime = $Row['ReportSaveTime'];
	$ReportIP = $Row['ReportIP'];
	$Survey = $Row['Survey'];
	$ResultView = $Row['ResultView'];
	$PassOk = $Row['PassOk'];

	$Today = date("Y-m-d",time());
	$RemailDate = intval((strtotime($LectureEnd)-strtotime($Today)) / 86400); //남은 수강일

	$StudyProgressStatus = StudyProgressStatus($ServiceType,$LectureCode,$Study_Seq);
	$StudyProgressStatus_Array = explode("|",$StudyProgressStatus);

	$ProgressStep = $StudyProgressStatus_Array[0];
	$ProgressStepExpl = $StudyProgressStatus_Array[1];
	$PlayProgressVal = $StudyProgressStatus_Array[2];

}else{
?>
<script type="text/javascript">
<!--
	alert("강의 정보가 정확하지 않습니다.");
	location.href="./lecture.php";
//-->
</script>
<?
}
?>
        	<!-- info Area -->
            <div class="contentArea">
        		<!-- content Area -->
                
                <div class="conInfoArea">

                    <!-- comment -->
                    <div class="comment_1">
                        <ul>
                            <li>수강은 하루 <span class="fc333B">최대 8차시까지</span> 가능합니다.</li>
                            <li>모바일을 지원하는 콘텐츠만 수강하실 수 있습니다.</li>
                            <li><span class="fc333B">평가 및 과제는 PC에서만 응시, 제출이 가능</span>합니다.</li>
                        </ul>
                    </div>
                    <!-- comment // -->
                    
                    <!-- list -->
                    <div class="myList mt20">
                        <ul>
                            <li>
                                <p class="title"><?=$ContentsName?></p>
                                <p class="lecInfo">수강기간 : <span><?=$LectureStart?> ~ <?=$LectureEnd?></span><br>
                                    남은수강일 : <span><?=$RemailDate?>일</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    내용전문가 : <span><?=$Professor?></span>
                                </p>
                                <!-- 상태 -->
                                <div class="checkArea">
                                    <dl>
                                        <dt>현재 진행상태</dt>
                                        <dd><strong><?=$ProgressStep?></strong><br>(<?=$ProgressStepExpl?>)</dd>
                                    </dl>
                                    <dl>
                                        <dt>강의진도</dt>
                                        <dd class="notxt"><strong><?=$ProgressCount?></strong>/<?=$Chapter?></dd>
                                    </dl>
                                    <dl>
                                        <dt>진도율</dt>
                                        <dd class="notxt"><strong><?=$Progress?></strong>%</dd>
                                    </dl>
                                </div>
                                <!-- 상태 // -->
                            </li>
                        </ul>
                    </div>
                    <!-- list // -->
                    
                    <!-- Tab -->
                    <div class="viewTab" style="margin-top:-1px;">
                        <ul class="area">
                            <li><a href="lecture.php">과정목록</a></li>
                            <?if($attachFile) {?><li><a href="./include/lecture_download.php?LectureCode=<?=$LectureCode?>">학습자료 다운로드</a></li><?}?>
                        </ul>
                    </div>
                    <!-- Tab // -->
                    
                    <!-- Lecture List -->
                    <div class="myLectureList">
						<?
						$ServiceTypeWhere = "";
						if($ServiceType=="3") {
							$ServiceTypeWhere = " AND a.ChapterType='A' ";
						}

						$k = 1;
						$LectureStudy = "Y"; //수강가능 초기값
						$MidTestOk = "N"; //중간평가 존재여부 초기값
						$TestOk = "N"; //최종평가 존재여부 초기값
						$ReportOk = "N"; //과제 존재여부 초기값
						$SurveyView = "N"; //설문조사 노출 초기값
						$SurveyStudy = "N"; //설문조사 가능여부 초기값
						$MidTestStudy = "N";
						$TestStudy = "N";
						$ReportStudy = "N";

						$SQL2 = "SELECT a.Seq AS Chapter_Seq, a.ChapterType, a.OrderByNum, a.Sub_idx, 
									b.Gubun AS ContentGubun, b.ContentsTitle, b.idx AS Contents_idx, 
									c.Progress AS ChapterProgress, c.UserIP AS ChapterUserIP, c.RegDate AS ChapterRegDate, c.StudyTime, 
									(SELECT Seq FROM Chapter WHERE LectureCode='$LectureCode' AND (ChapterType='C' OR ChapterType='D') ORDER BY OrderByNum DESC LIMIT 0,1) AS Max_Seq 
									FROM Chapter AS a 
									LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx 
									LEFT OUTER JOIN Progress AS c ON a.Seq=c.Chapter_Seq AND b.idx=c.Contents_idx AND c.ID='$LoginMemberID' AND c.LectureCode='$LectureCode' AND c.Study_Seq=$Study_Seq 
									WHERE a.LectureCode='$LectureCode' $ServiceTypeWhere ORDER BY a.OrderByNum ASC";
						//echo $SQL2;
						$QUERY2 = mysqli_query($connect, $SQL2);
						if($QUERY2 && mysqli_num_rows($QUERY2))
						{
							while($ROW2 = mysqli_fetch_array($QUERY2))
							{
						?>
						<?
						//강의 차시인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						if($ROW2['ChapterType']=="A") {

							if($ROW2['ChapterProgress']>100) {
								$ChapterProgress = 100;
							}else{
								$ChapterProgress = number_format($ROW2['ChapterProgress'],0);
							}


							if($ServiceType=="1" || $ServiceType=="4") {
								/*
								//13분 이하로 수강시 진도율 0%로 표시
								if($ROW2['StudyTime'] >= 780) {
									$ChapterProgress = number_format($ChapterProgress,0);
								}else{
									$ChapterProgress = 0;
								}
								*/
								if($ChapterProgress<100) {
									$ChapterProgress = 0;
								}
							}

							$SumChapterProgress = $SumChapterProgress + $ChapterProgress;


							$ProgressStep = str_replace("차시","",$ProgressStep);

							if($ProgressStep==$k) {
								$Active = "on";
								$LectureStudy="Y";
							}else{
								$Active = "off";
								$LectureStudy="N";
							}

							if($LoginTestID=="Y") { //테스트아이디인 경우 무조건 강의 수강 가능하게
								$LectureStudy="Y";
							}

							if($ROW2['StudyTime']<1) {
								$PlayMode = "S";
							}else{
								$PlayMode = "C";
							}

							if($MidTestStudy=="Y") {
								$Active = "off";
								$LectureStudy="N";
							}

							if($TestStudy=="Y") {
								$Active = "off";
								$LectureStudy="N";
							}

							if($ReportStudy=="Y") {
								$Active = "off";
								$LectureStudy="N";
							}

						?>
                        <ul>
                            <li><?=$k?><br>
                                <strong><?=$ChapterProgress?></strong>%</li>
                            <li class="infoArea">
                                <span class="title"><?=$ROW2['ContentsTitle']?></span>
                                <p class="mt5"><?if($ROW2['ChapterRegDate']) {?>최종수강시간 : <?=$ROW2['ChapterRegDate']?><br />
                                접속아이피 : <?=$ROW2['ChapterUserIP']?><?}?></p>
                            </li>
                            <li>
							<?if($LectureStudy=="Y" || $ChapterProgress>=100) {?>
							<span class="btnView"><a href="lecture_view.php?Chapter_Number=<?=$k?>&LectureCode=<?=$LectureCode?>&Study_Seq=<?=$Study_Seq?>&Chapter_Seq=<?=$ROW2['Chapter_Seq']?>&Contents_idx=<?=$ROW2['Contents_idx']?>&mode=S">수강<br>하기</a></span>
							<?}?>
							</li>
                        </ul>
						<?
						$k++;
						}
						//강의 차시인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						?>
						<?
						//중간평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						if($ROW2['ChapterType']=="B") {

							$MidTestOk = "Y"; //중간평가가 존재하는 경우 Y로 설정(최종평가와 과제 응시 체크를 위해)

							if($LectureCode=="W9500") { //중간평가를 볼수 있는 진도율
								$MidTestProgress = 47; //NCS기반 병원안내 실무2 만 47%
							}else{
								$MidTestProgress = 50;
							}

							if($Progress<$MidTestProgress) { //중간평가는 진도율 50%이상만 응시가능

								$MidTest_msg = "진도부족";
								$MidTestStudy = "N";
								$LectureStudy = "N";

							}else{

								switch($MidStatus) { //중간평가 상태
									case "C": //채점 완료
										$MidRatePercent = $MidScore * $MidRate / 100;
										$MidTest_msg = $MidScore."점(".$MidRatePercent ."%)";
										$MidTestStudy = "N";
										$LectureStudy = "Y";
									break;
									case "N": //미응시
										$MidTest_msg = "응시가능";
										$MidTestStudy = "Y";
										$LectureStudy = "N";
									break;
									case "Y": //응시완료
										$MidTest_msg = "응시완료<BR>(채점중)";
										$MidTestStudy = "N";
										$LectureStudy = "Y";
									break;
								}

							}

						?>
						<ul>
                            <li>[평가]</li>
                            <li class="infoArea">
                                <span class="title">중간평가</span>
                                <p class="mt5 fcBlue01">- 평가는 PC에서만 가능합니다.</p>
                            </li>
                            <li><?=$MidTest_msg?></li>
                        </ul>
						<?
						}
						//중간평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						?>
						<?
						//최종평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						if($ROW2['ChapterType']=="C") {

						$TestOk = "Y"; //최종평가가 존재하는 경우 Y로 설정(과제 응시 체크를 위해)

						if($Progress<$PassProgress) { //최종평가는 진도율이 수료기준 진도율 이상만 응시가능

							$Test_msg = "진도부족";
							$TestStudy = "N";
							$LectureStudy = "N";

						}else{

							if($MidTestOk == "Y" && $MidStatus=="N") { //중간평가가 있고 미응시 했다면 최종평가 불가

								$Test_msg = "중간평가 미응시";
								$TestStudy = "N";
								$LectureStudy = "N";

							}else{

								switch($TestStatus) { //최종평가 상태
									case "C": //채점완료
										$TestRatePercent = $TestScore * $TestRate / 100;
										$Test_msg = $TestScore."점(".$TestRatePercent ."%)";
										$TestStudy = "N";
										$LectureStudy = "Y";
									break;
									case "N": //미응시
										$Test_msg = "응시가능";
										$TestStudy = "Y";
										$LectureStudy = "N";
									break;
									case "Y": //응시완료
										$Test_msg = "응시완료<BR>(채점중)";
										$TestStudy = "N";
										$LectureStudy = "Y";
									break;
								}

							}

							//설문을 노출시키기 위한 조건
							if(($ROW2['Max_Seq']==$ROW2['Chapter_Seq']) && ($TestStatus=="C" || $TestStatus=="Y")) {
								$SurveyView = "Y";
							}

						}
						?>
						<ul>
                            <li>[평가]</li>
                            <li class="infoArea">
                                <span class="title">최종평가</span>
                                <p class="mt5 fcBlue01">- 평가는 PC에서만 가능합니다.</p>
                            </li>
                            <li><?=$Test_msg?></li>
                        </ul>
						<?
						}
						//최종평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						?>
						<?
						//과제인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						if($ROW2['ChapterType']=="D") {

							$ReportOk = "N"; //과제가 존재하는 경우 Y로 설정

							if($Progress<$PassProgress) { //과제는 진도율이 수료기준 진도율 이상만 응시가능

								$Report_msg = "진도부족";
								$ReportStudy = "N";
								$LectureStudy = "N";

							}else{

								if($TestOk == "Y" && $TestStatus=="N") { //최종평가가 있고 미응시 했다면 과제 불가

									$Report_msg = "최종평가 미응시";
									$ReportStudy = "N";
									$LectureStudy = "N";

								}else{

									switch($ReportStatus) {
										case "C":
											$ReportRatePercent = $ReportScore * $ReportRate / 100;
											$Report_msg = $ReportScore."점(".$ReportRatePercent ."%)";
											$ReportStudy = "N";
											$LectureStudy = "Y";
										break;
										case "N":
											$Report_msg = "응시가능";
											$ReportStudy = "Y";
											$LectureStudy = "N";
										break;
										case "Y":
											$Report_msg = "제출완료<BR>(채점중)";
											$ReportStudy = "N";
											$LectureStudy = "Y";
										break;
									}

								}


							}
						?>
						<ul>
                            <li>[평가]</li>
                            <li class="infoArea">
                                <span class="title">과제</span>
                                <p class="mt5 fcBlue01">- 과제는 PC에서만 가능합니다.</p>
                            </li>
                            <li><?=$Report_msg?></li>
                        </ul>
						<?
						}
						//과제인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						?>
						<?
							}
						}
						?>
                    </div>
                    <!-- Lecture List // -->
                    
                </div>
        		
                <!-- content Area // -->
            </div>
            <!-- info Area // -->

        </div>
        <!-- Content // -->
         
<?
include "./include/include_bottom.php";
?>