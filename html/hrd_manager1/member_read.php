<?
$MenuType = "A";
$PageName = "member";
$ReadPage = "member_read";
?>
<? include "./include/include_top.php"; ?>
<?
$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, AES_DECRYPT(UNHEX(Tel),'$DB_Enc_Key') AS Tel, AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay FROM Member WHERE idx=$idx";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$MemberType = $Row['MemberType']; //회원구분
	$ID = $Row['ID']; //아이디
	$Name = $Row['Name']; //이름
	$BirthDay = $Row['BirthDay']; //생년월일
	$Gender = $Row['Gender']; //성별
	$Email = $Row['Email']; //이메일
	$Tel = $Row['Tel']; //전화번호
	$Mobile = $Row['Mobile']; //휴대폰
	$Zipcode = $Row['Zipcode']; //우편번호
	$Address01 = $Row['Address01']; //주소
	$Address02 = $Row['Address02']; //상세주소
	$NameEng = $Row['NameEng']; //영문 이름
	$CompanyCode = $Row['CompanyCode']; //소속기관 사업자번호
	$Depart = $Row['Depart']; //부서
	$Position = $Row['Position']; //직위
	$Etc01 = $Row['Etc01']; //관심분야
	$Etc02 = $Row['Etc02']; //가입경로
	$Mailling = $Row['Mailling']; //메일링
	$ACS = $Row['ACS']; //ACS
	$UseYN = $Row['UseYN']; //계정 사용유무
	$RegDate = $Row['RegDate']; //가입일
	$EditDate = $Row['EditDate']; //최종 수정일
	$EduManager = $Row['EduManager']; //교육담당자 여부
	$ProtectID = $Row['ProtectID']; //대리수강 방지
	$Marketing= $Row['Marketing']; //마케팅 수신동의
	$CardName = $Row['CardName'];
	$CardNumber = $Row['CardNumber'];

	$Email = InformationProtection($Email,'Email','S');
	$Mobile = InformationProtection($Mobile,'Mobile','S');
	$Tel = InformationProtection($Tel,'Tel','S');
	$BirthDay = InformationProtection($BirthDay,'BirthDay','S');
}

$Login_token = makeRand(); //현재 아이디로 로그인시 검증용 토큰 생성
$_SESSION["Login_token"] = $Login_token;
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>수강생 상세 내용</h2>
            
            <div class="conZone">
            	<!-- ## START -->
            
                <!-- 내용 -->
				<form name="OutForm" method="post" action="member_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="out">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
				<form name="PasswordForm" method="post" action="member_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="pcd">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
				<form name="LoginForm" method="post" action="member_login.php" target="_blank">
					<INPUT TYPE="hidden" name="Login_token_value" value="<?=$Login_token?>">
					<INPUT TYPE="hidden" name="ID" value="<?=$ID?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                    <col width="120px" />
                    <col width="" />
					<col width="120px" />
                    <col width="" />
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>아이디</th>
                    <td><?=$ID?> <?if($UseYN=="N") {?>[미사용 계정]<?}?></td>
                    <th>이름</th>
                    <td><?=$Name?></td>
					<th>생년월일/성별</th>
                    <td><span id="InfoProt_BirthDay"><a href="Javascript:InformationProtection('Member','BirthDay','InfoProt_BirthDay','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','생년월일');"><?=$BirthDay?></a></span> / <?=$Gender_array[$Gender]?></td>
                    <th>이메일</th>
                    <td><span id="InfoProt_Email"><a href="Javascript:InformationProtection('Member','Email','InfoProt_Email','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','이메일');"><?=$Email?></a></span></td>
                  </tr>
                  <tr>
                    <th>전화번호</th>
                    <td><span id="InfoProt_Tel"><a href="Javascript:InformationProtection('Member','Tel','InfoProt_Tel','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','전화번호');"><?=$Tel?></a></span></td>
                    <th>휴대폰</th>
                    <td><span id="InfoProt_Mobile"><a href="Javascript:InformationProtection('Member','Mobile','InfoProt_Mobile','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','휴대폰');"><?=$Mobile?></a></span></td>
					<th>영문 이름</th>
                    <td><?=$NameEng?></td>
                    <th>주소</th>
                    <td>[<?=$Zipcode?>] <?=$Address01?> <?=$Address02?></td>
                  </tr>
				  <tr>
                    <th>부서</th>
                    <td><?=$Depart?></td>
                    <th>직위</th>
                    <td><?=$Position?></td>
					<th>관심분야</th>
                    <td><?=$Etc01?></td>
                    <th>가입경로</th>
                    <td><?=$Etc02?></td>
                  </tr>
				  <tr>
                    <th>메일링</th>
                    <td><?=$Mailling?></td>
                    <th>ACS</th>
                    <td><?=$ACS?></td>
					<th>가입일</th>
                    <td><?=$RegDate?></td>
                    <th>교육 담당자</th>
                    <td><?=$EduManager?></td>
                  </tr>
				  <tr>
                    <th>대리수강 방지</th>
                    <td><?=$ProtectID?></td>
                    <th>마케팅 수신동의</th>
                    <td><?=$CompanySMS_array[$Marketing]?></td>
					<th>회원구분</th>
                    <td><?=$CategoryType_array[$MemberType]?></td>
                    <th>내일배움카드</th>
                    <td><?=$Card_array[$CardName]?>&nbsp;<?=$CardNumber?></td>
                  </tr>
                </table>
                
                <!-- 버튼 -->
				<div class="btnAreaTc02">
				<?if($AdminWrite=="Y") {?>
                	<input type="button" value="정보 수정" class="btn_inputBlue01" onclick="InformationProtectionUrl('Member','<?=$_SERVER['PHP_SELF']?>','회원정보수정','<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>','<?=$ID?>')">&nbsp;&nbsp;
          			<input type="button" value="회원으로 로그인" class="btn_inputBlue01" onclick="MemberLoginSubmit('<?=$ID?>')">&nbsp;&nbsp;
					<input type="button" value="비밀번호 초기화" class="btn_inputBlue01" onclick="PasswordInit()">&nbsp;&nbsp;
					<input type="button" value="현재 회원 탈퇴처리" class="btn_inputBlue01" onclick="MemberOut()">&nbsp;&nbsp;
				<?}?>
          			<input type="button" value="목록" class="btn_inputLine01" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'">
              	</div>

			<?
			if($CompanyCode) {

			$Sql = "SELECT *, (SELECT Name FROM Member WHERE ID=Company.SalesManager) AS SalesName FROM Company WHERE CompanyCode='$CompanyCode' AND Del='N'";
			//echo $Sql;
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);

			if($Row) {
				$CompanyScale = $Row['CompanyScale']; //회사규모
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
				$EduManager = $Row['EduManager']; //교육담당자 아이디
				$SalesManager = $Row['SalesManager']; //영업담당자 아이디
				$Remark = $Row['Remark']; //메모
				$EduManager = $Row['EduManager']; //교육담당자명
				$EduManagerPhone = $Row['EduManagerPhone']; //교육담당자 연락처
				$EduManagerEmail = $Row['EduManagerEmail']; //교육담당자 이메일
				$SalesName = $Row['SalesName']; //영업담당자 이름
			}
			?>
			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">소속 정보</span>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
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
                </table>
			<?}?>

			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">로그인 내역</span>
			</div>
			<div id="LoginHistory" style="left:10px; top:20px; width:100%; height:350px; z-index:1; overflow: auto; overflow-x:hidden;">
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="100px" />
				<col width="300px" />
				<col width="300px" />
				<col width="150px" />
				<col width="" />
			  </colgroup>
              <tr>
				<th>번호</th>
                <th>로그인 시각</th>
                <th>아이피</th>
                <th>유형</th>
				<th> </th>
              </tr>
			<?
			$Sql = "SELECT COUNT(*) FROM LoginHistory WHERE ID='$ID'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$TOT_NO = $Row[0];

			$SQL = "SELECT ID, IP, RegDate, Device FROM LoginHistory WHERE ID='$ID' ORDER BY RegDate DESC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
			?>
			<tr>
                <td><?=$TOT_NO--?></td>
				<td><?=$ROW['RegDate']?></td>
                <td><?=$ROW['IP']?></td>
				<td><?=$ROW['Device']?></td>
				<td> </td>
              </tr>
			<?
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="5" class="tc">로그인 내역이 없습니다.</td>
			</tr>
			<? } ?>
            </table>
			</div>

			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">본인인증 내역</span>
			</div>
			<div id="LoginHistory" style="left:10px; top:20px; width:100%; height:350px; z-index:1; overflow: auto; overflow-x:hidden;">
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="100px" />
				<col width="300px" />
				<col width="300px" />
				<col width="150px" />
				<col width="" />
			  </colgroup>
              <tr>
				<th>번호</th>
                <th>교육과정</th>
                <th>인증시간</th>
				<th> </th>
              </tr>
			<?
			$Sql = "SELECT COUNT(*) FROM UserCertOTP WHERE ID='$ID'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$TOT_NO = $Row[0];

			$SQL = "SELECT a.*, b.ContentsName FROM UserCertOTP AS a LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode WHERE a.ID='$ID' ORDER BY a.RegDate DESC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
			?>
			<tr>
                <td><?=$TOT_NO--?></td>
				<td><?=$ROW['ContentsName']?></td>
                <td><?=$ROW['RegDate']?></td>
				<td> </td>
              </tr>
			<?
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="5" class="tc">본인인증 내역이 없습니다.</td>
			</tr>
			<? } ?>
            </table>
			</div>

			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">전화상담 내역</span>
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="신규 작성" class="btn_inputLine01" onclick="CounselPhoneRegist('<?=$ID?>','New','');">
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="100px" />
				<col width="150px" />
				<col width="150px" />
				<col width="" />
				<col width="150px" />
				<col width="80px" />
			  </colgroup>
              <tr>
				<th>번호</th>
                <th>문의종류</th>
                <th>상담자명</th>
                <th>상담내용</th>
				<th>등록일</th>
				<th>처리상태</th>
              </tr>
			<?
			$Sql = "SELECT COUNT(*) FROM CounselPhone WHERE ID='$ID'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$TOT_NO = $Row[0];

			$SQL = "SELECT * FROM CounselPhone WHERE ID='$ID' AND Del='N' ORDER BY RegDate DESC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
			?>
			<tr>
                <td><?=$TOT_NO--?></td>
				<td><?=$CounselPhone_array[$ROW['Category']]?></td>
                <td><a href="Javascript:CounselPhoneRegist('<?=$ID?>','Edit','<?=$ROW['idx']?>');"><?=$ROW['Name']?></a></td>
				<td style="text-align:left"><a href="Javascript:CounselPhoneRegist('<?=$ID?>','Edit','<?=$ROW['idx']?>');"><?=$ROW['Contents']?></a></td>
				<td><?=$ROW['RegDate']?></td>
				<td><?=$CounselPhoneStatus_array[$ROW['Status']]?></td>
              </tr>
			<?
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="6" class="tc">전화상담 내역이 없습니다.</td>
			</tr>
			<? } ?>
            </table>


			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">1:1 문의 내역</span>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="100px" />
				<col width="150px" />
				<col width="150px" />
				<col width="" />
				<col width="150px" />
				<col width="80px" />
			  </colgroup>
              <tr>
				<th>번호</th>
                <th>문의종류</th>
                <th>이름</th>
                <th>제목</th>
				<th>등록일</th>
				<th>처리상태</th>
              </tr>
			<?
			$Sql = "SELECT COUNT(*) FROM Counsel WHERE ID='$ID'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$TOT_NO = $Row[0];

			$SQL = "SELECT * FROM Counsel WHERE ID='$ID' AND Del='N' ORDER BY RegDate DESC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
			?>
			<tr>
                <td><?=$TOT_NO--?></td>
				<td><?=$Counsel_array[$ROW['Category']]?></td>
                <td><?=$ROW['Name']?></td>
				<td style="text-align:left"><A HREF="qna_read.php?idx=<?=$ROW['idx']?>" target="_blank"><?=$ROW['Title']?></A></td>
				<td><?=$ROW['RegDate']?></td>
				<td><?=$CounselStatus_array[$ROW['Status']]?></td>
              </tr>
			<?
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="6" class="tc">1:1 문의 내역이 없습니다.</td>
			</tr>
			<? } ?>
            </table>

			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">쪽지 내역</span>
				&nbsp;&nbsp;&nbsp;&nbsp;<?if($AdminWrite=="Y") {?><input type="button" value="쪽지 작성" class="btn_inputLine01" onclick="MessageRegist('<?=$ID?>');"><?}?>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="100px" />
				<col width="150px" />
				<col width="150px" />
				<col width="" />
				<col width="150px" />
			  </colgroup>
              <tr>
				<th>번호</th>
                <th>구분</th>
                <th>발신자</th>
                <th>제목</th>
				<th>발신일</th>
              </tr>
			<?
			$Sql = "SELECT COUNT(*) FROM Message WHERE ReciveID='$ID' OR SendID='$ID'";
			$Result = mysqli_query($connect, $Sql);
			$Row = mysqli_fetch_array($Result);
			$TOT_NO = $Row[0];

			$SQL = "SELECT *, (SELECT Name FROM Member WHERE ID=Message.SendID) AS Name FROM Message WHERE ReciveID='$ID' OR SendID='$ID' ORDER BY SendDate DESC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{

					if($ROW['SendID']==$ID) {
						$MessageType = "수신";
					}else{
						$MessageType = "발신";
					}

					if($MessageType=="발신") {
						$Name = "관리자";
					}else{
						$Name = $ROW['Name'];
					}
			?>
			<tr>
                <td><?=$TOT_NO--?></td>
				<td><?=$MessageType?></td>
                <td><?=$Name?></td>
				<td style="text-align:left"><A HREF="Javascript:MessageView('<?=$ID?>','<?=$ROW['Seq']?>');"><?=$ROW['Title']?></A></td>
				<td><?=$ROW['SendDate']?></td>
              </tr>
			<?
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="5" class="tc">쪽지 내역이 없습니다.</td>
			</tr>
			<? } ?>
            </table>


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
			$where = "WHERE a.ID='$ID'";

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
                <td><?=$TOT_NO--?><br /><?=$ServiceType_array[$ServiceType]?></td>
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
                
            	<!-- ## END -->
			</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>