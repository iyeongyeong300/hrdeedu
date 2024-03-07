<?
$MenuType = "A";
$PageName = "staff01";
$ReadPage = "staff01_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>관리자 관리</h2>
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

$where[] = "Dept='A'";
$where[] = "Del='N'";
$where[] = "SiteCode='$SiteCode'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY RegDate DESC, idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM StaffInfo $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

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
					<select name="col" class="wid150">
                		<option value="Name" <?if($col=="Name") { echo "selected";}?>>이름</option>
						<option value="ID" <?if($col=="ID") { echo "selected";}?>>아이디</option>
						<option value="Mobile" <?if($col=="Mobile") { echo "selected";}?>>휴대폰</option>
                	</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
                </div>
				</form>
            
                <!--목록 -->
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="80px" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="80px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>권한</th>
                    <th>소속</th>
					<th>휴대폰</th>
					<th>이메일</th>
					<th>최근 로그인</th>
					<th>최근 로그인 IP</th>
					<th>사용 유무</th>
                  </tr>
					<?
					$SQL = "SELECT *, (SELECT DeptName FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptName FROM StaffInfo $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
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
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$ID?></A></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Name?></A></td>
					<td><?=$DeptName?></td>
					<td><?=$Team?></td>
					<td><?=$Mobile?></td>
					<td><?=$Email?></td>
					<td><?=$LastLoginDate?></td>
					<td><?=$LastLoginIP?></td>
					<td><?=$UseYN_MSG?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="11">등록된 관리자가 없습니다.</td>
					</tr>
					<? 
					}

					
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->
                <div class="btnAreaTr02">
					<button type="button" name="Btn" id="Btn" class="btn btn_Blue" onClick="location.href='<?=$PageName?>_write.php?mode=new'">신규 등록</button>
              	</div>
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>