<?
$MenuType = "E";
$PageName = "simple_ask";
$ReadPage = "simple_ask_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>간편문의</h2>
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
$Sql = "SELECT COUNT(idx) 
			FROM SimpleAsk $where";
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
						<option value="Name" <?if($col=="Name") { echo "selected";}?>>이름</option>
						<option value="Contents" <?if($col=="Contents") { echo "selected";}?>>내용</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
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
                  </colgroup>
                  <tr>
                    <th>번호</th>
					<th>아이디</th>
                    <th>이름</th>
                    <th>연락처</th>
					<th>이메일</th>
					<th>내용</th>
					<th>상태</th>
					<th>상세보기</th>
					<th>삭제</th>
                  </tr>
					<?
					$SQL = "SELECT *, AES_DECRYPT(UNHEX(Phone),'$DB_Enc_Key') AS Phone, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email 
						FROM SimpleAsk $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							$Phone = InformationProtection($Phone,'Tel','S');
							$Email = InformationProtection($Email,'Email','S');

							$Contents = strcut_utf8($Contents,64);

							if(!$ID) {
								$ID = "비회원";
							}
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td><?=$Phone?></td>
					<td><?=$Email?></td>
					<td align="left"><?=$Contents?></td>
					<td><span id="Status"><?=$SimpleAskStatus_array[$Status]?></span></td>
					<td><input type="button" value="상세보기" class="btn_inputSm01" onclick="SimpleAskDetail(<?=$idx?>);"></td>
					<td><input type="button" value="삭제" class="btn_inputSm01" onclick="SimpleAskDelete('<?=$Name?>',<?=$idx?>);"></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 간편문의 내역이 없습니다.</td>
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