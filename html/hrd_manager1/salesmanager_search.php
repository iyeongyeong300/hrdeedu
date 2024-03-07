<?
include "../include/include_function.php";

$SalesName = Replace_Check_XSS2($SalesName);


$Sql = "SELECT COUNT(*) FROM StaffInfo WHERE (Name LIKE '%$SalesName%' OR ID LIKE '%$SalesName%') AND Dept='B' AND Del='N' AND UseYN='Y'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

mysqli_free_result($Result);



$SQL = "SELECT * FROM StaffInfo WHERE (Name LIKE '%$SalesName%' OR ID LIKE '%$SalesName%') AND Dept='B' AND Del='N' AND UseYN='Y' ORDER BY ID ASC";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
?>
<select name="SalesManagerTemp" id="SalesManagerTemp">
	<option value="">-- <?=$TOT_NO?>건이 검색되었습니다. 영업담당자를 선택하세요. --</option>
	<optgroup label="성명 | 아이디 | 소속 | 휴대폰">
<?
	while($ROW = mysqli_fetch_array($QUERY))
	{
		extract($ROW);

		if(!$Team) {
			$CompanyCode = "소속정보 없음";
		}
?>
	<option value="<?=$ID?>"><?=$Name?> | <?=$ID?> | <?=$Team?> | <?=$Mobile?></option>
<?
	}
?>
</select>
<?
mysqli_free_result($QUERY);

}else{
?>
[ 검색된 영업담당자가 없습니다. ]
<?
}

mysqli_close($connect);
?>