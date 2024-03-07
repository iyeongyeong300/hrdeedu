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
                    	<h3>근로자 내일배움카드 결제</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 수강신청 / 결제 관리 > 근로자 내일배움카드 결제</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
                    
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <div class="PageZone">
                        	
                            <!-- List -->
                            <div class="myManagerList">
                            	<!-- info list -->
                                <?
								$i = 1;
								$SQL = "SELECT 
											a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Price, a.rPrice2, 
											b.ContentsName, b.Category1, b.Category2, 
											(SELECT CategoryName FROM CourseCategory WHERE idx=b.Category1) AS Category1Name, 
											(SELECT CategoryName FROM CourseCategory WHERE idx=b.Category2) AS Category2Name, 
											d.idx AS pay_idx, d.CardPrice, d.PayStatus, d.PayDate, d.PaymentRemark, d.PayMethod, d.MOID 
											FROM Study AS a 
											LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
											LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
											LEFT OUTER JOIN PaymentSheet2 AS d ON a.ID=d.ID AND a.Seq=d.Study_Seq 
											WHERE a.ID='$LoginMemberID' AND a.ServiceType=4 AND (d.PayStatus='R' OR d.PayStatus='S' OR d.PayStatus='Y') ORDER BY a.Seq ASC
											";
								//echo $SQL;
								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);
								?>
                          		<div class="term">
                                	<strong><?=$LectureStart?> ~ <?=$LectureEnd?> 개강</strong>
                                </div>
                            	<ul class="area">
                                    <li class="baseInfo">
										<?=$Category1Name?> > <?=$Category2Name?>
                                        <p class="title"><?=$ContentsName?></p>
                               	  </li>    
                                	<li class="payInfo">
                                    	<span>교육비</span><br />
                                        	<?=number_format($Price,0)?>원
                                    </li>
                                    <li class="payInfo">
                                    	<span>결제요청금액</span><br />
                                        	<?=number_format($CardPrice,0)?>원
                                    </li>
                                    <li class="checkArea">
                                    	<span>상태</span>
										<?
										if($PayStatus=='R') { //결제요청시
										?>
                                        <p>결제요청중</p>
										<?
										}
										?>
										<?
										if($PayStatus=='S') { //가상계좌 입금요청
										?>
                                        <p>입금 대기중</p>
										<?
										}
										?>
										<?
										if($PayStatus=='Y') { //결제완료시
										?>
                                        <p>결제완료</p>
										<?
										}
										?>
										<?
										if($PayStatus!='R' && $PayStatus!='Y') { //초기상태
										?>
                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;</p>
										<?
										}
										?>
                                    </li>
                                </ul>
                                <!-- btn -->
								<?
								if($PayStatus=='R') { //결제요청시
								?>
                                <div class="btnAreaTl01">
                                    <span class="btnBlue01"><a href="Javascript:PayMentOpen2_LG('<?=$pay_idx?>','<?=$ID?>');">결제하기</a></span>
                                </div>
								<?
								}
								?>
								<?
								if($PayStatus=='S') { //가상계좌 입금요청
								?>
                                <div class="btnAreaTl01">
                                    <span class="btnBlue01"><a href="Javascript:PayMentBankInfo2('<?=$pay_idx?>','<?=$ID?>');">입금 계좌 보기</a></span>
                                </div>
								<?
								}
								?>
								<?
								if($PayStatus=='Y') { //결제완료시
								?>
								<div class="btnAreaTl01">
                                    <span class="btnBlue01"><a href="Javascript:PayResult2('<?=$pay_idx?>','<?=$ID?>');">결제 확인서</a></span>
                                </div>
								<?
								}
								?>
                                <!-- btn // -->
                                <!-- info list // -->
								<?
								$i++;
									}
								}else{
								?>
								<span class="fs18 fc000B">근로자 교육과정 수강 내역이 없습니다.</span>
								<? } ?>
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