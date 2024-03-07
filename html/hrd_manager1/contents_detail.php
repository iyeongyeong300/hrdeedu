<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$mode = Replace_Check($mode);
$Seq = Replace_Check($Seq);
$Contents_idx = Replace_Check($Contents_idx);

if($mode!="new") {

	$Sql = "SELECT * FROM ContentsDetail WHERE Seq=$Seq AND Contents_idx=$Contents_idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$Contents_idx = $Row['Contents_idx']; //컨텐츠 idx
		$ContentsType = $Row['ContentsType']; //컨텐츠 유형
		$ContentsPage = html_quote($Row['ContentsPage']); //차시 페이지수
		$ContentsMobilePage = html_quote($Row['ContentsMobilePage']); //모바일 페이지수
		$ContentsURLSelect = html_quote($Row['ContentsURLSelect']); //컨텐츠 URL 주경로, 예비경로 선택 여부 A:주, B:예비
		$ContentsURL = html_quote($Row['ContentsURL']); //컨텐츠 URL(주)
		$ContentsURL2 = html_quote($Row['ContentsURL2']); //컨텐츠 URL(예비)
		$MobileURL = html_quote($Row['MobileURL']); //모바일 URL
		$MobileURL2 = html_quote($Row['MobileURL2']); //모바일 URL(예비)
		$Question = stripslashes($Row['Question']); //문제풀이 질문
		$Example01 = html_quote($Row['Example01']); //예문1
		$Example02 = html_quote($Row['Example02']); //예문2
		$Example03 = html_quote($Row['Example03']); //예문3
		$Example04 = html_quote($Row['Example04']); //예문4
		$Example05 = html_quote($Row['Example05']); //예문5
		$Answer = html_quote($Row['Answer']); //정답
		$Comment = stripslashes($Row['Comment']); //해답 설명
		$UseYN = $Row['UseYN']; //사용 유무
		$OrderByNum = $Row['OrderByNum']; //정렬번호
		$Teacher = $Row['Teacher']; //강사 선택
		$Caption = $Row['Caption']; //자막 파일
	}

}

if($Caption) {
	$CaptionFileView = "<A HREF='./direct_download.php?code=Caption&file=".$Caption."'><B>".$Caption."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('Caption','CaptionFileArea') class='btn_inputSm01'>";
}


if(!$OrderByNum) {
	$query_select = "SELECT MAX(OrderByNum) FROM ContentsDetail WHERE Contents_idx=$Contents_idx";
	//echo $query_select;
	$result_select = mysqli_query($connect, $query_select);
	$row_select = mysqli_fetch_array($result_select);
	$max_no = $row_select[0];

	$OrderByNum = $max_no + 1;
}

if(!$ContentsType) {
	$ContentsType = "A";
}
if(!$ContentsURLSelect) {
	$ContentsURLSelect = "A";
}

if($ContentsType=="A") { //Flash 강의
	$CommonTR = "";
	$FlashTR = "";
	$MovieTR = "none";
	$ExamTR = "none";
	$ExamSelectTR = "none";
	$TeacherTR = "none";
}
if($ContentsType=="B") { //mp4 영상강의
	$CommonTR = "";
	$FlashTR = "none";
	$MovieTR = "";
	$ExamTR = "none";
	$ExamSelectTR = "none";
	$TeacherTR = "none";
}
if($ContentsType=="C") { //문제풀이 객관식
	$CommonTR = "none";
	$FlashTR = "none";
	$MovieTR = "none";
	$ExamTR = "";
	$ExamSelectTR = "";
	$TeacherTR = "none";
}
if($ContentsType=="D") { //문제풀이 주관식
	$CommonTR = "none";
	$FlashTR = "none";
	$MovieTR = "none";
	$ExamTR = "";
	$ExamSelectTR = "none";
	$TeacherTR = "none";
}
if($ContentsType=="E") { //강의 시작
	$CommonTR = "none";
	$FlashTR = "none";
	$MovieTR = "none";
	$ExamTR = "none";
	$ExamSelectTR = "none";
	$TeacherTR = "none";
}
if($ContentsType=="G") { //강의 종료
	$CommonTR = "none";
	$FlashTR = "none";
	$MovieTR = "none";
	$ExamTR = "none";
	$ExamSelectTR = "none";
	$TeacherTR = "none";
}
if($ContentsType=="F") { //강사 소개
	$CommonTR = "none";
	$FlashTR = "none";
	$MovieTR = "none";
	$ExamTR = "none";
	$ExamSelectTR = "none";
	$TeacherTR = "";
}
?>
<div class="Content">

	<div class="contentBody">
		<!-- ########## -->
		<h2>기초차시 상세 구성</h2>
		
		<div class="conZone">
			<!-- ## START -->
			
			<form name="Form1" method="post" action="contents_detail_script.php" target="ScriptFrame">
			<INPUT TYPE="hidden" name="mode" id="mode" value="<?=$mode?>">
			<INPUT TYPE="hidden" name="Seq" id="Seq" value="<?=$Seq?>">
			<INPUT TYPE="hidden" name="Contents_idx" id="Contents_idx" value="<?=$Contents_idx?>">
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
			  <colgroup>
				<col width="130px" />
				<col width="" />
			  </colgroup>
			  <tr>
				<th>컨텐츠 유형</th>
				<td>
				<?
				$i = 1;
				while (list($key,$value)=each($ContentsType_array)) {
				?>
				<input type="radio" name="ContentsType" id="ContentsType<?=$i?>" value="<?=$key?>" <?if($ContentsType==$key) {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer" onclick="ContentsTypeSelected();"><label for="ContentsType<?=$i?>" style="cursor:pointer"><?=$value?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<?
				$i++;
				}
				?>
				</td>
			  </tr>
			  <tr id="CommonTR" style="display:<?=$CommonTR?>">
					<th>차시 페이지수</th>
					<td align="left"><input name="ContentsPage" id="ContentsPage" type="text"  size="10" value="<?=$ContentsPage?>"></td>
				</tr>
				<tr id="CommonTR" style="display:<?=$CommonTR?>">
					<th>모바일 페이지수</th>
					<td align="left"><input name="ContentsMobilePage" id="ContentsMobilePage" type="text"  size="10" value="<?=$ContentsMobilePage?>"></td>
				</tr>
				<tr id="FlashTR" style="display:<?=$FlashTR?>">
					<th>Flash 서버</th>
					<td align="left"> <?=$FlashServerURL?></td>
				</tr>
				<tr id="MovieTR" style="display:<?=$MovieTR?>">
					<th>동영상 서버</th>
					<td align="left"> <?=$MovieServerURL?></td>
				</tr>
				<tr id="MovieTR" style="display:<?=$MovieTR?>">
					<th>컨텐츠 경로 선택</th>
					<td align="left"><input type="radio" name="ContentsURLSelect" id="ContentsURLSelect1" value="A" <?if($ContentsURLSelect=="A") {?>checked<?}?>> <label for="ContentsURLSelect1">주 경로</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect2" value="B" <?if($ContentsURLSelect=="B") {?>checked<?}?>> <label for="ContentsURLSelect2">예비 경로</label></td>
				</tr>
				<tr id="CommonTR" style="display:<?=$CommonTR?>">
					<th>컨텐츠 경로</th>
					<td align="left"><input name="ContentsURL" id="ContentsURL" type="text"  size="120" value="<?=$ContentsURL?>"></td>
				</tr>
				<tr id="MovieTR" style="display:<?=$MovieTR?>">
					<th>컨텐츠 경로(예비)</th>
					<td align="left"><input name="ContentsURL2" id="ContentsURL2" type="text"  size="120" value="<?=$ContentsURL2?>"></td>
				</tr>
				<tr id="CommonTR" style="display:<?=$CommonTR?>">
					<th>모바일 서버</th>
					<td align="left"> <?=$MobileServerURL?></td>
				</tr>
				<tr id="CommonTR" style="display:<?=$CommonTR?>">
					<th>모바일 경로</th>
					<td align="left"><input name="MobileURL" id="MobileURL" type="text"  size="120" value="<?=$MobileURL?>"></td>
				</tr>
				<tr id="MovieTR" style="display:<?=$MovieTR?>">
					<th>모바일 경로(예비)</th>
					<td align="left"><input name="MobileURL2" id="MobileURL2" type="text"  size="120" value="<?=$MobileURL2?>"></td>
				</tr>
				<tr id="MovieTR" style="display:<?=$MovieTR?>">
					<th>자막 업로드</th>
					<td align="left"><input name="Caption" id="Caption" type="hidden"  value="<?=$Caption?>"><span id="CaptionFileArea"><?=$CaptionFileView?></span>&nbsp;<input type="button" value="파일 첨부" onclick="CaptionUploadFile('Caption','CaptionFileArea');" class="btn_inputSm01" ></td>
				</tr>
				<tr id="ExamTR" style="display:<?=$ExamTR?>">
					<th>질문 내용</th>
					<td align="left"><textarea name="Question" id="Question" style="width:750px; height:40px;"><?=$Question?></textarea></td>
				</tr>
				<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th>보기 1</th>
					<td align="left"><input type="radio" name="Answer" id="Answer" value="1" <?if($Answer=="1") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example01" id="Example01" type="text"  size="110" value="<?=$Example01?>"></td>
				</tr>
				<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th>보기 2</th>
					<td align="left"><input type="radio" name="Answer" id="Answer" value="2" <?if($Answer=="2") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example02" id="Example02" type="text"  size="110" value="<?=$Example02?>"></td>
				</tr>
				<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th>보기 3</th>
					<td align="left"><input type="radio" name="Answer" id="Answer" value="3" <?if($Answer=="3") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example03" id="Example03" type="text"  size="110" value="<?=$Example03?>"></td>
				</tr>
				<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th>보기 4</th>
					<td align="left"><input type="radio" name="Answer" id="Answer" value="4" <?if($Answer=="4") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example04" id="Example04" type="text"  size="110" value="<?=$Example04?>"></td>
				</tr>
				<tr id="ExamSelectTR" style="display:<?=$ExamSelectTR?>">
					<th>보기 5</th>
					<td align="left"><input type="radio" name="Answer" id="Answer" value="5" <?if($Answer=="5") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer">&nbsp;&nbsp;&nbsp;&nbsp;<input name="Example05" id="Example05" type="text"  size="110" value="<?=$Example05?>"></td>
				</tr>
				<tr id="ExamTR" style="display:<?=$ExamTR?>">
					<th>해답 설명</th>
					<td align="left"><textarea name="Comment" id="Comment" style="width:750px; height:80px;"><?=$Comment?></textarea></td>
				</tr>
				<tr id="TeacherTR" style="display:<?=$TeacherTR?>">
					<th>강사 선택</th>
					<td align="left">
					<select name="Teacher" id="Teacher">
						<option value="">-- 강사 선택 --</option>
					<?
					$SQL = "SELECT * FROM Teacher WHERE Del='N' ORDER BY Name ASC";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
					?>
						<option value="<?=$ROW['idx']?>" <?if($ROW['idx']==$Teacher) {?>selected<?}?>><?=$ROW['Name']?></option>
					<?
						}
					}
					?>
					</select>
					</td>
				</tr>
				<tr>
					<th>정렬 순서</th>
					<td align="left"><input name="OrderByNum" id="OrderByNum" type="text"  size="5" value="<?=$OrderByNum?>"></td>
				</tr>
				<tr>
					<th>사용 여부</th>
					<td align="left"><input type="radio" name="UseYN" id="UseYN2" value="Y" <?if($UseYN=="Y" || !$UseYN) {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer"> <label for="UseYN2">사용</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="UseYN" id="UseYN1" value="N" <?if($UseYN=="N") {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer"> <label for="UseYN1">미사용</label></th>
				</tr>
			</table>
			</form>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center">
					<span id="SubmitBtn"><input type="button" value="등록 하기" onclick="ContentsDetailSubmitOk();" class="btn_inputBlue01"></span>
					<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
					</td>
					<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
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