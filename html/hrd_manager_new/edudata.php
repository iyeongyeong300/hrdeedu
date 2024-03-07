<?
$MenuType = "E";
$PageName = "edudata";
$ReadPage = "edudata_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>학습자료실</h2>
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
$Sql = "SELECT COUNT(*) FROM StudyPDS $where";
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
						<option value="Content" <?if($col=="Content") { echo "selected";}?>>내용</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="Btn" id="Btn" value="자료 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
				<?}?>
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="80px" />
                    <col width="" />
                    <col width="200px" />
                    <col width="150px" />
                    <col width="80px" />
					<col width="80px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>첨부</th>
                    <th>등록일</th>
					<th>조회</th>
					<th>사용 유무</th>
                  </tr>
					<?
					$SQL = "SELECT * FROM StudyPDS WHERE Del='N' AND Notice='Y' ORDER BY RegDate DESC, idx DESC";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							if($UseYN=="Y") {
								$UseYN_MSG = "<font color='blue'>사용</font>";
							}else{
								$UseYN_MSG = "<font color='red'>미사용</font>";
							}
					?>
					<tr>
						<td>공지</td>
						<td style="text-align:left"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Title?></A></td>
						<td><?=$RealFileName1?></td>
						<td><?=$RegDate?></td>
						<td><?=$ViewCount?></td>
						<td><?=$UseYN_MSG?></td>
					  </tr>
					<?
						}
					}
					?>
					<?
					$SQL = "SELECT * FROM StudyPDS $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							if($UseYN=="Y") {
								$UseYN_MSG = "<font color='blue'>사용</font>";
							}else{
								$UseYN_MSG = "<font color='red'>미사용</font>";
							}
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td style="text-align:left"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Title?></A></td>
					<td><?=$RealFileName1?></td>
					<td><?=$RegDate?></td>
					<td><?=$ViewCount?></td>
					<td><?=$UseYN_MSG?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="6">등록된 내용이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                <div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="Btn" id="Btn" value="자료 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
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