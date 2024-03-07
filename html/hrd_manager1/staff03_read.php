<?
$MenuType = "A";
$PageName = "staff03";
$ReadPage = "staff03_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT *, (SELECT DeptString FROM DeptStructure WHERE idx=StaffInfo.Dept_idx) AS DeptString FROM StaffInfo WHERE idx=$idx AND Del='N'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ID = $Row['ID'];
	$Dept_idx = $Row['Dept_idx'];
	$Name = $Row['Name'];
	$Team = $Row['Team'];
	$Mobile = $Row['Mobile'];
	$Phone = $Row['Phone'];
	$Email = $Row['Email'];
	$BankName = $Row['BankName'];
	$BankNumber = $Row['BankNumber'];
	$LastLoginDate = $Row['LastLoginDate'];
	$UseYN = $Row['UseYN'];
	$RegDate = $Row['RegDate'];
	$DeptString = $Row['DeptString'];

	if($UseYN=="Y") {
		$UseYN_MSG = "<font color='blue'>사용</font>";
	}else{
		$UseYN_MSG = "<font color='red'>미사용</font>";
	}

	$DeptStringName = DeptStringNaming($DeptString);


	$Login_token = makeRand(); //현재 아이디로 로그인시 검증용 토큰 생성
	$_SESSION["Login_token"] = $Login_token;
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 관리자를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}

//-->
</SCRIPT>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>관리자 상세 내용</h2>
            
            <div class="conZone">
            	<!-- ## START -->
            
                <!-- 내용 -->
				<form name="DeleteForm" method="post" action="staff03_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
				<form name="PasswordForm" method="post" action="staff03_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="pcd">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
				<form name="LoginForm" method="post" action="staff_login.php">
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
                    <td><?=$ID?></td>
                    <th>이름</th>
                    <td><?=$Name?></td>
					<th>카테고리</th>
                    <td><?=$DeptStringName?></td>
                    <th>소속</th>
                    <td><?=$Team?></td>
                  </tr>
                  <tr>
                    <th>휴대폰</th>
                    <td><?=$Mobile?></td>
                    <th>연락처</th>
                    <td><?=$Phone?></td>
					<th>이메일</th>
                    <td><?=$Email?></td>
                    <th>사용 유무</th>
                    <td><?=$UseYN_MSG?></td>
                  </tr>
				  <tr>
                    <th>계좌정보</th>
                    <td><?=$Bank_array[$BankName]?> <?=$BankNumber?></td>
                    <th> </th>
                    <td> </td>
					<th> </th>
                    <td> </td>
                    <th> </th>
                    <td> </td>
                  </tr>
                </table>

				<div class="btnAreaTl02">
					<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">로그인 내역</span>
              	</div>
				<div id="LoginHistory" style="left:10px; top:20px; width:100%; height:500px; z-index:1; overflow: auto; overflow-x:hidden;">
				<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="100px" />
                    <col width="300px" />
                    <col width="300px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>로그인 시각</th>
                    <th>아이피</th>
                    <th></th>
                  </tr>
					<?
					$Sql = "SELECT COUNT(*) FROM StaffLoginHistory WHERE ID='$ID' AND SiteCode='$SiteCode'";
					$Result = mysqli_query($connect, $Sql);
					$Row = mysqli_fetch_array($Result);
					$TOT_NO = $Row[0];

					$SQL = "SELECT ID, IP, RegDate FROM StaffLoginHistory WHERE ID='$ID' AND SiteCode='$SiteCode' ORDER BY RegDate DESC";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
                  <tr>
					<td><?=$TOT_NO--?></td>
					<td><?=$RegDate?></td>
					<td><?=$IP?></td>
					<td></td>
                  </tr>
                  <?
						}
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="5">로그인 내역이 없습니다.</td>
					</tr>
					<? 
					}

					mysqli_free_result($QUERY);
					?>
                </table>
                </div>
                <!-- 버튼 -->
				<div class="btnAreaTc02">
                	<input type="button" value="정보 수정" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'">
          			<input type="button" value="현재 아이디로 로그인" class="btn_inputBlue01" onclick="ManagerLoginSubmit('<?=$ID?>')">
					<input type="button" value="비밀번호 초기화" class="btn_inputBlue01" onclick="PasswordInit()">
          			<input type="button" value="삭제" class="btn_inputLine01" onclick="DelOk()">
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