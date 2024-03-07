<?
$list_page = "notice.php";
$read_page = "notice_view.php";

include "../include/include_top.php";
?>
<?
$idx = Replace_Check($idx);

$Sql = "UPDATE Notice SET ViewCount=ViewCount+1 WHERE idx=$idx";
$Row = mysqli_query($connect, $Sql);

$Sql = "SELECT * FROM Notice WHERE idx=$idx AND UseYN='Y' AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Notice = $Row['Notice'];
	$Title = $Row['Title'];
	$Content = stripslashes($Row['Content']);
	$FileName1 = $Row['FileName1'];
	$RealFileName1 = $Row['RealFileName1'];
	$FileName2 = $Row['FileName2'];
	$RealFileName2 = $Row['RealFileName2'];
	$FileName3 = $Row['FileName3'];
	$RealFileName3 = $Row['RealFileName3'];
	$FileName4 = $Row['FileName4'];
	$RealFileName4 = $Row['RealFileName4'];
	$FileName5 = $Row['FileName5'];
	$RealFileName5 = $Row['RealFileName5'];
	$ViewCount = $Row['ViewCount'];
	$RegDate = $Row['RegDate'];
}else{
?>
<script type="text/javascript">
<!--
	location.href="notice.php";
//-->
</script>
<?
exit;
}

$BOARD_TITLE = $Title." > ";
?>
        <!-- Container -->
        <div id="container">
        	
			<!-- Content -->
            <div class="Content">
            
            	<!-- left -->
            	<?
				include "./include_support.php";
				?>
                <!-- left // -->
                
                <!-- content area -->
                <div class="contentArea" id="ContentGo">
                
                	<!-- page Title -->
                	<div class="titleZone">
                    	<h3>공지사항</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 학습지원센터 > 공지사항</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->

                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <!-- info -->
                      	<div class="panViewArea">
                            <!-- view -->
                        	<ul class="viewInfo">
                          		<li class="title"><?if($Notice=="Y") {?><span class="fcGreen01B mr5">공지 &middot;</span><?}?><?=$Title?></li>
                                <!-- item -->
           		  				<li class="item">
                                    <ul class="area">
                                        <li>
                                    		<span class="item01">등록일</span>
                                            <span><?=substr($RegDate,0,10)?></span>
                                        </li>
                                        <li>
                                    		<span class="item01">조회</span>
                                            <span><?=$ViewCount?></span>
                                    	</li>
                                    </ul>
                                </li>
                                <!-- item // -->
                                <!-- file -->
								<?if($FileName1 || $FileName2 || $FileName3 || $FileName4 || $FileName5) { ?>
                  				<li class="file">
                                    <?if($FileName1) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=1"><img src="../images/common/icon_file01.png" /><?=$RealFileName1?></a></p><?}?>
                                    <?if($FileName2) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=2"><img src="../images/common/icon_file01.png" /><?=$RealFileName2?></a></p><?}?>
									<?if($FileName3) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=3"><img src="../images/common/icon_file01.png" /><?=$RealFileName3?></a></p><?}?>
									<?if($FileName4) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=4"><img src="../images/common/icon_file01.png" /><?=$RealFileName4?></a></p><?}?>
									<?if($FileName5) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=5"><img src="../images/common/icon_file01.png" /><?=$RealFileName5?></a></p><?}?>
                                </li>
								<?}?>
                                <!-- file // -->
                                <!-- txt -->
                          		<div class="txt"><?=$Content?></div>
                                <!-- txt // -->
                          </ul>
                          <!-- view // -->
                            
                          <!-- prev next 
							 <ul class="prevnext">
                              <li><span><img src="../images/common/btn_page_next02.png" alt="다음글" class="mr5" /></span>다음글이 없습니다.</li>
                              <li><span><img src="../images/common/btn_page_prev02.png" alt="이전글" class="mr5" /></span><a href="#">	2019년 걸그룹 데뷔 인원수에 대한 이야기</a></li>
                          </ul> 
                          prev next // -->
                        
                        </div>
                        <!-- info // -->
                        
                        <!-- btn -->
                        <div class="btnAreaTc03">
                            <span class="btnGray01"><a href="notice.php?pg=<?=$pg?>&sw=<?=$sw?>">목록</a></span>
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
