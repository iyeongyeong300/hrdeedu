<?
$list_page = "edudata.php";
$read_page = "/support/edudata_view.php";

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
                    	<h3>찜한 학습자료</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 자료/상담관리 > 찜한 학습자료</div>
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

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 25;
$block_size = 10;

##-- 검색 조건
$where = array();

if($sw){
	$where[] = "(b.Title LIKE '%$sw%' OR b.Content LIKE '%$sw%')";
}

$where[] = "a.ID='$LoginMemberID'";
$where[] = "b.Del='N'";
$where[] = "b.UseYN='Y'";
//$where[] = "b.Notice='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY a.RegDate DESC, a.Num DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM StudyPDS_Scrap AS a LEFT OUTER JOIN StudyPDS AS b ON a.idx=b.idx $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


##-- 페이지 클래스 생성
include_once("../include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
                        <!-- search -->
                        <form name="BoardSearchForm" action="<?=$_SERVER['PHP_SELF']?>" method="GET">
                        <div class="panSearch">
                            <span><img src="/images/common/icon_search01.png" alt="검색" class="vm mr10" /></span>
                        	<span><input name="sw" id="sw" type="text" value="<?=$sw?>" /></span>
                            <span class="btn"><a href="Javascript:BoardSearch();">검색</a></span>
                        </div>
						</form>
                        <!-- search // -->
                        
                        <!-- list -->
                        <div class="panListArea mt30">
                        <table cellpadding="0" class="pan_table">
                              <caption>게시판 목록</caption>
                              <tr>
                                <th class="wid_no">번호</th>
                                <th>제목</th>
                                <th class="wid_file">파일</th>
                                <th class="wid_date">등록일</th>
                                <th class="wid_no">조회</th>
                              </tr>
                              <?
							$SQL = "SELECT a.idx, b.Title, b.FileName1, b.RegDate, b.ViewCount, b.Content FROM StudyPDS_Scrap AS a LEFT OUTER JOIN StudyPDS AS b ON a.idx=b.idx $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
							$QUERY = mysqli_query($connect, $SQL);
							if($QUERY && mysqli_num_rows($QUERY))
							{
								while($ROW = mysqli_fetch_array($QUERY))
								{
									extract($ROW);

									$Title = strcut_utf8($Title,64);
							?>
                              <tr>
                                <td><?=$PAGE_UNCOUNT--?></td>
                                <td class="title"><a href="Javascript:readRun('<?=$idx?>');"><?=$Title?></a></td>
                                <td><?if($FileName1) {?><img src="/images/common/icon_file01.png" alt="첨부파일 있음" /><?}?></td>
                                <td><?=substr($RegDate,0,10)?></td>
                                <td><?=$ViewCount?></td>
                              </tr>
							<?
								}
							}else{
							?>
                    		<tr>
                    		  <td colspan="5">찜한 학습자료가 없습니다.</td>
                            </tr>
                    		<? } ?>
                            </table>
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