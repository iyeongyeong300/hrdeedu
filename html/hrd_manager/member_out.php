<?
$MenuType = "A";
$PageName = "member_out";
$ReadPage = "member_out_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>탈퇴회원 관리</h2>
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

$where[] = "a.MemberOut='Y'";
$where[] = "a.Sleep='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode $where";
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
						<option value="a.Name" <?if($col=="a.Name") { echo "selected";}?>>이름</option>
						<option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
						<option value="a.Mobile" <?if($col=="a.Mobile") { echo "selected";}?>>휴대폰</option>
						<option value="b.CompanyName" <?if($col=="b.CompanyName") { echo "selected";}?>>사업주명</option>
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
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>사업주</th>
                    <th>생년월일</th>
					<th>성별</th>
					<th>이메일</th>
					<th>휴대폰</th>
					<th>부서</th>
					<th>직위</th>
					<th>최종로그인</th>
					<th>가입일</th>
					<th>탈퇴일</th>
                  </tr>
					<?
					$SQL = "SELECT a.*, b.CompanyName FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							if(!$CompanyName) {
								$CompanyName = "일반회원";
							}
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td><?=$CompanyName?></td>
					<td><?=$BirthDay?></td>
					<td><?=$Gender_array[$Gender]?></td>
					<td><?=$Email?></td>
					<td><?=$Mobile?></td>
					<td><?=$Depart?></td>
					<td><?=$Position?></td>
					<td><?=$LastLogin?></td>
					<td><?=$RegDate?></td>
					<td><?=$MemberOutDate?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="15">탈퇴회원 정보가 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>