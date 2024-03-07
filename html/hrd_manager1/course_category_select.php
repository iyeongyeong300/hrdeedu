<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$Category1 = Replace_Check($Category1);
$Category2 = Replace_Check($Category2);

if(!$Category1) {
	echo "";
}else{
?>
	<select name="Category2" id="Category2">
		<option value="">-- 소분류 선택 --</option>
<?
	$SQL = "SELECT * FROM CourseCategory WHERE Deep=2 AND UseYN='Y' AND Del='N' AND ParentCategory=$Category1 ORDER BY OrderByNum ASC, idx ASC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY) )
	{
		while($row = mysqli_fetch_array($QUERY) )
		{
		extract($row);
?>
		<option value="<?=$idx?>" <?if($idx==$Category2) {?>selected<?}?>><?=$CategoryName?></option>
<?
		}
	}else{
	echo "";
	}
?>
	</select>
<?
}

mysqli_close($connect);
?>