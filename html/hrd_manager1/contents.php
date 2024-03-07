<?
$MenuType = "D";
$PageName = "contents";
$ReadPage = "contents_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>기초차시 관리</h2>
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

$where[] = "Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY Gubun ASC, idx ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Contents $where";
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
                	<select name="Gubun">
						<option value="">-- 차시구분 선택 --</option>
						<?
						$SQL = "SELECT DISTINCT(Gubun) FROM Contents WHERE Del='N' ORDER BY Gubun ASC";
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
					<select name="col">
						<option value="ContentsTitle" <?if($col=="ContentsTitle") { echo "selected";}?>>차시명</option>
						<option value="Expl01" <?if($col=="Expl01") { echo "selected";}?>>차시목표</option>
						<option value="Expl02" <?if($col=="Expl02") { echo "selected";}?>>훈련내용</option>
						<option value="Expl03" <?if($col=="Expl03") { echo "selected";}?>>학습활동</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
					<input type="button" value="엑셀로 기초차시 등록" onclick="location.href='<?=$PageName?>_excel.php'" class="btn_inputLine01">
					<input type="button" value="신규 등록" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn_inputBlue01">
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
					<col width="80px" />
                    <col width="300px" />
                    <col width="" />
					<col width="100px" />
                    <col width="150px" />
					<col width="150px" />
                  </colgroup>
                  <tr>
					<th>번호</th>
					<th>차시 구분</th>
					<th>차시명</th>
					<th>수강시간(분)</th>
					<th>등록일</th>
					<th>하부 컨텐츠수</th>
                  </tr>
					<?
					$SQL = "SELECT *, (SELECT COUNT(*) FROM ContentsDetail WHERE Contents_idx=Contents.idx) AS ContentsDetail_Count FROM Contents $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
                  <tr>
					<td align="center"  class="text01"><?=$PAGE_UNCOUNT--?></td>
					<td align="center" class="text01"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Gubun?></A></td>
					<td align="left" class="text01"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$ContentsTitle?></A></td>
					<td align="center" class="text01"><?=$LectureTime?></td>
					<td align="center" class="text01"><?=$RegDate?></td>
					<td align="center" class="text01"><?=$ContentsDetail_Count?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 기초차시가 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->
				<div class="btnAreaTr02">
					<input type="button" value="엑셀로 기초차시 등록" onclick="location.href='<?=$PageName?>_excel.php'" class="btn_inputLine01">
					<input type="button" value="신규 등록" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn_inputBlue01">
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