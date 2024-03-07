<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ExamGubun = Replace_Check($ExamGubun);
$ChapterType = Replace_Check($ChapterType);


$ExamTypeWhere = " AND (ExamType='A' OR ExamType='B' OR ExamType='C')";

$Sql = "SELECT COUNT(*) FROM ExamBank WHERE UseYN='Y' AND Del='N' AND Gubun='$ExamGubun' $ExamTypeWhere";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];


if($TOT_NO > 0) {
?>
<select name="Exam_idx" id="Exam_idx" style="width:700px">
	<option value="">-- 평가 문제 선택 --</option>
	<optgroup label="[문제유형] 질문명">
	<?
	$SQL = "SELECT * FROM ExamBank WHERE UseYN='Y' AND Del='N' AND Gubun='$ExamGubun' $ExamTypeWhere ORDER BY ExamType ASC, Question ASC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		$i = 1;
		while($Row = mysqli_fetch_array($QUERY))
		{
	?>
	<option value="<?=$Row['idx']?>" title="<?=html_quote($Row['Question'])?>"><?=$i?>. [<?=$ExamType_array[$Row['ExamType']]?>] <?=strcut_utf8(html_quote($Row['Question']),65)?></option>
	<?
		$i++;
		}
	}
	?>
</select><span id="ChapterExamAddBtn">&nbsp;&nbsp;<input type="button" value="추가하기" class="btn_inputSm01" onclick="ChapterExamAdd();"></span>
<?
}else{
?>
<select name="Exam_idx" id="Exam_idx" style="width:100%">
	<option value="">-- 평가 문제 선택 --</option>
	<optgroup label="[문제 유형] 질문">
</select>
<?
}
?>
<?
mysqli_close($connect);
?>