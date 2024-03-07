<?
$MenuType = "B";
$PageName = "lecture_request";
$ReadPage = "lecture_request_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>학습신청</h2>
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

$where[] = "a.Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(a.idx) 
			FROM LectureRequest AS a 
			LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
			LEFT OUTER JOIN Company AS c ON b.CompanyCode=c.CompanyCode 
			LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
			$where";
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
						<option value="b.Name" <?if($col=="b.Name") { echo "selected";}?>>이름</option>
						<option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
						<!-- <option value="b.Mobile" <?if($col=="b.Mobile") { echo "selected";}?>>휴대폰</option> -->
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
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>사업주</th>
					<th>휴대폰</th>
					<th>신청한 교육 과정</th>
					<th>교육비</th>
					<th>상태 / 결제수단</th>
					<th>삭제</th>
                  </tr>
					<?
					$SQL = "SELECT a.*, b.Name, AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS Mobile, c.CompanyName, d.ContentsName 
						FROM LectureRequest AS a 
						LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
						LEFT OUTER JOIN Company AS c ON b.CompanyCode=c.CompanyCode 
						LEFT OUTER JOIN Course AS d ON a.LectureCode=d.LectureCode 
						$where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							if($CompanyName) {
								$CompanyName = $CompanyName;
							}else{
								$CompanyName = "일반회원";
							}

							$Mobile = InformationProtection($Mobile,'Mobile','S');
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td><?=$CompanyName?></td>
					<td><?=$Mobile?></td>
					<td align="left"><?=$ContentsName?></td>
					<td><?=number_format($Price,0)?></td>
					<td>
					<select name="Status" id="Status" style="width:100px">
					<?
					while (list($key,$value)=each($LectureRequestStatus_array)) {
						?>
						<option value="<?=$key?>" <?if($Status==$key) {?>selected<?}?>><?=$value?></option>
					<?
					}
					reset($LectureRequestStatus_array);
					?>
					</select>&nbsp;
					<select name="Payment" id="Payment" style="width:100px">
						<option value="">-결제수단-</option>
					<?
					while (list($key,$value)=each($LectureRequestPayment_array)) {
						?>
						<option value="<?=$key?>" <?if($Payment==$key) {?>selected<?}?>><?=$value?></option>
					<?
					}
					reset($LectureRequestPayment_array);
					?>
					</select>&nbsp;
					<input type="button" value="변경" class="btn_inputSm01" onclick="LectureRequestStatus('<?=$ID?>','<?=$idx?>','<?=$i?>');">
					</td>
					<td><input type="button" value="삭제" class="btn_inputSm01" onclick="LectureRequestDelete('<?=$ID?>','<?=$idx?>','<?=$i?>');"></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 학습신청 내역이 없습니다.</td>
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