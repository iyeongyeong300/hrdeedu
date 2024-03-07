<?
$list_page = "data_qna.php";
$read_page = "data_qna_view.php";

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
                    	<h3>학습 상담 리스트</h3>
                        <!-- here -->
                        <div class="here"><a href="/">Home</a> > 온라인 학습실 > 자료/상담관리 > 학습 상담 리스트</div>
                        <!-- here // -->
                	</div>
                    <!-- page Title // -->
                    
                    <!-- info area -->
                    <div class="conInfoArea">
                    	<!-- area -->
                        
                        <div class="comment_1">
                        	<ul>
                            	<li>학습 수강시 질문한 내용의 답변을 보실 수 있습니다.</li>
                            </ul>
                        </div>
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
	$where[] = "(Title LIKE '%$sw%' OR Contents LIKE '%$sw%')";
}

$where[] = "ID='$LoginMemberID'";
$where[] = "Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY RegDate DESC, idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM StudyCounsel $where";
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
                                <th class="wid_cate">문의종류</th>
                                <th>제목</th>
                                <th class="wid_date">등록일</th>
                                <th class="wid_file">답변</th>
                              </tr>
							  <?
								$SQL = "SELECT *, (SELECT ContentsName FROM Course WHERE LectureCode=StudyCounsel.LectureCode) AS ContentsName, (SELECT ContentsTitle FROM Contents WHERE idx=StudyCounsel.Contents_idx) AS ContentsTitle FROM StudyCounsel $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
								$QUERY = mysqli_query($connect, $SQL);
								if($QUERY && mysqli_num_rows($QUERY))
								{
									while($ROW = mysqli_fetch_array($QUERY))
									{
										extract($ROW);
								?>
                              <tr>
                                <td><?=$PAGE_UNCOUNT--?></td>
                                <td><?=$Counsel_array[$Category]?></td>
                                <td class="title"><a href="Javascript:readRun('<?=$idx?>');">
                                	<p class="lecture"><?=$ContentsName?><br />
                                    <?=$ContentsTitle?></p>
                                	<?=$Title?></a></td>
                                <td><?=substr($RegDate,0,10)?></td>
                                <td><?if($Status=="A") {?><?=$CounselStatus_array[$Status]?><?}else{?><span class="fcOrg01B"><?=$CounselStatus_array[$Status]?></span><?}?></td>
                              </tr>
                              <?
									}
								}else{
								?>
								<tr>
								  <td colspan="5">학습 상담 내역이 없습니다.</td>
								</tr>
								<? } ?>
                            </table>
      		      		</div>    
                        <!-- list // -->     
                            
                        <!-- page -->
                        <?=$BLOCK_LIST?>
                        <!-- page // -->
                    
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