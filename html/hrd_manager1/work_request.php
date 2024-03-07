<?
$MenuType = "G";
$PageName = "work_request";
$ReadPage = "work_request_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>작업요청 게시판</h2>
<?
##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		$where[] = "$col LIKE '%$sw%'";
	}
}

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
$Sql = "SELECT COUNT(*) FROM WorkRequest $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

mysqli_free_result($Result);

##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->
				<form name="search" method="get">
                <div class="searchPan">
                	<select name="col">
						<option value="Title" <?if($col=="Title") { echo "selected";}?>>제목</option>
						<option value="Name" <?if($col=="Name") { echo "selected";}?>>작성자</option>
						<option value="Content" <?if($col=="Content") { echo "selected";}?>>내용</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="Btn" id="Btn" value="작업요청 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
				<?}?>
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="60px" />
                    <col width="" />
                    <col width="150px" />
                    <col width="100px" />
                    <col width="150px" />
					<col width="80px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>첨부</th>
                    <th>작성자</th>
					<th>등록일</th>
					<th>상태</th>
                  </tr>
					<?
					$SQL = "SELECT * FROM WorkRequest $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							switch ($Status) {
								case "A": // 접수
									$StatusView = "<font color='#ff6600'>접수</font>";
								break;
								case "B": // 작업중
									$StatusView = "<font color='#0066ff'>작업중</font>";
								break;
								case "C": // 작업완료
									$StatusView = "<font color='#000000'>작업완료</font>";
								break;
							}
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td align="left"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Title?></A></td>
					<td><?=$RealFileName1?></td>
					<td><?=$Name?></td>
					<td><?=$RegDate?></td>
					<td><?=$StatusView?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 내용이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                <div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="Btn" id="Btn" value="작업요청 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
				<?}?>
              	</div>
            	<!-- 버튼 -->

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>