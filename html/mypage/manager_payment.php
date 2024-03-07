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
<?
if($LoginEduManager!="Y") {
?>
<script type="text/javascript">
<!--
	location.href="myinfo.php";
//-->
</script>
<?
exit;
}
?>
                <!-- content area -->
                <div class="contentArea" id="ContentGo">
                
                	<!-- page Title -->
                	<div class="titleZone">
                    	<h3>자부담금 관리</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 교육담당자메뉴 > 자부담금 관리</div>
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
								$Sql = "SELECT *, (SELECT CompanyName FROM Company WHERE CompanyCode=Member.CompanyCode LIMIT 0,1) AS CompanyName FROM Member WHERE ID='$LoginMemberID' AND MemberOut='N' AND UseYN='Y'";
								$Result = mysqli_query($connect, $Sql);
								$Row = mysqli_fetch_array($Result);

								if($Row) {
									$CompanyCode = $Row['CompanyCode']; //사업자 번호
									$CompanyName = $Row['CompanyName']; //소속기업명
								}
								?>
								<?
								$i = 1;
								$SQL = "SELECT 
											DISTINCT(a.LectureStart) AS LectureStart, a.LectureEnd, 
											(SELECT DISTINCT(LectureCode) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode ORDER BY ServiceType ASC LIMIT 0,1) AS LectureCode, 
											(SELECT COUNT(DISTINCT(LectureCode)) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5,9)) AS CourseCount 
											FROM Study AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode WHERE a.CompanyCode='$CompanyCode' AND a.ServiceType IN (1,3,5,9) ORDER BY a.LectureStart ASC, a.LectureEnd ASC ";
								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);

										$Sql = "SELECT ContentsName FROM Course WHERE LectureCode='$LectureCode'";
										$Result = mysqli_query($connect, $Sql);
										$Row = mysqli_fetch_array($Result);

										if($Row) {
											$ContentsName = $Row['ContentsName'];
										}

										if($CourseCount>1) {
											$ContentsName = $ContentsName." 등 ".$CourseCount."개 과정";
										}else{
											$ContentsName = $ContentsName;
										}
								?>
                          		<div class="term">
                                	<strong><?=$LectureStart?> ~ <?=$LectureEnd?> 개강</strong>
                                </div>
								<?
								$SQL2 = "SELECT DISTINCT(a.CompanyCode), b.CompanyName, c.BankPrice, c.CardPrice, c.PayStatus, c.PaymentRemark, c.PayMethod, c.MOID, c.PayDate, c.CancelDate,c.idx AS pay_idx,  
								(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5,9)) AS TotalPrice, 
								(SELECT SUM(rPrice) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5,9)) AS TotalRPrice, 
								(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS TotalPrice2, 
								(SELECT SUM(rPrice) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS TotalRPrice2, 
								(SELECT SUM(rPrice2) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (1,3,5,9)) AS rPrice2Sum, 
								(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1) AS StudyCount, 
								(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (3,5,9)) AS StudyBeCount 
								FROM  Study AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode LEFT OUTER JOIN PaymentSheet AS c ON a.CompanyCode=c.CompanyCode AND a.LectureStart=c.LectureStart AND a.LectureEnd=c.LectureEnd WHERE b.CompanyCode='$CompanyCode' AND a.ServiceType IN (1,3,5,9) AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd' ORDER BY b.CompanyName ASC";
								//echo $SQL2."<br><br>";
								$QUERY2 = mysqli_query($connect, $SQL2);
								if($QUERY2 && mysqli_num_rows($QUERY2))
								{
									while($ROW2 = mysqli_fetch_array($QUERY2))
									{

										$TotalPrice = $ROW2['TotalPrice']; //전체 교육비
										$TotalRPrice = $ROW2['TotalRPrice']; //전체 환급액
										$TotalPrice2 = $ROW2['TotalPrice2']; //환급과정 교육비
										$TotalRPrice2 = $ROW2['TotalRPrice2']; //환급과정 환급액
										$rPrice2Sum = $ROW2['rPrice2Sum']; //자부담금
										$CompanyCode = $ROW2['CompanyCode'];
										$StudyCount = $ROW2['StudyCount'];
										$StudyBeCount = $ROW2['StudyBeCount'];
										$BankPrice = $ROW2['BankPrice'];
										$CardPrice = $ROW2['CardPrice'];
										$PayStatus = $ROW2['PayStatus'];
										$PaymentRemark = $ROW2['PaymentRemark'];
										$PayMethod = $ROW2['PayMethod'];
										$MOID = $ROW2['MOID'];
										$PayDate = $ROW2['PayDate'];
										$CancelDate = $ROW2['CancelDate'];
										$pay_idx = $ROW2['pay_idx'];

										if(!$BankPrice) {
											$BankPrice = 0;
										}else{
											$BankPrice = $BankPrice;
										}
										if(!$CardPrice) {
											$CardPrice = $TotalPrice2;
										}else{
											$CardPrice = $CardPrice;
										}

								?>
                            	<ul class="area">
                                    <li class="baseInfo">
                                        <p class="title"><?=$ContentsName?></p>
                                        <dl class="noTxt">
                                        	<dd><span>환급 : </span><?=$StudyCount?>명</dd>
                                            <dd><span>비환급 : </span><?=$StudyBeCount?>명</dd>
                                        </dl>
                               	  </li>    
                                	<li class="payInfo">
                                    	<p><span>교육비</span><br />
                                        	<?=number_format($TotalPrice,0)?>원</p>
                                    	<p><span>자부담금</span><br />
                                        	<strong><?=number_format($rPrice2Sum,0)?>원</strong></p>
                                    </li>
                                    <li class="payInfo">
                                    	<p><span>통장입금액</span><br />
                                        	<?=number_format($BankPrice,0)?>원</p>
                                    	<p><span>결제요청금액</span><br />
                                        	<?=number_format($CardPrice,0)?>원</p>
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
                                    <span class="btnBlue01"><a href="Javascript:PayMentOpen_LG('<?=$pay_idx?>','<?=$CompanyCode?>');">결제하기</a></span>
                                </div>
								<?
								}
								?>
								<?
								if($PayStatus=='Y') { //결제완료시
								?>
								<div class="btnAreaTl01">
                                    <span class="btnBlue01"><a href="Javascript:PayResult('<?=$pay_idx?>','<?=$CompanyCode?>');">결제 확인서</a></span>
                                </div>
								<?
								}
								?>
                                <!-- btn // -->
								<?
								$k++;
									}
								}
								?>
                                <!-- info list // -->
								<?
								$i++;
									}
								}else{
								?>
								<span class="fs18 fc000B">수강 내역이 없습니다.</span>
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