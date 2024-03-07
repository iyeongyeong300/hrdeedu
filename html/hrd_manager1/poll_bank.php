<?
$MenuType = "D";
$PageName = "poll_bank";
$ReadPage = "poll_bank_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>강사 관리</h2>
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

if($Gubun) {
	$where[] = "Gubun='$Gubun'";
}

if($ExamType) {
	$where[] = "ExamType='$ExamType'";
}

$where[] = "Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY OrderByNum ASC, Gubun ASC, idx ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM PollBank $where";
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
                	<select name="Gubun">
						<option value="">-- 설문구분 선택 --</option>
						<?
						$SQL = "SELECT DISTINCT(Gubun) FROM PollBank WHERE Del='N' ORDER BY Gubun ASC";
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							while($Row = mysqli_fetch_array($QUERY))
							{
						?>
						<option value="<?=$Row['Gubun']?>" <?if($Row['Gubun']==$Gubun) {?>selected<?}?>><?=$Row['Gubun']?></option>
						<?
							}
						}
						?>
					</select>&nbsp;&nbsp;
					<select name="ExamType">
						<option value="" <?if($ExamType=="") { echo "selected";}?>>-- 문제유형 선택 --</option>
						<?while (list($key,$value)=each($PollType_array)) {?>
						<option value="<?=$key?>" <?if($ExamType==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
					<input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="80px" />
                    <col width="250px" />
                    <col width="100px" />
                    <col width="" />
                    <col width="150px" />
					<col width="80px" />
					<col width="80px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>설문 구분</th>
                    <th>설문 유형</th>
                    <th>질문</th>
					<th>등록일</th>
					<th>정렬 순서</th>
					<th>사용 여부</th>
                  </tr>
					<?
					$SQL = "SELECT *FROM PollBank $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Gubun?></A></td>
					<td align="center" class="text01"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$PollType_array[$ExamType]?></A></td>
					<td style="text-align:left"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Question?></A></td>
					<td><?=$RegDate?></td>
					<td><?=$OrderByNum?></td>
					<td><?=$UseYN_array[$UseYN]?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="7">등록된 설문이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->

                <div class="btnAreaTr02">
					<input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
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