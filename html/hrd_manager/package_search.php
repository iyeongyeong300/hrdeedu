<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$ContentsName = Replace_Check($ContentsName);
?>
<select name="PackageCourse" id="PackageCourse">
	<option value="">-- 과정 선택 --</option>
	<optgroup label="강의코드 | 과정명 | 수강유형 | 차시수">
	<?
	$SQL = "SELECT * FROM Course WHERE Del='N' AND PackageYN='N' AND ContentsName LIKE '%$ContentsName%' ORDER BY ContentsName ASC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		$i = 1;
		while($Row = mysqli_fetch_array($QUERY))
		{
	?>
	<option value="<?=$Row['LectureCode']?>"><?=$Row['LectureCode']?> | <?=html_quote($Row['ContentsName'])?> | <?=$ServiceTypeCourse_array[$Row['ServiceType']]?> | <?=$Row['Chapter']?>차시</option>
	<?
		$i++;
		}
	}
	?>
</select>&nbsp;&nbsp;<input type="button" value="추가 하기" onclick="PackageSearchSelect();" class="btn_inputSm01">
<?
mysqli_close($connect);
?>