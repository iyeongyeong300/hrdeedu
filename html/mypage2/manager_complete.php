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
                    	<h3>수료 관리</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 교육담당자메뉴 > 수료 관리</div>
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
								$SQL = "SELECT DISTINCT a.LectureStart AS LectureStart, a.LectureEnd 
											FROM Study AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode WHERE a.CompanyCode='$CompanyCode' AND a.ServiceType IN (1,3,5,9) ORDER BY a.LectureStart ASC, a.LectureEnd ASC ";

								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);

										if($LectureEnd) {
											if($LectureEnd>date('Y-m-d')) {
												$CertificatePrintOK = "N";
											}else{
												$CertificatePrintOK = "Y";
											}
										}else{
											$CertificatePrintOK = "N";
										}
								?>
                          		<div class="term">
                                	<strong><?=$LectureStart?> ~ <?=$LectureEnd?> 개강</strong>
                                    <!-- btn -->
                                    <div class="btnSideArea">
                                    	<span class="btnMyBase01"><a href="Javascript:CertificatePrintMulti('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','','Y','<?=$CertificatePrintOK?>');">전체 환급과정 수료증PDF</a></span>
                                        <span class="btnMyBase01"><a href="Javascript:CertificatePrintMulti('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','','N','<?=$CertificatePrintOK?>');">전체 비환급과정 수료증PDF</a></span>
                                    </div>
                                    <!-- btn // -->
                                </div>
								<?
								$SQL2 = "SELECT  DISTINCT 
								a.CompanyCode, c.Category1, c.Category2, 
								(SELECT CategoryName FROM CourseCategory WHERE idx=c.Category1) AS Category1Name, 
								(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1 AND PassOk='Y') AS StudyCount, 
								(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType=1 AND PassOk='N') AS StudyBeCount, 
								(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (3,5,9) AND PassOk='Y') AS StudyCount2, 
								(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND ServiceType IN (3,5,9) AND PassOk='N') AS StudyBeCount2, 
								c.ContentsName, c.LectureCode 
								FROM Study AS a 
								LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode 
								LEFT OUTER JOIN Course AS c ON a.LectureCode=c.LectureCode 
								
								WHERE b.CompanyCode='$CompanyCode' AND a.ServiceType IN (1,3,5,9) AND a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd' ORDER BY b.CompanyName ASC";
								//echo $SQL2."<br><br>";
								$QUERY2 = mysqli_query($connect, $SQL2);
								if($QUERY2 && mysqli_num_rows($QUERY2))
								{
									while($ROW2 = mysqli_fetch_array($QUERY2))
									{

										$StudyCount = $ROW2['StudyCount']; //환급수료인원
										$StudyBeCount = $ROW2['StudyBeCount']; //환급 미수료인원

										$StudySum = $StudyCount + $StudyBeCount; //환급 전체인원

										$StudyCount2 = $ROW2['StudyCount2']; //비환급수료인원
										$StudyBeCount2 = $ROW2['StudyBeCount2']; //비환급 미수료인원

										$StudySum2 = $StudyCount2 + $StudyBeCount2; //비환급 전체인원

										$Category1Name = $ROW2['Category1Name'];
										$ContentsName = $ROW2['ContentsName'];
										$LectureCode = $ROW2['LectureCode'];

								?>
                            	<ul class="area">
                                    <li class="baseInfo">
                                    	<?=$Category1Name?>
                                        <p class="title"><?=$ContentsName?></p>
                                        <dl class="noTxt">
                                        	<dd><span>환급 : </span><?=$StudySum?>명</dd>
                                            <dd><span>비환급 : </span><?=$StudySum2?>명</dd>
                                        </dl>
                               	  	</li>    
                                	<li class="noDetail">
                                    	<p><span>환급 수료인원</span><br />
                                        	<strong><?=$StudyCount?>명</strong> / <?=$StudySum?>명</p>
                                    	<p><span>비환급 수료인원</span><br />
                                        	<strong><?=$StudyCount2?>명</strong> / <?=$StudySum2?>명</p>
                                    </li>
                                    <li class="btnArea">
                                        <p class="btnMyBase01"><a href="Javascript:CertificatePrintMulti('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','<?=$LectureCode?>','Y','<?=$CertificatePrintOK?>');" class="wid100">환급과정<br>수료증PDF</a></p>
                                        <p class="btnMyBase01 mt5"><a href="Javascript:CertificatePrintMulti('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','<?=$LectureCode?>','N','<?=$CertificatePrintOK?>')" class="wid100">비환급과정<br>수료증PDF</a></p>
                                    </li>
                                </ul>
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
                                <!-- info list // -->
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
