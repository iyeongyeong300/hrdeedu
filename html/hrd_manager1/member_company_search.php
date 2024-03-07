<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$CompanyName = Replace_Check($CompanyName);

$SQL = "SELECT * FROM Company WHERE CompanyName LIKE '%$CompanyName%' ORDER BY CompanyName ASC";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY) )
{
?>
<select name="CompanyResult" id="CompanyResult" class="wid400">
	<option value="">-- 소속된 회사를 선택하세요. --</option>
<?
	while($row = mysqli_fetch_array($QUERY) )
		{
		extract($row);
?>
	<option value="<?=$CompanyCode?>|<?=$CompanyName?>"><?=$CompanyName?></option>
<?
		}
?>
</select>&nbsp;&nbsp;<input type="button" value="선택" onclick="MemberCompanySearchSelect();" class="btn_inputLine01">
<?
	}else{
?>
등록된 사업자정보가 없습니다.
<?
}

mysqli_close($connect);
?>