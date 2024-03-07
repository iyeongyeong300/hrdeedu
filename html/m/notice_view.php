<?
include "./include/include_top.php";
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
?>
        <!-- Content -->
        <div id="Content">
        
        	<!-- h2 -->
        	<h2>공지사항</h2>
        
        	<!-- info Area -->
            <div class="contentArea">
        		<!-- content Area -->
                
                <div class="">

                    <!-- view -->
                	<div class="panViewArea mt15">
               			<!-- view info -->
                        <ul class="viewInfo">
							<li class="title"><?if($Notice=="Y") {?><span class="fcGreen01">공지 · </span><?}?><?=$Title?></li>
							<li class="item">
                				<span class="type01">등록일</span><span class="type02"><?=substr($RegDate,0,10)?></span>
                				<span class="type01">조회</span><span class="type02"><?=$ViewCount?></span>
                			</li>
                			<!-- file -->
							<?if($FileName1 || $FileName2 || $FileName3 || $FileName4 || $FileName5) { ?>
							<li class="file">
                				<?if($FileName1) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=1"><span class="fcSky01">[첨부] </span><?=$RealFileName1?></a></p><?}?>
                				<?if($FileName2) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=2"><span class="fcSky01">[첨부] </span><?=$RealFileName2?></a></p><?}?>
								<?if($FileName3) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=3"><span class="fcSky01">[첨부] </span><?=$RealFileName3?></a></p><?}?>
								<?if($FileName4) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=4"><span class="fcSky01">[첨부] </span><?=$RealFileName4?></a></p><?}?>
								<?if($FileName5) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=Notice&file=5"><span class="fcSky01">[첨부] </span><?=$RealFileName5?></a></p><?}?>
                			</li>
							<?}?>
                			<!-- file // -->
                            <!-- txt -->
							<div class="txt">
                            <?=$Content?>
						  </div>
                            <!-- txt // -->
               		  	</ul>
               		  	
                        <!-- view info // -->
                	</div>
                	<!-- view // -->
                        
                	<!-- btn -->
                	<div class="btnAreaTc02">
                		<p class="btnGrayF"><a href="notice.php?pg=<?=$pg?>&sw=<?=$sw?>">목록</a></p>
                	</div>
                    <!-- btn // -->

                </div>
                
                <!-- content Area // -->
            </div>
            <!-- info Area // -->

        </div>
        <!-- Content // -->
         
<?
include "./include/include_bottom.php";
?>