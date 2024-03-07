<?
include "../include/include_top.php";
?>
        
        <!-- Container -->
        <div id="container">
        	
			<!-- Content -->
            <div class="Content">
            
            	<!-- left -->
            	<?
				include "../edugrow/include_edugrow.php";
				?>
                <!-- left // -->
                
                <!-- content area -->
                <div class="contentArea" id="ContentGo">
                
                	<!-- page Title -->
                	<div class="titleZone">
                    	<h3><?=$CategoryName?></h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 직무능력향상교육 > <?=$CategoryName?></div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
<?
$pg = Replace_Check_XSS2($pg);


##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 10;
$block_size = 10;

##-- 검색 조건
$where = array();

$where[] = "Del='N'";
$where[] = "UseYN='Y'";
$where[] = "PackageYN='N'";
$where[] = "Category1=$Menu02ParentCategory";

if($Category) {
$where[] = "Category2=$Category";
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY RegDate DESC, idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}
?>
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <div class="PageZone">
                        	
                            <!-- list -->
                            <div class="lectureList">
								<?
								$i = 1;
								$SQL = "SELECT * FROM Course $where $str_orderby";
								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);

										if($PreviewImage) {
											$PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' alt='".$ContentsName."'>";
										}else{
											$PreviewImageView = "<img src='/images/no_img.jpg' alt='".$ContentsName."'>";
										}

										if($IE8Compat=="Y") {
											//$PreviewFun = "CoursePreviewPopup";
											$PreviewFun = "CoursePreview";
										}else{
											$PreviewFun = "CoursePreview";
										}
								?>
                            	<ul>
                                	<li class="imgArea"><a href="course_detail.php?Category=<?=$Category?>&idx=<?=$idx?>"><?=$PreviewImageView?></a></li>
                                    <li class="infoArea">
                                    	<p class="title"><a href="course_detail.php?Category=<?=$Category?>&idx=<?=$idx?>"><?=$ContentsName?></a></p>
                                        <p class="modeMark">
											<?if($ServiceType=="1") {?><img src="../images/common/icon_show_refund.png" alt="사업주환급" /><?}?>
                                        	<img src="../images/common/icon_show_pc.png" alt="PC" />
                                            <?if($Mobile=="Y") {?><img src="../images/common/icon_show_mobile.png" alt="모바일병행" /><?}?>
                                      	</p>
                                    	<p class="lecInfo">
                                        	<span>내용전문가 : <?=$Professor?></span>
                                            <span>교육시간 : <?=$Chapter?>차시<em> / </em><?=$ContentsTime?>시간</span>
                                        </p>
                                  		<p class="priceInfo">
                                            <span class="fcFix"><?=number_format($Price,0)?>원</span> → 
											<span class="fcPriceB">자부담금 <?=number_format($Price01,0)?>원</span>
                                            <!-- <span class="fcPriceB"><?=number_format($Price01View,0)?>원</span> -->
                                            <span class="btnSmLine02"><a href="Javascript:CoursePriceDetail('<?=$LectureCode?>');" id="CoursePriceDetailA">환급지원 / 자부담금 상세보기</a></span>
                                        </p>
                                        <!-- btn -->
                                        <div class="lecBtn">
                                        	<span class="btn01"><a href="Javascript:<?=$PreviewFun?>('<?=$LectureCode?>');">교육맛보기</a></span>
                                            <span class="btn02"><a href="Javascript:LectureRequest('<?=$LectureCode?>','<?=$Price?>');">학습신청</a></span>
                                            <span class="btn01"><a href="Javascript:SimpleAsk();">간편문의</a></span>
                                        </div>
                                        <!-- btn // -->
                                    </li>
                                </ul>
                                <?
								$i++;
									}
								}
								?>
                            </div>
                            <!-- list // -->
                           
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