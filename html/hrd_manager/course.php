<?
$MenuType = "D";
$PageName = "course";
$ReadPage = "course_read";
?>
<? include "./include/include_top.php"; ?>
<?
if($ctype) {
	$_SESSION["ctype_session"] = $ctype;
}else{
	if($ctype_session) {
		$ctype = $ctype_session;
	}else{
		$ctype = "A";
		$_SESSION["ctype_session"] = $ctype;
	}
}
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>단과 컨텐츠 관리 [<?=$CategoryType_array[$ctype]?>]</h2>
<?
##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		if($col=="LectureCode") {
			$where[] = "a.LectureCode='$sw'";
		}else{
			$where[] = "a.$col LIKE '%$sw%'";
		}
	}
}

if($ServiceType) {
	$where[] = "ServiceType='$ServiceType'";
}

$where[] = "a.PackageYN='N'";
$where[] = "a.Del='N'";
$where[] = "a.ctype='$ctype'";


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

mysqli_free_result($Result);



##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소

if($ctype=="A") {
	$CompanyScaleTitle01 = "우선지원";
	$CompanyScaleTitle02 = "대규모 1000인 미만";
	$CompanyScaleTitle03 = "대규모 1000인 이상";
}

if($ctype=="B") {
	$CompanyScaleTitle01 = "일반훈련생";
	$CompanyScaleTitle02 = "취업성공패키지";
	$CompanyScaleTitle03 = "근로장려금";
}
?>

            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->
				<form name="search" method="get">
                <div class="searchPan">
                	<select name="ServiceType" id="ServiceType">
						<option value="">서비스 구분</option>
						<?
						if($ctype == "A") {
							while (list($key,$value)=each($ServiceTypeCourse_array)) {
								?>
							<option value="<?=$key?>" <?if($ServiceType==$key) {?>selected<?}?>><?=$value?></option>
							<?
							}
							reset($ServiceTypeCourse_array);
						}
						if($ctype == "B") {
							while (list($key,$value)=each($ServiceTypeCourse2_array)) {
								?>
							<option value="<?=$key?>" <?if($ServiceType==$key) {?>selected<?}?>><?=$value?></option>
							<?
							}
							reset($ServiceTypeCourse2_array);
						}
						?>
					</select>&nbsp;&nbsp;
					<select name="col">
						<option value="ContentsName" <?if($col=="ContentsName") { echo "selected";}?>>과정명</option>
						<option value="LectureCode" <?if($col=="LectureCode") { echo "selected";}?>>강의 코드</option>
						<option value="Cp" <?if($col=="Cp") { echo "selected";}?>>CP사</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
					<?if($AdminWrite=="Y") {?><input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'"><?}?>
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="40px" />
                    <col width="70px" />
                    <col width="100px" />
                    <col width="" />
                    <col width="120px" />
					<col width="340px" />
					<col width="150px" />
					<col width="130px" />
					<col width="80px" />
					<col width="50px" />
					<col width="50px" />
					<col width="100px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
					<th>등&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;급<br>과정 코드</th>
					<th>서비스 구분</th>
					<th>과정 분류<br>과&nbsp;&nbsp;정&nbsp;&nbsp;명</th>
					<th>총차시/교육시간</th>
					<th>교육비<br>자부담금</th>
					<th>심사코드</th>
					<th>HRD-NET 과정코드</th>
					<th>유효기간<br>&nbsp;인정만료</th>
					<th>모바일</th>
					<th>사이트<br>노출</th>
					<th>8개 차시<br>수강 제한</th>
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
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$ClassGrade_array[$ClassGrade]?><br><strong><?=$LectureCode?></strong></A></td>
					<td>
					<?if($ctype == "A") {?>
					<A HREF="Javascript:readRun('<?=$idx?>');"><?=$ServiceTypeCourse_array[$ServiceType]?></A>
					<?}?>
					<?if($ctype == "B") {?>
					<A HREF="Javascript:readRun('<?=$idx?>');"><?=$ServiceTypeCourse2_array[$ServiceType]?></A>
					<?}?>
					</td>
					<td class="tl"><A HREF="Javascript:readRun('<?=$idx?>');"><span class="sm"><?=$Category1Name?> <?if($Category2Name) {?> > <?=$Category2Name?><?}?></span><br><?if($Hit=="Y") {?><span class="redB">[인기]</span> <?}?><strong><?=$ContentsName?></strong></A></td>
					<td><?=$Chapter?> 차시 / <?=$ContentsTime?> 시간</td>
					<td>
					교육비 : <?=number_format($Price,0)?> 원 / <?=$CompanyScaleTitle02?> : <?=number_format($Price02,0)?> 원<br>
				<?=$CompanyScaleTitle01?>  : <?=number_format($Price01,0)?> 원 / <?=$CompanyScaleTitle03?> : <?=number_format($Price03,0)?> 원
					</td>
					<td><?=$PassCode?></td>
					<td><?=$HrdCode?></td>
					<td><?=substr($ContentsPeriod,0,10)?><br><?=substr($ContentsExpire,0,10)?></td>
					<td><?=$UseYN_array[$Mobile]?></td>
					<td><?=$UseYN_array[$UseYN]?></td>
					<td><?=$ChapterLimit_array[$ChapterLimit]?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 단과 컨텐츠가 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->

                <div class="btnAreaTr02">
					<?if($AdminWrite=="Y") {?><input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'"><?}?>
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