<?
include "../include/include_top.php";
?>

<script>

function MidResetProcess(Seq) {
	Yes = confirm('중간평가를 재응시 가능하도록 요청하시겠습니까?');

	if (Yes == true) {
		$.post(
			'/hrd_manager/study_test_reset.php',
			{
				Seq: Seq,
				sType: 'Mid',
			},
			function (data, status) {
				 
				if (data == 'Y') {
					 location.reload();
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}
	function TestResetProcess(Seq) {
		Yes = confirm('최종평가를 재응시 가능하도록 요청하시겠습니까?');

		if (Yes == true) {
			$.post(
				'/hrd_manager/study_test_reset.php',
				{
					Seq: Seq,
					sType: 'Test',
				},
				function (data, status) {
				 
					if (data == 'Y') {
					 location.reload();
					} else {
						alert('처리중 문제가 발생했습니다.');
					}
				}
			);
		}
	}

	function ReportResetProcess(Seq) {
		Yes = confirm(' 과제를 재응시 가능하도록 요청하시겠습니까?');

		if (Yes == true) {
			$.post(
				'/hrd_manager/study_test_reset.php',
				{
					Seq: Seq,
					sType: 'Report',
				},
				function (data, status) {					 
					if (data == 'Y') {
						 location.reload();
					} else {
						alert('처리중 문제가 발생했습니다.');
					}
				}
			);
		}
	}
</script>
        
        <!-- Container -->
        <div id="container">
        	
			<!-- Content -->
            <div class="Content">
            
            	<!-- left -->
            	<?
				include "./include_mypage.php";
				?>
                <!-- left // -->
                
                <!-- content area -->
                <div class="contentArea" id="ContentGo">
                
                	<!-- page Title -->
                	<div class="titleZone">
                    	<h3>복습중인 과정</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 수강관리 > 복습중인 과정</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
<?
$Seq = Replace_Check_XSS2($Seq);

$DirectBtnLabel = "";
$DirecFunction = "";
$NowDate = date('Y-m-d');
$Sql = "SELECT a.*, a.Seq AS Study_Seq, a.MidSaveTime, a.TestSaveTime, a.ReportSaveTime, a.MidIP, a.TestIP, a.ReportIP, a.PassOk, a.StudyEnd, a.LectureReStudy, 
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
			WHERE a.ID='$LoginMemberID' AND a.LectureEnd < '$NowDate' AND a.LectureReStudy >= '$NowDate' AND a.Seq=$Seq";
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
	$ReTest = $Row['ReTest'];
	$ReMid = $Row['ReMid'];
	$ReReport = $Row['ReReport'];

	$TotalScore = $Row['TotalScore'];

	$StudyEnd = $Row['StudyEnd'];
	$LectureReStudy = $Row['LectureReStudy'];

	$Today = date("Y-m-d",time());
	$RemailDate = intval((strtotime($LectureReStudy)-strtotime($Today)) / 86400); //남은 수강일

	$StudyProgressStatus = StudyProgressStatus($ServiceType,$LectureCode,$Study_Seq);
	$StudyProgressStatus_Array = explode("|",$StudyProgressStatus);

	$ProgressStep = $StudyProgressStatus_Array[0];
	$ProgressStepExpl = $StudyProgressStatus_Array[1];
	$PlayProgressVal = $StudyProgressStatus_Array[2];


	if($Category1_idx==$Menu01ParentCategory) {
		$LectureUrl = "/educps/course_detail.php?Category=$Category2_idx&idx=$Course_idx";
	}
	if($Category1_idx==$Menu02ParentCategory) {
		$LectureUrl = "/edugrow/course_detail.php?Category=$Category2_idx&idx=$Course_idx";
	}
	if($Category1_idx==$Menu03ParentCategory) {
		$LectureUrl = "/educard/course_detail.php?Category=$Category2_idx&idx=$Course_idx";
	}


}else{
?>
<script type="text/javascript">
<!--
	alert("강의 정보가 정확하지 않습니다.");
	location.href="/mypage/lecture_review.php";
//-->
</script>
<?
}
?>
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <div class="PageZone">
                        	
                            <!-- List -->
                            <div class="myList">
                                <ul class="area">
                                	<li class="title"><?=$ContentsName?></li>
                                    <li class="lecInfo">
                                    	<p><span>수강기간 : </span><strong><?=$LectureStart?> ~ <?=$LectureEnd?> </strong><em> / </em><span>남은 복습일 : </span><strong><?=$RemailDate?>일</strong></p>
                                        <p><span>내용전문가 : </span><?=$Professor?></p>
                                        <!-- btn -->
										<?
										$StatusBtnDisplay = "Y";

										$PlayProgressVal_Array  = explode("#",$PlayProgressVal);

										$Direct_ChapterType = $PlayProgressVal_Array[0];
										$Direct_Chapter_Number = $PlayProgressVal_Array[1];
										$Direct_LectureCode = $PlayProgressVal_Array[2];
										$Direct_Study_Seq = $PlayProgressVal_Array[3];
										$Direct_Chapter_Seq = $PlayProgressVal_Array[4];
										$Direct_Contents_idx = $PlayProgressVal_Array[5];
										$Direct_PlayMode = $PlayProgressVal_Array[6];

										if($Direct_ChapterType=="A") {
											$DirectBtnLabel = "이어서 학습진행";
											$DirecFunction = "Play('$Direct_Chapter_Number','$Direct_LectureCode','$Direct_Study_Seq','$Direct_Chapter_Seq','$Direct_Contents_idx','$Direct_PlayMode')";
											$StatusBtnDisplay = "N";
										}
										if($Direct_ChapterType=="B") {
											$DirectBtnLabel = "중간평가 응시하기";
											$DirecFunction = "ExamStart('$Direct_Chapter_Number','$Direct_LectureCode','$Direct_Study_Seq','MidTest')";
											$StatusBtnDisplay = "N";
										}
										if($Direct_ChapterType=="C") {
											$DirectBtnLabel = "최종평가 응시하기";
											$DirecFunction = "ExamStart('$Direct_Chapter_Number','$Direct_LectureCode','$Direct_Study_Seq','Test')";
											$StatusBtnDisplay = "N";
										}
										if($Direct_ChapterType=="D") {
											$DirectBtnLabel = "과제 응시하기";
											$DirecFunction = "ExamStart('$Direct_Chapter_Number','$Direct_LectureCode','$Direct_Study_Seq','Report')";
											$StatusBtnDisplay = "N";
										}
										if($Direct_ChapterType=="E") {
											$DirectBtnLabel = "설문조사 참여하기";
											$DirecFunction = "SurveyStart('$Direct_Chapter_Number','$Direct_LectureCode')";
										}
										if($Direct_ChapterType=="F") {
											$StatusBtnDisplay = "N";
										}
										if($Direct_ChapterType=="G") {
											$DirectBtnLabel = "수료증 출력";
											$DirecFunction = "CertificatePrint($Direct_Chapter_Number)";
										}
										if($Direct_ChapterType=="H") {
											$StatusBtnDisplay = "N";
										}
										?>
                                        <div class="lecBtn">
                                            <?if($StatusBtnDisplay == "Y") {?><span class="btn02"><a href="Javascript:<?=$DirecFunction?>"><?=$DirectBtnLabel?></a></span><?}?>
                                      	</div>
                                        <!-- btn // -->
                                    </li>
                                    <!-- 상태 -->
                                    <div class="checkArea">
                                    	<dl>
                                        	<dt>현재 진행상태</dt>
                                            <dd><p class="txt"><?=$ProgressStep?></p>
                                            <?=$ProgressStepExpl?></dd>
                                        </dl>
                                        <dl>
                                        	<dt>강의진도</dt>
                                            <dd><span class="notxt"><strong><?=$ProgressCount?></strong>/<?=$Chapter?></span></dd>
                                        </dl>
                                        <dl>
                                        	<dt>진료율</dt>
                                            <dd><span class="notxt"><strong><?=$Progress?></strong>%</span></dd>
                                        </dl>
                                    </div>
                                    <!-- 상태 // -->
                                </ul>
                            </div>
                            <!-- List // -->
                            
                            <!-- Tab -->
                            <div class="viewTab">
                            	<ul class="area">
                                	<li><a href="Javascript:void(0);" class="show">강의목차</a></li>
                                    <li><a href="<?=$LectureUrl?>" target="_blank" title="새창으로 열림">교육내용 상세보기</a></li>
                                    <li><?if($attachFile) {?><a href="/player/lecture_download.php?LectureCode=<?=$LectureCode?>" target="ScriptFrame">학습자료 다운로드</a><?}?></li>
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


									$ProgressStep = str_replace("차시","",$ProgressStep);

									if($ROW2['StudyTime']<1) {
										$PlayMode = "S";
									}else{
										$PlayMode = "C";
									}

								?>
                            	<ul>
                                	<li><?=$k?></li>
                                    <li class="infoArea">
                                    	<span class="title"><?=$ROW2['ContentsTitle']?></span>
                                        <p class="mt10"><?if($ROW2['ChapterRegDate']) {?>최종수강시간 : <?=$ROW2['ChapterRegDate']?><br /><?}?>
                                        <?if($ROW2['ChapterUserIP']) {?>접속아이피 : <?=$ROW2['ChapterUserIP']?><?}?></p>
                                    </li>
                                    <li><strong><?=$ChapterProgress?></strong>%</li>
                                    <li><span class="btnViewTy02"><a href="Javascript:RePlay('<?=$k?>','<?=$LectureCode?>','<?=$Study_Seq?>','<?=$ROW2['Chapter_Seq']?>','<?=$ROW2['Contents_idx']?>','<?=$PlayMode?>');">수강하기</a></span></li>
                                </ul>
                                <?
								$k++;
								}
								//강의 차시인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
								?>
								<?
								//중간평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
								if($ROW2['ChapterType']=="B") {

									switch($MidStatus) { //중간평가 상태
										case "C": //채점 완료
											$MidRatePercent = $MidScore * $MidRate / 100;
											$MidTest_msg = $MidScore."점(".$MidRatePercent ."%)";
											$MidTestStudy = "Y";
										break;
										case "N": //미응시
											$MidTest_msg = "미응시";
											$MidTestStudy = "N";
										break;
										case "Y": //응시완료
											$MidTest_msg = "응시완료<BR>(채점중)";
											$MidTestStudy = "N";
										break;
									}

								?>
								<?
									
									if( $ReMid != 'Y'){
								?>
								
								
								
                                <ul>
                                	<li>[평가]</li>
                                    <li class="infoArea">
                                    	<span class="title">중간평가</span>
                                        <p class="mt10"><?if($MidSaveTime) {?>제출일 : <?=$MidSaveTime?><br />
                                        접속아이피 : <?=$MidIP?><?}?></p>
                                    </li>
                                    <li><strong><?=$MidTest_msg?></strong></li>
                                    <li>
										<?if($MidTestStudy=="Y") {?><span class="btnViewTy03"><a href="Javascript:StudyCorrectResult('<?=$Study_Seq?>','MidTest');">결과/첨삭보기</a></span><?}?>
										
										<?
										
										if($StudyEnd=="N") {?>
											<?if($MidStatus=="C" || $MidStatus=="Y") {?><span class="btnViewTy02"><a href="Javascript:MidResetProcess(<?=$Seq?>);">재응시요청</a></span><?}?>
 										<?}?>
									
									</li>
                                </ul>
								
								<?
									}else{
								?>
								
									<ul  >
										<li>[평가]</li>
										<li class="infoArea">
											<span class="title">중간평가</span>
											<p class="mt10">
											</p>
										</li>
										 <li><strong><?=$MidTest_msg?></li>									 
										<li><span class="btnViewTy02"><?if($TestStudy=="N") {?><a href="Javascript:ExamStart('<?=$Study_Seq?>','<?=$LectureCode?>','<?=$ROW2['Chapter_Seq']?>','MidTest');">평가응시</a><?}?></span></li>
									</ul>
								<?
									}
								?>
								
								
								<?
								}
								//중간평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
								?>
								<?
								//최종평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
								if($ROW2['ChapterType']=="C") {

									switch($TestStatus) { //최종평가 상태
										case "C": //채점완료
											$TestRatePercent = $TestScore * $TestRate / 100;
											$Test_msg = $TestScore."점(".$TestRatePercent ."%)";
											$TestStudy = "Y";
										break;
										case "N": //미응시
											$Test_msg = "미응시";
											$TestStudy = "N";
										break;
										case "Y": //응시완료
											$Test_msg = "응시완료<BR>(채점중)";
											$TestStudy = "N";
										break;
									}
								?>
								<!--<ul>
                                	<li>[평가]</li>
                                    <li class="infoArea">
                                    	<span class="title">최종평가</span>
                                        <p class="mt10"><?if($TestSaveTime) {?>제출일 : <?=$TestSaveTime?><br />
                                        접속아이피 : <?=$TestIP?><?}?></p>
                                    </li>
                                    <li><strong><?=$Test_msg?></strong></li>
                                    <li><?if($TestStudy=="Y") {?><span class="btnViewTy03"><a href="Javascript:StudyCorrectResult('<?=$Study_Seq?>','Test');">결과/첨삭보기</a></span><?}?></li>
                                </ul>-->
								<?
									
									if( $ReTest != 'Y'){
								?>
								<ul>
                                	<li>[평가]</li>
                                    <li class="infoArea">
                                    	<span class="title">최종평가</span>
                                        <p class="mt10"><?if($TestSaveTime) {?>제출일 : <?=$TestSaveTime?><br />
                                        접속아이피 : <?=$TestIP?><?}?></p>
                                    </li>
                                    <li><strong><?=$Test_msg?></strong></li>
                                    <li><?if($TestStudy=="Y") {?><span class="btnViewTy03"><a href="Javascript:StudyCorrectResult('<?=$Study_Seq?>','Test');">결과/첨삭보기</a></span><?}?>
										<?if($StudyEnd=="N") {?>
 											<?if($TestStatus=="C" || $TestStatus=="Y") {?><span class="btnViewTy02"><a href="Javascript:TestResetProcess(<?=$Seq?>);">재응시요청</a></span><?}?>
 										<?}?>									
									</li>
                                </ul>
								<?
									}else{
								?>
								
									<ul>
										<li>[평가]</li>
										<li class="infoArea">
											<span class="title">최종평가</span>
											
										</li>
										 <li><strong><?=$Test_msg?></li>
									 
										<li><?if($TestStudy=="N") {?><span class="btnViewTy02"><a href="Javascript:ExamStart('<?=$Study_Seq?>','<?=$LectureCode?>','<?=$ROW2['Chapter_Seq']?>','Test');">평가응시</a></span><?}?></li>
									</ul>
								<?
									}
								?>
								<?
								}
								//최종평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
								?>
								<?
								//과제인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
								if($ROW2['ChapterType']=="D") {

									switch($ReportStatus) {
										case "C":
											$ReportRatePercent = $ReportScore * $ReportRate / 100;
											$Report_msg = $ReportScore."점(".$ReportRatePercent ."%)";
											$ReportStudy = "Y";
										break;
										case "N":
											$Report_msg = "미응시";
											$ReportStudy = "N";
										break;
										case "Y":
											$Report_msg = "제출완료<BR>(채점중)";
											$ReportStudy = "N";
										break;
									}
								?>
								<?
									
									if( $ReReport != 'Y'){
								?>
								
								<ul>
                                	<li>[평가]</li>
                                    <li class="infoArea">
                                    	<span class="title">과제</span>
                                        <p class="mt10"><?if($ReportSaveTime) {?>제출일 : <?=$ReportSaveTime?><br />
                                        접속아이피 : <?=$ReportIP?><?}?></p>
                                    </li>
                                    <li><strong><?=$Report_msg?></strong></li>
                                    <li><?if($ReportStudy=="Y") {?><span class="btnViewTy03"><a href="Javascript:StudyCorrectResult('<?=$Study_Seq?>','Report');">결과/첨삭보기</a></span><?}?>
									<?if($StudyEnd=="N") {?>
 											<?if($ReportStatus=="C" || $ReportStatus=="Y") {?><span class="btnViewTy02"><a href="Javascript:ReportResetProcess(<?=$Seq?>);">재응시요청</a></span><?}?>
										<?}?>
									
									</li>
                                </ul>
								
								<?
									}else{
								?>
								
									<ul  >
										<li>[평가]</li>
										<li class="infoArea">
											<span class="title">과제</span>
											<p class="mt10">
											</p>
										</li>
										 <li><strong><?=$Report_msg?></li>
									 
										<li><span class="btnViewTy02"><?if($TestStudy=="N") {?><a href="Javascript:ExamStart('<?=$Study_Seq?>','<?=$LectureCode?>','<?=$ROW2['Chapter_Seq']?>','Report');">평가응시</a><?}?></span></li>
									</ul>
								<?
									}
								?>
								
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
						<?if($Survey=="N") {?>
                        <!-- btn -->
                        <div class="btnAreaTc04">
                        	<span class="btnGray01"><a href="Javascript:SurveyStart('<?=$Study_Seq?>','<?=$LectureCode?>');">설문조사</a></span>
                        </div>
						<?}?>
                        <!-- area // -->
                    </div>
                    <!-- info area // -->
                
                </div>
                <!-- content area -->
            
            </div>
            <!-- Content // -->
            
        </div>
        <!-- Container // -->
         
<?
include "../include/include_bottom.php";
?>