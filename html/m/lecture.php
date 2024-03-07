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
        
        	<!-- info Area -->
            <div class="contentArea">
        		<!-- content Area -->
                
                <div class="conInfoArea">
					<?
					$NowDate = date('Y-m-d');

					$Sql = "SELECT COUNT(*) FROM Study WHERE ID='$LoginMemberID' AND ((LectureStart <= '$NowDate' AND LectureEnd >= '$NowDate') AND StudyEnd='N')";
					$Result = mysqli_query($connect, $Sql);
					$Row = mysqli_fetch_array($Result);
					$TOT_NO = $Row[0];
					?>
                    <!-- my lecture info -->
                    <div class="myLecinfo"><span class="fs18b">회원</span>님은 총 <span class="fs18b"><?=$TOT_NO?>과정</span>을 수강중입니다.</div>
                    <!-- my lecture info // -->
                    
                    <!-- list -->
                    <div class="myList">
                        <ul>
							<?
							$i = 0;
							$SQL = "SELECT a.*, a.Seq AS Study_Seq, a.MidSaveTime, a.TestSaveTime, a.ReportSaveTime, a.MidIP, a.TestIP, a.ReportIP, a.PassOk, 
										b.PreviewImage, b.ContentsName, b.idx AS Course_idx, b.Mobile, b.Chapter, b.Limited, b.PassProgress, b.TotalPassMid, b.MidRate, 
										b.TotalPassTest, b.TestRate, b.TotalPassReport, b.ReportRate, b.PassScore, b.attachFile, b.ctype, b.Professor, b.Mobile AS MobileSupport, 
										b.CompleteTime AS CompleteTime,
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
							// echo $SQL;
							$QUERY = mysqli_query($connect, $SQL);
							if($QUERY && mysqli_num_rows($QUERY))
							{
								while($ROW = mysqli_fetch_array($QUERY))
								{
									extract($ROW);

									$Today = date("Y-m-d",time());
									$RemailDate = intval((strtotime($LectureEnd)-strtotime($Today)) / 86400); //남은 수강일

									$StudyProgressStatus = StudyProgressStatus($ServiceType,$LectureCode,$Study_Seq);
									$StudyProgressStatus_Array = explode("|",$StudyProgressStatus);

									$ProgressStep = $StudyProgressStatus_Array[0];
									$ProgressStepExpl = $StudyProgressStatus_Array[1];
									$PlayProgressVal = $StudyProgressStatus_Array[2];
							?>
                            <li><?if($MobileSupport=="Y") {?><a href="lecture_detail.php?Seq=<?=$Seq?>"><?}?>
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
                                <?if($MobileSupport=="Y") {?></a><?}?>
								<?if($MobileSupport!="Y") {?><p class="onlyPC">모바일을 지원하지 않는 강의 입니다.</p><?}?>
                            </li>
							<?
								$i++;
								}
							}else{
							?>
							<li>
								<center><strong>학습중인 과정이 없습니다.</strong></center>
                            </li>
							<?}?>
                        </ul>
                    </div>
                    <!-- list // -->
                    
                </div>
        		
                <!-- content Area // -->
            </div>
            <!-- info Area // -->

        </div>
        <!-- Content // -->
         
<?
include "./include/include_bottom.php";
?>