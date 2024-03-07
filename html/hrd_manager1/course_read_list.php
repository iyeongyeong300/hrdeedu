<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$LectureCode = Replace_Check($LectureCode);

//차시수, 평가문제가 정상적으로 등록되었는지 확인하기 위해 강의 정보를 불러온다
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode' AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Chapter = $Row['Chapter']; //차시수
	$Mid01EA = $Row['Mid01EA']; //중간평가 객관식 문항수
	$Mid02EA = $Row['Mid02EA']; //중간평가 주관식 문항수
	$Test01EA = $Row['Test01EA']; //최종평가 객관식 문항수
	$Test02EA = $Row['Test02EA']; //최종평가 주관식 문항수
	$ReportEA = $Row['ReportEA']; //과제 문항수
}

//등록된 차시수 구하기
$Sql = "SELECT COUNT(Seq) FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='A'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

$Chapter_Count = $Row[0];


if($Chapter != $Chapter_Count) {
	$Chapter_alert = "<br><span class='redB'>☆ 차시수 오류 : 차시구성에 등록된 차시수가 강의정보와 일치하지 않습니다.</span>";
}

//등록된 중간평가 객관식, 주관식 문항수 구하기
$Sql = "SELECT * FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='B'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Sub_idx = $Row['Sub_idx']; //문제은행 idx값 배열

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

	//객관식
	$Sql2 = "SELECT COUNT(idx) FROM ExamBank WHERE $Exam_Where AND ExamType='A'";
	$Result2 = mysqli_query($connect, $Sql2);
	$Row2 = mysqli_fetch_array($Result2);
	$ExamA_Count = $Row2[0];
	//주관식
	$Sql2 = "SELECT COUNT(idx) FROM ExamBank WHERE $Exam_Where AND ExamType='B'";
	$Result2 = mysqli_query($connect, $Sql2);
	$Row2 = mysqli_fetch_array($Result2);
	$ExamB_Count = $Row2[0];

}

if(!$ExamA_Count) {
	$ExamA_Count = 0;
}
if(!$ExamB_Count) {
	$ExamB_Count = 0;
}

if($ExamA_Count < $Mid01EA) {
	$Mid01_alert = "<br><span class='redB'>☆ 중간평가 객관식 문항수 오류 : 차시구성에 등록된 중간평가 객관식 문항수가 강의정보 객관식 문항수 보다 큰 문항수로 등록하세요.</span>";
}
if($ExamB_Count < $Mid02EA) {
	$Mid02_alert = "<br><span class='redB'>☆ 중간평가 주관식 문항수 오류 : 차시구성에 등록된 중간평가 주관식 문항수가 강의정보 주관식 문항수 보다 큰 문항수로 등록하세요.</span>";
}

//등록된 최종평가 객관식, 주관식 문항수 구하기
$Sql = "SELECT * FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='C'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Sub_idx = $Row['Sub_idx']; //문제은행 idx값 배열

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

	//객관식
	$Sql2 = "SELECT COUNT(idx) FROM ExamBank WHERE $Exam_Where AND ExamType='A'";
	$Result2 = mysqli_query($connect, $Sql2);
	$Row2 = mysqli_fetch_array($Result2);
	$ExamA_Count = $Row2[0];
	//주관식
	$Sql2 = "SELECT COUNT(idx) FROM ExamBank WHERE $Exam_Where AND ExamType='B'";
	$Result2 = mysqli_query($connect, $Sql2);
	$Row2 = mysqli_fetch_array($Result2);
	$ExamB_Count = $Row2[0];

}

if(!$ExamA_Count) {
	$ExamA_Count = 0;
}
if(!$ExamB_Count) {
	$ExamB_Count = 0;
}

if($ExamA_Count < $Test01EA) {
	$Test01_alert = "<br><span class='redB'>☆ 최종평가 객관식 문항수 오류 : 차시구성에 등록된 최종평가 객관식 문항수가 강의정보 객관식 문항수 보다 큰 문항수로 등록하세요.</span>";
}
if($ExamB_Count < $Test02EA) {
	$Test02_alert = "<br><span class='redB'>☆ 최종평가 주관식 문항수 오류 : 차시구성에 등록된 최종평가 주관식 문항수가 강의정보 주관식 문항수 보다 큰 문항수로 등록하세요.</span>";
}

//등록된 과제 문항수 구하기
$Sql = "SELECT * FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='D'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
	$Sub_idx = $Row['Sub_idx']; //문제은행 idx값 배열

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

	$Sql2 = "SELECT COUNT(idx) FROM ExamBank WHERE $Exam_Where AND ExamType='C'";
	$Result2 = mysqli_query($connect, $Sql2);
	$Row2 = mysqli_fetch_array($Result2);
	$ReportEA_Count = $Row2[0];

}
if(!$ReportEA_Count) {
	$ReportEA_Count = 0;
}
if($ReportEA_Count < $ReportEA) {
	$Report_alert = "<br><span class='redB'>☆ 과제 문항수 오류 : 차시구성에 등록된 과제 문항수가 강의정보 과제 문항수 보다 큰 문항수로 등록하세요.</span>";
}
?>
<div class="tl pt15">
<?=$Chapter_alert ?>
<?=$Mid01_alert ?>
<?=$Mid02_alert ?>
<?=$Test01_alert?>
<?=$Test02_alert?>
<?=$Report_alert?>
</div>
<div class="btnAreaTl02">
	<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">차시 구성</span>
	&nbsp;&nbsp;&nbsp;&nbsp;<?if($AdminWrite=="Y") {?><input type="button" value="추가 하기" class="btn_inputLine01" onclick="ChapterRegist('new','<?=$LectureCode?>','','Y');"><?}?>
</div>


<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<colgroup>
		<col width="70px">
		<col width="80px">
		<col width="100px">
		<col width="*">
		<col width="150px">
		<col width="60px">
		<col width="60px">
	</colgroup>
	<tr>
		<th>차시 순서</th>
		<th>순서 조정</th>
		<th>차시 유형</th>
		<th>차시명 / 질문</th>
		<th>하부 컨텐츠수 / 문항수</th>
		<?if($AdminWrite=="Y") {?>
		<th>수정</th>
		<th>삭제</th>
		<?}?>
	</tr>
</table>
<table id="CourseTable" width="100%" cellpadding="0" cellspacing="0" class="list_ty01">
	<colgroup>
		<col width="70px">
		<col width="80px">
		<col width="100px">
		<col width="*">
		<col width="150px">
		<col width="60px">
		<col width="60px">
	</colgroup>
<?
$SQL = "SELECT a.Seq AS Chapter_seq, a.ChapterType, a.OrderByNum, a.Sub_idx, b.Gubun AS ContentGubun, b.ContentsTitle, 
			(SELECT COUNT(Seq) FROM ContentsDetail WHERE Contents_idx=a.Sub_idx) AS ContentsCount 
			FROM Chapter AS a LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx 
			WHERE a.LectureCode='$LectureCode' ORDER BY a.OrderByNum ASC";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{
		extract($ROW);

		if($ChapterType=="A") {

			$Bgcolor = "#FFFFFF";
			$ContentsListTitle = $ContentsTitle;
			$SubCount = $ContentsCount." 건";

		}else{

			$Bgcolor = "#eeeeee";
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

			$Sql2 = "SELECT COUNT(idx) FROM ExamBank WHERE $Exam_Where AND ExamType='A'";
			$Result2 = mysqli_query($connect, $Sql2);
			$Row2 = mysqli_fetch_array($Result2);
			$ExamA_Count = $Row2[0];

			$Sql2 = "SELECT COUNT(idx) FROM ExamBank WHERE $Exam_Where AND ExamType='B'";
			$Result2 = mysqli_query($connect, $Sql2);
			$Row2 = mysqli_fetch_array($Result2);
			$ExamB_Count = $Row2[0];

			$Sql2 = "SELECT COUNT(idx) FROM ExamBank WHERE $Exam_Where AND ExamType='C'";
			$Result2 = mysqli_query($connect, $Sql2);
			$Row2 = mysqli_fetch_array($Result2);
			$ExamC_Count = $Row2[0];


			$SubCount = "[객관식] ".$ExamA_Count." 건<BR>[단답형] ".$ExamB_Count." 건<br>[서술형] ".$ExamC_Count." 건";


			$Sql2 = "SELECT * FROM ExamBank WHERE ".$Exam_Where." AND Del='N' ORDER BY ExamType ASC, idx ASC LIMIT 0,1";
			//echo $Sql2."<BR>";
			$Result2 = mysqli_query($connect, $Sql2);
			$Row2 = mysqli_fetch_array($Result2);

			if($Row2) {
				$ContentsListTitle = strcut_utf8(strip_tags($Row2['Question']),200);
			}

		}

?>
<tr bgcolor="<?=$Bgcolor?>">
	<td><?=$OrderByNum?><input type="hidden" name="Chapter_seq_value" id="Chapter_seq_value" value="<?=$Chapter_seq?>"></td>
	<td><input type="button" value="▲" onclick="ChapterListMoveUp(this);" style="width:30px"> <input type="button" value="▼" onclick="ChapterListMoveDown(this);" style="width:30px"></td>
	<td><?=$ChapterType_array[$ChapterType]?></td>
	<td align="left"><?=$ContentsListTitle?></td>
	<td><?=$SubCount?></td>
	<?if($AdminWrite=="Y") {?>
	<td><input type="button"  value="수정" class="btn_inputSm01" onclick="ChapterRegist('edit','<?=$LectureCode?>','<?=$Chapter_seq?>','Y');"></td>
	<td><input type="button"  value="삭제" class="btn_inputSm01" onclick="ChapterDelete('del','<?=$LectureCode?>','<?=$Chapter_seq?>');"></td>
	<?}?>
  </tr>
<?
	$ContentsListTitle = "";
	$SubCount = "";
	}
}else{
?>
<tr>
	<td height="100" colspan="10">차시 구성 내역이 없습니다.</td>
</tr>
<? } ?>
</table>
<form name="OrderByForm" method="POST" action="chapter_orderby.php" target="ScriptFrame">
	<input type="hidden" name="Chapter_seq_array" id="Chapter_seq_array">
	<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
</form>
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:20px">
	<tr>
		<td valign="top" align="left"><?if($AdminWrite=="Y") {?><input type="button" id="BtnOrderby" value="정렬 하기" class="btn_inputLine01" onclick="ChapterOrderByGo();">&nbsp;&nbsp;<input type="button" value="차시 정보 가져오기" onclick="ChapterCopy('<?=$LectureCode?>')" class="btn_inputLine01"><?}?></td>
	</tr>
</table>
