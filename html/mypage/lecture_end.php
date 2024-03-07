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
                    	<h3>학습종료 과정</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 수강관리 > 학습종료 과정</div>
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

								$NowDate = date('Y-m-d');
								$SQL = "SELECT a.*, a.Seq AS Study_Seq, a.MidSaveTime, a.TestSaveTime, a.ReportSaveTime, a.MidIP, a.TestIP, a.ReportIP, a.PassOk, 
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
											WHERE a.ID='$LoginMemberID' AND a.StudyEnd='Y' ORDER BY a.PackageRef ASC, a.PackageLevel ASC, a.InputDate DESC";
								//echo $SQL;
								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);

										$Today = date("Y-m-d",time());

										if($PassOk=="Y") {
											$PassOkStatus = "수료";
										}else{
											$PassOkStatus = "미수료";
										}
								?>
                                <ul class="area">
                                	<li class="title"><?=$ContentsName?></li>
                                    <li class="lecInfo">
                                    	<p><span>수강기간 : </span><strong><?=$LectureStart?> ~ <?=$LectureEnd?> </strong></p>
                                        <p><span>내용전문가 : </span><?=$Professor?></p>
                                        <!-- btn -->
                                        <div class="lecBtn">
                                            <?if($PassOk=="Y") {?><span class="btn02"><a href="Javascript:CertificatePrint(<?=$Seq?>);">수료증 출력</a></span><?}else{?><br><?}?>
                                   	  </div>
                                        <!-- btn // -->
                                    </li>
                                    <!-- 상태 -->
                                    <div class="checkArea">
                                    	<dl>
                                        	<dt>수료 여부</dt>
                                            <dd><p class="txt"><?=$PassOkStatus?></p>
                                            </dd>
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
                                <?
									$i++;
									}
								}else{
								?>
								<ul class="area">
								  <li class="title"><strong>학습이 종료된 과정이 없습니다.</strong></li>
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