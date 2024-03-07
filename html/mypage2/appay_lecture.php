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
                    	<h3>수강신청 내역</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 수강신청 / 결제 관리 > 수강신청 내역</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
                    
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <div class="PageZone">
                        	
                            <!-- List -->
                            <div class="myOtherList">
								<?
								$SQL = "SELECT a.*, b.PreviewImage, b.ContentsName, b.idx AS Course_idx, c.CategoryName AS Category1Name, c.idx AS Category1_idx, d.CategoryName AS Category2Name, 
											d.idx AS Category2_idx, b.Professor 
											FROM 
											LectureRequest AS a 
											LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
											LEFT OUTER JOIN CourseCategory AS c ON b.Category1=c.idx 
											LEFT OUTER JOIN CourseCategory AS d ON b.Category2=d.idx 
											WHERE a.ID='$LoginMemberID' ORDER BY a.RegDate DESC";
								//echo $SQL;
								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);


										if($Category2Name) {
											$Category2Name = " &gt; ".$Category2Name;
										}

										$timestamp = strtotime($LectureStart."+1 months");
										$RequestCancelDate = date("Y-m-d 23:59:59", $timestamp);

										if(date("Y-m-d H:i:s") < $RequestCancelDate) {
											$RequestCancelDateYN = "Y";
										}else{
											$RequestCancelDateYN = "N";
										}

										if($Category1_idx==$Menu01ParentCategory) {
											$LectureUrl = "/educps/course_detail.php?Category=$Category2_idx&idx=$Course_idx";
										}
										if($Category1_idx==$Menu02ParentCategory) {
											$LectureUrl = "/edugrow/course_detail.php?Category=$Category2_idx&idx=$Course_idx";
										}
										if($Category1_idx==$Menu03ParentCategory) {
											$LectureUrl = "/educard/course_detail.php?Category=$Category2_idx&idx=$Course_idx";
										}
								?>
                                <ul class="area">
                                	<li>
                                    	<p class="cate"><?=$Category1Name?> <?=$Category2Name?></p>
                                        <p class="title"><?=$ContentsName?></p>
                                        <div class="lecInfo">
                                            <p><span>수강 신청일 : </span><strong><?=substr($RegDate,0,10)?></strong><em> / </em><span>신청 학습기간 : </span><strong><?=$LectureStart?> ~ <?=$LectureEnd?> </strong></p>
                                            <p><span>내용전문가 : </span><?=$Professor?></p>
                                        </div>
                                    </li>
                                    <li class="wid150 tr">
                                    	<?if($Status=="A") {?><p class="btnSmLine01"><a href="Javascript:LectureRequestCancel('<?=$idx?>');" class="wid110 tc">수강신청 취소</a></p><?}?>
                                    	<p class="btnSmLine01 mt5"><a href="<?=$LectureUrl?>" target="_blank" class="wid110 tc">강의정보 보기</a></p>
                                    </li>
                                </ul>
                                <?
									}
								}else{
								?>
								<ul class="info">
								  <li style="text-align:center"><strong>수강 신청내역이 없습니다.</strong></li>
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