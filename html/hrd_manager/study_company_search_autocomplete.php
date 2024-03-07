<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$CompanyName = Replace_Check($CompanyName);

$i = 1;
$SQL = "SELECT * FROM Company WHERE Del='N' AND CompanyName LIKE '%$CompanyName%' ORDER BY CompanyName ASC";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY))
{
	while($ROW = mysqli_fetch_array($QUERY))
	{

		$CompanyNameResult = str_replace($CompanyName,"<font color='#db2400'><B>".$CompanyName."</B></font>",$ROW['CompanyName']);
?>
	<ul>
		<li><a href="Javascript:CompanySearchAutoCompleteApply('<?=$ROW['CompanyName']?>','<?=$ROW['CompanyCode']?>')"><?=$i?>. <?=$CompanyNameResult?>&nbsp;&nbsp;<?=$ROW['CompanyCode']?></a></li>
	</ul>
<?
$i++;
	}
}else{
?>
	<ul>
		<li>검색 결과가 없습니다.</li>
	</ul>
<?
}

mysqli_close($connect);
?>

<p class="gapT20"><a href="Javascript:CompanySearchAutoCompleteClose();"><img src="./images/btn_close02.gif"></a></p>
