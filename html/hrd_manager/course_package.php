<?
$MenuType = "D";
$PageName = "course_package";
$ReadPage = "course_package_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>패키지 컨텐츠 관리</h2>
<?
##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		if($col=="LectureCode") {
			$where[] = "a.LectureCode='$LectureCode'";
		}else{
			$where[] = "a.$col LIKE '%$sw%'";
		}
	}
}

$where[] = "a.PackageYN='Y'";
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
$Sql = "SELECT COUNT(*) FROM Course AS a 
						LEFT OUTER JOIN CourseCategory AS b ON a.Category1=b.idx 
						LEFT OUTER JOIN CourseCategory AS c ON a.Category2=c.idx  $where";
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
                	<select name="col">
						<option value="ContentsName" <?if($col=="ContentsName") { echo "selected";}?>>과정명</option>
						<option value="LectureCode" <?if($col=="LectureCode") { echo "selected";}?>>강의 코드</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
					<?if($AdminWrite=="Y") {?><input type="button" value="신규 등록" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn_inputBlue01"><?}?>
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
					<col width="50px" />
                    <col width="120px" />
                    <col width="" />
					<col width="110px" />
                    <col width="130px" />
					<col width="90px" />
                  </colgroup>
                  <tr>
					<th>번호</th>
					<th>과정 코드</th>
					<th>과정 분류 / 과정명</th>
					<th>패키지 번호</th>
					<th>등록된 단과 강의수</th>
					<th>사이트 노출</th>
                  </tr>
					<?
					$SQL = "SELECT a.*, b.CategoryName AS Category1Name, c.CategoryName AS Category2Name FROM 
						Course AS a 
						LEFT OUTER JOIN CourseCategory AS b ON a.Category1=b.idx 
						LEFT OUTER JOIN CourseCategory AS c ON a.Category2=c.idx 
						$where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							if($ROW['PackageLectureCode']) {
								$PackageLectureCode_array = explode("|",$ROW['PackageLectureCode']);
								$PackageLectureCode_count = count($PackageLectureCode_array);
							}else{
								$PackageLectureCode_count = 0;
							}

							$PackageRef_pad = PackageRefLeftString($PackageRef);
					?>
                  <tr>
					<td align="center" ><?=$PAGE_UNCOUNT--?></td>
					<td align="center"><A HREF="Javascript:readRun('<?=$idx?>');"><strong><?=$LectureCode?></strong></A></td>
					<td align="left"><A HREF="Javascript:readRun('<?=$idx?>');"><span class="sm"><?=$Category1Name?> <?if($Category2Name) {?> > <?=$Category2Name?><?}?></span><br><strong><?=$ContentsName?></strong></A></td>
					<td align="center"><?=$PackageRef_pad?></td>
					<td align="center"><?=$PackageLectureCode_count?></td>
					<td align="center"><?=$UseYN_array[$UseYN]?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 패키지 컨텐츠가 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->
				<div class="btnAreaTr02">
					<?if($AdminWrite=="Y") {?><input type="button" value="신규 등록" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn_inputBlue01"><?}?>
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