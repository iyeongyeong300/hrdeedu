<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$mode = Replace_Check($mode);
$LectureCode = Replace_Check($LectureCode);
$Chapter_seq = Replace_Check($Chapter_seq);
$ContentGubunOnly = Replace_Check($ContentGubunOnly);

$ChapterType_disbled = array();

$ChapterType_disbled[0] = "";
$ChapterType_disbled[1] = "";
$ChapterType_disbled[2] = "";
$ChapterType_disbled[3] = "";


$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$ContentsName = html_quote($Row['ContentsName']); //과정명
}

if($mode!="new") {

	$Sql = "SELECT * FROM Chapter WHERE Seq=$Chapter_seq AND LectureCode='$LectureCode'";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$LectureCode = $Row['LectureCode']; //과정 코드
		$ChapterType = $Row['ChapterType']; //차시 구분
		$Sub_idx = $Row['Sub_idx']; //강의 또는 문제 idx값
		$OrderByNum = $Row['OrderByNum']; //정렬번호
	}

	if($ChapterType=="A") {
		$ChapterType_disbled[0] = "";
		$ChapterType_disbled[1] = "disabled";
		$ChapterType_disbled[2] = "disabled";
		$ChapterType_disbled[3] = "disabled";
	}
	if($ChapterType=="B") {
		$ChapterType_disbled[0] = "disabled";
		$ChapterType_disbled[1] = "";
		$ChapterType_disbled[2] = "disabled";
		$ChapterType_disbled[3] = "disabled";
	}
	if($ChapterType=="C") {
		$ChapterType_disbled[0] = "disabled";
		$ChapterType_disbled[1] = "disabled";
		$ChapterType_disbled[2] = "";
		$ChapterType_disbled[3] = "disabled";
	}
	if($ChapterType=="D") {
		$ChapterType_disbled[0] = "disabled";
		$ChapterType_disbled[1] = "disabled";
		$ChapterType_disbled[2] = "disabled";
		$ChapterType_disbled[3] = "";
	}

}


if(!$OrderByNum) {

	$query_select = "SELECT MAX(OrderByNum) FROM Chapter WHERE LectureCode='$LectureCode'";
	$result_select = mysqli_query($connect, $query_select);
	$result_row = mysqli_fetch_array($result_select);
	$max_no = $result_row[0];
	$OrderByNum = $max_no + 1;
	
}

if(!$ChapterType) {
	$ChapterType = "A";
}

if($ChapterType=="A") { //차시 유형
	$ContentsTR = "";
	$ExamTR = "none";
}else{
	$ContentsTR = "none";
	$ExamTR = "";
}

if($ChapterType=="A" && $mode=="edit") {
	$Sql = "SELECT Gubun FROM Contents WHERE idx=$Sub_idx";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$ContentGubun = $Row['Gubun']; //차시 구분
	}
}
?>
<div class="Content">

	<div class="contentBody">
		<!-- ########## -->
		<h2>차시 구성</h2>
		
		<div class="conZone">
			<!-- ## START -->
			
			<form name="Form1" method="post" action="chapter_regist_script.php" target="ScriptFrame">
			<INPUT TYPE="hidden" name="mode" id="mode" value="<?=$mode?>">
			<INPUT TYPE="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
			<INPUT TYPE="hidden" name="Chapter_seq" id="Chapter_seq" value="<?=$Chapter_seq?>">
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
			  <colgroup>
				<col width="120px" />
				<col width="" />
			  </colgroup>
			  <tr>
				<th>차시 유형</th>
				<td>
				<?
				$i = 0;
				while (list($key,$value)=each($ChapterType_array)) {
				?>
				<input type="radio" name="ChapterType" id="ChapterType<?=$i?>" value="<?=$key?>" <?if($ChapterType==$key) {?>checked<?}?> style="width:14px; height:14px; background:none; border:none; cursor:pointer" onclick="ChapterTypeSelected();" <?=$ChapterType_disbled[$i]?>><label for="ChapterType<?=$i?>" style="cursor:pointer"><?=$value?></label>&nbsp;&nbsp;&nbsp;&nbsp;
				<?
				$i++;
				}
				reset($ChapterType_array);
				?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="checkbox" name="ContentGubunOnly" id="ContentGubunOnly" value="Y" <?if($ContentGubunOnly=="Y") {?>checked<?}?> onclick="ChapterRegistReload('<?=$mode?>','<?=$LectureCode?>','<?=$Chapter_seq?>')"> <label for="ContentGubunOnly">현재 강의와 일치하는 차시구분만 보기</label>
				</td>
			  </tr>
			  <tr id="ContentsTR" style="display:<?=$ContentsTR?>">
				<th>차시 구분 선택</th>
				<td>
				<select name="ContentGubun" id="ContentGubun" onchange="ChapterContentsSelect('<?=$Sub_idx?>');" style="width:620px">
					<option value="">-- 차시구분 선택 --</option>
					<?
					if($ContentGubunOnly=="Y") {
						$ContentGubun_str = " AND Gubun='$ContentsName' ";
					}

					$SQL = "SELECT DISTINCT(Gubun) FROM Contents WHERE Del='N' $ContentGubun_str ORDER BY Gubun ASC";
					//echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($Row = mysqli_fetch_array($QUERY))
						{
					?>
					<option value="<?=$Row['Gubun']?>" <?if($Row['Gubun']==$ContentGubun) {?>selected<?}?>><?=$Row['Gubun']?></option>
					<?
						}
					}
					?>
				</select><?if($mode=="new") {?>&nbsp;&nbsp;<input type="button" value="선택한 [차시 구분] 모두 등록하기" class="btn_inputSm01" onclick="ChapterContentsBatch();"><?}?>
				</td>
			  </tr>
			  <tr id="ContentsTR" style="display:<?=$ContentsTR?>">
				<th>기초 차시 선택</th>
				<td>
				<div id="Content_idx_div">
				<select name="Content_idx" id="Content_idx" style="width:100%">
					<option value="">-- 기초 차시 선택 --</option>
					<optgroup label="차시명 (하부 컨텐츠수)">
					<?
					if($mode!="new") {
						$SQL = "SELECT *, (SELECT COUNT(*) FROM ContentsDetail WHERE Contents_idx=Contents.idx) AS ContentsDetail_Count FROM Contents WHERE Del='N' AND Gubun='$ContentGubun' ORDER BY RegDate ASC";
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							$i = 1;
							while($Row = mysqli_fetch_array($QUERY))
							{
						?>
						<option value="<?=$Row['idx']?>" <?if($Row['idx']==$Sub_idx) {?>selected<?}?>><?=$i?>. <?=html_quote($Row['ContentsTitle'])?>  (<?=$Row['ContentsDetail_Count']?>) </option>
						<?
							$i++;
							}
						}
					}
					?>
				</select>
				<div>
				</td>
			  </tr>
			  <tr id="ExamTR" style="display:<?=$ExamTR?>">
				<th>차시 구분 선택</th>
				<td>
				<select name="ExamGubun" id="ExamGubun" onchange="ChapterExamSelect();" style="width:620px">
					<option value="">-- 차시구분 선택 --</option>
					<?
					if($ContentGubunOnly=="Y") {
						$ExamGubun_str = " AND Gubun LIKE '%$ContentsName%' ";
					}

					$SQL = "SELECT DISTINCT(Gubun) FROM ExamBank WHERE UseYN='Y' AND Del='N' $ExamGubun_str ORDER BY Gubun ASC";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($Row = mysqli_fetch_array($QUERY))
						{
					?>
					<option value="<?=$Row['Gubun']?>" ><?=$Row['Gubun']?></option>
					<?
						}
					}
					?>
				</select><?if($mode=="new") {?>&nbsp;&nbsp;<input type="button" value="선택한 [차시 구분] 모두 추가하기" class="btn_inputSm01" onclick="ChapterExamBatch();"><?}?>
				</td>
			  </tr>
			  <tr id="ExamTR" style="display:<?=$ExamTR?>">
				<th>문제은행 선택</th>
				<td>
				<div id="Exam_idx_div">
				<select name="Exam_idx" id="Exam_idx" style="width:90%">
					<option value="">-- 평가 문제 선택 --</option>
					<optgroup label="[문제 유형] 질문">
				</select>
				<div>
				</td>
			  </tr>
			  <tr id="ExamTR" style="display:<?=$ExamTR?>">
				<th>선택한 평가문제</th>
				<td>
				<input type="hidden" name="Exam_idx_arrary" id="Exam_idx_arrary" value="<?=$Sub_idx?>">
				<table border="0" cellspacing="0" width="870px" style="border-top: #a2a2a2 1px solid; border-right: #a2a2a2 1px solid; border-bottom: #a2a2a2 1px solid; border-left: #a2a2a2 1px solid; background-color:#E1E1E1">
					<colgroup>
						<col width="800px">
						<col width="70px">
					</colgroup>
					<tr>
						<th>질문</th>
						<th>삭제</th>
					</tr>
				</table>
				<table id="ExamTable" border="0" cellspacing="0" width="870px" style="border-top: #a2a2a2 1px solid; border-right: #a2a2a2 1px solid; border-bottom: #a2a2a2 1px solid; border-left: #a2a2a2 1px solid; background-color:#ffffff">
					<colgroup>
						<col width="800px">
						<col width="70px">
					</colgroup>
					<?
					if($mode!="new") {
						$Sub_idx_Array = explode("|",$Sub_idx);
						$Exam_Where = "";
						foreach ($Sub_idx_Array as $Sub_idx_Array_value) {
							//echo $Sub_idx_Array_value."<BR>";
							if(!$Exam_Where) {
								$Exam_Where = $Sub_idx_Array_value;
							}else{
								$Exam_Where = $Exam_Where.",".$Sub_idx_Array_value;
							}
						}
						$Exam_Where = "idx IN (".$Exam_Where.")";

						$SQL = "SELECT * FROM ExamBank WHERE UseYN='Y' AND Del='N' AND $Exam_Where ORDER BY ExamType ASC, idx ASC";
						$QUERY = mysqli_query($connect, $SQL);
						if($QUERY && mysqli_num_rows($QUERY))
						{
							$i = 1;
							while($Row = mysqli_fetch_array($QUERY))
							{
						?>
						<tr><td align="center"><input type="hidden" name="Exam_idx_temp" id="Exam_idx_temp" value="<?=$Row['idx']?>" readonly><input type="text" name="Exam_idx_text" style="width:100%" value="<?=$i?>. [<?=$ExamType_array[$Row['ExamType']]?>] <?=html_quote($Row['Question'])?>" readonly></td><td align="center"><input type="button" value="삭제" onclick="Javascript:ChapterExamDelRow(this);" class="btn_inputSm01"></td></tr>
						<?
							$i++;
							}
						}
					}
					?>
				</table>
				</td>
			  </tr>
			  <tr>
				<th>정렬 순서</th>
				<td><input name="OrderByNum" id="OrderByNum" type="text"  size="5" value="<?=$OrderByNum?>" maxlength="3"></td>
			  </tr>
			</table>
			</form>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center">
					<span id="SubmitBtn"><input type="button" value="등록 하기" onclick="ChapterSubmitOk();" class="btn_inputBlue01"></span>
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