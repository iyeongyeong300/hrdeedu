<?
$list_page = "data_qna.php";
$read_page = "data_qna_view.php";

include "../include/include_top.php";
?>
<?
$idx = Replace_Check($idx);

$Sql = "UPDATE StudyCounsel SET ViewCount=ViewCount+1 WHERE idx=$idx";
$Row = mysqli_query($connect, $Sql);

$Sql = "SELECT * FROM StudyCounsel WHERE idx=$idx AND ID='$LoginMemberID' AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$LectureCode = $Row['LectureCode'];
	$Contents_idx = $Row['Contents_idx'];
	$Name = $Row['Name'];
	$Category = $Row['Category'];
	$Mobile = $Row['Mobile'];
	$Email = $Row['Email'];
	$Title = $Row['Title'];
	$Contents = nl2br(stripslashes($Row['Contents']));
	$RegDate = $Row['RegDate'];
	$Name2 = $Row['Name2'];
	$Contents2 = stripslashes($Row['Contents2']);
	$RegDate2 = $Row['RegDate2'];
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
	$Status = $Row['Status'];
}else{
?>
<script type="text/javascript">
<!--
	location.href="data_qna.php";
//-->
</script>
<?
exit;
}

$BOARD_TITLE = $Title." > ";


$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsName = $Row['ContentsName'];
}

$Sql = "SELECT * FROM Contents WHERE idx=$Contents_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsTitle = $Row['ContentsTitle'];
}
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
                    	<h3>학습 상담 리스트</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 자료/상담관리 > 학습 상담 리스트</div>
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
                            	<li class="lecture"><?=$ContentsName?><br />
                                    <?=$ContentsTitle?></li>
                          		<li class="title"><?=$Title?></li>
                                <!-- item -->
           		  				<li class="item">
                                    <ul class="area">
                                        <li>
                                    		<span class="item01">문의종류</span>
                                            <span><?=$Counsel_array[$Category]?></span>
                                    	</li>
                                        <li>
                                    		<span class="item01">등록일</span>
                                            <span><?=substr($RegDate,0,10)?></span>
                                    	</li>
                                    </ul>
                                </li>
                                <!-- item // -->
                                <!-- txt -->
                          		<div class="txt"><?=$Contents?></div>
                                <!-- txt // -->
                        	</ul>
                        	<!-- view // -->
                          
                        	<!-- reply -->
                        	<?if($Status=="B") {?>
                        	<!-- reply -->
                        	<ul class="viewInfo mt40">
                          		<li class="titleReply"><span>답변</span> 답변입니다.</li>
                                <!-- item -->
           		  				<li class="item">
                                    <ul class="area">
                                        <li>
                                    		<span class="item01">답변</span>
                                            <span><?=$Name2?></span>
                                        </li>
                                        <li>
                                    		<span class="item01">등록일</span>
                                            <span><?=substr($RegDate2,0,10)?></span>
                                    	</li>
                                    </ul>
                                </li>
                                <!-- item // -->
								<?if($FileName1 || $FileName2 || $FileName3 || $FileName4 || $FileName5) { ?>
                  				<li class="file">
                                    <?if($FileName1) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=StudyCounsel&file=1"><img src="../images/common/icon_file01.png" /><?=$RealFileName1?></a></p><?}?>
                                    <?if($FileName2) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=StudyCounsel&file=2"><img src="../images/common/icon_file01.png" /><?=$RealFileName2?></a></p><?}?>
									<?if($FileName3) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=StudyCounsel&file=3"><img src="../images/common/icon_file01.png" /><?=$RealFileName3?></a></p><?}?>
									<?if($FileName4) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=StudyCounsel&file=4"><img src="../images/common/icon_file01.png" /><?=$RealFileName4?></a></p><?}?>
									<?if($FileName5) { ?><p><a href="../include/download.php?idx=<?=$idx?>&code=StudyCounsel&file=5"><img src="../images/common/icon_file01.png" /><?=$RealFileName5?></a></p><?}?>
                                </li>
								<?}?>
                                <!-- txt -->
                          		<div class="txt"><?=$Contents2?></div>
                                <!-- txt // -->
                        	</ul>
                        	<!-- reply // -->
							<?}?>
                        	<!-- reply // -->
                        
                        </div>
                      	<!-- info // -->
                        
                        <!-- btn -->
                        <div class="btnAreaTc03">
                            <span class="btnGray01"><a href="data_qna.php?pg=<?=$pg?>&sw=<?=$sw?>">목록</a></span>
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