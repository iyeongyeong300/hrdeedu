<?
$list_page = "faq.php";

include "../include/include_top.php";
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
                    	<h3>자주묻는 질문</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 학습지원센터 > 자주묻는 질문</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
                    
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
<?
$pg = Replace_Check_XSS2($pg);
$col = Replace_Check_XSS2($col);
$sw = Replace_Check_XSS2($sw);
$FaqCate = Replace_Check_XSS2($FaqCate);

$MainSend = Replace_Check_XSS2($MainSend);
$view_num = Replace_Check_XSS2($view_num);

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 25;
$block_size = 10;

##-- 검색 조건
$where = array();

if($sw){
	$where[] = "(Title LIKE '%$sw%' OR Content LIKE '%$sw%')";
}

$where[] = "Del='N'";
$where[] = "UseYN='Y'";

if($FaqCate) {
$where[] = "Category='$FaqCate'";
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY OrderByNum ASC, RegDate ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Faq $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


##-- 페이지 클래스 생성
include_once("../include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<form name="listScriptForm" method="GET" action="<?=$_SERVER['PHP_SELF']?>">
<input type="hidden" name="col" value="<?=$col?>">
<input type="hidden" name="sw" value="<?=$sw?>">
<input type="hidden" name="pg" value="<?=$pg?>">
<input type="hidden" name="orderby" value="<?=$orderby?>">
<input type="hidden" name="FaqCate" value="<?=$FaqCate?>">
</form>
<?if($MainSend=="Y") {?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	FaqView(<?=$view_num?>);
});
//-->
</script>
<?}?>
                   	  	<!-- tab -->
						<div class="tabFree">
                            <ul class="list">
                                <li class="fb"><a href="faq.php?FaqCate=&col=<?=$col?>&sw=<?=$sw?>" <?if(!$FaqCate) {?>class="show"<?}?>>전체</a></li>
                                <?
								while (list($key,$value)=each($Faq_array)) {
								?>
								<li><a href="faq.php?FaqCate=<?=$key?>&col=<?=$col?>&sw=<?=$sw?>" <?if($FaqCate==$key) {?>class="show"<?}?>><?=$value?></a></li>
								<?
								}
								?>
                            </ul>
                        </div>
                      	<!-- tab // -->
                    
                        <!-- search -->
						<form name="BoardSearchForm" action="<?=$_SERVER['PHP_SELF']?>" method="GET">
						<div class="panSearch mt40">
                            <span><img src="../images/common/icon_search01.png" alt="검색" class="vm mr10" /></span>
                        	<span><input name="sw" id="sw" type="text" /></span>
                            <span class="btn"><a href="Javascript:BoardSearch();">검색</a></span>
                        </div>
						</form>
                        <!-- search // -->
                        
                        <!-- list -->
                        <div class="faqZone mt30">
                        	<ul class="list">
								<?
								$i = 0;
								$SQL = "SELECT * FROM Faq $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);

										$Content = stripslashes($ROW['Content']);
								?>
                            	<li>
                                	<a href="Javascript:FaqView(<?=$i?>);"><strong><?=$Faq_array[$Category]?></strong>
                                    <?=$Title?></a>
                                    <div id="ContentElement" class="faqView" style="display:none">
                                    <?=$Content?>
                                    </div>
                                </li>
                                <?
								$i++;
									}
								}else{
								?>
								<li>
									<p style='text-align:center; height:80px'><br><br>등록된 자주묻는질문이 없습니다.</p>
								</li>
								<? } ?>
                            </ul>
                        </div>
                        <!-- list // -->     
                            
                        <!-- page -->
                        <?=$BLOCK_LIST?>
                    
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