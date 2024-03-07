<?
$MenuType = "A";
$PageName = "company";
$ReadPage = "company_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT *, (SELECT Name FROM StaffInfo WHERE ID=Company.SalesManager) AS SalesName FROM Company WHERE idx=$idx AND Del='N'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$CompanyScale = $Row['CompanyScale']; //회사규모
	$CompanyCode = $Row['CompanyCode']; //사업자번호
	$CompanyName = $Row['CompanyName']; //회사명
	$CompanyID = $Row['CompanyID']; //회사아이디
	$HRD = $Row['HRD']; //HRD번호
	$Ceo = $Row['Ceo']; //대표자명
	$Uptae = $Row['Uptae']; //업태
	$Upjong = $Row['Upjong']; //업종
	$Zipcode = $Row['Zipcode']; //우편번호
	$Address01 = $Row['Address01']; //주소
	$Address02 = $Row['Address02']; //상세주소
	$Tel = $Row['Tel']; //대표 연락처
	$Tel2 = $Row['Tel2']; //고객센터 연락처
	$Fax = $Row['Fax']; //대표 FAX
	$Fax2 = $Row['Fax2']; //고객센터 FAX
	$Email = $Row['Email']; //이메일
	$BankName = $Row['BankName']; //은행명
	$BankNumber = $Row['BankNumber']; //계좌번호
	$CSEnabled = $Row['CSEnabled']; //고객센터 번호 사용여부
	$CyberEnabled = $Row['CyberEnabled']; //사이버교육센터 사용여부
	$HomePage = $Row['HomePage']; //홈페이지
	$CyberURL = $Row['CyberURL']; //사이버교육센터 주소
	$EduManager = $Row['EduManager']; //교육담당자명
	$EduManagerPhone = $Row['EduManagerPhone']; //교육담당자 연락처
	$EduManagerEmail = $Row['EduManagerEmail']; //교육담당자 이메일
	$SalesManager = $Row['SalesManager']; //영업담당자 아이디
	$Remark = $Row['Remark']; //메모
	$EduName = $Row['EduName']; //교육담당자 이름
	$SalesName = $Row['SalesName']; //영업담당자 이름
	$SendSMS = $Row['SendSMS']; //독려수신 여부
}

$Sql = "SELECT *, (SELECT DeptString FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptString FROM StaffInfo WHERE ID='$SalesManager'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Dept_idx = $Row['Dept_idx'];
	$DeptString = $Row['DeptString'];

	$DeptStringName = DeptStringNaming($DeptString);
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 사업주를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}

//-->
</SCRIPT>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>사업주 상세 내용</h2>
            
            <div class="conZone">
            	<!-- ## START -->
            
                <!-- 내용 -->
				<form name="DeleteForm" method="post" action="company_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                    <col width="120px" />
                    <col width="" />
					<col width="120px" />
                    <col width="" />
                    <col width="130px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>회사 규모</th>
                    <td><?=$CompanyScale_array[$CompanyScale]?></td>
                    <th>회사명</th>
                    <td><?=$CompanyName?></td>
					<th>사업자 번호</th>
                    <td><?=$CompanyCode?></td>
                    <th>HRD 번호</th>
                    <td><?=$HRD?></td>
                  </tr>
                  <tr>
                    <th>사업주 ID</th>
                    <td><?=$CompanyID?></td>
                    <th>대표자명</th>
                    <td><?=$Ceo?></td>
					<th>대표 전화번호</th>
                    <td><?=$Tel?></td>
                    <th>고객센터 전화번호</th>
                    <td><?=$Tel2?>&nbsp;&nbsp;<?if($CSEnabled=="Y") {?><img src="images/checked.gif" align="absmiddle"><?}else{?><img src="images/unchecked.gif" align="absmiddle"><?}?> 사용 여부</td>
                  </tr>
				  <tr>
                    <th>업태</th>
                    <td><?=$Uptae?></td>
                    <th>업종</th>
                    <td><?=$Upjong?></td>
					<th>대표 팩스번호</th>
                    <td><?=$Fax?></td>
                    <th>고객센터 팩스번호</th>
                    <td><?=$Fax2?></td>
                  </tr>
				  <tr>
                    <th>주소</th>
                    <td>[<?=$Zipcode?>] <?=$Address01?> <?=$Address02?></td>
                    <th>계좌정보</th>
                    <td><?=$Bank_array[$BankName]?> <?=$BankNumber?></td>
					<th>이메일</th>
                    <td><?=$Email?></td>
                    <th>홈페이지</th>
                    <td><?=$HomePage?></td>
                  </tr>
				  <tr>
                    <th>교육담당자</th>
                    <td><?=$EduManager?> / <?=$EduManagerPhone?> / <?=$EduManagerEmail?></td>
                    <th>영업담당자</th>
                    <td><?=$SalesName?></td>
					<th>메모</th>
                    <td><?=$Remark?></td>
                    <th>사이버교육센터</th>
                    <td><?=$CyberURL?>&nbsp;&nbsp;<?if($CyberEnabled=="Y") {?><img src="images/checked.gif" align="absmiddle"><?}else{?><img src="images/unchecked.gif" align="absmiddle"><?}?> 사용 여부</td>
                  </tr>
				  <tr>
                    <th>독려문자 수신</th>
                    <td><?=$CompanySMS_array[$SendSMS]?></td>
                    <th>영업팀 카테고리</th>
                    <td colspan="3"><?=$DeptStringName?></td>
                    <th> </th>
                    <td> </td>
                  </tr>
                </table>
                
                <!-- 버튼 -->
				<div class="btnAreaTc02">
				<?if($AdminWrite=="Y") {?>
                	<input type="button" value="정보 수정" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'">
          			<input type="button" value="삭제" class="btn_inputBlue01" onclick="DelOk()">
				<?}?>
          			<input type="button" value="목록" class="btn_inputLine01" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'">
              	</div>


			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">수강 정보</span>
			</div>
			<div id="LoginHistory" style="left:10px; top:20px; width:100%; height:400px; z-index:1; overflow: auto; overflow-x:hidden;">
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="60px" />
				<col width="" />
				<col width="" />
				<col width="" />
				<col width="" />
				<col width="" />
				<col width="" />
			  </colgroup>
              <tr>
				<th>번호</th>
                <th>강의명</th>
                <th>기간</th>
                <th>수강/수료</th>
				<th>수료율</th>
				<th>교육비</th>
				<th>환급비</th>
              </tr>
			<?
			$i = 1;
			$SQL = "SELECT DISTINCT(a.LectureStart) AS LectureStart, a.LectureEnd FROM Study AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode WHERE a.CompanyCode='$CompanyCode' AND a.ServiceType IN (1,3,5) ORDER BY a.LectureStart ASC, a.LectureEnd ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{

				$LectureStart = $ROW['LectureStart'];
				$LectureEnd = $ROW['LectureEnd'];

				$SQL2 = "SELECT DISTINCT(LectureCode), 
				(SELECT ContentsName FROM Course WHERE LectureCode=a.LectureCode) AS ContentsName, 
				(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode) AS StudyCount, 
				(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND PassOk='Y') AS PassOkCount, 
				(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode) AS StudyPrice, 
				(SELECT SUM(rPrice) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode) AS StudyrPrice  
				FROM Study AS a WHERE a.LectureStart='$LectureStart' AND a.LectureEnd='$LectureEnd' AND a.CompanyCode='$CompanyCode'";
				$QUERY2 = mysqli_query($connect, $SQL2);
				if($QUERY2 && mysqli_num_rows($QUERY2))
				{
					while($ROW2 = mysqli_fetch_array($QUERY2))
					{

						$PassOkRatio = $ROW2['PassOkCount'] / $ROW2['StudyCount'] * 100;
			?>
			<tr>
                <td><?=$i?></td>
				<td><?=$ROW2['ContentsName']?></td>
                <td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
				<td><?=$ROW2['StudyCount']?> / <?=$ROW2['PassOkCount']?></td>
				<td><?=number_format($PassOkRatio,0)?>%</td>
				<td><?=number_format($ROW2['StudyPrice'],0)?></td>
				<td><?=number_format($ROW2['StudyrPrice'],0)?></td>
              </tr>
			<?
				$i++;
					}
				}


				}
			}else{
			?>
			<tr>
				<td height="50" colspan="7" class="tc">수강 정보가 없습니다.</td>
			</tr>
			<? } ?>
            </table>
			</div>

			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">수강생 정보</span>
			</div>
			<div id="LoginHistory" style="left:10px; top:20px; width:100%; height:400px; z-index:1; overflow: auto; overflow-x:hidden;">
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
			  </colgroup>
              <tr>
				<th>번호</th>
				<th>아이디</th>
				<th>이름</th>
				<th>생년월일</th>
				<th>성별</th>
				<th>이메일</th>
				<th>휴대폰</th>
				<th>부서</th>
				<th>직위</th>
				<th>최종로그인</th>
				<th>가입일</th>
				<th>계정 사용유무</th>
              </tr>
			<?
			$Sql = "SELECT COUNT(*) FROM Member WHERE CompanyCode='$CompanyCode'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$TOT_NO = $Row[0];

			$i = 1;
			$SQL = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, AES_DECRYPT(UNHEX(Tel),'$DB_Enc_Key') AS Tel, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay FROM Member WHERE CompanyCode='$CompanyCode' ORDER BY Name ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{

					$Email = InformationProtection($ROW['Email'],'Email','S');
					$Mobile = InformationProtection($ROW['Mobile'],'Mobile','S');
					$Tel = InformationProtection($ROW['Tel'],'Tel','S');
					$BirthDay = InformationProtection($ROW['BirthDay'],'BirthDay','S');
			?>
			<tr>
                <td ><?=$i?></td>
				<td ><a href="Javascript:MemberInfo('<?=$ROW['ID']?>');"><?=$ROW['ID']?></a></td>
                <td ><a href="Javascript:MemberInfo('<?=$ROW['ID']?>');"><?=$ROW['Name']?></a></td>
				<td ><?=$BirthDay?></td>
				<td ><?=$Gender_array[$ROW['Gender']]?></td>
				<td ><?=$Email?></td>
				<td ><?=$Mobile?></td>
				<td ><?=$ROW['Depart']?></td>
				<td ><?=$ROW['Position']?></td>
				<td ><?=$ROW['LastLogin']?></td>
				<td ><?=$ROW['RegDate']?></td>
				<td ><?=$UseYN_array[$ROW['UseYN']]?></td>
              </tr>
			<?
				$i++;
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="12" class="tc">수강생 정보가 없습니다.</td>
			</tr>
			<? } ?>
            </table>
			</div>


			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">수강 내역</span>
			</div>
			<div id="StudyHistory" style="left:10px; top:20px; width:100%; height:500px; z-index:1; overflow: auto; overflow-x:hidden;">
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
              <tr>
				<th>번호<br />구분</th>
				<th>이름<br />ID</th>
				<th>과정명<br />수강기간</th>
				<th>진도율</th>
				<th>중간평가(%)<br />응시일</th>
				<th>최종평가(%)<br />응시일</th>
				<th>과제(%)<br />제출일</th>
				<th>총점<br />수료여부</th>
				<th>교·강사</th>
				<th>사업주<br />부서</th>
				<th>실명인증<br />(건)</th>
              </tr>
			<?
			$where = "WHERE a.CompanyCode='$CompanyCode'";

			$Colume = "a.Seq, a.ServiceType, a.ID, a.LectureStart, a.LectureEnd, a.Progress, a.MidStatus, a.MidSaveTime, a.MidScore, a.TestStatus, a.TestScore, a.TestSaveTime, a.ReportStatus, a.ReportSaveTime,
				a.ReportScore, a.TotalScore, a.PassOK, a.certCount, a.StudyEnd, a.LectureCode, 
				b.ContentsName, b.MidRate, b.TestRate, b.ReportRate, 
				c.Name, c.Depart, 
				d.CompanyName, 
				e.Name AS TutorName 
				 ";

			$JoinQuery = " Study AS a 
						LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode 
						LEFT OUTER JOIN Member AS c ON a.ID=c.ID 
						LEFT OUTER JOIN Company AS d ON a.CompanyCode=d.CompanyCode 
						LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID 
					";

			$Sql = "SELECT COUNT(a.Seq) FROM $JoinQuery $where";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$TOT_NO = $Row[0];

			$i = 1;
			$SQL = "SELECT $Colume FROM $JoinQuery $where ORDER BY a.Seq DESC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{

					extract($ROW);

					//첨삭완료일
					$Tutor_limit_day = strtotime("$LectureEnd +4 days");

					//중간평가
					if($MidRate<1) {
						$Mid_View = "평가 없음";
					}else{
						switch($MidStatus) {
							case "C":
								$MidRatePercent = $MidScore * $MidRate / 100;
								$Mid_View = $MidScore."(".$MidRatePercent.")<BR>".$MidSaveTime;
							break;
							case "Y":
								$Mid_View = "채점 대기중<BR>".$MidSaveTime;
							break;
							case "N":
								$Mid_View = "<span class='fcOrg01B'>미응시</span>";
							break;
							default :
								$Mid_View = "";
						}
					}

					//최종평가
					if($TestRate<1) {
						$Test_View = "평가 없음";
					}else{
						switch($TestStatus) {
							case "C":
								$TestRatePercent = $TestScore * $TestRate / 100;
								$Test_View = $TestScore."(".$TestRatePercent.")<BR>".$TestSaveTime;
							break;
							case "Y":
								$Test_View = "채점 대기중<BR>".$TestSaveTime;
							break;
							case "N":
								$Test_View = "<span class='fcOrg01B'>미응시</span>";
							break;
							default :
								$Test_View = "";
						}
					}

					//과제
					if($ReportRate<1) {
						$Report_View = "과제 없음";
					}else{
						switch($ReportStatus) {
							case "C":
								$ReportRatePercent = $ReportScore * $ReportRate / 100;
								$Report_View = $ReportScore."(".$ReportRatePercent.")<BR>".$ReportSaveTime;
							break;
							case "Y":
								$Report_View = "채점 대기중<BR>".$ReportSaveTime;
							break;
							case "N":
								$Report_View = "<span class='fcOrg01B'>미응시</span>";
							break;
							case "R":
								$Report_View = "반려";
							break;
							default :
								$Report_View = "";
						}
					}


					if(is_null($TotalScore)) {
						$TotalScore_View = "-";
					}else{
						$TotalScore_View = $TotalScore;
					}

					switch($PassOK) {
						case "N":
							$PassOK_View = "<span class='fcOrg01B'>미수료</span>";
						break;
						case "Y":
							$PassOK_View = "<span class='fcSky01B'>수료</span>";
						break;
						default :
							$PassOK_View = "";
					}
			?>
			<tr>
                <td><?=$i?><br /><?=$ServiceType_array[$ServiceType]?></td>
				<td><a href="Javascript:MemberInfo('<?=$ID?>');"><?=$Name?><br /><?=$ID?></a></td>
				<td><a href="Javascript:CourseInfo('<?=$LectureCode?>');"><?=$ContentsName?></a><br />
				<?=$LectureStart?> ~ <?=$LectureEnd?><br />
				첨삭완료 : <?=date("Y-m-d", $Tutor_limit_day)?>까지</td>
				<td><a href="Javascript:ProgressInfo('<?=$ID?>','<?=$LectureCode?>',<?=$Seq?>);"><?=$Progress?>%</a></td>
				<td><?=$Mid_View?></td>
				<td><?=$Test_View?></td>
				<td><?=$Report_View?></td>
				<td><?=$TotalScore_View?><br /><?=$PassOK_View?></td>
				<td><?=$TutorName?></td>
				<td><?=$CompanyName?><?if($Depart) {?><br />부서 : <?=$Depart?><?}?></td>
				<td><?=$certCount?></td>
              </tr>
			<?
				$i++;
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="11" class="tc">수강 내역이 없습니다.</td>
			</tr>
			<? } ?>
            </table>
			</div>

			<div class="btnAreaTc02">
			<?if($AdminWrite=="Y") {?>
				<input type="button" value="정보 수정" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'">
				<input type="button" value="삭제" class="btn_inputBlue01" onclick="DelOk()">
			<?}?>
				<input type="button" value="목록" class="btn_inputLine01" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'">
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