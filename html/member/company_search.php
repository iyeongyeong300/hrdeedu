<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$CompanyName = Replace_Check_XSS2($CompanyName);

$SQL = "SELECT * FROM Company WHERE CompanyName LIKE '%$CompanyName%' ORDER BY CompanyName ASC";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY) )
{
?>
<br><select name="CompanyResult" id="CompanyResult" class="inp_slt85">
		<option value="">-- 소속된 회사를 선택하세요. --</option>
<?
	while($row = mysqli_fetch_array($QUERY) )
		{
		extract($row);
?>
	<option value="<?=$CompanyCode?>|<?=$CompanyName?>">[<?=substr($CompanyCode,0,3)?>-<?=substr($CompanyCode,3,2)?>-<?=substr($CompanyCode,5,5)?>] <?=$CompanyName?></option>
<?
		}
?>
</select>&nbsp;&nbsp;<span class="btnSmGray01"><a href="Javascript:JoinCompanySearchSelect();">선택</a></span>
<?
	}else{
?>
<BR>등록된 사업자정보가 없습니다.
<?
}

mysqli_close($connect);
?>