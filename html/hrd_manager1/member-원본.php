<?
$MenuType = "A";
$PageName = "member";
$ReadPage = "member_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>수강생 관리</h2>
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

$where[] = "a.MemberOut='N'";
$where[] = "a.Sleep='N'";

//영업사원의 경우 본인의 건만 체크
//영업사원의 경우 본인과 하부 조직의 내용만 체크====================================================================================================================
if($LoginAdminDept=="B") {

	$Sql = "SELECT *, (SELECT DeptString FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptString FROM StaffInfo WHERE ID='$LoginAdminID'";
	$Result = mysql_query($Sql);
	$Row = mysql_fetch_array($Result);

	if($Row) {
		$DeptString = $Row['DeptString'];
		$Dept_idx = $Row['Dept_idx'];
	}

	if($DeptString) {

	//현재 해당 조직이 하부에 조직이 존재하면 팀장급 이상이므로 하부 조직 모두, 하부조직이 없으면 말단 영업사원이므로 본인것만 나오게한다.
		$DeptCount = mysql_result(mysql_query("SELECT COUNT(*) FROM DeptStructure WHERE DeptString LIKE '$DeptString%'"),0,0);

		if($DeptCount>1) { //하부조직이 있는 경우

			$Dept_String = "";
			$SQL = "SELECT REPLACE(DeptString,'$DeptString','') AS DeptString FROM DeptStructure WHERE DeptString LIKE '$DeptString%' ORDER BY Deep ASC";
			$QUERY = mysql_query($SQL);
			if($QUERY && mysql_num_rows($QUERY))
			{
				while($ROW = mysql_fetch_array($QUERY))
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
			foreach($DeptString_array as $DeptString_array_value) {

				if($DeptString_array_value) {
					if(!$Dept_idx_query) {
						$Dept_idx_query = "c.Dept_idx=$DeptString_array_value";
					}else{
						$Dept_idx_query = $Dept_idx_query." OR c.Dept_idx=$DeptString_array_value";
					}
				}
			$i++;
			}

			$Dept_idx_query  = "(c.Dept_idx=".$Dept_idx." OR ".$Dept_idx_query.")";

			$where[] = $Dept_idx_query;

		}else{ //하부조직이 없는 경우
			$where[] = "b.SalesManager='".$LoginAdminID."'";
		}

	}else{

		$where[] = "b.SalesManager='".$LoginAdminID."'";

	}
}
//영업사원 ==========================================================================================================================================================

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

//echo $where;
##-- 정렬조건
if($orderby=="") {
	//$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
	$str_orderby = "ORDER BY a.Name ASC, a.idx ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode LEFT OUTER JOIN StaffInfo AS c ON b.SalesManager=c.ID $where";
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
						<!-- <option value="a.Mobile" <?if($col=="a.Mobile") { echo "selected";}?>>휴대폰</option> -->
						<option value="b.CompanyName" <?if($col=="b.CompanyName") { echo "selected";}?>>사업주명</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
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
					<col width="" />
					<col width="" />
					<col width="" />
					<col width="" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
					<th>구분</th>
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
					<th>대리수강 방지</th>
					<th>계정 사용유무</th>
					<!-- <th>마케팅 수신동의</th> -->
                  </tr>
					<?
					$SQL = "SELECT a.*, b.CompanyName, AES_DECRYPT(UNHEX(a.Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(a.Mobile),'$DB_Enc_Key') AS Mobile, AES_DECRYPT(UNHEX(a.BirthDay),'$DB_Enc_Key') AS BirthDay FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode LEFT OUTER JOIN StaffInfo AS c ON b.SalesManager=c.ID $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							$Email = InformationProtection($Email,'Email','S');
							$Mobile = InformationProtection($Mobile,'Mobile','S');
							$BirthDay = InformationProtection($BirthDay,'BirthDay','S');
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$CategoryType_array[$MemberType]?></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$ID?></A></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Name?></A></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$CompanyName?></A></td>
					<td><?=$BirthDay?></td>
					<td><?=$Gender_array[$Gender]?></td>
					<td><?=$Email?></td>
					<td><?=$Mobile?></td>
					<td><?=$Depart?></td>
					<td><?=$Position?></td>
					<td><?=$LastLogin?></td>
					<td><?=$RegDate?></td>
					<td><?=$UseYN_array[$ProtectID]?></td>
					<td><?=$UseYN_array[$UseYN]?></td>
					<!-- <td><?=$CompanySMS_array[$Marketing]?></td> -->
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 수강생 정보가 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->
                <div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="ExcelOutBtn" id="ExcelOutBtn" value="검색항목 엑셀 출력" class="btn_inputLine01" onclick="location.href='<?=$PageName?>_excel.php?col=<?=$col?>&sw=<?=$sw?>'">
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