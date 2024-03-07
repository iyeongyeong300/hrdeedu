<?
$MenuType = "A";
$PageName = "company";
$ReadPage = "company_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>사업주 관리</h2>
<?
##-- 검색 조건
$where = array();


if($Gubun) {
	$where[] = "a.CompanyScale='$Gubun'";
}

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		$where[] = "a.$col LIKE '%$sw%'";
	}
}

//영업사원의 경우 본인과 하부 조직의 내용만 체크====================================================================================================================
if($LoginAdminDept == "B") {

	$Sql = "SELECT *, (SELECT DeptString FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptString FROM StaffInfo WHERE ID='$LoginAdminID'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$DeptString = $Row['DeptString'];
		$Dept_idx = $Row['Dept_idx'];
	}
	
	if($DeptString) {
	
		//현재 해당 조직이 하부에 조직이 존재하면 팀장급 이상이므로 하부 조직 모두, 하부조직이 없으면 말단 영업사원이므로 본인것만 나오게한다.
		// Brad (2021.11.19) : 영업사원 하부 조직정보가 나오지 않는 현상 수정 --------
		$strSql = "SELECT COUNT(*) AS DeptCount FROM DeptStructure WHERE DeptString LIKE '$DeptString%'";		
		$Result = mysqli_query($connect, $strSql);
		$Row = mysqli_fetch_array($Result);

		if($Row) {
			$DeptCount = $Row['DeptCount'];
		}
		//------------------------------------------------------------------------
	
		if($DeptCount > 1) { //하부조직이 있는 경우
			$Dept_String = "";
			$SQL = "SELECT REPLACE(DeptString,'$DeptString','') AS DeptString FROM DeptStructure WHERE DeptString LIKE '$DeptString%' ORDER BY Deep ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
					if($ROW['DeptString']) {
						$Dept_String = $Dept_String.$ROW['DeptString'];
					}
				}
			}

			$DeptString_array = explode("|",$Dept_String);
			$DeptString_array = array_unique($DeptString_array);
			$DeptString_array_count = count($DeptString_array);

			$Dept_idx_query = "";
			$i = 0;
			echo '<br>'.$DeptString_array_value.'</br>';
			foreach($DeptString_array as $DeptString_array_value) {

				if($DeptString_array_value) {
					if(!$Dept_idx_query) {
						$Dept_idx_query = "b.Dept_idx=$DeptString_array_value";
					}else{
						$Dept_idx_query = $Dept_idx_query." OR b.Dept_idx=$DeptString_array_value";
					}
				}
			$i++;
			}
			$Dept_idx_query  = "(b.Dept_idx=".$Dept_idx." OR ".$Dept_idx_query.")";
			$where[] = $Dept_idx_query;

		}else{ //하부조직이 없는 경우
			$where[] = "a.SalesManager='".$LoginAdminID."'";
		}

	}else{

		$where[] = "a.SalesManager='".$LoginAdminID."'";

	}
}
//영업사원 ==========================================================================================================================================================

$where[] = "a.Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

//echo $where;
##-- 정렬조건
if($orderby=="") {
	//$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
	$str_orderby = "ORDER BY a.CompanyName ASC, a.idx ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Company AS a LEFT OUTER JOIN StaffInfo AS b ON a.SalesManager=b.ID $where";
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
                	<select name="Gubun" class="wid150">
                		<option value="" <?if($Gubun=="") { echo "selected";}?>>-회사규모 선택-</option>
						<?while (list($key,$value)=each($CompanyScale_array)) {?>
						<option value="<?=$key?>" <?if($Gubun==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
                	</select>
					<select name="col" class="wid150">
                		<option value="CompanyName" <?if($col=="CompanyName") { echo "selected";}?>>회사명</option>
						<option value="CompanyID" <?if($col=="CompanyID") { echo "selected";}?>>사업주 ID</option>
						<option value="CompanyCode" <?if($col=="CompanyCode") { echo "selected";}?>>사업자번호</option>
						<option value="HomePage" <?if($col=="HomePage") { echo "selected";}?>>기업관리코드</option>
                	</select>
                    <input name="sw" type="text" id="sw" class="wid300" placeholder="검색어를 입력하세요" value="<?=$sw?>" />
					<button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green" onClick="location.href='<?=$PageName?>_write_excel.php'"><i class="fas fa-file-excel"></i> 엑셀로 등록</button>
					<button type="button" name="Btn" id="Btn" value="" class="btn btn_Blue" onClick="location.href='<?=$PageName?>_write.php?mode=new'">신규 등록</button>		
				<?}?>
              	</div>
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
                  </colgroup>
				  <thead>
					  <tr>
						<th>번호</th>
						<th>사업자번호</th>
						<th>회사명</th>
						<th>회사규모</th>
						<th>교육담당자명</th>
						<th>교육담당자 휴대폰</th>
						<th>교육담당자 이메일</th>
						<th>영업담당자</th>
						<th>기업관리코드</th>
						<th>사업주 아이디</th>
						<th>독려 문자 수신</th>
					  </tr>
				  </thead>
				  <tbody>
					<?
					$SQL = "SELECT 
								a.idx, a.CompanyCode, a.CompanyName, a.CompanyScale, a.CompanyID, a.CyberEnabled, a.EduManager, a.EduManagerPhone, a.EduManagerEmail, a.SendSMS, 
								b.Name AS StaffName , HomePage 
								FROM Company AS a LEFT OUTER JOIN StaffInfo AS b ON a.SalesManager=b.ID 
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
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$CompanyCode?></A></td>
					<td class="tl"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$CompanyName?></A></td>
					<td><?=$CompanyScale_array[$CompanyScale]?></td>
					<td><?=$EduManager?></td>
					<td><?=$EduManagerPhone?></td>
					<td><?=$EduManagerEmail?></td>
					<td><?=$StaffName?></td>
					<td><?=$HomePage?></td>
					<td><?=$CompanyID?></td>
					<td><?=$CompanySMS_array[$SendSMS]?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="11">등록된 사업주 정보가 없습니다.</td>
					</tr>
					<? 
					}
					?>
				  </tbody>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->
                <div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<button type="button" name="ExcelOutBtn" id="ExcelOutBtn" class="btn btn_Green line" onClick="location.href='<?=$PageName?>_excel.php?Gubun=<?=$Gubun?>&col=<?=$col?>&sw=<?=$sw?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
				<?}?>
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