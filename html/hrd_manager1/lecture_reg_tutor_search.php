<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$TempSearchTutor = Replace_Check($TempSearchTutor);
?>
<select name="Tutor" id="Tutor">
	<option value="">-- 첨삭강사 선택 --</option>
	<optgroup label="- 이름 | 아이디 | 소속">
	<?
	$SQL = "SELECT * FROM StaffInfo WHERE Del='N' AND UseYN='Y' AND Dept='C' AND (ID LIKE '%$TempSearchTutor%' OR Name LIKE '%$TempSearchTutor%') ORDER BY Name ASC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		$i = 1;
		while($Row = mysqli_fetch_array($QUERY))
		{
	?>
	<option value="<?=$Row['ID']?>"><?=$Row['Name']?> | <?=$Row['ID']?> | <?=$Row['Team']?></option>
	<?
		$i++;
		}
	}else{
	?>
	<option value="">검색된 첨삭강사가 없습니다.</option>
	<?
	}
	?>
</select>
<?
mysqli_close($connect);
?>