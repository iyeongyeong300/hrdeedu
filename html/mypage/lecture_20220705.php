<?
include "../include/include_top.php";
?>
        
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
                    	<h3>학습중인 과정</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 수강관리 > 학습중인 과정</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
                    
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <div class="PageZone">
                        	
                            <!-- List -->
                            <div class="myList">
								<?
								$i = 0;
								$DirectBtnLabel = "";
								$DirecFunction = "";
								$NowDate = date('Y-m-d');
								// Brad(2021.12.15) : Query 수정
								$SQL = "SELECT a.*, a.Seq AS Study_Seq, a.MidSaveTime, a.TestSaveTime, a.ReportSaveTime, a.MidIP, a.TestIP, a.ReportIP, a.PassOk, 
											b.PreviewImage, b.ContentsName, b.idx AS Course_idx, b.Mobile, b.Chapter, b.Limited, b.PassProgress, b.TotalPassMid, b.MidRate, 
											b.TotalPassTest, b.TestRate, b.TotalPassReport, b.ReportRate, b.PassScore, b.attachFile, b.ctype, b.Professor, b.CompleteTime AS CompleteTime,
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
											WHERE a.ID='$LoginMemberID' AND ((a.LectureStart <= '$NowDate' AND a.LectureEnd >= '$NowDate') AND a.StudyEnd='N') ORDER BY a.PackageRef ASC, a.PackageLevel ASC, a.InputDate DESC";
								//echo $SQL;
								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);

										$Today = date("Y-m-d",time());
										$RemailDate = intval((strtotime($LectureEnd)-strtotime($Today)) / 86400); //남은 수강일

										// Brad(2021.12.17) : $CompleteTime 파레메터 수정 
										//$StudyProgressStatus = StudyProgressStatus($ServiceType,$LectureCode,$Study_Seq, $CompleteTime);
										$StudyProgressStatus = StudyProgressStatus($ServiceType,$LectureCode,$Study_Seq);
										$StudyProgressStatus_Array = explode("|",$StudyProgressStatus);

										$ProgressStep = $StudyProgressStatus_Array[0];
										$ProgressStepExpl = $StudyProgressStatus_Array[1];
										$PlayProgressVal = $StudyProgressStatus_Array[2];
								?>
                                <ul class="area">
                                	<li class="title"><?=$ContentsName?></li>
                                    <li class="lecInfo">
                                    	<p><span>수강기간 : </span><strong><?=$LectureStart?> ~ <?=$LectureEnd?> </strong><em> / </em><span>남은수강일 : </span><strong><?=$RemailDate?>일</strong></p>
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

										// echo $Direct_ChapterType;
										if($Direct_ChapterType=="A" ) { 
											$DirectBtnLabel = "이어서 학습진행";
											$DirecFunction = "Play('$Direct_Chapter_Number','$Direct_LectureCode','$Direct_Study_Seq','$Direct_Chapter_Seq','$Direct_Contents_idx','$Direct_PlayMode')";
										}
										if($Direct_ChapterType=="B") {
											$DirectBtnLabel = "중간평가 응시하기";
											$DirecFunction = "ExamStart('$Direct_Chapter_Number','$Direct_LectureCode','$Direct_Study_Seq','MidTest')";
										}
										if($Direct_ChapterType=="C") {
											$DirectBtnLabel = "최종평가 응시하기";
											$DirecFunction = "ExamStart('$Direct_Chapter_Number','$Direct_LectureCode','$Direct_Study_Seq','Test')";
										}
										if($Direct_ChapterType=="D") {
											$DirectBtnLabel = "과제 응시하기";
											$DirecFunction = "ExamStart('$Direct_Chapter_Number','$Direct_LectureCode','$Direct_Study_Seq','Report')";
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
										// Brad(2021.12.19) : 비환급 과정 수료후 비활성화 버튼 제거
										if ($Direct_ChapterType == "") {
											$StatusBtnDisplay = "N";
										}									
										?>
										<?
	//패키지 강의인 경우
	if($PackageRef>0) {

$targetData = "	B002018850114, 	B002018020318   고지유   010-2358-4032
B002018001206   김서경   010-4884-2552
B002018000318   안수빈   010-5518-3474
B002018990209   이민지   010-4943-0970
B002018990730   이수희   010-7523-0730
B002018991105   이주영   010-6407-4168
B002018000322   최정윤   010-8568-2158
B002018730110   허재형   010-2810-7773";

		
		if($PackageLevel==1) { //패키지 첫번째 강의인 경우 무조건 오픈
			$BeforePassOK = "Y";
		}
		if($BeforePassOK=="Y") {
			$PackageStudyOpen = "Y";
		}else{
			$PackageStudyOpen = "N";
		}
		if(Progress > 50){
			$PackageStudyOpen = "Y";
		}
	}else{
		$PackageStudyOpen = "Y";
	}
	
	echo strpos($targetData,$ID);
	if(strpos($targetData,$ID)  !== false){
		 
			$BeforePassOK = "Y";
			$PackageStudyOpen="Y";
			$StatusBtnDisplay="Y";
		}
		 
?>
                                        <div class="lecBtn">

										<?if($PackageStudyOpen=="Y") {?>

                                            <?if($StatusBtnDisplay == "Y") {?><span class="btn02"><a href="Javascript:<?=$DirecFunction?>"><?=$DirectBtnLabel?></a></span><?}?>
                                            <span class="btn01"><a href="lecture_detail.php?Seq=<?=$Seq?>">상세보기</a></span>
										<?}else{?>
											<?if($StatusBtnDisplay == "Y") {?><span class="btn02"><a href="Javascript:PackageOpenNo('<?=$BeforeContentsName?>');"><?=$DirectBtnLabel?></a></span><?}?>
										<?}?>
                                      	</div>
                                        <!-- btn // -->
                                    </li>
									<?
										$BeforePassOK = $PassOK;
										$BeforeContentsName = $ContentsName;									
									?>
                                    <!-- 상태 -->
                                    <div class="checkArea">
                                    	<dl>
                                        	<dt>현재 진행상태</dt>
                                            <dd><p class="txt"><?=$ProgressStep?></p>
                                            <?=$ProgressStepExpl?></dd>
                                        </dl>
                                        <dl>
                                        	<dt>강의진도</dt>
                                            <dd><span class="notxt"><strong><span id="Data_<?=$Study_Seq?>_ProgressCount"><?=$ProgressCount?></span></strong>/<?=$Chapter?></span></dd>
                                        </dl>
                                        <dl>
                                        	<dt>진도율</dt>
                                            <dd><span class="notxt"><strong><span id="Data_<?=$Study_Seq?>_Progress"><?=$Progress?></span></strong>%</span></dd>
                                        </dl>
                                    </div>
                                    <!-- 상태 // -->
                                </ul>
                                <?
									$DirectBtnLabel = "";
									$DirecFunction = "";
									$i++;
									}
								}else{
								?>
								<ul class="area">
								  <li class="title"><strong>학습중인 과정이 없습니다.</strong></li>
								</ul>
								<?}?>
  
                            </div>
                            <!-- List // -->
                           
                        </div>
                        
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