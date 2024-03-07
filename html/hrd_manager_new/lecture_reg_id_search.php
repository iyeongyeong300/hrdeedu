<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$TempSearchID = Replace_Check($TempSearchID);
?>
<select name="UserID" id="UserID">
	<option value="">-- 수강생 선택 --</option>
	<optgroup label="- 이름 | 아이디 | 소속 사업주">
	<?
	$SQL = "SELECT a.ID, a.Name, b.CompanyName FROM Member AS a LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode WHERE a.UseYN='Y' AND a.MemberOut='N' AND a.Sleep='N' AND (a.ID LIKE '%$TempSearchID%' OR a.Name LIKE '%$TempSearchID%') ORDER BY a.Name ASC";
	//$SQL = "SELECT ID, Name FROM Member WHERE UseYN='Y' AND MemberOut='N' AND Sleep='N' AND (ID LIKE '%$TempSearchID%' OR Name LIKE '%$TempSearchID%') ORDER BY Name ASC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		$i = 1;
		while($Row = mysqli_fetch_array($QUERY))
		{
	?>
	<option value="<?=$Row['ID']?>"><?=$Row['Name']?> | <?=$Row['ID']?> | <?=$Row['CompanyName']?></option>
	<?
		$i++;
		}
	}else{
	?>
	<option value="">검색된 수강생이 없습니다.</option>
	<?
	}
	?>
</select>
<?
mysqli_close($connect);
?>