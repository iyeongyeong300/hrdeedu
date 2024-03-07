<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ContentGubun = Replace_Check($ContentGubun);
$Sub_idx = Replace_Check($Sub_idx);
?>
<select name="Content_idx" id="Content_idx" style="width:100%">
	<option value="">-- 기초 차시 선택 --</option>
	<optgroup label="차시명 (하부 컨텐츠수)">
	<?
	$SQL = "SELECT *, (SELECT COUNT(*) FROM ContentsDetail WHERE Contents_idx=Contents.idx) AS ContentsDetail_Count FROM Contents WHERE Del='N' AND Gubun='$ContentGubun' ORDER BY RegDate ASC";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY))
	{
		$i = 1;
		while($Row = mysqli_fetch_array($QUERY))
		{
	?>
	<option value="<?=$Row['idx']?>" <?if($Row['idx']==$Sub_idx) {?>selected<?}?>><?=$i?>. <?=html_quote($Row['ContentsTitle'])?>  (<?=$Row['ContentsDetail_Count']?>)</option>
	<?
		$i++;
		}
	}
	?>
</select>
<?
mysqli_close($connect);
?>