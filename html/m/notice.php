<?
$list_page = "notice.php";
$read_page = "notice_view.php";

include "./include/include_top.php";
?>


        <!-- Content -->
        <div id="Content">
        
        	<!-- h2 -->
        	<h2>공지사항</h2>
        
        	<!-- info Area -->
            <div class="contentArea">
        		<!-- content Area -->
<?
$pg = Replace_Check_XSS2($pg);
$col = Replace_Check_XSS2($col);
$sw = Replace_Check_XSS2($sw);

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 10;
$block_size = 10;

##-- 검색 조건
$where = array();

if($sw){
	$where[] = "(Title LIKE '%$sw%' OR Content LIKE '%$sw%')";
}

$where[] = "Del='N'";
$where[] = "UseYN='Y'";
$where[] = "Notice='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY RegDate DESC, idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Notice $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

##-- 페이지 클래스 생성
include_once("../include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
                <div class="">

                    <!-- list -->
                	<div class="panListArea">
                   	  	<ul class="list">
							<?
							$SQL = "SELECT * FROM Notice WHERE Del='N' AND Notice='Y' ORDER BY RegDate DESC, idx DESC";
							$QUERY = mysqli_query($connect, $SQL);
							if($QUERY && mysqli_num_rows($QUERY))
							{
								while($ROW = mysqli_fetch_array($QUERY))
								{
									extract($ROW);

							?>
                   	  		<li><a href="Javascript:readRun('<?=$idx?>');"><span class="titleNotice">[공지] <?=$Title?></span>
                   	  			<p><span class="first"><?=substr($RegDate,0,10)?></span><span><?=$ViewCount?></span></p></a>
                   	  		</li>
							<?
								}
							}
							?>
							<?
							$SQL = "SELECT * FROM Notice $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
							$QUERY = mysqli_query($connect, $SQL);
							if($QUERY && mysqli_num_rows($QUERY))
							{
								while($ROW = mysqli_fetch_array($QUERY))
								{
									extract($ROW);

									$Title = strcut_utf8($Title,64);
							?>
                   	  		<li><a href="Javascript:readRun('<?=$idx?>');"><span class="title"><?=$Title?> </span>
                   	  			<p><span class="first"><?=substr($RegDate,0,10)?></span><span><?=$ViewCount?></span></p></a>
                   	  		</li>
							<?
								}
							}else{
							?>
							<li>
							  <span class="title">등록된 공지사항이 없습니다.</span>
							</li>
							<? } ?>
                   	  	</ul>
                	</div>
                	<!-- list // -->
                        
                	<!-- page -->
                	<div class="pageArea">
                        <?=$BLOCK_LIST?>
                	</div>
                	<!-- page // -->
                    
                    <!-- search -->
					<form name="BoardSearchForm" action="<?=$_SERVER['PHP_SELF']?>" method="GET">
                    <div class="panSearch mt30">
                    	<ul class="area">
                   	  		<li class="inputArea"><input name="sw" id="sw" type="text" /></li>
                    		<li class="btnArea"><a href="Javascript:BoardSearch();">검색</a></li>
                        </ul>
                    </div>
					</form>
                    <!-- search // -->

                </div>
                
                <!-- content Area // -->
            </div>
            <!-- info Area // -->

        </div>
        <!-- Content // -->
         
<?
include "./include/include_bottom.php";
?>