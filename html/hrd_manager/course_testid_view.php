<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$LectureCode = Replace_Check($LectureCode);
?>
<div class="Content">

	<div class="contentBody">
		<!-- ########## -->
		<h2>심사용 테스트 아이디 보기</h2>
		
		<div class="conZone">
			<!-- ## START -->
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
			  <colgroup>
				<col width="50px" />
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
				<th>휴대폰</th>
				<th>강의 시작일</th>
				<th>강의 종료일</th>
				<th>최종로그인</th>
				<th>가입일</th>
				<th>계정 사용유무</th>
              </tr>
			<?
			$i = 1;
			$SQL = "SELECT a.*, b.LectureStart, b.LectureEnd, AES_DECRYPT(UNHEX(a.Mobile),'$DB_Enc_Key') AS Mobile FROM Member AS a LEFT OUTER JOIN Study AS b ON a.ID=b.ID WHERE a.TestID='Y' AND a.TestLectureCode='$LectureCode' ORDER BY a.ID ASC, a.RegDate ASC";
			$QUERY = mysqli_query($connect, $SQL);
			if($QUERY && mysqli_num_rows($QUERY))
			{
				while($ROW = mysqli_fetch_array($QUERY))
				{
					extract($ROW);

					$Mobile = InformationProtection($Mobile,'Mobile','E');
			?>
			<tr>
				<td align="center"  class="text01"><?=$i?></td>
				<td align="center" class="text01"><?=$ID?></td>
				<td align="center" class="text01"><?=$Name?></td>
				<td align="center" class="text01"><?=$Mobile?></td>
				<td align="center"  class="text01"><?=$LectureStart?></td>
				<td align="center"  class="text01"><?=$LectureEnd?></td>
				<td align="center"  class="text01"><?=$LastLogin?></td>
				<td align="center"  class="text01"><?=$RegDate?></td>
				<td align="center"  class="text01"><?=$UseYN_array[$UseYN]?></td>
              </tr>
			<?
				}
			}else{
			?>
			<tr>
				<td height="50" colspan="20" class="tc">등록된 테스트 아이디가 없습니다.</td>
			</tr>
			<? } ?>
            </table>

			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>&nbsp;</td>
					<td height="15">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="100" valign="top">&nbsp;</td>
					<td align="center" valign="top">&nbsp;</td>
					<td width="100" align="right" valign="top"><input type="button" value="닫기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>
			
			<!-- ## END -->
		</div>
		<!-- ########## // -->
	</div>

</div>

<?
mysqli_close($connect);
?>