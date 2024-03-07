<?
$MenuType = "E";
$PageName = "after";
$ReadPage = "after_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>수강후기</h2>
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

$where[] = "a.UseYN='Y'";


$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Review AS a LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode $where";
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
<script type="text/javascript">
<!--
function DeleteOk(idx) {

	del_confirm = confirm("현재 수강후기를 삭제하시겠습니까?");
	if(del_confirm==true) {
		document.DeleteForm.idx.value = idx;
		DeleteForm.submit();
	}
}
//-->
</script>
			<form name="DeleteForm" method="post" action="after_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="del">
				<INPUT TYPE="hidden" name="idx" value="">
				<INPUT TYPE="hidden" name="pg" value="<?=$pg?>">
				<INPUT TYPE="hidden" name="col" value="<?=$col?>">
				<INPUT TYPE="hidden" name="sw" value="<?=$sw?>">
			</form>
            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->
				<form name="search" method="get">
                <div class="searchPan">
                	<select name="col">
						<option value=" b.ContentsName" <?if($col==" b.ContentsName") { echo "selected";}?>>과정명</option>
						<option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
						<option value="a.Name" <?if($col=="a.Name") { echo "selected";}?>>이름</option>
						<option value="a.Contents" <?if($col=="a.Contents") { echo "selected";}?>>내용</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->

                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="40px" />
                    <col width="300px" />
                    <col width="120px" />
                    <col width="80px" />
                    <col width="80px" />
					<col width="" />
					<col width="100px" />
					<col width="120px" />
					<col width="50px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
					<th>과정명</th>
					<th>별점</th>
					<th>아이디</th>
					<th>이름</th>
					<th>내용</th>
					<th>등록 IP</th>
					<th>등록일</th>
					<th>삭제</th>
                  </tr>
					<?
					$SQL = "SELECT a.*, b.ContentsName FROM Review AS a LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							$Star = StarPointView($StarPoint);
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td style="text-align:left"><?=$ContentsName?></td>
					<td><?=$Star?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td style="text-align:left"><?=$Contents?></td>
					<td><?=$IP?></td>
					<td><?=$RegDate?></td>
					<td><?if($AdminWrite=="Y") {?><input type="button"  value="삭제" class="btn_inputSm01" onclick="DeleteOk(<?=$idx?>);"><a href="Javascript:DeleteOk(<?=$idx?>);"><?}?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="10">등록된 수강후기가 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
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