<?
$MenuType = "D";
$PageName = "discussion_topic";
$ReadPage = "discussion_topic_read";
?>
<? include "./include/include_top.php"; ?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#Gubun").select2();
	changeSelect2Style();
});
//-->
</script>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>토론주제 관리</h2>
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

 

if($str_TestType) {
	$where[] = "Gubun LIKE '%$str_TestType%'";
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
$Sql = "SELECT COUNT(*) FROM DiscussionTopic $where";
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
                	<select name="Gubun" id="Gubun">
						<option value="">-- 과목구분 선택 --</option>
						<?
						$SQL = "SELECT DISTINCT(Gubun) FROM DiscussionTopic WHERE Del='N' ORDER BY Gubun ASC";
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
					
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
					<button type="button" onclick="ExamBankCheckedDelete()" class="btn btn_DGray line">체크 항목 삭제</button>
					<button type="button" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn btn_Blue">신규 등록</button>
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
					<col width="30px" />
                    <col width="80px" />
                    <col width="250px" />
                    <col width="" />
                    <col width="150px" />
					<col width="80px" />
                  </colgroup>
                  <tr>
					<th><input type="checkbox" name="AllCheck" id="AllCheck" value="Y" onclick="CheckBox_AllSelect('check_seq')" class="checkbox"/></th>
                    <th>번호</th>
                    <th>과목 구분</th>
                    <th>토픽</th>
					<th>등록일</th>
					<th>사용 여부</th>
                  </tr>
					<?
					$SQL = "SELECT * FROM DiscussionTopic $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
                  <tr>
					<td><font color="#FFFFFF"><?=$idx?></font><br><input type="checkbox" name="check_seq" id="check_seq" value="<?=$idx?>" class="checkbox"/></td>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');">&nbsp;<?=$Gubun?>&nbsp;</A></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Topic?></A></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$RegDate?></A></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$UseYN_array[$UseYN]?></A></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="7">등록된 토론주제가 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->
				<div class="btnAreaTr02">
					<button type="button" onclick="ExamBankCheckedDelete()" class="btn btn_DGray line">체크 항목 삭제</button>
					<button type="button" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn btn_Blue">신규 등록</button>
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