<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$SearchYear = Replace_Check($SearchYear); //검색 년도
$SearchMonth = Replace_Check($SearchMonth); //검색 월
$ctype = Replace_Check($ctype); //사업주, 근로자 구분
$SubmitFunction = Replace_Check($SubmitFunction);

if($SearchMonth) {
	$Where = "LEFT(LectureStart,7)='".$SearchYear."-".$SearchMonth."'";
}else{
	$Where = "LEFT(LectureStart,4)='".$SearchYear."'";
}

if(!$ctype || $ctype=="A") {
	$WhereServiceType = " AND ServiceType IN (1,3,5,9)";
}

if($ctype=="B") {
	$WhereServiceType = " AND ServiceType=4";
}

?>
&nbsp;<select name="StudyPeriod" id="StudyPeriod" style="width:250px" onchange="LectureCompanySearch();<?=$SubmitFunction?>">
	<option value="">-- 기간 선택 --</option>
<?
	$SQL = "SELECT DISTINCT(CONCAT(LectureStart,'~',LectureEnd)) AS StudyPeriod FROM LectureTerme WHERE ".$Where.$WhereServiceType." ORDER BY LectureStart DESC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		$i = 1;
		while($Row = mysqli_fetch_array($QUERY))
		{
	?>
	<option value="<?=$Row['StudyPeriod']?>"><?=$Row['StudyPeriod']?></option>
	<?
		$i++;
		}
	}
	?>
</select>
<?
mysqli_close($connect);
?>